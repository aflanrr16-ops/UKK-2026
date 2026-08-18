# Tutorial Batara Framework

Panduan langkah demi langkah untuk pemula. Di akhir tutorial ini Anda akan punya
aplikasi **Data Buku** dengan fitur tambah, lihat, ubah, dan hapus (CRUD).

**Daftar isi**

1. [Persiapan](#1-persiapan)
2. [Menjalankan server](#2-menjalankan-server)
3. [Mengatur database MySQL](#3-mengatur-database-mysql)
4. [Membuat tabel (migrasi)](#4-membuat-tabel-migrasi)
5. [Membuat Model](#5-membuat-model)
6. [Membuat Controller](#6-membuat-controller)
7. [Membuat View](#7-membuat-view)
8. [Mendaftarkan Route](#8-mendaftarkan-route)
9. [Latihan: CRUD lengkap](#9-latihan-crud-lengkap)
10. [Kalau error](#10-kalau-error)

---

## 1. Persiapan

Yang dibutuhkan:

- **PHP 8.1 atau lebih baru**
- **MySQL / MariaDB** — paling gampang lewat **XAMPP** atau **Laragon**

Cek PHP sudah terpasang. Buka terminal (CMD / PowerShell), ketik:

```bash
php -v
```

Kalau muncul tulisan `PHP 8.x.x`, berarti aman. Kalau muncul `'php' is not recognized`,
PHP belum ada di PATH — pakai XAMPP dan jalankan lewat `C:\xampp\php\php.exe`.

Lalu masuk ke folder framework:

```bash
cd C:\batara-framework
```

> **Catatan penting:** semua perintah `php batara ...` di tutorial ini
> **harus dijalankan dari dalam folder framework**, bukan dari folder lain.

---

## 2. Menjalankan server

Ada dua cara. Pilih salah satu.

### Cara A — server bawaan PHP (paling mudah)

```bash
php batara serve
```

Akan muncul:

```
  Batara Framework v1.0.0
  Server berjalan di http://127.0.0.1:8000
  Tekan Ctrl+C untuk berhenti.
```

Buka browser ke **http://127.0.0.1:8000** — halaman selamat datang akan tampil.

Mau ganti port (misalnya 8080 karena 8000 dipakai aplikasi lain)?

```bash
php batara serve 127.0.0.1 8080
```

Untuk menghentikan server: tekan `Ctrl + C` di terminal.

> Biarkan terminal ini tetap terbuka selama Anda ngoding. Buka terminal **kedua**
> untuk menjalankan perintah `php batara` yang lain.

### Cara B — lewat XAMPP (Apache)

1. Salin seluruh folder `batara-framework` ke `C:\xampp\htdocs\`
2. Nyalakan **Apache** di XAMPP Control Panel
3. Buka **http://localhost/batara-framework/**

File `.htaccess` sudah disiapkan supaya URL otomatis diarahkan ke folder `public/`.

---

## 3. Mengatur database MySQL

### Langkah 1 — nyalakan MySQL

Buka **XAMPP Control Panel**, klik **Start** pada baris **MySQL**.
Tunggu sampai tulisannya berubah jadi hijau.

### Langkah 2 — buat database

Buka **http://localhost/phpmyadmin** di browser:

1. Klik menu **New** / **Baru** di kiri atas
2. Isi nama database: **`batara_belajar`**
3. Pilih collation **`utf8mb4_general_ci`**
4. Klik **Create** / **Buat**

Kalau lebih suka lewat tab **SQL**, jalankan:

```sql
CREATE DATABASE batara_belajar CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

### Langkah 3 — edit file `.env`

Buka file **`.env`** di folder framework pakai teks editor (VS Code, Notepad++, dll),
lalu sesuaikan bagian database:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=batara_belajar
DB_USERNAME=root
DB_PASSWORD=
```

Keterangan tiap baris:

| Baris | Isi |
|---|---|
| `DB_DATABASE` | Nama database yang tadi dibuat |
| `DB_USERNAME` | Di XAMPP biasanya `root` |
| `DB_PASSWORD` | Di XAMPP biasanya **dikosongkan**. Di Laragon juga `root` tanpa password |

> Kalau file `.env` belum ada, salin dari `.env.example` dan ganti namanya jadi `.env`.

### Langkah 4 — uji koneksinya

```bash
php batara db:check
```

Kalau berhasil:

```
  Menguji koneksi database...

    DB_CONNECTION : mysql
    Host          : 127.0.0.1:3306
    Database      : batara_belajar
    Username      : root
    Password      : (kosong)

  ✔ Koneksi berhasil. Versi server: 8.0.36
    Jumlah tabel  : 0
```

Kalau gagal, pesan errornya sudah disertai saran perbaikan — baca
[bagian 10](#10-kalau-error).

### Alternatif: tanpa MySQL (SQLite)

Kalau belum sempat pasang MySQL, ganti satu baris saja di `.env`:

```ini
DB_CONNECTION=sqlite
```

File database otomatis dibuat di `database/database.sqlite`. Syaratnya ekstensi
`pdo_sqlite` aktif di `php.ini`.

---

## 4. Membuat tabel (migrasi)

Migrasi adalah file `.sql` berisi perintah pembuatan tabel. Keuntungannya:
struktur tabel ikut tersimpan bersama kode, jadi teman satu kelompok tinggal
menjalankan satu perintah.

Buat file migrasi:

```bash
php batara make:migration create_buku_table
```

Hasilnya muncul file baru di `database/migrations/` dengan nama berawalan tanggal,
misalnya `2026_08_19_101500_create_buku_table.sql`. Buka file itu, ubah isinya jadi:

```sql
-- create_buku_table

CREATE TABLE IF NOT EXISTS `buku` (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul      VARCHAR(150) NOT NULL,
    penulis    VARCHAR(100) NOT NULL,
    tahun      INT NULL,
    stok       INT NOT NULL DEFAULT 0,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

> Kolom `created_at` dan `updated_at` diisi otomatis oleh model. Sebaiknya selalu
> disertakan.

Jalankan migrasinya:

```bash
php batara migrate
```

```
  ✔ 2026_08_19_101500_create_buku_table.sql

  Selesai. 1 migrasi dijalankan.
```

Cek di phpMyAdmin — tabel `buku` sudah ada.

**Perintah migrasi yang perlu diingat:**

| Perintah | Fungsi |
|---|---|
| `php batara migrate` | Jalankan migrasi yang belum pernah dijalankan |
| `php batara migrate:fresh` | Hapus **semua** tabel (hati-hati, data ikut hilang) |
| `php batara db:check` | Lihat tabel apa saja yang sudah ada |

> Migrasi yang sudah pernah jalan **tidak akan diulang**. Kalau Anda mengubah isi
> file migrasi lama, jalankan `php batara migrate:fresh` lalu `php batara migrate`.

---

## 5. Membuat Model

Model adalah kelas PHP yang mewakili satu tabel. Lewat model inilah kita
menyimpan dan mengambil data — tanpa menulis SQL manual.

```bash
php batara make:model Buku
```

File baru muncul di `app/Models/Buku.php`. Buka dan lengkapi:

```php
<?php

namespace App\Models;

use Batara\Database\Model;

class Buku extends Model
{
    // Nama tabel di database
    protected static ?string $table = 'buku';

    // Kolom yang boleh diisi lewat create() dan update()
    protected array $fillable = ['judul', 'penulis', 'tahun', 'stok'];
}
```

> **Kenapa perlu `$fillable`?** Supaya pengunjung nakal tidak bisa mengisi kolom
> yang tidak Anda izinkan lewat form. Kolom di luar daftar ini akan diabaikan.

### Mencoba model

Sekarang model sudah bisa dipakai. Perintah-perintah yang tersedia:

```php
// Mengambil data
Buku::all();                                  // semua baris
Buku::find(1);                                // cari berdasarkan id
Buku::findOrFail(1);                          // sama, tapi tampilkan 404 kalau tidak ada
Buku::where('penulis', 'Andi')->get();        // dengan syarat
Buku::where('stok', '>', 0)->latest()->get(); // syarat + urut terbaru
Buku::query()->paginate(10);                  // dibagi per halaman
Buku::count();                                // hitung jumlah baris

// Menyimpan data
Buku::create([
    'judul'   => 'Belajar PHP',
    'penulis' => 'Andi',
    'tahun'   => 2026,
    'stok'    => 5,
]);

// Mengubah data
$buku = Buku::find(1);
$buku->judul = 'Judul Baru';
$buku->save();

// atau sekaligus
$buku->update(['stok' => 10]);

// Menghapus
$buku->delete();
```

---

## 6. Membuat Controller

Controller adalah tempat menulis logika: mengambil data dari model, lalu
mengirimkannya ke view.

```bash
php batara make:controller BukuController
```

File baru muncul di `app/Controllers/BukuController.php`. Ubah isinya:

```php
<?php

namespace App\Controllers;

use App\Models\Buku;
use Batara\Controller;
use Batara\Http\Request;

class BukuController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        $buku = Buku::latest()->get();

        return view('buku.index', ['buku' => $buku]);
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('buku.create');
    }

    // Menyimpan data dari form
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'   => 'required|min:3|max:150',
            'penulis' => 'required|max:100',
            'tahun'   => 'nullable|integer',
            'stok'    => 'required|integer|min:0',
        ]);

        Buku::create($data);

        return redirect(route('buku.index'))->with('success', 'Buku berhasil ditambahkan.');
    }
}
```

Tiga hal penting di atas:

**`view('buku.index', [...])`** — menampilkan file
`resources/views/buku/index.batara.php`. Titik berarti folder.

**`$request->validate([...])`** — memeriksa isian form. Kalau ada yang salah,
pengunjung otomatis dikembalikan ke form beserta pesan errornya. Baris di
bawahnya tidak akan dijalankan.

**`redirect(...)->with('success', ...)`** — pindah halaman sambil menitipkan
pesan yang bisa ditampilkan sekali di halaman tujuan.

---

## 7. Membuat View

View adalah tampilan HTML-nya. Semua file view ada di `resources/views` dengan
akhiran `.batara.php`.

```bash
php batara make:view buku.index
```

File muncul di `resources/views/buku/index.batara.php`. Isi dengan:

```blade
@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Data Buku</h1>
        <a class="btn btn-brand" href="{{ route('buku.create') }}">Tambah Buku</a>
    </div>

    @forelse ($buku as $b)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h2 class="h5 mb-1">{{ $b->judul }}</h2>
                <p class="text-secondary small mb-0">
                    {{ $b->penulis }} &middot; {{ $b->tahun }} &middot; stok {{ $b->stok }}
                </p>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <p class="text-secondary">Belum ada data buku.</p>
                <a class="btn btn-brand" href="{{ route('buku.create') }}">Tambah sekarang</a>
            </div>
        </div>
    @endforelse

@endsection
```

> Tampilannya memakai **Bootstrap 5.3.8** yang sudah tersedia di folder
> `public/vendor/bootstrap` — tidak perlu unduh apa pun, tidak perlu internet.
> Kelas seperti `card`, `btn`, dan `shadow-sm` berasal dari Bootstrap;
> `btn-brand` adalah warna khas Batara dari `public/css/app.css`.

Penjelasan sintaksnya:

| Sintaks | Arti |
|---|---|
| `@extends('layouts.app')` | Pakai kerangka halaman dari `resources/views/layouts/app.batara.php` |
| `@section('content') ... @endsection` | Isi bagian `content` pada kerangka tersebut |
| `{{ $b->judul }}` | Tampilkan isi variabel (otomatis aman dari serangan XSS) |
| `@forelse ... @empty ... @endforelse` | Perulangan, dengan tampilan cadangan bila data kosong |
| `{{ route('buku.create') }}` | URL berdasarkan **nama route**, bukan ditulis manual |

> **Selalu pakai `{{ }}`**, jangan `<?= ?>`. Tanda kurung kurawal ganda otomatis
> mengamankan output dari kode berbahaya yang diketik pengunjung.

Sekarang buat form tambahnya:

```bash
php batara make:view buku.create
```

Isi `resources/views/buku/create.batara.php`:

```blade
@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tambah Buku</h1>
        <a class="btn btn-outline-secondary" href="{{ route('buku.index') }}">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('buku.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                           class="form-control {{ errors()->has('judul') ? 'is-invalid' : '' }}">
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="penulis">Penulis</label>
                    <input type="text" id="penulis" name="penulis" value="{{ old('penulis') }}"
                           class="form-control {{ errors()->has('penulis') ? 'is-invalid' : '' }}">
                    @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label class="form-label" for="tahun">Tahun</label>
                        <input type="number" id="tahun" name="tahun" value="{{ old('tahun') }}"
                               class="form-control {{ errors()->has('tahun') ? 'is-invalid' : '' }}">
                        @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label class="form-label" for="stok">Stok</label>
                        <input type="number" id="stok" name="stok" value="{{ old('stok', 0) }}"
                               class="form-control {{ errors()->has('stok') ? 'is-invalid' : '' }}">
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-2">
                    <button class="btn btn-brand px-4" type="submit">Simpan</button>
                    <a class="btn btn-outline-secondary" href="{{ route('buku.index') }}">Batal</a>
                </div>
            </form>
        </div>
    </div>

@endsection
```

Empat hal penting pada setiap form:

**`@csrf`** — token keamanan. **Tanpa ini form akan ditolak dengan error 419.**

**`old('judul')`** — mengembalikan isian sebelumnya kalau validasi gagal, supaya
pengunjung tidak perlu mengetik ulang semuanya.

**`@error('judul') ... @enderror`** — menampilkan pesan kesalahan untuk kolom itu.

**`errors()->has('judul') ? 'is-invalid' : ''`** — memberi garis merah pada kotak
isian yang salah. `is-invalid` dan `invalid-feedback` adalah pasangan kelas
Bootstrap: pesan error hanya muncul kalau kotaknya bertanda `is-invalid`.

### Tentang tampilan (Bootstrap)

Batara sudah menyertakan **Bootstrap 5.3.8** secara lokal:

```
public/vendor/bootstrap/css/bootstrap.min.css
public/vendor/bootstrap/js/bootstrap.bundle.min.js
```

Keduanya sudah dipanggil di `resources/views/layouts/app.batara.php`, jadi
**semua view yang memakai `@extends('layouts.app')` otomatis ikut tertata rapi.**
Tidak perlu mengunduh apa pun dan tetap jalan tanpa internet — cocok untuk
praktik di lab sekolah.

Kelas yang paling sering dipakai:

| Kelas | Fungsi |
|---|---|
| `card`, `card-body`, `shadow-sm` | Kotak putih dengan bayangan |
| `btn btn-brand` | Tombol warna khas Batara |
| `btn btn-outline-secondary` | Tombol abu-abu bergaris |
| `form-label`, `form-control` | Label dan kotak isian form |
| `is-invalid`, `invalid-feedback` | Menandai isian yang salah |
| `table table-hover` | Tabel data |
| `mb-3`, `mt-4`, `p-4`, `gap-2` | Jarak antar elemen |
| `row`, `col-sm-6` | Membagi kolom |

Rujukan lengkapnya di <https://getbootstrap.com/docs/5.3/>.

**Mengubah warna khas** — buka `public/css/app.css`, ubah baris ini:

```css
:root {
    --brand: #c2410c;        /* ganti dengan warna pilihan Anda */
    --brand-dark: #9a3412;   /* versi lebih gelap untuk efek hover */
}
```

**Menambah menu di navbar** — buka `resources/views/layouts/app.batara.php`,
cari `<ul class="navbar-nav ...">`, lalu tambahkan:

```blade
<li class="nav-item">
    <a class="nav-link" href="{{ route('buku.index') }}">Data Buku</a>
</li>
```

---

## 8. Mendaftarkan Route

Route menghubungkan alamat URL dengan method di controller. Buka
`routes/web.php`, tambahkan:

```php
<?php

use App\Controllers\BukuController;
use Batara\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
```

Cara membacanya:

```php
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
//     ↑        ↑              ↑             ↑                  ↑
//   method    URL         controller      method          nama route
```

`->name('buku.index')` inilah yang membuat `route('buku.index')` di view
menghasilkan URL yang benar. Kalau nanti URL-nya diubah, view tidak perlu diedit.

Lihat semua route yang terdaftar:

```bash
php batara route:list
```

Sekarang jalankan servernya dan buka **http://127.0.0.1:8000/buku**.
Coba tambah buku lewat tombol **Tambah Buku**.

Coba juga kosongkan judul lalu tekan Simpan — pesan error akan muncul dan isian
lain tetap terisi.

---

## 9. Latihan: CRUD lengkap

Sejauh ini baru ada **C** (create) dan **R** (read). Untuk melengkapinya jadi
**U** (update) dan **D** (delete), ganti seluruh isi `routes/web.php` bagian buku
dengan satu baris:

```php
Route::resource('buku', BukuController::class);
```

Satu baris itu setara dengan tujuh route sekaligus:

| Method | URL | Controller | Nama route |
|---|---|---|---|
| GET | /buku | index | buku.index |
| GET | /buku/create | create | buku.create |
| POST | /buku | store | buku.store |
| GET | /buku/{id} | show | buku.show |
| GET | /buku/{id}/edit | edit | buku.edit |
| PUT | /buku/{id} | update | buku.update |
| DELETE | /buku/{id} | destroy | buku.destroy |

Lengkapi `BukuController` dengan empat method sisanya:

```php
    // Menampilkan satu buku.
    // Parameter bertipe Buku otomatis diambil dari database berdasarkan {id}.
    public function show(Buku $buku)
    {
        return view('buku.show', ['buku' => $buku]);
    }

    // Menampilkan form ubah
    public function edit(Buku $buku)
    {
        return view('buku.edit', ['buku' => $buku]);
    }

    // Menyimpan perubahan
    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'judul'   => 'required|min:3|max:150',
            'penulis' => 'required|max:100',
            'tahun'   => 'nullable|integer',
            'stok'    => 'required|integer|min:0',
        ]);

        $buku->update($data);

        return redirect(route('buku.index'))->with('success', 'Buku berhasil diperbarui.');
    }

    // Menghapus
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect(route('buku.index'))->with('success', 'Buku berhasil dihapus.');
    }
```

> Perhatikan `show(Buku $buku)` — cukup tulis tipenya, framework otomatis
> mencarikan datanya dari database. Kalau tidak ketemu, muncul halaman 404.
> Ini namanya **route model binding**.

Buat view `buku.edit` — salin saja isi `buku.create`, lalu ubah tiga hal:

```blade
<form method="POST" action="{{ route('buku.update', ['id' => $buku->id]) }}">
    @csrf
    @method('PUT')                              {{-- 1. wajib untuk update --}}

    <div class="mb-3">
        <label class="form-label" for="judul">Judul</label>
        <input type="text" id="judul" name="judul"
               value="{{ old('judul', $buku->judul) }}"
               {{-- 2. argumen kedua = data lama dari database --}}
               class="form-control {{ errors()->has('judul') ? 'is-invalid' : '' }}">
        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    ...

    {{-- 3. action mengarah ke buku.update, tombolnya "Perbarui" --}}
    <button class="btn btn-brand px-4" type="submit">Perbarui</button>
</form>
```

Terakhir, tambahkan tombol Ubah dan Hapus di `buku.index`. Ganti isi
`card-body` pada `@forelse` menjadi:

```blade
<div class="card-body d-flex justify-content-between align-items-center gap-3">
    <div>
        <h2 class="h5 mb-1">{{ $b->judul }}</h2>
        <p class="text-secondary small mb-0">
            {{ $b->penulis }} &middot; {{ $b->tahun }} &middot; stok {{ $b->stok }}
        </p>
    </div>

    <div class="d-flex gap-2 flex-shrink-0">
        <a class="btn btn-sm btn-outline-secondary"
           href="{{ route('buku.edit', ['id' => $b->id]) }}">Ubah</a>

        <form method="POST" action="{{ route('buku.destroy', ['id' => $b->id]) }}"
              onsubmit="return confirm('Yakin hapus buku ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-outline-danger" type="submit">Hapus</button>
        </form>
    </div>
</div>
```

> **Kenapa hapus pakai `<form>`, bukan `<a href>`?** Karena penghapusan mengubah
> data. Link biasa bisa terpicu tanpa sengaja oleh browser atau mesin pencari.
> HTML hanya mengenal GET dan POST, jadi `@method('DELETE')` dipakai untuk
> memberi tahu framework bahwa ini sebenarnya permintaan DELETE.

Selesai — CRUD Anda lengkap.

---

## 10. Kalau error

### `Gagal terhubung ke database ... Unknown database "xxx"`

Databasenya belum dibuat. Buka phpMyAdmin, buat database dengan nama yang persis
sama seperti `DB_DATABASE` di `.env`.

### `Gagal terhubung ke database ... Access denied for user 'root'`

Username atau password salah. Di XAMPP biasanya `DB_USERNAME=root` dan
`DB_PASSWORD=` (dikosongkan). Cek lagi `.env`, lalu:

```bash
php batara db:check
```

### `Gagal terhubung ke database ... Server MySQL tidak berjalan`

Nyalakan MySQL di XAMPP Control Panel.

### `could not find driver`

Ekstensi database belum aktif. Buka `php.ini`, cari baris berikut dan hapus
titik-koma di depannya:

```ini
extension=pdo_mysql
```

Simpan, lalu restart Apache / server.

### Error 419 saat submit form

`@csrf` lupa ditulis di dalam `<form>`. Tambahkan tepat setelah tag `<form>`.

### `Route dengan nama [xxx] tidak terdaftar`

Nama di `route('xxx')` tidak cocok dengan `->name('xxx')` di `routes/web.php`.
Cek daftarnya:

```bash
php batara route:list
```

### `View [xxx] tidak ditemukan`

Nama file atau foldernya salah. `view('buku.index')` mencari file
`resources/views/buku/index.batara.php`. Pastikan akhirannya `.batara.php`,
bukan `.php` saja.

### Halaman tidak berubah padahal view sudah diedit

Bersihkan cache view:

```bash
php batara view:clear
```

### `'php' is not recognized`

PHP belum terdaftar di PATH Windows. Pakai path lengkapnya:

```bash
C:\xampp\php\php.exe batara serve
```

### Tabel tidak berubah padahal file migrasi sudah diedit

Migrasi yang sudah jalan tidak diulang. Hapus semua tabel lalu bangun ulang:

```bash
php batara migrate:fresh
```

```bash
php batara migrate
```

---

## Ringkasan perintah

```bash
php batara serve                    # jalankan server
php batara db:check                 # uji koneksi database
php batara migrate                  # buat tabel dari file migrasi
php batara migrate:fresh            # hapus semua tabel
php batara route:list               # lihat semua route
php batara make:migration nama      # buat file migrasi
php batara make:model Nama          # buat model
php batara make:controller Nama     # buat controller
php batara make:view nama.view      # buat view
php batara view:clear               # bersihkan cache view
```

## Alur berpikir saat menambah fitur baru

```
1. Tabel   →  make:migration  →  edit file .sql  →  migrate
2. Model   →  make:model      →  isi $table dan $fillable
3. Route   →  edit routes/web.php
4. Control →  make:controller →  ambil data, kirim ke view
5. View    →  make:view       →  tampilkan datanya
```

Rujukan sintaks selengkapnya ada di **README.md**.
