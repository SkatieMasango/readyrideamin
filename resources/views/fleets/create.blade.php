<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex">
                   <a href="{{ route('fleets.index') }}"
                        class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center" style="width:30px">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h5 class="text-lg font-semibold text-gray-800 ms-3">
                        New Fleet
                        <span class="text-sm text-gray-500">Input new Fleet's details below.</span>
                    </h5>
                </div>

            </div>

            <form method="POST" action="{{ route('fleets.store') }}">
                @csrf
                <div class="mb-5 grid grid-cols-4 gap-8">
                    <div class="relative">
                        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                            :value="old('name')" autofocus autocomplete="name" />
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="user_name" class="mt-1 block w-full" type="text" name="user_name"
                            :value="old('user_name')" autofocus autocomplete="user_name" />
                        <x-input-label for="user_name" :value="__('User Name')" />
                        <x-input-error :messages="$errors->get('user_name')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="phone_number" class="mt-1 block w-full" type="text" name="phone_number"
                            :value="old('phone_number')" autofocus autocomplete="phone_number" />
                        <x-input-label for="phone_number" :value="__('Phone Number')" />
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="mobile_number" class="mt-1 block w-full" type="text" name="mobile_number"
                            :value="old('mobile_number')" autofocus autocomplete="mobile_number" />
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
                            :value="old('account_number')" autofocus autocomplete="account_number" />
                        <x-input-label for="account_number" :value="__('Bank Account Number')" />
                        <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="commission_share_percent" class="mt-1 block w-full" type="number"
                            name="commission_share_percent" :value="old('commission_share_percent')" min="0" autofocus
                            autocomplete="commission_share_percent" />
                        <x-input-label for="commission_share_percent" :value="__('Commision Share Percent')" />
                        <x-input-error :messages="$errors->get('commission_share_percent')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="commission_share_flat" class="mt-1 block w-full" type="number"
                            name="commission_share_flat" :value="old('commission_share_flat')" step="0.01" min="0"
                            autocomplete="commission_share_flat" autofocus />
                        <x-input-label for="commission_share_flat" :value="__('Commission Share Flat')" />
                        <x-input-error :messages="$errors->get('commission_share_flat')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-text-input id="address" class="mt-1 block w-full" type="text" name="address"
                            :value="old('address')" autofocus autocomplete="address" />
                        <x-input-label for="bank_account_info" :value="__('Address')" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="fee_multiplier" class="mt-1 block w-full" type="number" name="fee_multiplier"
                            :value="old('fee_multiplier')" step="0.01" min="0" autocomplete="fee_multiplier"
                            autofocus />
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
