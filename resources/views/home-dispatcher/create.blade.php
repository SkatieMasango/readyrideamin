<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-semibold text-gray-800">
                    Drivers
                    <span class="text-sm text-gray-500">Create new Driver</span>
                </h5>
            </div>
            <form method="POST" action="{{ route('drivers.store') }}">
                @csrf
                <div class="mb-5 grid grid-cols-2 gap-8">
                    <div class="relative">
                        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                            :value="old('name')" autofocus autocomplete="name" />
                        <x-input-label for="name" :value="__('Name')" />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                   
                    <div class="relative">
                        <div class="flex rounded-md shadow-sm mt-1" style="height: 55px">
                            <select name="phone_code" id="phone_code"
                                class="w-[150px] truncate rounded-l-md border border-gray-300 bg-white p-3 text-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                @foreach ($countries as $country)
                                    <option value="{{ $country['phone_code'] }}" title="{{ $country['name'] }}">
                                        {{ \Illuminate\Support\Str::limit($country['name'], 15) }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Phone Input -->
                            <input type="text" name="phone_number" id="phone_number"
                                class="block w-full rounded-r-md border border-gray-300 p-5 text-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                                :value="old('phone_number')" autocomplete="text" placeholder="Enter phone number" />
                        </div>

                        <!-- Validation Errors -->
                        <div class="flex gap-4">
                            <x-input-error :messages="$errors->get('country')" class="mt-2 w-1/3" />
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2 w-2/3" />
                        </div>
                    </div>
                    <div class="relative">
                        <x-select-input name="gender" :options="\App\Enums\Gender::options()" :selected="old('gender')" class="mt-1" />
                        <x-input-label for="gender" :value="__('Gender')" />
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                </div>
                <div class="flex justify-end ">
                    <x-primary-button class="w-56">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
