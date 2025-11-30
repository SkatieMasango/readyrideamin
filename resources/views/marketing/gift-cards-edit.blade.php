<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex justify-between mb-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex justify-between items-center">
                            <a href="{{ route('marketing-gift-cards.index') }}"
                                class=" rounded-md flex items-center back-icon justify-center" style="width:40px;">
                                <x-icons.back-button />
                            </a>
                            <h5 class="text-lg font-semibold text-gray-800 ms-3">
                                Marketing
                                <span class="text-sm text-gray-500">Edit gift card</span>
                            </h5>
                        </div>

                    </div>

                </div>

                <form method="POST" action="{{ route('marketing-gift-cards.update', $giftCard->id) }}">
                    @csrf
                    <div class="mb-4 grid grid-cols-4 gap-8" x-data="{ discount_type: '{{ old('discount_type', $giftCard->discount_percent === null ? 'flat' : 'percentage') }}' }">
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                                autofocus autocomplete="title" :value="old('title', $giftCard->title)" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="code" :value="__('Code')" />
                            <x-text-input id="code" class="mt-1 block w-full" type="text" name="code"
                                autofocus autocomplete="code" :value="old('code', $giftCard->code)" />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="max_uses_per_user" :value="__('Times User can use')" />
                            <x-text-input id="max_uses_per_user" class="mt-1 block w-full" type="number"
                                name="max_uses_per_user" autofocus autocomplete="max_uses_per_user" :value="old('max_uses_per_user', $giftCard->max_uses_per_user)" />
                            <x-input-error :messages="$errors->get('max_uses_per_user')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="minimum_cost" :value="__('Minimum Cost')" />
                            <x-text-input id="minimum_cost" class="mt-1 block w-full" type="number" name="minimum_cost"
                                autofocus autocomplete="minimum_cost" :value="old('minimum_cost', $giftCard->minimum_cost)" />
                            <x-input-error :messages="$errors->get('minimum_cost')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="maximum_cost" :value="__('Maximum Cost')" />
                            <x-text-input id="maximum_cost" class="mt-1 block w-full" type="number" name="maximum_cost"
                                autofocus autocomplete="maximum_cost" :value="old('maximum_cost', $giftCard->maximum_cost)" />
                            <x-input-error :messages="$errors->get('maximum_cost')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="valid_from" :value="__('Availability From')" />
                            <x-text-input id="valid_from" class="mt-1 block w-full" type="date" name="valid_from"
                                :value="old('valid_from', optional($giftCard->valid_from)->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('valid_from')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="start_time" :value="__('Start Time')" />
                            <x-text-input id="start_time" class="mt-1 block w-full" type="time" name="start_time"
                                autofocus autocomplete="start_time" :value="old('start_time', $giftCard->start_time)" />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="valid_till" :value="__('Availability To')" />
                            <x-text-input id="valid_till" class="mt-1 block w-full" type="date" name="valid_till"
                                :value="old('valid_till', optional($giftCard->valid_till)->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('valid_till')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="expired_time" :value="__('Expired Time')" />
                            <x-text-input id="expired_time" class="mt-1 block w-full" type="time" name="expired_time"
                                autofocus autocomplete="expired_time" :value="old('expired_time', $giftCard->expired_time)" />
                            <x-input-error :messages="$errors->get('expired_time')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="discount_type" :value="__('Discount Type')" />
                            <x-select-input name="discount_type" id="discount_type" :options="\App\Enums\DiscountType::options()"
                                :selected="old('discount_type', $giftCard->description)" x-model="discount_type" class="mt-1" />
                            <x-input-error :messages="$errors->get('discount_type')" class="mt-2" />
                        </div>
                        <div x-show="discount_type === 'percentage'" x-cloak>
                            <x-input-label for="discount_percent" :value="__('Discount ')" />
                            <x-text-input id="discount_percent" class="mt-1 block w-full" type="number" min="1"
                                name="discount_percent" autofocus autocomplete="discount_percent" :value="old('discount_percent', $giftCard->discount_percent)" />
                            <x-input-error :messages="$errors->get('discount_percent')" class="mt-2" />
                        </div>
                        <div x-show="discount_type === 'flat'" x-cloak>
                            <x-input-label for="discount_flat" :value="__('Discount ')" />
                            <x-text-input id="discount_flat" class="mt-1 block w-full" type="number" min="1"
                                name="discount_flat" autofocus autocomplete="discount_flat" :value="old('discount_flat', $giftCard->discount_flat)" />
                            <x-input-error :messages="$errors->get('discount_flat')" class="mt-2" />
                        </div>
                        <div class=" mt-1" id="userSelectWrapper">
                            <x-input-label style="margin-top:-12px" for="rider_ids" class="text-gray-600 text-sm"
                                :value="__('Riders')" />
                            <select name="rider_ids[]" id="rider_ids" multiple
                                class="select2 truncate rounded-l-md border border-gray-300 bg-white p-3 text-sm focus:border-primary-500 focus:ring-primary-500">
                                @php
                                    $riders = \App\Models\Rider::whereIn('id', $giftCard->rider_ids ?? [])->get();
                                @endphp

                                @foreach ($riders as $rider)
                                    @if ($rider)
                                        <option value="{{ $rider->id }}" selected>
                                            {{ $rider->user->name ?? 'N/A' }}
                                        </option>
                                    @endif
                                @endforeach

                            </select>

                            <x-input-error :messages="$errors->get('rider_ids')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea id="description" class="mt-1 block w-full" type="text" name="description"
                                autofocus autocomplete="description" :value="old('description', $giftCard->description)" />

                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="mt-3">
                            <label for="">Is Enabled</label><br>

                            <label class="ant-switch mt-2" id="statusToggle">
                                <input type="checkbox" id="is_enabled" class="hidden"
                                    {{ old('is_enabled', $giftCard->is_enabled) === true ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>

                            <input type="hidden" name="is_enabled" id="is_enabled_hidden"
                                value="{{ old('is_enabled', $giftCard->is_enabled) }}">

                            <x-input-error :messages="$errors->get('is_enabled')" class="mt-2" />
                        </div>

                        <div class="mt-3">
                            <label for="">Is Notified</label><br>
                            <label class="ant-switch mt-2" id="statusNotifyToggle">
                                <input type="checkbox" id="is_notified" class="hidden"
                                    {{ old('is_notified', $giftCard->is_notified) === true ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>

                            <input type="hidden" name="is_notified" id="is_notified_hidden"
                                value="{{ old('is_notified', 'active') }}">

                            <x-input-error :messages="$errors->get('is_notified')" class="mt-2" />
                        </div>

                        <div class="mt-3">
                            <label for="">Is First Travel Only</label><br>

                            <label class="ant-switch mt-2" id="statusFirstToggle">
                                <input type="checkbox" id="is_first_travel_only" class="hidden"
                                    {{ old('is_first_travel_only', $giftCard->is_first_travel_only) === true ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>

                            <input type="hidden" name="is_first_travel_only" id="is_first_travel_only_hidden"
                                value="{{ old('is_first_travel_only', $giftCard->is_first_travel_only) }}">

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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    document.addEventListener('DOMContentLoaded', function() {
        const checkboxNotified = document.getElementById('is_notified');
        const hiddenNotifiedInput = document.getElementById('is_notified_hidden');
        const notifyToggle = document.getElementById('statusNotifyToggle');

        function updateNotifyToggle() {
            if (checkboxNotified.checked) {
                notifyToggle.classList.add('active');
                hiddenNotifiedInput.value = 1;
            } else {
                notifyToggle.classList.remove('active');
                hiddenNotifiedInput.value = 0;
            }
        }
        checkboxNotified.addEventListener('change', updateNotifyToggle);

        // Initial state setup
        updateNotifyToggle();
    });
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

    $(document).ready(function() {

        let type = 'riders';

        // Initialize Select2
        $('#rider_ids').select2({
            allowClear: true,
            width: '100%',
        });

        function fetchUsers(type) {
            fetch(`/marketing/get-users-by-type/${type}`)
                .then(res => res.json())
                .then(data => {
                    const selectedValues = $('#rider_ids').val(); // already selected

                    data.forEach(user => {
                        if (!selectedValues.includes(user.value.toString())) {
                            const newOption = new Option(user.name, user.value, false, false);
                            $('#rider_ids').append(newOption);
                        }
                    });

                    $('#rider_ids').trigger('change');
                });
        }


        fetchUsers(type);

    });
</script>
