@props([
    'title' => 'Belum ada data',
    'message' => 'Data akan muncul di sini setelah tersedia.',
    'icon' => 'bi-inbox',
    'actionUrl' => null,
    'actionLabel' => null,
])

<div class="empty-state">
    <span class="empty-icon"><i class="bi {{ $icon }}"></i></span>
    <h3>{{ $title }}</h3>
    <p>{{ $message }}</p>
    @if ($actionUrl && $actionLabel)
        <a href="{{ $actionUrl }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> {{ $actionLabel }}
        </a>
    @endif
</div>
