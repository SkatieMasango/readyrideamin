@props([
  'name',
  'label',
  'src',
])

<div class="mb-6">
  <label class="mb-2 block">
    <span class="mb-3 flex justify-center text-end text-sm text-gray-400">{{ $label }}</span>
    <input
      type="file"
      name="{{ $name }}"
      class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
    />
  </label>

  <div x-show="{{ $src }}" class="flex h-24 w-auto items-center justify-center rounded border">
    <img
      src="{{ asset(\Illuminate\Support\Facades\Storage::url($src)) }}"
      class="mt-2 h-20 w-auto object-fill"
      alt="preview"
    />
  </div>

  <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
