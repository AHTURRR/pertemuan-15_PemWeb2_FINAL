<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Anggota</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Detail Profil Anggota</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item">
                                <strong>Kode Anggota:</strong> <br>
                                {{ $anggota['kode'] }}
                            </li>
                            <li class="list-group-item">
                                <strong>Nama Lengkap:</strong> <br>
                                {{ $anggota['nama'] }}
                            </li>
                            <li class="list-group-item">
                                <strong>Email:</strong> <br>
                                {{ $anggota['email'] }}
                            </li>
                            <li class="list-group-item">
                                <strong>Telepon:</strong> <br>
                                {{ $anggota['telepon'] }}
                            </li>
                            <li class="list-group-item">
                                <strong>Alamat:</strong> <br>
                                {{ $anggota['alamat'] }}
                            </li>
                            <li class="list-group-item">
                                <strong>Status:</strong> <br>
                                @if($anggota['status'] == 'Aktif')
                                    <span class="badge bg-success">{{ $anggota['status'] }}</span>
                                @elseif($anggota['status'] == 'Tidak Aktif')
                                    <span class="badge bg-secondary">{{ $anggota['status'] }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $anggota['status'] }}</span>
                                @endif
                            </li>
                        </ul>
                        
                        <div class="text-end">
                            <a href="{{ url('/anggota') }}" class="btn btn-secondary">
                                &laquo; Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>