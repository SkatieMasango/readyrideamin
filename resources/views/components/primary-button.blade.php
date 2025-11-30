<button
  {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary inline-flex w-full items-center justify-center gap-x-2 rounded-lg px-2 py-3 text-sm font-medium text-white transition duration-500 focus:outline-none disabled:pointer-events-none disabled:opacity-50']) }}
>
  {{ $slot }}
</button>
