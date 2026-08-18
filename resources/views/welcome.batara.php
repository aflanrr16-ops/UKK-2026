@extends('layouts.app')

@section('title', config('app.name') . ' — Kerangka PHP Ringan')

@section('content')

    {{-- Hero --}}
    <section class="text-center py-4 py-lg-5">
        <span class="badge rounded-pill badge-brand px-3 py-2 mb-3">Batara v1.0.0</span>

        <h1 class="display-5 fw-bold mb-3">
            Kerangka PHP rasa Laravel,<br class="d-none d-md-inline">
            <span class="text-brand">tanpa Composer</span>
        </h1>

        <p class="lead text-secondary mx-auto mb-4" style="max-width: 620px;">
            Route, Model, View, dan Controller dalam satu paket ringan.
            Cukup PHP OOP murni — salin foldernya, jalankan, selesai.
        </p>

        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a class="btn btn-brand btn-lg px-4" href="#langkah">Mulai dari sini</a>
        </div>

        <p class="text-secondary small mt-3 mb-0">
            Panduan langkah demi langkah ada di berkas
            <code class="inline">TUTORIAL.md</code>
        </p>
    </section>

    {{-- Langkah berikutnya --}}
    <section id="langkah" class="row g-4 align-items-start mb-5">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-semibold mb-3">Langkah berikutnya</h2>

                    <ul class="list-unstyled d-grid gap-3 mb-0">
                        <li class="d-flex gap-3">
                            <span class="step-number">1</span>
                            <div>
                                <div class="fw-medium">Atur koneksi database</div>
                                <div class="text-secondary small">
                                    Edit berkas <code class="inline">.env</code>, lalu uji dengan
                                    <code class="inline">php batara db:check</code>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex gap-3">
                            <span class="step-number">2</span>
                            <div>
                                <div class="fw-medium">Buat tabel</div>
                                <div class="text-secondary small">
                                    <code class="inline">php batara make:migration create_buku_table</code>
                                    lalu <code class="inline">php batara migrate</code>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex gap-3">
                            <span class="step-number">3</span>
                            <div>
                                <div class="fw-medium">Buat model, controller, dan view</div>
                                <div class="text-secondary small">
                                    <code class="inline">make:model</code>,
                                    <code class="inline">make:controller</code>,
                                    <code class="inline">make:view</code>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex gap-3">
                            <span class="step-number">4</span>
                            <div>
                                <div class="fw-medium">Daftarkan route</div>
                                <div class="text-secondary small">
                                    Tulis di <code class="inline">routes/web.php</code>, cek dengan
                                    <code class="inline">php batara route:list</code>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 fw-semibold mb-3">Perintah yang sering dipakai</h2>

                    <pre class="code"><span class="cmt"># jalankan server</span>
php batara serve

<span class="cmt"># uji koneksi database</span>
php batara db:check

<span class="cmt"># lihat semua route</span>
php batara route:list

<span class="cmt"># bantuan lengkap</span>
php batara</pre>
                </div>
            </div>
        </div>
    </section>

    {{-- Empat pilar --}}
    <section>
        <h2 class="h5 fw-semibold mb-3">Empat pilar</h2>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <span class="fw-semibold">Route</span>
                        <span class="text-secondary small ms-1">routes/web.php</span>
                    </div>
                    <div class="card-body">
                        <pre class="code">Route::get('/buku',
    [BukuController::class, 'index'])
    -&gt;name('buku.index');

<span class="cmt">// 7 route CRUD sekaligus</span>
Route::resource('buku',
    BukuController::class);</pre>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <span class="fw-semibold">Controller</span>
                        <span class="text-secondary small ms-1">app/Controllers</span>
                    </div>
                    <div class="card-body">
                        <pre class="code">class BukuController extends Controller
{
    public function index()
    {
        return view('buku.index', [
            'buku' =&gt; Buku::all(),
        ]);
    }
}</pre>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <span class="fw-semibold">Model</span>
                        <span class="text-secondary small ms-1">app/Models</span>
                    </div>
                    <div class="card-body">
                        <pre class="code">Buku::all();
Buku::find(1);
Buku::where('stok', '&gt;', 0)
    -&gt;latest()
    -&gt;paginate(10);

Buku::create(['judul' =&gt; 'PHP']);</pre>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <span class="fw-semibold">View</span>
                        <span class="text-secondary small ms-1">resources/views</span>
                    </div>
                    <div class="card-body">
                        <pre class="code">@@extends('layouts.app')

@@section('content')
    @@foreach ($buku as $b)
        &lt;h2&gt;&#123;&#123; $b-&gt;judul &#125;&#125;&lt;/h2&gt;
    @@endforeach
@@endsection</pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
