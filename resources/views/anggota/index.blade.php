<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota Perpustakaan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Daftar Anggota Perpustakaan</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Anggota</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggota_list as $index => $anggota)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $anggota['kode'] }}</td>
                            <td>{{ $anggota['nama'] }}</td>
                            <td>{{ $anggota['email'] }}</td>
                            <td>
                                <!-- Pengkondisian warna badge sesuai status -->
                                @if($anggota['status'] == 'Aktif')
                                    <span class="badge bg-success">{{ $anggota['status'] }}</span>
                                @elseif($anggota['status'] == 'Tidak Aktif')
                                    <span class="badge bg-secondary">{{ $anggota['status'] }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $anggota['status'] }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/anggota/' . $anggota['id']) }}" class="btn btn-sm btn-info text-white">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>