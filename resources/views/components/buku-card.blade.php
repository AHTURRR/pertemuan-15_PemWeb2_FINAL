@php
    $judul = data_get($buku, 'judul', '-');
    $pengarang = data_get($buku, 'pengarang', '-');
    $kategori = data_get($buku, 'kategori', '-');
    $harga = data_get($buku, 'harga', 0);
    $stok = data_get($buku, 'stok', 0);
@endphp

<div class="card border-0 shadow-sm h-100">
    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
        <i class="bi bi-book fs-1 text-secondary"></i>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <h5 class="card-title fw-bold mb-2">{{ $judul }}</h5>
            <span class="badge bg-info text-dark">{{ $kategori }}</span>
        </div>
        <p class="text-muted mb-3">{{ $pengarang }}</p>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="fw-semibold">Rp {{ number_format($harga, 0, ',', '.') }}</div>
                <small class="text-muted">Stok: {{ $stok }}</small>
            </div>
            @if ($stok > 0)
                <span class="badge bg-success">Tersedia</span>
            @else
                <span class="badge bg-danger">Habis</span>
            @endif
        </div>
    </div>
    @if ($showActions)
        <div class="card-footer bg-white border-0 pt-0">
            <div class="d-flex gap-2">
                <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
                <a href="#" class="btn btn-primary btn-sm">Edit</a>
            </div>
        </div>
    @endif
</div>
