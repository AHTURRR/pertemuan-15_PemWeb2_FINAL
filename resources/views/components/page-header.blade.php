@props([
    'title',
    'subtitle' => null,
    'icon' => 'bi-circle',
    'breadcrumbs' => [],
])

<section class="page-title-card">
    <div>
        @if (!empty($breadcrumbs))
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb mb-0">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if (!empty($breadcrumb['url']))
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['label'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif

        <div class="d-flex align-items-start gap-3">
            <span class="page-icon"><i class="bi {{ $icon }}"></i></span>
            <div>
                <h2 class="page-title">{{ $title }}</h2>
                @if ($subtitle)
                    <p class="page-subtitle">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
    </div>

    @if (isset($actions))
        <div class="page-actions">
            {{ $actions }}
        </div>
    @endif
</section>
