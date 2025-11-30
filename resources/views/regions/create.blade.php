<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex">
                    <a href="{{ url()->previous() }}"
                        class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center" style="width:30px">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>

                    </a>
                    <h5 class="text-lg font-semibold text-gray-800 ms-3">
                        Regions
                        <span class="text-sm text-gray-500">Create new Region</span>
                    </h5>
                </div>

            </div>

            <form method="POST" action="{{ route('regions.store') }}">
                @csrf
                <div class="mb-4 grid grid-cols-2 gap-8">
                    <div class="relative">
                        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" required
                            autofocus autocomplete="name" />
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-select-input name="currency" :options="$currencies" selected="active" class="w-full border p-2" />
                        <x-input-label for="name" :value="__('Currency')" />
                        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                    </div>
                    <div class="block">
                        <label for="is_enabled" class="inline-flex items-center">
                            <input id="is_enabled" type="checkbox"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500"
                                name="is_enabled" value="1" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Is Enabled') }}</span>
                        </label>
                    </div>
                    <div class="relative col-span-2">
                        <p class="pb-2 text-sm text-gray-900">Geofence</p>
                        <x-maps.region />
                        <x-input-error :messages="$errors->get('polygon_coordinates')" class="mt-2" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <x-primary-button class="w-56">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
