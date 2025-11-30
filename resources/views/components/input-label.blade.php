@props([
  'value',
])

<label
  {{ $attributes->merge(['class' => 'pointer-events-none text-md ']) }}
>
  {{ $value ?? $slot }}
</label>
