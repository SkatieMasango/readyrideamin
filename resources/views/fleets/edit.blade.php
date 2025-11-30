<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex justify-between mb-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex">
                        <a href="{{ route('fleets.index') }}"
                            class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center"
                            style="width:30px">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h5 class="text-lg font-semibold text-gray-800 ms-3">
                            New Fleet
                            <span class="text-sm text-gray-500">Input new Fleet's details below.</span>
                        </h5>
                    </div>

                </div>
                <div class="flex items-center">
                    <div x-data="{ showModal_{{ $fleet->id }}: false }" x-cloak class="inline-block">
                        <!-- Trigger Button -->
                        <button type="button" @click="showModal_{{ $fleet->id }} = true"
                            class="inline-flex items-center p-2 text-red-500 border border-dashed border-red-500 hover:bg-red-100 rounded"
                            title="Delete Fleet">
                            <!-- Delete Icon -->
                            <svg class="h-5 w-5" fill="currentColor" viewBox="64 64 896 896"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z" />
                            </svg>
                        </button>

                        <!-- Modal -->
                        <div x-show="showModal_{{ $fleet->id }}" x-cloak
                            class="absolute inset-0 z-50 flex items-start justify-end bg-opacity-50" aria-modal="true"
                            role="dialog">
                            <div @click.away="showModal_{{ $fleet->id }} = false"
                                class="bg-white rounded-lg shadow-lg p-6 relative" style="top: 50px; right:100px">

                                <!-- Modal Header -->
                                <div class="flex justify-between items-center border-b pb-2 mb-4">
                                    <h2 class="text-lg font-semibold text-red-600">Delete Fleet</h2>
                                    <button @click="showModal_{{ $fleet->id }} = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl">
                                        &times;
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mb-4">
                                    <h3 class="text-yellow-600 font-bold">Are you sure?</h3>
                                    <p class="text-gray-700">You want to permanently delete this fleet?</p>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex justify-end gap-2">
                                    <button @click="showModal_{{ $fleet->id }} = false"
                                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                        Cancel
                                    </button>

                                    <form method="POST" action="{{ route('fleets.destroy', $fleet->id) }}">
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
            <form method="POST" action="{{ route('fleets.update', $fleet->id) }}">
                @csrf
                <div class="mb-5 grid grid-cols-4 gap-8">
                    <div class="relative">
                        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                            :value="old('name', $fleet->name)" autofocus autocomplete="name" />
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="user_name" class="mt-1 block w-full" type="text" name="user_name"
                            :value="old('user_name', $fleet->user_name)" autofocus autocomplete="user_name" />
                        <x-input-label for="user_name" :value="__('User Name')" />
                        <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="phone_number" class="mt-1 block w-full" type="text" name="phone_number"
                            :value="old('phone_number', $fleet->phone_number)" autofocus autocomplete="phone_number" />
                        <x-input-label for="phone_number" :value="__('Phone Number')" />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="mobile_number" class="mt-1 block w-full" type="text" name="mobile_number"
                            :value="old('mobile_number', $fleet->mobile_number)" autofocus autocomplete="mobile_number" />
                        <x-input-label for="mobile_number" :value="__('Mobile Number')" />
                        <x-input-error :messages="$errors->get('mobile_number')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-text-input id="password" class="mt-1 block w-full" type="password" name="password"
                            :value="old('password')" autofocus autocomplete="password" />
                        <x-input-label for="password" :value="__('Password')" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="account_number" class="mt-1 block w-full" type="text" name="account_number"
                            :value="old('account_number', $fleet->account_number)" autofocus autocomplete="account_number" />
                        <x-input-label for="account_number" :value="__('Bank Account Number')" />
                        <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="commission_share_percent" class="mt-1 block w-full" type="number"
                            name="commission_share_percent" :value="old('commission_share_percent', $fleet->commission_share_percent)" min="0" autofocus
                            autocomplete="commission_share_percent" />
                        <x-input-label for="commission_share_percent" :value="__('Commision Share Percent')" />
                        <x-input-error :messages="$errors->get('commission_share_percent')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="commission_share_flat" class="mt-1 block w-full" type="number"
                            name="commission_share_flat" :value="old('commission_share_flat', $fleet->commission_share_flat)" step="0.01" min="0"
                            autocomplete="commission_share_flat" autofocus />
                        <x-input-label for="commission_share_flat" :value="__('Commission Share Flat')" />
                        <x-input-error :messages="$errors->get('commission_share_flat')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-text-input id="address" class="mt-1 block w-full" type="text" name="address"
                            :value="old('address', $fleet->address)" autofocus autocomplete="address" />
                        <x-input-label for="bank_account_info" :value="__('Address')" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="fee_multiplier" class="mt-1 block w-full" type="number"
                            name="fee_multiplier" :value="old('fee_multiplier', $fleet->fee_multiplier)" step="0.01" min="0"
                            autocomplete="fee_multiplier" autofocus />
                        <x-input-label for="fee_multiplier" :value="__('Free multiplier')" />
                        <x-input-error :messages="$errors->get('fee_multiplier')" class="mt-2" />
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
