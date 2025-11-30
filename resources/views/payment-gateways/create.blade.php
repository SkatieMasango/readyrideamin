<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('management.payment-gateways.index') }}"
                            class="rounded-md flex items-center back-icon justify-center" style="width:30px">
                            <x-icons.back-button />

                        </a>
                        <h5 class="text-lg font-semibold text-gray-800 ms-3">
                            Payment Gateway
                            <span class="text-sm text-gray-500">create a payment gateway</span>
                        </h5>
                    </div>

                </div>

                <form method="POST" action="{{ route('management.payment-gateways.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 grid grid-cols-4 gap-8" x-data="{ type: '{{ old('type') ?? '' }}' }">
                        <div class="relative">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                                autofocus autocomplete="title" value="{{ old('title') }}" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="relative">
                            <x-input-label for="type" :value="__('Type')" />
                            <x-select-input name="type" id="type" :options="\App\Enums\PaymentType::options()" :selected="old('type')"
                                x-model="type" class="mt-1" />
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Secret Key Field (hidden if cash) -->
                        <div class="relative" x-show="type !== 'cash'" x-cloak>
                            <x-input-label for="secret_key" :value="__('Secret Keys')" />
                            <x-text-input id="secret_key" class="mt-1 block w-full" type="text" name="secret_key"
                                autofocus autocomplete="secret_key" value="{{ old('secret_key') }}" />
                            <x-input-error :messages="$errors->get('secret_key')" class="mt-2" />
                        </div>

                        <!-- Public Key Field (hidden if cash) -->
                        <div class="relative" x-show="type !== 'cash'" x-cloak>
                            <x-input-label for="public_key" :value="__('Public Keys')" />
                            <x-text-input id="public_key" class="mt-1 block w-full" type="text" name="public_key"
                                autofocus autocomplete="public_key" value="{{ old('public_key') }}" />
                            <x-input-error :messages="$errors->get('public_key')" class="mt-2" />
                        </div>
                        <div class="relative" style="margin-top: -20px">
                            <div x-data="{ imagePreview: null }" @click="$refs.image.click()"
                                class="ant-upload ant-upload-select-picture-card flex flex-col justify-center items-center cursor-pointer relative h-32 w-100">

                                <!-- Hidden File Input -->
                                <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                    x-ref="image"
                                    @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }" />

                                <!-- Show image preview if new file is selected -->
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" alt="Image Preview" class=" rounded object-cover "
                                        style="height: 8rem;width:100%" />
                                </template>

                                <!-- Show existing image if no new file selected -->
                                <template x-if="!imagePreview">
                                    <div class="z-10 text-black rounded object-cover absolute flex items-center justify-center"
                                        style="height: 8rem; width:100%; border: 1px dashed #434343;">
                                        <div>
                                            <div class="flex items-center justify-center mb-2">
                                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24" width="24" height="24">
                                                    <g id="Layer_53" data-name="Layer 53">
                                                        <path
                                                            d="M22,9.25a.76.76,0,0,0-.75.75v6l-4.18-4.78a2.84,2.84,0,0,0-4.14,0L10.06,14.5l-.94-1.14a2.76,2.76,0,0,0-4.24,0L2.75,15.93V6A3.26,3.26,0,0,1,6,2.75h8a.75.75,0,0,0,0-1.5H6A4.75,4.75,0,0,0,1.25,6V18a.09.09,0,0,0,0,.05v0A4.75,4.75,0,0,0,6,22.75H18a4.75,4.75,0,0,0,4.74-4.68s0,0,0,0V10A.76.76,0,0,0,22,9.25Zm-4,12H6a3.25,3.25,0,0,1-3.23-3L6,14.32a1.29,1.29,0,0,1,1.92,0l1.51,1.82a.74.74,0,0,0,.57.27.86.86,0,0,0,.57-.26l3.44-3.94a1.31,1.31,0,0,1,1.9,0l5.27,6A3.24,3.24,0,0,1,18,21.25Z" />
                                                        <path
                                                            d="M4.25,7A2.75,2.75,0,1,0,7,4.25,2.75,2.75,0,0,0,4.25,7Zm4,0A1.25,1.25,0,1,1,7,5.75,1.25,1.25,0,0,1,8.25,7Z" />
                                                        <path
                                                            d="M16,5.75h2.25V8a.75.75,0,0,0,1.5,0V5.75H22a.75.75,0,0,0,0-1.5H19.75V2a.75.75,0,0,0-1.5,0V4.25H16a.75.75,0,0,0,0,1.5Z" />
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="text-md"><span>Select your gateway image</span></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2 text-red-600 text-sm" />
                        </div>
                         <div class="relative">
                            <label for=""> Status</label><br>

                            <label class="ant-switch mt-2" id="statusToggle">
                                <input type="checkbox" id="status" class="hidden"
                                    {{ old('status', 'active') === 'active' ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>

                            <input type="hidden" name="status" id="status_hidden"
                                value="{{ old('status', 'active') }}">

                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                    </div>
                    <div class="flex justify-start ">
                        <x-primary-button class="w-auto">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
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
                hiddenInput.value = 'active';
            } else {
                toggle.classList.remove('active');
                hiddenInput.value = 'in_active';
            }
        }

        checkbox.addEventListener('change', updateToggle);

        // Initial state setup
        updateToggle();
    });
</script>
