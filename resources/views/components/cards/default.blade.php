{{-- @php
  $colorMap = [
    'primary' => 'border-primary-500 bg-primary-50',
    'violet' => 'border-violet-500 bg-violet-50',
    'teal' => 'border-teal-500 bg-teal-50',
    'indigo' => 'border-indigo-500 bg-indigo-50',
  ];
@endphp

<div class="{{ $colorMap[$type] }} flex max-h-32 flex-col gap-2 rounded-md border p-4">
  <h2 class="text-4xl font-bold text-slate-800">{{ $count }}</h2>
  <div class="flex items-center justify-between">
    @if (isset($title))
      <div class="text-xl font-semibold text-slate-500">{{ $title }}</div>
    @endif

    @if (isset($icon))
      <div class="rounded-md bg-white p-3 shadow-sm">{{ $icon }}</div>
    @endif
  </div>
</div> --}}
