@props(['href' => null])
@php
    $tag = $href ? 'a' : 'button';
    $defaultAttributes = $href ? ['href' => $href] : ['type' => 'submit'];
@endphp

<{{ $tag }} {{ $attributes->merge($defaultAttributes)->merge(['class' => 'inline-flex items-center justify-center gap-2 rounded-lg font-sans font-semibold transition disabled:opacity-50 disabled:pointer-events-none bg-brand-gradient text-white hover:brightness-105 shadow-sm h-10 px-4 text-body-md cursor-pointer']) }}>
    {{ $slot }}
</{{ $tag }}>
