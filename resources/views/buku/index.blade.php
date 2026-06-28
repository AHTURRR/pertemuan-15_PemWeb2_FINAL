@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <x-page-header
        title="Daftar Buku"
        subtitle="Kelola koleksi buku, pantau stok, dan temukan data buku dengan cepat."
        icon="bi-journal-bookmark"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Buku'],
        ]"
    >
        <x-slot name="actions">
            <button type="button" id="btn-bulk-delete" class="btn btn-danger d-none">
                <i class="bi bi-trash"></i> Hapus Terpilih (<span id="jumlah-terpilih">0</span>)
            </button>
            <a href="{{ route('buku.export') }}" class="btn btn-success" data-loading-link>
                <i class="bi bi-file-earmark-spreadsheet"></i> Export
            </a>
            <a href="{{ route('buku.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Buku
            </a>
        </x-slot>
    </x-page-header>

    <div class="stat-grid">
        <x-stat-card label="Total Buku" :value="$totalBuku" icon="bi-bookshelf" variant="primary" />
        <x-stat-card label="Buku Tersedia" :value="$bukuTersedia" icon="bi-check-circle" variant="success" />
        <x-stat-card label="Buku Habis" :value="$bukuHabis" icon="bi-x-circle" variant="danger" />
        <x-stat-card label="Data Ditampilkan" :value="$bukus->count()" icon="bi-table" variant="info" />
    </div>

    <div class="app-card">
        <form action="{{ route('buku.search') }}" method="GET" class="row g-3 align-items-end" data-no-loading>
            <div class="col-lg-4">
                <label for="keyword" class="form-label">Cari Buku</label>
                <input type="text" id="keyword" name="keyword" class="form-control"
                    placeholder="Cari judul, pengarang, atau penerbit..." value="{{ request('keyword') }}">
                <div class="form-text">Gunakan kata kunci agar koleksi lebih cepat ditemukan.</div>
            </div>
            <div class="col-md-4 col-lg-2">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="kategori" id="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList ?? [] as $kat)
                        <option value="{{ $kat }}" @selected(request('kategori', $kategori ?? '') == $kat)>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label for="tahun" class="form-label">Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach ($tahunList ?? [] as $tahun)
                        <option value="{{ $tahun }}" @selected(request('tahun') == $tahun)>{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label for="ketersediaan" class="form-label">Ketersediaan</label>
                <select name="ketersediaan" id="ketersediaan" class="form-select">
                    <option value="">Semua</option>
                    <option value="tersedia" @selected(request('ketersediaan') == 'tersedia')>Tersedia</option>
                    <option value="habis" @selected(request('ketersediaan') == 'habis')>Habis</option>
                </select>
            </div>
            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-search"></i> Cari
                </button>
                <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Reset filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="app-card table-card">
        <div class="table-toolbar">
            <div>
                <h3 class="h5 fw-bold mb-1">Koleksi Buku</h3>
                <p class="text-muted mb-0">Menampilkan {{ $bukus->count() }} data buku.</p>
            </div>
            <div class="input-group search-box">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" placeholder="Cari cepat di tabel..." data-table-search="#bukuTable">
            </div>
        </div>

        <form id="form-bulk-delete" action="{{ route('buku.bulk-delete') }}" method="POST"
            data-confirm
            data-confirm-title="Hapus Buku Terpilih"
            data-confirm-text="Apakah Anda yakin ingin menghapus semua buku yang dipilih?"
            data-confirm-button="Ya, Hapus">
            @csrf
            <div id="hidden-ids"></div>
        </form>

        @if ($bukus->count())
            <div class="table-responsive">
                <table class="table align-middle" id="bukuTable">
                    <thead>
                        <tr>
                            <th style="width: 48px;">
                                <input class="form-check-input" type="checkbox" id="select-all" aria-label="Pilih semua buku">
                            </th>
                            <th>Buku</th>
                            <th>Kategori</th>
                            <th>Pengarang</th>
                            <th class="text-end">Tahun</th>
                            <th class="text-end">Stok</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bukus as $buku)
                            <tr>
                                <td>
                                    <input class="form-check-input checkbox-buku" type="checkbox" data-id="{{ $buku->id }}" aria-label="Pilih {{ $buku->judul }}">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $buku->judul }}</div>
                                    <div class="text-muted small">{{ $buku->kode_buku }} · {{ $buku->penerbit }}</div>
                                </td>
                                <td><span class="badge bg-primary-subtle text-primary">{{ $buku->kategori }}</span></td>
                                <td>{{ $buku->pengarang }}</td>
                                <td class="text-end">{{ $buku->tahun_terbit }}</td>
                                <td class="text-end fw-bold">{{ $buku->stok }}</td>
                                <td>
                                    @if ($buku->stok > 0)
                                        <span class="badge bg-success">Tersedia</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="Aksi buku">
                                        <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" data-confirm
                                            data-confirm-title="Hapus Buku"
                                            data-confirm-text="Apakah Anda yakin ingin menghapus buku '{{ $buku->judul }}'?"
                                            data-confirm-button="Ya, Hapus">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state
                title="Belum ada data buku"
                message="Tambahkan buku agar pengguna dapat mulai melakukan peminjaman."
                icon="bi-journal-plus"
                :actionUrl="route('buku.create')"
                actionLabel="Tambah Buku"
            />
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const btnBulk = document.getElementById('btn-bulk-delete');
            const formBulk = document.getElementById('form-bulk-delete');
            const hiddenIds = document.getElementById('hidden-ids');

            function selectedBoxes() {
                return document.querySelectorAll('.checkbox-buku:checked');
            }

            function updateSelectedState() {
                const total = selectedBoxes().length;
                document.getElementById('jumlah-terpilih').textContent = total;
                btnBulk.classList.toggle('d-none', total === 0);
            }

            selectAll?.addEventListener('change', function() {
                document.querySelectorAll('.checkbox-buku').forEach(cb => cb.checked = this.checked);
                updateSelectedState();
            });

            document.querySelectorAll('.checkbox-buku').forEach(cb => {
                cb.addEventListener('change', updateSelectedState);
            });

            btnBulk?.addEventListener('click', function() {
                hiddenIds.innerHTML = '';
                selectedBoxes().forEach(cb => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'buku_ids[]';
                    input.value = cb.dataset.id;
                    hiddenIds.appendChild(input);
                });
                formBulk.requestSubmit();
            });
        });
    </script>
@endpush
