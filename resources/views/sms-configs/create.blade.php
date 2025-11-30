<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">

        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex">
                    <a href="{{ route('sms-configs.index') }}"
                        class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center" style="width:30px">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h5 class="text-lg font-semibold text-gray-800 ms-3">
                        Sms Providers
                        <span class="text-sm text-gray-500">Manage SMS providers for sending verification codes</span>
                    </h5>
                </div>

            </div>

            <form method="POST" action="{{ route('sms-configs.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-5 grid grid-cols-2 gap-8">
                    <div class="relative">
                        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" autofocus
                            autocomplete="name" value="{{ old('name') }}" />
                        <x-input-label for="name" :value="__('Name')" />

                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-select-input name="type" id="type" :options="\App\Enums\SmsType::options()" :selected="old('type')"
                            class="mt-1" />
                        <x-input-label for="type" :value="__('Type')" />
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <label for="">Visibility Status</label><br>

                        <label class="ant-switch mt-2" id="statusToggle">
                            <input type="checkbox" id="status" class="hidden"
                                {{ old('status', 'active') === 'active' ? 'checked' : '' }} />
                            <span class="ant-switch-inner"></span>
                        </label>

                        <input type="hidden" name="status" id="status_hidden" value="{{ old('status', 'active') }}">

                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div id="twilioContainer">
                        <div class="relative" style="margin-top: -20px">
                            <x-text-input id="twilio_sid" class="mt-1 block w-1/3" type="text" name="twilio_sid"
                                autofocus autocomplete="twilio_sid" value="{{ old('twilio_sid') }}" />
                            <x-input-label for="twilio_sid" :value="__('Twilio SID')" />

                            <x-input-error :messages="$errors->get('twilio_sid')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="twilio_token" class="mt-1 block w-1/3" type="text" name="twilio_token"
                                autofocus autocomplete="twilio_token" value="{{ old('twilio_token') }}" />
                            <x-input-label for="twilio_token" :value="__('Twilio Token')" />

                            <x-input-error :messages="$errors->get('twilio_token')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="twilio_from" class="mt-1 block w-1/3" type="text" name="twilio_from"
                                autofocus autocomplete="twilio_from" value="{{ old('twilio_from') }}" />
                            <x-input-label for="twilio_from" :value="__('Twilio From')" />

                            <x-input-error :messages="$errors->get('twilio_from')" class="mt-2" />
                        </div>

                    </div>
                    <div id="telesignContainer">
                        <div class="relative" style="margin-top: -20px">
                            <x-text-input id="customer_id" class="mt-1 block w-1/3" type="text" name="customer_id"
                                autofocus autocomplete="customer_id" value="{{ old('customer_id') }}" />
                            <x-input-label for="customer_id" :value="__('Customer Id')" />

                            <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="api_key" class="mt-1 block w-1/3" type="text" name="api_key"
                                autofocus autocomplete="api_key" value="{{ old('api_key') }}" />
                            <x-input-label for="api_key" :value="__('API KEY')" />

                            <x-input-error :messages="$errors->get('api_key')" class="mt-2" />
                        </div>
                    </div>
                    <div id="nexmoContainer">
                        <div class="relative" style="margin-top: -20px">
                            <x-text-input id="nexmo_key" class="mt-1 block w-1/3" type="text" name="nexmo_key"
                                autofocus autocomplete="nexmo_key" value="{{ old('nexmo_key') }}" />
                            <x-input-label for="nexmo_key" :value="__('Nexmo Key')" />

                            <x-input-error :messages="$errors->get('nexmo_key')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="nexmo_secret" class="mt-1 block w-1/3" type="text"
                                name="nexmo_secret" autofocus autocomplete="nexmo_secret"
                                value="{{ old('nexmo_secret') }}" />
                            <x-input-label for="nexmo_secret" :value="__('Nexmo Secret')" />

                            <x-input-error :messages="$errors->get('nexmo_secret')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="nexmo_from" class="mt-1 block w-1/3" type="text" name="nexmo_from"
                                autofocus autocomplete="nexmo_from" value="{{ old('nexmo_from') }}" />
                            <x-input-label for="nexmo_from" :value="__('Nexmo From')" />

                            <x-input-error :messages="$errors->get('nexmo_from')" class="mt-2" />
                        </div>

                    </div>
                    <div id="messagebirdContainer">
                        <div class="relative" style="margin-top: -20px">
                            <x-text-input id="m_api_key" class="mt-1 block w-1/3" type="text" name="m_api_key"
                                autofocus autocomplete="m_api_key" value="{{ old('m_api_key') }}" />
                            <x-input-label for="m_api_key" :value="__('API KEY')" />

                            <x-input-error :messages="$errors->get('m_api_key')" class="mt-2" />
                        </div>

                        <div class="relative">
                            <x-text-input id="from" class="mt-1 block w-1/3" type="text" name="from"
                                autofocus autocomplete="from" value="{{ old('from') }}" />
                            <x-input-label for="from" :value="__('From')" />

                            <x-input-error :messages="$errors->get('from')" class="mt-2" />
                        </div>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('status');
        const hiddenInput = document.getElementById('status_hidden');
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
        const typeSelect = document.getElementById('type');
        const twilioContainer = document.getElementById('twilioContainer');
        const telesignContainer = document.getElementById('telesignContainer');
        const nexmoContainer = document.getElementById('nexmoContainer');
        const messagebirdContainer = document.getElementById('messagebirdContainer');

        const containers = {
            'twilio': twilioContainer,
            'telesign': telesignContainer,
            'nexmo': nexmoContainer,
            'messagebird': messagebirdContainer
        };

        function toggleApiKeyField() {
            // First hide all containers
            Object.values(containers).forEach(container => {
                container.style.display = 'none';
            });

            // Then show the one corresponding to the selected type
            const selected = typeSelect.value;
            if (containers[selected]) {
                containers[selected].style.display = 'block';
            }
        }

        // Initial check on page load
        toggleApiKeyField();

        // Listen for changes
        typeSelect.addEventListener('change', toggleApiKeyField);
    });
</script>
