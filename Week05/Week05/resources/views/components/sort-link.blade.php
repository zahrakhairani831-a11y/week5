@props(['column', 'label'])

@php
    $aktif = request('sort', 'name') === $column;
    $arahBaru = ($aktif && request('dir', 'asc') === 'asc') ? 'desc' : 'asc';
@endphp

<a href="{{ route('products.index', array_merge(request()->query(), ['sort' => $column, 'dir' => $arahBaru])) }}">
    {{ $label }}
    @if ($aktif)
        {{ request('dir', 'asc') === 'asc' ? '▲' : '▼' }}
    @endif
</a>
