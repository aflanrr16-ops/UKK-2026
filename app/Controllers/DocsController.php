<?php

namespace App\Controllers;

use Sakuci\Controller;

class DocsController extends Controller
{
    public function index()
    {
        return view('docs.index', ['sections' => $this->sections()]);
    }

    protected function sections(): array
    {
        return [
            // ===== INTRO =====
            [
                'id'    => '0-intro',
                'title' => 'ðŸ“š Dokumentasi Batara',
                'parts' => [
                    ['p' => 'Kerangka PHP ringan bergaya Laravel tanpa Composer. Fitur: Route, Model, View, Controller, Validation, Session, Middleware, CSRF protection, Query Builder dengan eager loading, dan Bootstrap 5.3.8 built-in.'],
                    ['p' => '<strong>Coba akun demo:</strong> admin / rahasia123 (atau staff, atau budi)'],
                ],
            ],

            // ===== CLI =====
            [
                'id'    => '1-cli',
                'title' => 'ðŸ–¥ï¸ CLI â€” Perintah batara',
                'parts' => [
                    ['p' => 'Jalankan semua perintah dari folder project:'],
                    ['code' => "php batara serve                    # Jalankan server (127.0.0.1:8000)\nphp batara migrate                  # Jalankan migrasi\nphp batara migrate:fresh            # Hapus semua tabel\nphp batara db:check                 # Uji koneksi database\nphp batara route:list               # Lihat semua route\nphp batara make:model Nama          # Buat model\nphp batara make:model Nama -m       # Buat model + migrasi\nphp batara make:controller Nama     # Buat controller\nphp batara make:view nama.view      # Buat view\nphp batara make:migration nama      # Buat migrasi\nphp batara view:clear               # Bersihkan cache view", 'lang' => 'bash'],
                ],
            ],

            // ===== ROUTING =====
            [
                'id'    => '2-routing',
                'title' => 'ðŸ›£ï¸ Routing',
                'parts' => [
                    ['p' => 'Daftarkan route di routes/web.php:'],
                    ['code' => <<<'PHP'
                        use App\Controllers\PostController;
                        use Sakuci\Route;

                        // Route dasar
                        Route::get('/', function () { return view('welcome'); })->name('home');
                        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
                        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

                        // Parameter
                        Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
                        Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');

                        // 7 route CRUD sekaligus
                        Route::resource('posts', PostController::class);

                        // Group dengan middleware
                        Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
                            Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
                        });
                        PHP, 'lang' => 'php'],
                    ['p' => 'Route dapat diakses lewat nama:'],
                    ['code' => "route('home')                  # /\nroute('posts.index')            # /posts\nroute('posts.show', ['id' => 1]) # /posts/1\nroute('admin.dashboard')        # /admin/", 'lang' => 'php'],
                ],
            ],

            // ===== MODEL =====
            [
                'id'    => '3-model',
                'title' => 'ðŸ“Š Model & Query Builder',
                'parts' => [
                    ['p' => 'Model mewakili satu tabel di database. Buat dengan:'],
                    ['code' => 'php batara make:model Post -m', 'lang' => 'bash'],
                    ['code' => <<<'PHP'
                        <?php
                        namespace App\Models;
                        use Sakuci\Database\Model;

                        class Post extends Model
                        {
                            protected static ?string $table = 'posts';  // opsional, ditebak dari nama
                            protected array $fillable = ['title', 'body', 'status'];
                            protected array $hidden = [];               // tidak tampil saat JSON
                        }
                        PHP, 'lang' => 'php'],
                    ['p' => '<strong>Query dasar:</strong>'],
                    ['code' => <<<'PHP'
                        Post::all();                           // Semua post
                        Post::find(1);                         // Post id=1
                        Post::findOrFail(1);                   // Atau 404
                        Post::where('status', 'published')->get();
                        Post::where('status', 'published')->first();
                        Post::latest()->limit(5)->get();
                        Post::count();

                        // Join
                        Post::leftJoin('users', 'users.id', '=', 'posts.user_id')
                            ->select('posts.title', 'users.nama')
                            ->get();

                        // Eager loading (cegah N+1)
                        Post::with('user', 'comments')->get();

                        // Paging
                        Post::paginate(15);  // 15 per halaman
                        PHP, 'lang' => 'php'],
                    ['p' => '<strong>CRUD:</strong>'],
                    ['code' => <<<'PHP'
                        // Create
                        Post::create(['title' => 'Hello', 'body' => '...', 'status' => 'published']);

                        // Update
                        $post = Post::find(1);
                        $post->update(['title' => 'New title']);

                        // Delete
                        $post->delete();
                        PHP, 'lang' => 'php'],
                ],
            ],

            // ===== CONTROLLER =====
            [
                'id'    => '4-controller',
                'title' => 'âš™ï¸ Controller',
                'parts' => [
                    ['p' => 'Buat dengan: php batara make:controller PostController'],
                    ['code' => <<<'PHP'
                        <?php
                        namespace App\Controllers;

                        use App\Models\Post;
                        use Sakuci\Controller;
                        use Sakuci\Http\Request;

                        class PostController extends Controller
                        {
                            // GET /posts
                            public function index()
                            {
                                $posts = Post::latest()->paginate(10);
                                return view('posts.index', ['posts' => $posts]);
                            }

                            // GET /posts/create
                            public function create()
                            {
                                return view('posts.create');
                            }

                            // POST /posts
                            public function store(Request $request)
                            {
                                $data = $request->validate([
                                    'title' => 'required|min:3|max:100',
                                    'body'  => 'required|min:10',
                                ]);

                                Post::create($data);

                                return redirect(route('posts.index'))
                                    ->with('success', 'Post berhasil dibuat.');
                            }

                            // GET /posts/{id} â€” Route model binding
                            public function show(Post $post)
                            {
                                return view('posts.show', ['post' => $post]);
                            }

                            // GET /posts/{id}/edit
                            public function edit(Post $post)
                            {
                                return view('posts.edit', ['post' => $post]);
                            }

                            // PUT /posts/{id}
                            public function update(Request $request, Post $post)
                            {
                                $data = $request->validate([
                                    'title' => 'required|min:3|max:100',
                                    'body'  => 'required|min:10',
                                ]);

                                $post->update($data);

                                return redirect(route('posts.index'))
                                    ->with('success', 'Post berhasil diubah.');
                            }

                            // DELETE /posts/{id}
                            public function destroy(Post $post)
                            {
                                $post->delete();

                                return redirect(route('posts.index'))
                                    ->with('success', 'Post berhasil dihapus.');
                            }
                        }
                        PHP, 'lang' => 'php'],
                    ['p' => '<strong>Penjelasan:</strong> Parameter bertipe (Post $post) otomatis diambil dari database berdasarkan {id}. Ini namanya route model binding.'],
                ],
            ],

            // ===== VIEW =====
            [
                'id'    => '5-view',
                'title' => 'ðŸŽ¨ View (Template)',
                'parts' => [
                    ['p' => 'File view ada di resources/views/ dengan akhiran .batara.php. Pakai sintaks Blade-like:'],
                    ['code' => <<<'BLADE'
                        @extends('layouts.app')
                        @section('title', 'Daftar Post')
                        @section('content')

                            <h1>Daftar Post</h1>

                            {{-- Output aman (escape) --}}
                            <h2>{{ $post->title }}</h2>

                            {{-- Output tanpa escape --}}
                            {!! $html !!}

                            {{-- Kondisi --}}
                            @if ($posts->count() > 0)
                                Ada {{ $posts->count() }} post
                            @else
                                Belum ada post
                            @endif

                            {{-- Loop --}}
                            @foreach ($posts as $post)
                                <h3>{{ $post->title }}</h3>
                            @endforeach

                            {{-- Loop dengan else --}}
                            @forelse ($posts as $post)
                                <article>{{ $post->title }}</article>
                            @empty
                                <p>Belum ada post</p>
                            @endforelse

                            {{-- Include --}}
                            @include('components.post-card', ['post' => $post])

                            {{-- CSRF (wajib di form) --}}
                            <form method="POST" action="/posts">
                                @csrf
                                <input type="text" name="title">
                            </form>

                            {{-- Flash message --}}
                            @if (session('success'))
                                <div class="alert">{{ session('success') }}</div>
                            @endif

                            {{-- Validation error --}}
                            @error('title')
                                <span class="error">{{ $message }}</span>
                            @enderror

                            {{-- Old input --}}
                            <input type="text" value="{{ old('title') }}">

                        @endsection
                        BLADE, 'lang' => 'blade'],
                ],
            ],

            // ===== VALIDATION =====
            [
                'id'    => '6-validation',
                'title' => 'âœ“ Validation',
                'parts' => [
                    ['p' => 'Di controller, gunakan $request->validate():'],
                    ['code' => <<<'PHP'
                        $data = $request->validate([
                            'nama'   => 'required|min:3|max:100',
                            'email'  => 'required|email|unique:users,email',
                            'umur'   => 'nullable|integer|min:18',
                            'status' => 'required|in:aktif,tidak-aktif',
                        ]);

                        // Kalau validasi gagal, auto-redirect dengan error & old input
                        // Kalau validasi lulus, $data berisi nilai yang sudah validated
                        PHP, 'lang' => 'php'],
                    ['p' => '<strong>Rule tersedia:</strong> required, nullable, email, url, numeric, integer, min, max, between, in, not_in, regex, alpha, alpha_num, alpha_dash, confirmed, same, different, unique, exists, date, size, array, boolean, string'],
                ],
            ],

            // ===== BOOTSTRAP UI =====
            [
                'id'    => '7-bootstrap-ui',
                'title' => 'ðŸŽ¯ Bootstrap Components',
                'parts' => [
                    ['p' => 'Bootstrap 5.3.8 sudah built-in. Ganti warna khas di public/css/app.css:'],
                    ['code' => <<<'CSS'
                        :root {
                            --brand: #c2410c;       /* Warna utama */
                            --brand-dark: #9a3412; /* Saat hover */
                        }
                        CSS, 'lang' => 'css'],
                    ['p' => '<strong>Component Bootstrap yang sering dipakai:</strong>'],
                    ['table' => [
                        ['Kelas' => 'card', 'Fungsi' => 'Kotak putih dengan bayangan'],
                        ['Kelas' => 'btn btn-primary', 'Fungsi' => 'Tombol biru'],
                        ['Kelas' => 'btn btn-brand', 'Fungsi' => 'Tombol warna khas Batara'],
                        ['Kelas' => 'form-label, form-control', 'Fungsi' => 'Label & input form'],
                        ['Kelas' => 'is-invalid, invalid-feedback', 'Fungsi' => 'Garis merah saat validasi gagal'],
                        ['Kelas' => 'alert alert-success', 'Fungsi' => 'Notifikasi hijau'],
                        ['Kelas' => 'table table-hover', 'Fungsi' => 'Tabel'],
                        ['Kelas' => 'mb-3, mt-4, p-4, gap-2', 'Fungsi' => 'Spacing (margin/padding)'],
                        ['Kelas' => 'row, col-md-6', 'Fungsi' => 'Grid (responsive)'],
                        ['Kelas' => 'navbar navbar-expand-lg', 'Fungsi' => 'Navigation bar'],
                    ]],
                    ['p' => 'Contoh form pakai Bootstrap:'],
                    ['code' => <<<'BLADE'
                        <form method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" id="nama" name="nama"
                                       class="form-control {{ errors()->has('nama') ? 'is-invalid' : '' }}"
                                       value="{{ old('nama') }}">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn btn-brand" type="submit">Simpan</button>
                        </form>
                        BLADE, 'lang' => 'blade'],
                ],
            ],

            // ===== DATABASE =====
            [
                'id'    => '8-database',
                'title' => 'ðŸ’¾ Database Setup',
                'parts' => [
                    ['p' => 'Edit .env:'],
                    ['code' => "DB_CONNECTION=mysql\nDB_HOST=127.0.0.1\nDB_PORT=3306\nDB_DATABASE=batara_belajar\nDB_USERNAME=root\nDB_PASSWORD=", 'lang' => 'ini'],
                    ['p' => 'Lalu buat database (lewat phpMyAdmin atau SQL):'],
                    ['code' => 'CREATE DATABASE batara_belajar CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;', 'lang' => 'sql'],
                    ['p' => 'Uji koneksi:'],
                    ['code' => 'php batara db:check', 'lang' => 'bash'],
                    ['p' => 'Untuk SQLite (tanpa setup), cukup ubah .env:'],
                    ['code' => 'DB_CONNECTION=sqlite', 'lang' => 'ini'],
                ],
            ],

            // ===== SESSION =====
            [
                'id'    => '9-session',
                'title' => 'ðŸ” Session & Flash Message',
                'parts' => [
                    ['p' => 'Di controller atau view:'],
                    ['code' => <<<'PHP'
                        use Sakuci\Session;

                        // Simpan
                        Session::put('user_id', 123);
                        Session::put('cart', ['item1', 'item2']);

                        // Baca
                        $id = Session::get('user_id');
                        $cart = Session::get('cart', []);  // Default []

                        // Cek ada
                        if (Session::has('user_id')) { ... }

                        // Hapus
                        Session::forget('user_id');

                        // Flash (sekali pakai, auto-hapus setelah ditampilkan)
                        return redirect('/')->with('success', 'Berhasil login!');
                        PHP, 'lang' => 'php'],
                    ['p' => 'Di view:'],
                    ['code' => <<<'BLADE'
                        {{ session('success') }}  {{-- atau null --}}
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        BLADE, 'lang' => 'blade'],
                ],
            ],

            // ===== MIDDLEWARE =====
            [
                'id'    => '10-middleware',
                'title' => 'ðŸš¦ Middleware',
                'parts' => [
                    ['p' => 'Middleware adalah filter yang menjalankan kode sebelum/sesudah request masuk ke controller. Daftarkan di config/app.php:'],
                    ['code' => <<<'PHP'
                        'middleware' => [
                            'auth'  => App\Middleware\Authenticate::class,
                            'guest' => App\Middleware\RedirectIfAuthenticated::class,
                            'admin' => App\Middleware\AdminOnly::class,
                        ],
                        PHP, 'lang' => 'php'],
                    ['p' => 'Pakai di route:'],
                    ['code' => <<<'PHP'
                        Route::get('/dashboard', [DashboardController::class, 'index'])
                            ->middleware('auth');

                        Route::group(['middleware' => 'admin'], function () {
                            Route::get('/admin', [AdminController::class, 'index']);
                        });
                        PHP, 'lang' => 'php'],
                    ['p' => 'Buat middleware:'],
                    ['code' => <<<'PHP'
                        <?php
                        namespace App\Middleware;

                        use Sakuci\Http\Request;
                        use Sakuci\Middleware;

                        class MyMiddleware extends Middleware
                        {
                            public function handle(Request $request, \Closure $next): mixed
                            {
                                // Sebelum masuk controller
                                if (/* kondisi gagal */) {
                                    abort(403, 'Tidak diizinkan');
                                }

                                $response = $next($request);

                                // Setelah controller selesai
                                return $response;
                            }
                        }
                        PHP, 'lang' => 'php'],
                ],
            ],

            // ===== MULTI-ROLE (dari awal) =====
            [
                'id'    => '11-multi-role',
                'title' => 'ðŸ‘¥ Multi-Role Login System',
                'parts' => [
                    ['p' => 'Sistem login dengan 3 role: admin, staff, user. Lihat awal dokumentasi untuk detailnya.'],
                    ['p' => 'Coba login dengan salah satu akun demo:'],
                    ['table' => [
                        ['username' => 'admin', 'password' => 'rahasia123', 'akses' => '/admin'],
                        ['username' => 'staff', 'password' => 'rahasia123', 'akses' => '/staff'],
                        ['username' => 'budi',  'password' => 'rahasia123', 'akses' => '/dashboard'],
                    ]],
                ],
            ],

            // ===== TIPS =====
            [
                'id'    => '12-tips',
                'title' => 'ðŸ’¡ Tips & Trik',
                'parts' => [
                    ['p' => '<strong>Helper global yang tersedia:</strong>'],
                    ['code' => <<<'PHP'
                        view('name', ['var' => 'value'])     // Render view
                        route('name', ['id' => 1])           // Generate URL
                        redirect('/path')                    // Redirect
                        redirect(route('home'))
                        back()                               // Kembali ke halaman sebelumnya
                        old('field')                         // Nilai input sebelumnya
                        errors()                             // Object error dari validasi
                        session('key')                       // Baca session
                        dd($var)                             // Dump & die
                        abort(404, 'Not found')              // Abort dengan status code
                        PHP, 'lang' => 'php'],
                    ['p' => '<strong>Eager loading (cegah N+1):</strong>'],
                    ['code' => <<<'PHP'
                        // Buruk: 11 query (1 posts + 10 comments)
                        foreach (Post::all() as $post) {
                            echo $post->comments;
                        }

                        // Bagus: 2 query (1 posts + 1 comments)
                        foreach (Post::with('comments')->get() as $post) {
                            echo $post->comments;
                        }

                        // Nested
                        Post::with('comments.user')->get();
                        PHP, 'lang' => 'php'],
                    ['p' => '<strong>Join data dari tabel lain:</strong>'],
                    ['code' => <<<'PHP'
                        User::leftJoin('profil', 'profil.user_id', '=', 'users.id')
                            ->select('users.nama', 'profil.alamat')
                            ->get();
                        PHP, 'lang' => 'php'],
                ],
            ],
        ];
    }
}

