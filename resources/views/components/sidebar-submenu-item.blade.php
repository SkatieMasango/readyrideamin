{{-- @props([
  'active',
])

@php
  $classes =
    $active ?? false
      ? 'text-white rounded-lg before:block py-2.5 px-3 transition-all duration-300  ease-in-out text-ellipsis text-sm overflow-hidden whitespace-nowrap max-w-52 before:content-[""] before:absolute before:left-[-16px] before:top-0 before:w-4 before:h-[22px] before:rounded-bl-lg before:border-l-2 before:border-b-2 before:border-white'
      : 'rounded-lg before:block py-2.5 px-3 transition-all duration-300 hover:text-white ease-in-out text-white text-ellipsis text-sm overflow-hidden whitespace-nowrap max-w-52 before:content-[""] before:absolute before:left-[-16px] before:top-0 before:w-4 before:h-[22px] before:rounded-bl-lg before:border-l-2 before:border-b-2 before:border-gray-200 hover:before:border-white';

  $styles =
    $active ?? false
      ? 'background-color: rgba(20, 105, 181, 0.24);'
      : 'background-color: #0E2743;';
@endphp




<a {{ $attributes->merge(['class' => $classes]) }}{{ $attributes->merge(['style' => $styles]) }}>
  {{ $slot }}
</a> --}}


@props(['active' => false])

@php
  $isActive = $active;

  $classes = $isActive
    ? 'scroll-mt-16 ms-2 text-white rounded-lg before:block py-2.5 px-3 transition-all duration-300 ease-in-out text-ellipsis text-sm overflow-hidden whitespace-nowrap max-w-full ms-1'
    : 'scroll-mt-16 ms-2 rounded-lg before:block py-2.5 px-3 transition-all duration-300 hover:text-white ease-in-out text-white text-ellipsis text-sm overflow-hidden whitespace-nowrap max-w-full ms-1';

  $lineStyle = $isActive
    ? 'width: 3px; height:40px; background-color:#1469B5; margin-left: -6px;'
    : 'width: 3px; height:40px; background-color:#FFFFFF; opacity: 8%; margin-left: -6px;';

  $circleStyle = $isActive
    ? 'width:10px; height:10px; border-radius:50%; background-color:#1469B5; margin-top:15px; margin-left: -3.5px;'
    : 'width:10px; height:10px; border-radius:50%; background-color:#FFFFFF; margin-top:15px; margin-left: -3.5px;';

  $styles = $isActive
    ? 'background-color: rgba(20, 105, 181, 0.24); width:190px'
    : 'background-color: #0E2743; width:190px';
@endphp

<div class="relative flex items-center gap-1 w-full" >
  <div style="{{ $lineStyle }}">
    <div style="{{ $circleStyle }}"></div>
  </div>

  <a
    id="{{ $attributes->get('id') ?? '' }}"
    {{ $attributes->merge(['class' => $classes]) }}
    style="{{ $styles }}"
    data-scroll-id="{{ $attributes->get('id') }}"
  >
    {{ $slot }}
  </a>
</div>


