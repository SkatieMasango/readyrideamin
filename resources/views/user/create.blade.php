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
                        New User
                        <span class="text-sm text-gray-500">Input new user's details below.</span>
                    </h5>
                </div>

            </div>

            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="mb-5 grid grid-cols-4 gap-8">
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
                            @php
                                $phoneCode = $iso->phone_code ?? '';
                                $fullNumber = $driver->user->mobile ?? '';
                                $strippedNumber =
                                    $phoneCode && str_starts_with($fullNumber, $phoneCode)
                                        ? substr($fullNumber, strlen($phoneCode))
                                        : $fullNumber;
                            @endphp

                            <input type="text" name="phone_number" id="phone_number"
                                class="block w-full rounded-r-md border border-gray-300 p-5 text-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                                value="{{ $strippedNumber }}" autocomplete="text" placeholder="Enter phone number" />
                        </div>

                        <!-- Validation Errors -->
                        <div class="flex gap-4">
                            <x-input-error :messages="$errors->get('country')" class="mt-2 w-1/3" />
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2 w-2/3" />
                        </div>
                    </div>
                    <div class="relative">
                        <x-select-input name="role" :options="$roles" :selected="old('role')" class="mt-1" />
                        <x-input-label for="role" :value="__('Role')" />
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-text-input id="password" class="mt-1 block w-full" type="password" name="password"
                            :value="old('password')" autofocus autocomplete="password" />
                        <x-input-label for="password" :value="__('Password')" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="email" class="mt-1 block w-full" type="text" name="email"
                            :value="old('email')" autofocus autocomplete="email" />
                        <x-input-label for="email" :value="__('Email')" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-select-input name="gender" :options="\App\Enums\Gender::options()" :selected="old('gender')" class="mt-1" />
                        <x-input-label for="gender" :value="__('Gender')" />
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-text-input id="address" class="mt-1 block w-full" type="text" name="address"
                            :value="old('address')" autofocus autocomplete="address" />
                        <x-input-label for="address" :value="__('Address')" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-select-input name="status" :options="\App\Enums\Status::options()" :selected="old('status')" class="mt-1" />
                        <x-input-label for="status" :value="__('Status')" />
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                </div>
                <div class="flex justify-end">
                    <x-primary-button class="w-56">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
