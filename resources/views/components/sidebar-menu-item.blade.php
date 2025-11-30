@props([
  'href' => '#',
  'active',
])

@php
  $classes =
    $active ?? false
      ? 'flex w-full items-center justify-between gap-x-3 rounded-md p-2 text-left text-sm font-semibold leading-6 text-white'
      : 'flex w-full items-center justify-between gap-x-3 rounded-md p-2 text-left text-sm font-semibold leading-6 text-white ';

    $styles =
    $active ?? false
      ? 'background-color: rgba(20, 105, 181, 0.24);'
      : 'background-color: #0E2743;';

@endphp


<a
  href="{{ $href }}"
  {{ $attributes->merge(['class' => $classes]) }} {{ $attributes->merge(['style' => $styles]) }}
>
  {{ $slot }}
</a>
