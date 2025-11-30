<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex justify-between mb-5">
                <div class="flex items-center justify-between">
                    <div class="flex">
                        <a href="{{ route('users.index') }}"
                            class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center"
                            style="width:30px">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h5 class="text-lg font-semibold text-gray-800 ms-3">
                            Edit User
                            <span class="text-sm text-gray-500">Input new user's details below.</span>
                        </h5>
                    </div>

                </div>
                <div class="flex items-center">
                    <div x-data="{ showModal_{{ $user->id }}: false }" x-cloak class="inline-block">
                        <!-- Trigger Button -->
                        <button type="button" @click="showModal_{{ $user->id }} = true"
                            class="inline-flex items-center p-2 text-red-500 border border-dashed border-red-500 hover:bg-red-100 rounded"
                            title="Delete user">
                            <!-- Delete Icon -->
                            <svg class="h-5 w-5" fill="currentColor" viewBox="64 64 896 896"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z" />
                            </svg>
                        </button>

                        <!-- Modal -->
                        <div x-show="showModal_{{ $user->id }}" x-cloak
                            class="absolute inset-0 z-50 flex items-start justify-end bg-opacity-50" aria-modal="true"
                            role="dialog">
                            <div @click.away="showModal_{{ $user->id }} = false"
                                class="bg-white rounded-lg shadow-lg p-6 relative" style="top: 50px; right:100px">

                                <!-- Modal Header -->
                                <div class="flex justify-between items-center border-b pb-2 mb-4">
                                    <h2 class="text-lg font-semibold text-red-600">Delete user</h2>
                                    <button @click="showModal_{{ $user->id }} = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl">
                                        &times;
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mb-4">
                                    <h3 class="text-yellow-600 font-bold">Are you sure?</h3>
                                    <p class="text-gray-700">You want to permanently delete this user?</p>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex justify-end gap-2">
                                    <button @click="showModal_{{ $user->id }} = false"
                                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                        Cancel
                                    </button>

                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                <div class="mb-5 grid grid-cols-4 gap-8">
                    <div class="relative">
                        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                            :value="old('name', $user->name)" autofocus autocomplete="name" />
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <div class="flex rounded-md shadow-sm mt-1" style="height: 55px">
                            <select name="phone_code" id="phone_code"
                                class="w-[150px] truncate rounded-l-md border border-gray-300 bg-white p-3 text-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                @foreach ($countries as $country)
                                    <option value="{{ $country['phone_code'] }}" title="{{ $country['name'] }}"
                                        @if ($country['name'] === $iso?->name) selected @endif>
                                        {{ \Illuminate\Support\Str::limit($country['name'], 15) }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Phone Input -->
                            @php
                                $phoneCode = $iso->phone_code ?? '';
                                $fullNumber = $user->mobile ?? '';
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
                        @foreach ($user->getRoleNames() as $role)
                        @endforeach

                        <x-select-input name="role" :options="$roles" :selected="old('role', $role ?? '')" class="mt-1" />
                        <x-input-label for="role" :value="__('Role')" />
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-text-input id="email" class="mt-1 block w-full" type="text" name="email"
                            :value="old('email', $user->email)" autofocus autocomplete="email" />
                        <x-input-label for="email" :value="__('Email')" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="relative">

                        <x-select-input name="gender" :options="\App\Enums\Gender::options()" :selected="old('gender', $user->gender)" class="mt-1" />
                        <x-input-label for="gender" :value="__('Gender')" />
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-text-input id="address" class="mt-1 block w-full" type="text" name="address"
                            :value="old('address', $user->address)" autofocus autocomplete="address" />
                        <x-input-label for="address" :value="__('Address')" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <div class="relative">

                        <x-select-input name="status" :options="\App\Enums\Status::options()" :selected="$user->status->value ?? old('status')" class="mt-1" />
                        <x-input-label for="status" :value="__('Status')" />
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                </div>
                <div class="flex justify-end">
                    <x-primary-button class="w-56">
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
