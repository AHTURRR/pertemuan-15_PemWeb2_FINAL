@props([
    'label',
    'value',
    'icon' => 'bi-bar-chart',
    'variant' => 'primary',
    'hint' => null,
])

<div class="stat-card stat-{{ $variant }}">
    <div>
        <p>{{ $label }}</p>
        <h3>{{ $value }}</h3>
        @if ($hint)
            <small>{{ $hint }}</small>
        @endif
    </div>
    <span class="stat-icon"><i class="bi {{ $icon }}"></i></span>
</div>
