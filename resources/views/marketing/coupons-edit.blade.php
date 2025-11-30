<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('marketing-coupons.index') }}"
                            class=" rounded-md flex items-center back-icon justify-center" style="width:40px;">
                            <x-icons.back-button />
                        </a>
                        <h5 class="text-lg font-semibold text-gray-800 ms-3">
                            Marketing
                            <span class="text-sm text-gray-500">List of all coupons</span>
                        </h5>
                    </div>
                </div>

                <form method="POST" action="{{ route('marketing-coupons.update', $coupon->id) }}">
                    @csrf
                    <div class="mb-4 grid grid-cols-4 gap-8" x-data="{ discount_type: '{{ old('discount_type', $coupon->discount_percent === null ? 'flat' : 'percentage') }}' }">

                        <div class="relative">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                                autofocus autocomplete="title" :value="old('title', $coupon->title)" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-input-label for="code" :value="__('Code')" />
                            <x-text-input id="code" class="mt-1 block w-full" type="text" name="code"
                                autofocus autocomplete="code" :value="old('code', $coupon->code)" />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-input-label for="max_users" :value="__('User can use')" />
                            <x-text-input id="max_users" class="mt-1 block w-full" type="number" name="max_users"
                                autofocus autocomplete="max_users" :value="old('max_users', $coupon->max_users)" />
                            <x-input-error :messages="$errors->get('max_users')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-input-label for="max_uses_per_user" :value="__('Times User can use')" />
                            <x-text-input id="max_uses_per_user" class="mt-1 block w-full" type="number"
                                name="max_uses_per_user" autofocus autocomplete="max_uses_per_user"
                                :value="old('max_uses_per_user', $coupon->max_uses_per_user)" />
                            <x-input-error :messages="$errors->get('max_uses_per_user')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-input-label for="minimum_cost" :value="__('Minimum Cost')" />
                            <x-text-input id="minimum_cost" class="mt-1 block w-full" type="number" name="minimum_cost"
                                autofocus autocomplete="minimum_cost" :value="old('minimum_cost', $coupon->minimum_cost)" />
                            <x-input-error :messages="$errors->get('minimum_cost')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-input-label for="maximum_cost" :value="__('Maximum Cost')" />
                            <x-text-input id="maximum_cost" class="mt-1 block w-full" type="number" name="maximum_cost"
                                autofocus autocomplete="maximum_cost" :value="old('maximum_cost', $coupon->maximum_cost)" />
                            <x-input-error :messages="$errors->get('maximum_cost')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-input-label for="valid_from" :value="__('Availability From')" />
                            <x-text-input id="valid_from" class="mt-1 block w-full" type="date" name="valid_from"
                                :value="old('valid_from', optional($coupon->valid_from)->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('valid_from')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="start_time" :value="__('Start Time')" />
                            <x-text-input id="start_time" class="mt-1 block w-full" type="time" name="start_time"
                                autofocus autocomplete="start_time" :value="old('start_time', $coupon->start_time)" />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-input-label for="valid_till" :value="__('Availability To')" />
                            <x-text-input id="valid_till" class="mt-1 block w-full" type="date" name="valid_till"
                                :value="old('valid_till', optional($coupon->valid_till)->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('valid_till')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="expired_time" :value="__('Expired Time')" />
                            <x-text-input id="expired_time" class="mt-1 block w-full" type="time" name="expired_time"
                                autofocus autocomplete="expired_time" :value="old('expired_time', $coupon->expired_time)" />
                            <x-input-error :messages="$errors->get('expired_time')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="discount_type" :value="__('Discount Type')" />
                            <x-select-input name="discount_type" id="discount_type" :options="\App\Enums\DiscountType::options()"
                                :selected="old('discount_type', $coupon->description)" x-model="discount_type" class="mt-1" />
                            <x-input-error :messages="$errors->get('discount_type')" class="mt-2" />
                        </div>
                        <div x-show="discount_type === 'percentage'" x-cloak>
                            <x-input-label for="discount_percent" :value="__('Discount ')" />
                            <x-text-input id="discount_percent" class="mt-1 block w-full" type="number"
                                min="1" name="discount_percent" autofocus autocomplete="discount_percent"
                                :value="old('discount_percent', $coupon->discount_percent)" />
                            <x-input-error :messages="$errors->get('discount_percent')" class="mt-2" />
                        </div>
                        <div x-show="discount_type === 'flat'" x-cloak>
                            <x-input-label for="discount_flat" :value="__('Discount ')" />
                            <x-text-input id="discount_flat" class="mt-1 block w-full" type="number" min="1"
                                name="discount_flat" autofocus autocomplete="discount_flat" :value="old('discount_flat', $coupon->discount_flat)" />
                            <x-input-error :messages="$errors->get('discount_flat')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea id="description" class="mt-1 block w-full" type="text" name="description"
                                autofocus autocomplete="description" :value="old('description', $coupon->description)" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <label for="">Is Enabled</label><br>

                            <label class="ant-switch mt-2" id="statusToggle">
                                <input type="checkbox" id="is_enabled" class="hidden"
                                    {{ old('is_enabled', $coupon->is_enabled) === true ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>

                            <input type="hidden" name="is_enabled" id="is_enabled_hidden"
                                value="{{ old('is_enabled', $coupon->is_enabled) }}">

                            <x-input-error :messages="$errors->get('is_enabled')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <label for="">Is First Travel Only</label><br>

                            <label class="ant-switch mt-2" id="statusFirstToggle">
                                <input type="checkbox" id="is_first_travel_only" class="hidden"
                                    {{ old('is_first_travel_only', $coupon->is_first_travel_only) === true ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>

                            <input type="hidden" name="is_first_travel_only" id="is_first_travel_only_hidden"
                                value="{{ old('is_first_travel_only', $coupon->is_first_travel_only) }}">

                            <x-input-error :messages="$errors->get('is_first_travel_only')" class="mt-2" />
                        </div>

                    </div>
                    <div class="flex justify-start ">
                        <x-primary-button class="w-auto">
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const ids = [
        'max_users',
        'max_uses_per_user',
        'minimum_cost',
        'maximum_cost',
        'discount_percent',
        'discount_flat',
        'credit_gift'
    ];
    ids.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() {
                if (this.value < 1) {
                    this.value = '';
                }
            });
        }
    });

    //Enabled Button
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('is_enabled');
        const hiddenInput = document.getElementById('is_enabled_hidden');
        const toggle = document.getElementById('statusToggle');

        function updateToggle() {
            if (checkbox.checked) {
                toggle.classList.add('active');
                hiddenInput.value = 1;
            } else {
                toggle.classList.remove('active');
                hiddenInput.value = 0;
            }
        }
        checkbox.addEventListener('change', updateToggle);
        // Initial state setup
        updateToggle();
    });

    //First Travel Button
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox1 = document.getElementById('is_first_travel_only');
        const hiddenInput = document.getElementById('is_first_travel_only_hidden');
        const toggle1 = document.getElementById('statusFirstToggle');

        function updateFirstToggle() {
            if (checkbox1.checked) {
                toggle1.classList.add('active');
                hiddenInput.value = 1;
            } else {
                toggle1.classList.remove('active');
                hiddenInput.value = 0;
            }
        }
        checkbox1.addEventListener('change', updateFirstToggle);

        // Initial state setup
        updateFirstToggle();
    });
</script>
