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
                    Payouts
                    <span class="text-sm text-gray-500">Api keys and client facing definitions</span>
                </h5>
                </div>

            </div>

            <form method="POST" action="{{ route('payouts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-5 grid grid-cols-2 gap-8">
                    <div class="relative">
                        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" autofocus
                            autocomplete="name" />
                        <x-input-label for="name" :value="__('Name')" />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="description" class="mt-1 block w-full" type="text" name="description"
                            autofocus autocomplete="description" />
                        <x-input-label for="description" :value="__('Description')" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <div class="flex rounded-md shadow-sm mt-1" style="height: 53px">
                            <select name="currency" id="currency"
                                class=" truncate w-full rounded border border-gray-300 bg-white pt-5 px-3 text-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->currency }}" title="{{ $country->currency }}">
                                        {{ \Illuminate\Support\Str::limit($country->name, 15) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-label for="type" style="margin-top:-10px" class="text-gray-600 text-sm"
                                :value="__('Type')" />
                        </div>

                        <!-- Validation Errors -->
                        <div class="flex gap-4">
                            <x-input-error :messages="$errors->get('currency')" class="mt-2 w-1/3" />

                        </div>
                    </div>
                    <div class="relative">
                        <x-select-input name="type" id="payment_type" :options="\App\Enums\PayoutType::options()" :selected="old('type')"
                            class="mt-1" />
                        <x-input-label for="type" :value="__('Type')" />
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <label for="">Visibility Status</label><br>

                        <label class="ant-switch mt-2" id="statusToggle">
                            <input type="checkbox" id="payment_status" class="hidden"
                                {{ old('payment_status', 'active') === 'active' ? 'checked' : '' }} />
                            <span class="ant-switch-inner"></span>
                        </label>

                        <input type="hidden" name="payment_status" id="payment_status_hidden"
                            value="{{ old('payment_status', 'active') }}">

                        <x-input-error :messages="$errors->get('payment_status')" class="mt-2" />
                    </div>
                    <div class="relative" style="display: none" id="apiKeyContainer">
                        <x-text-input id="api_key" class="mt-1 block w-full" type="text" name="api_key" autofocus
                            autocomplete="api_key" />
                        <x-input-label for="api_key" :value="__('API Keys')" />

                        <x-input-error :messages="$errors->get('api_key')" class="mt-2" />
                    </div>

                    <div class="relative mb-4 mt-4">
                        <span>Avater Image</span>
                        <div x-data="{ imagePreview: null }" @click="$refs.image.click()"
                            class="ant-upload ant-upload-select-picture-card flex flex-col justify-center items-center cursor-pointer relative h-24">

                            <!-- Hidden File Input -->
                            <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                x-ref="image"
                                @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }" />

                            <!-- Show image preview if new file is selected -->
                            <template x-if="imagePreview">
                                <img :src="imagePreview" alt="Image Preview"
                                    class=" rounded object-cover profile_image" style="height: 8rem;" />
                            </template>

                            <!-- Show existing image if no new file selected -->
                            <template x-if="!imagePreview">
                                <img src="{{ asset('images/user.png') }}" alt="Upload Image"
                                    class="rounded object-cover absolute profile_image"
                                    style="height: 8rem; width:8rem; border: 1px dashed #434343;" />
                                <span>Upload</span>
                            </template>
                        </div>
                        <x-input-error :messages="$errors->get('image')" class="mt-2 text-red-600 text-sm" />
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
        const checkbox = document.getElementById('payment_status');
        const hiddenInput = document.getElementById('payment_status_hidden');
        const toggle = document.getElementById('statusToggle');

        function updateToggle() {
            if (checkbox.checked) {
                toggle.classList.add('active');
                hiddenInput.value = 'active';
            } else {
                toggle.classList.remove('active');
                hiddenInput.value = 'inactive';
            }
        }

        checkbox.addEventListener('change', updateToggle);

        // Initial state setup
        updateToggle();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('payment_type');
        const apiKeyContainer = document.getElementById('apiKeyContainer');

        function toggleApiKeyField() {
            if (typeSelect.value === 'stripe') {
                apiKeyContainer.style.display = 'block';
            } else {
                apiKeyContainer.style.display = 'none';
            }
        }

        // Initial check on page load
        toggleApiKeyField();

        // Listen for changes
        typeSelect.addEventListener('change', toggleApiKeyField);
    });
</script>
