<?php

namespace App\Controllers;

use Batara\Controller;

/**
 * Halaman /docs: tutorial login multi-role, ditulis sebagai data (bukan
 * ditulis langsung di view) supaya contoh kode di dalamnya tidak perlu
 * di-escape manual dari compiler @directive milik View.
 */
class DocsController extends Controller
{
    public function index()
    {
        return view('docs.index', ['sections' => $this->sections()]);
    }

    protected function sections(): array
    {
        return [
            [
                'id'    => 'ringkasan',
                'title' => 'Ringkasan',
                'parts' => [
                    ['p' => 'Batara tidak punya sistem auth bawaan, tapi semua bahan dasarnya sudah ada: Session untuk menyimpan siapa yang login, Middleware untuk menjaga route, dan Route::group() untuk mengelompokkan halaman per role. Tutorial ini merakit ketiganya menjadi login dengan 3 role: admin, staff, dan user biasa.'],
                    ['p' => 'Alurnya singkat: tabel users punya kolom role. Saat login berhasil, id user disimpan di session. Middleware membaca user yang sedang login lewat session itu, lalu memutuskan boleh atau tidak masuk ke suatu halaman berdasarkan role-nya.'],
                    ['note' => 'Fitur ini sudah aktif di project ini. Coba langsung login di /login dengan salah satu akun demo: admin, staff, atau budi — passwordnya sama, rahasia123.'],
                ],
            ],
            [
                'id'    => 'skema-database',
                'title' => '1. Skema database',
                'parts' => [
                    ['p' => 'Tabel users butuh kolom role di samping username dan password. Buat modelnya sekalian dengan migrasinya:'],
                    ['code' => 'php batara make:model User -m', 'lang' => 'bash'],
                    ['p' => 'Lalu isi berkas migrasi yang dihasilkan (database/migrations/..._create_users_table.sql):'],
                    ['code' => <<<'SQL'
                        CREATE TABLE IF NOT EXISTS `users` (
                            id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            username   VARCHAR(255) NOT NULL,
                            password   VARCHAR(255) NOT NULL,
                            role       VARCHAR(50)  NOT NULL DEFAULT 'user',
                            created_at DATETIME NULL,
                            updated_at DATETIME NULL
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                        SQL, 'lang' => 'sql'],
                    ['p' => 'Kolom role diisi bebas sesuai kebutuhan aplikasi — di sini dipakai tiga nilai: admin, staff, user. Jalankan migrasinya:'],
                    ['code' => 'php batara migrate', 'lang' => 'bash'],
                ],
            ],
            [
                'id'    => 'model',
                'title' => '2. Model User',
                'parts' => [
                    ['p' => 'Tambahkan dua helper kecil di model: hasRole() untuk mengecek role, dan current() untuk mengambil (lalu meng-cache) user yang sedang login dari session.'],
                    ['code' => <<<'PHP'
                        <?php

                        namespace App\Models;

                        use Batara\Database\Model;
                        use Batara\Session;

                        class User extends Model
                        {
                            protected static ?string $table = 'users';
                            protected array $fillable = ['username', 'password', 'role'];
                            protected array $hidden   = ['password'];

                            public function hasRole(string ...$roles): bool
                            {
                                return in_array($this->role, $roles, true);
                            }

                            public static function current(): ?static
                            {
                                static $user = null;
                                static $resolved = false;

                                if (! $resolved) {
                                    $resolved = true;

                                    if (Session::has('user_id')) {
                                        $user = static::find(Session::get('user_id'));
                                    }
                                }

                                return $user;
                            }
                        }
                        PHP, 'lang' => 'php'],
                    ['p' => 'static $user / static $resolved membuat query ke database hanya jalan sekali walau User::current() dipanggil berkali-kali dalam satu request (misalnya dari middleware lalu dari view).'],
                ],
            ],
            [
                'id'    => 'middleware',
                'title' => '3. Middleware',
                'parts' => [
                    ['p' => 'Middleware di Batara dibuat tanpa argumen (new $class()), jadi tidak ada sintaks middleware(\'role:admin\') seperti Laravel. Solusinya: satu class dasar EnsureRole yang isi role-nya di-override oleh turunan tipis per role.'],
                    ['code' => <<<'PHP'
                        <?php

                        namespace App\Middleware;

                        use App\Models\User;
                        use Batara\Http\Request;
                        use Batara\Middleware;

                        abstract class EnsureRole extends Middleware
                        {
                            /** @return string[] role yang diizinkan mengakses route ini */
                            abstract protected function roles(): array;

                            public function handle(Request $request, \Closure $next): mixed
                            {
                                $user = User::current();

                                if ($user === null) {
                                    return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
                                }

                                if (! $user->hasRole(...$this->roles())) {
                                    abort(403, 'Anda tidak punya akses ke halaman ini.');
                                }

                                return $next($request);
                            }
                        }
                        PHP, 'lang' => 'php'],
                    ['p' => 'Role baru tinggal 3 baris:'],
                    ['code' => <<<'PHP'
                        // app/Middleware/AdminOnly.php
                        class AdminOnly extends EnsureRole
                        {
                            protected function roles(): array { return ['admin']; }
                        }

                        // app/Middleware/StaffOnly.php — admin & staff sama-sama boleh
                        class StaffOnly extends EnsureRole
                        {
                            protected function roles(): array { return ['admin', 'staff']; }
                        }
                        PHP, 'lang' => 'php'],
                    ['p' => 'Dua middleware pelengkap: Authenticate (wajib login, dipakai alias auth) dan RedirectIfAuthenticated (kebalikannya — dipakai di halaman login supaya yang sudah login tidak melihat form login lagi, alias guest).'],
                    ['code' => <<<'PHP'
                        class Authenticate extends Middleware
                        {
                            public function handle(Request $request, \Closure $next): mixed
                            {
                                if (User::current() === null) {
                                    return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
                                }

                                return $next($request);
                            }
                        }
                        PHP, 'lang' => 'php'],
                ],
            ],
            [
                'id'    => 'konfigurasi',
                'title' => '4. Daftarkan alias middleware',
                'parts' => [
                    ['p' => 'Middleware harus dikenalkan namanya di config/app.php supaya bisa dipakai sebagai string pendek di route.'],
                    ['code' => <<<'PHP'
                        'middleware' => [
                            'auth'  => App\Middleware\Authenticate::class,
                            'guest' => App\Middleware\RedirectIfAuthenticated::class,
                            'admin' => App\Middleware\AdminOnly::class,
                            'staff' => App\Middleware\StaffOnly::class,
                        ],
                        PHP, 'lang' => 'php'],
                ],
            ],
            [
                'id'    => 'controller',
                'title' => '5. AuthController',
                'parts' => [
                    ['p' => 'Controller ini menangani form login, verifikasi password, penyimpanan session, dan logout. Setelah login sukses, user diarahkan ke dashboard sesuai role-nya masing-masing.'],
                    ['code' => <<<'PHP'
                        <?php

                        namespace App\Controllers;

                        use App\Models\User;
                        use Batara\Controller;
                        use Batara\Http\Request;
                        use Batara\Session;

                        class AuthController extends Controller
                        {
                            public function showLogin()
                            {
                                return view('auth.login');
                            }

                            public function login(Request $request)
                            {
                                $data = $request->validate([
                                    'username' => 'required',
                                    'password' => 'required',
                                ]);

                                $user = User::firstWhere('username', $data['username']);

                                if (! $user || ! password_verify($data['password'], $user->password)) {
                                    return back()
                                        ->withErrors(['username' => 'Username atau password salah.'])
                                        ->withInput();
                                }

                                Session::put('user_id', $user->id);

                                return redirect(match ($user->role) {
                                    'admin' => '/admin',
                                    'staff' => '/staff',
                                    default => '/dashboard',
                                })->with('success', 'Selamat datang, ' . $user->username . '.');
                            }

                            public function logout()
                            {
                                Session::forget('user_id');

                                return redirect('/login')->with('success', 'Berhasil logout.');
                            }
                        }
                        PHP, 'lang' => 'php'],
                    ['p' => 'password_verify() membandingkan input dengan hash bcrypt yang tersimpan. Password mentah tidak pernah dibandingkan langsung — dan tidak pernah disimpan langsung (lihat $hidden di model, juga akun demo di migrasi yang sudah di-hash lewat password_hash()).'],
                ],
            ],
            [
                'id'    => 'route',
                'title' => '6. Routes',
                'parts' => [
                    ['p' => 'Route login/logout tidak butuh proteksi role. Route dashboard dikelompokkan per prefix dengan middleware yang sesuai.'],
                    ['code' => <<<'PHP'
                        use App\Controllers\AuthController;
                        use App\Controllers\DashboardController;

                        Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
                        Route::post('/login', [AuthController::class, 'login'])->name('login.attempt')->middleware('guest');
                        Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

                        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

                        Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
                            Route::get('/', [DashboardController::class, 'admin'])->name('admin.dashboard');
                        });

                        Route::group(['prefix' => 'staff', 'middleware' => 'staff'], function () {
                            Route::get('/', [DashboardController::class, 'staff'])->name('staff.dashboard');
                        });
                        PHP, 'lang' => 'php'],
                    ['p' => 'Middleware admin sudah otomatis mencakup pengecekan login, jadi tidak perlu ditulis dobel dengan auth. Cek hasilnya kapan saja dengan:'],
                    ['code' => 'php batara route:list', 'lang' => 'bash'],
                ],
            ],
            [
                'id'    => 'view-login',
                'title' => '7. View login',
                'parts' => [
                    ['p' => 'Form biasa: @csrf wajib ada, dan errors()/old() dipakai supaya validasi gagal tetap menampilkan pesan serta mengisi ulang input sebelumnya.'],
                    ['code' => <<<'BLADE'
                        @extends('layouts.app')

                        @section('title', 'Login')

                        @section('content')
                            <div class="col-md-5 mx-auto">
                                <form method="POST" action="{{ route('login.attempt') }}">
                                    @csrf

                                    <input type="text" name="username" value="{{ old('username') }}">
                                    @error('username') <div>{{ $message }}</div> @enderror

                                    <input type="password" name="password">

                                    <button type="submit">Login</button>
                                </form>
                            </div>
                        @endsection
                        BLADE, 'lang' => 'blade'],
                ],
            ],
            [
                'id'    => 'uji-coba',
                'title' => '8. Uji coba',
                'parts' => [
                    ['p' => 'Jalankan migrasi (sekali saja, otomatis dilewati kalau sudah pernah jalan) lalu nyalakan server:'],
                    ['code' => "php batara migrate\nphp batara serve", 'lang' => 'bash'],
                    ['p' => 'Buka /login lalu masuk dengan salah satu akun demo berikut (dibuat otomatis oleh migrasi):'],
                    ['table' => [
                        ['username' => 'admin', 'password' => 'rahasia123', 'role' => 'admin', 'tujuan' => '/admin'],
                        ['username' => 'staff', 'password' => 'rahasia123', 'role' => 'staff', 'tujuan' => '/staff'],
                        ['username' => 'budi',  'password' => 'rahasia123', 'role' => 'user',  'tujuan' => '/dashboard'],
                    ]],
                    ['p' => 'Coba juga akses /admin memakai akun budi (role user) — akan ditolak dengan 403, karena middleware admin hanya mengizinkan role admin.'],
                ],
            ],
        ];
    }
}
