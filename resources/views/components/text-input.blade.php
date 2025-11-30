{{-- @props(['disabled' => false])

<input
  @disabled($disabled)
  {{ $attributes->merge([
      'class' => ' peer block w-full rounded-lg p-3 text-sm autofill:pb-2 disabled:pointer-events-none disabled:opacity-50 [&:not(:placeholder-shown)]:pb-2 [&:not(:placeholder-shown)]:pt-6',
      'style' => 'background-color: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.10);'
  ]) }}
  placeholder="Search"
/> --}}
@props(['disabled' => false])

<input
  @disabled($disabled)
  {{ $attributes->merge(['class' => 'focus:border-primary-500 focus:ring-primary-500 peer block w-full rounded-lg p-4 text-sm placeholder:text-transparent autofill:pb-2 autofill:pt-6 focus:pb-2 focus:pt-6 disabled:pointer-events-none disabled:opacity-50 [&:not(:placeholder-shown)]:pb-2 [&:not(:placeholder-shown)]:pt-6']) }}
  placeholder=" "
/>
