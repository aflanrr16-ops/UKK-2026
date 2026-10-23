<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengembalian - Alat Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-family: Arial, sans-serif;
        }
        .table th, .table td {
            font-size: 0.9rem;
            vertical-align: middle;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
            .container {
                max-width: 100% !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body> <!-- Dihapus: onload="window.print()" -->

    <div class="container py-4">
        <!-- Tombol Aksi (Hilang Saat Diprint) -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-secondary btn-sm">
                &larr; Kembali
            </a>
        </div>

        <!-- Kop Laporan -->
        <div class="text-center border-bottom pb-3 mb-4">
            <h3 class="fw-bold text-uppercase m-0">Laporan Pengembalian Alat</h3>
            <p class="text-muted m-0 small">Sistem Peminjaman Alat Sekolah</p>
            <p class="text-muted small">Dicetak pada: {{ date('d F Y H:i') }} oleh {{ $user->username ?? 'Petugas' }}</p>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tgl Kembali</th>
                        <th width="25%">Nama Peminjam</th>
                        <th width="30%">Nama Alat</th>
                        <th width="15%">Kondisi</th>
                        <th width="10%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datap as $index => $item)
                        @php
                            $peminjaman = $peminjamanList[$item->id_peminjaman] ?? null;
                            $namaUser = $peminjaman ? ($userList[$peminjaman->id_user] ?? 'Tidak diketahui') : 'Tidak diketahui';
                            $namaAlat = $peminjaman ? ($alatList[$peminjaman->id_alat] ?? 'Alat dihapus') : 'Alat dihapus';
                        @endphp
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->tanggal_pengembalian)) }}</td>
                            <td>{{ $namaUser }}</td>
                            <td>{{ $namaAlat }}</td>
                            <td class="text-center">{{ ucfirst($item->kondisi_barang ?? 'Baik') }}</td>
                            <td class="text-center">Selesai</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pengembalian alat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tanda Tangan -->
        <div class="row mt-5">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-5">Petugas Pengelola,</p>
                <br>
                <p class="fw-bold border-bottom pb-1 mb-0">{{ $user->username ?? 'Petugas ' }}</p>
                <small class="text-muted">NIP. ............................</small>
            </div>
        </div>
    </div>

</body>
</html>