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
                            <span class="text-sm text-gray-500">update a payment gateway</span>
                        </h5>
                    </div>

                </div>

                @php
                    $image = $paymentGateway->gatewayPicture()->first();
                    $imagePath = $image ? asset('storage/' . $image->path) : asset('images/user.png');
                @endphp
                <form method="POST" action="{{ route('management.payment-gateways.update', $paymentGateway->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 grid grid-cols-4 gap-8" x-data="{ type: '{{ $paymentGateway->type->value ?? '' }}' }">
                        <div class="relative">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                                autofocus autocomplete="title" value="{{ old('title', $paymentGateway->title) }}" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="relative">
                            <x-input-label for="type" :value="__('Type')" />
                            <x-select-input name="type" id="type" :options="\App\Enums\PaymentType::options()" :selected="old('type', $paymentGateway->type->value)"
                                x-model="type" class="mt-1" />
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        @php
                            $config = json_decode($paymentGateway->config ?? '{}', true);
                        @endphp

                        <!-- Secret Key Field (hidden if cash) -->
                        <div class="relative" x-show="type !== 'cash'" x-cloak>
                            <x-input-label for="secret_key" :value="__('Secret Keys')" />
                            <x-text-input id="secret_key" class="mt-1 block w-full" type="text" name="secret_key"
                                autofocus autocomplete="secret_key"
                                value="{{ old('secret_key', $config['secret_key'] ?? '') }}" />
                            <x-input-error :messages="$errors->get('secret_key')" class="mt-2" />
                        </div>

                        <!-- Public Key Field (hidden if cash) -->
                        <div class="relative" x-show="type !== 'cash'" x-cloak>
                            <x-input-label for="public_key" :value="__('Public Keys')" />
                            <x-text-input id="public_key" class="mt-1 block w-full" type="text" name="public_key"
                                autofocus autocomplete="public_key"
                                value="{{ old('public_key', $config['public_key'] ?? '') }}" />
                            <x-input-error :messages="$errors->get('public_key')" class="mt-2" />
                        </div>

                        <div class="relative mb-4 w-100 ">
                            <div x-data="{ imagePreview: null }" @click="$refs.image.click()"
                                class="ant-upload ant-upload-select-picture-card flex flex-col justify-center items-center cursor-pointer relative h-32 w-100 image-preview">

                                <!-- Hidden File Input -->
                                <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                    x-ref="image"
                                    @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }" />

                                <!-- Show image preview if new file is selected -->
                                <template x-if="imagePreview">
                                    <div class=" z-10 text-black rounded object-cover absolute flex items-center justify-center relative"
                                        style="height: 8rem; width:100%;">
                                        <!-- Image -->
                                        <img :src="imagePreview" alt="Image Preview" class=" rounded object-cover "
                                            style="height: 8rem;width:100%;" />

                                        <!-- Overlay -->
                                        <div class="absolute inset-0 z-10 flex items-start justify-end p-1">
                                            <div class="rounded flex items-center justify-center "
                                                style="height: 18%; width:8%; background-color: #fff">
                                                <img src="{{ asset('assets/images/image-plus.svg') }}" alt="">
                                            </div> <!-- Example overlay content -->
                                        </div>
                                    </div>
                                </template>

                                <!-- Show existing image if no new file selected -->
                                <template x-if="!imagePreview">

                                    <div class=" z-10 text-black rounded object-cover absolute flex items-center justify-center relative"
                                        style="height: 8rem; width:100%;"> <!-- 8rem = 32 in Tailwind -->
                                        <!-- Image -->
                                        <img src="{{ $imagePath ? $imagePath : asset('images/user.png') }}"
                                            class=" object-cover rounded" style="height: 8rem; width:100%;" />

                                        <!-- Overlay -->
                                        <div class="absolute inset-0 z-10 flex items-start justify-end p-1">
                                            <div class="flex items-center justify-center rounded"
                                                style="height: 18%; width:8%; background-color: #fff">
                                                <img src="{{ asset('assets/images/image-plus.svg') }}" alt="">
                                            </div> <!-- Example overlay content -->
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
                                    {{ old('status', $paymentGateway->status) === 'active' ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>
                            <input type="hidden" name="status" id="status_hidden"
                                value="{{ old('status', 'active') }}">
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
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
