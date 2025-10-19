@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'bg-seagreen rounded px-4 py-2 font-medium text-sm text-white absolute top-4 right-6 z-[11111] hover:bg-seagreen']) }}>
        {{ $status }}
        <span class="menu-icon"><i class="mdi mdi-close"></i></span>
    </div>
@endif
