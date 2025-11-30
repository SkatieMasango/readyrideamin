<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex justify-between mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('services.index') }}"
                                class=" rounded-md flex items-center bg-gray-50 back-icon justify-center"
                                style="width:40px;">
                                <x-icons.back-button />
                            </a>
                            <h5 class="text-lg font-semibold text-gray-800 ms-3">
                                Services
                                <span class="text-sm text-gray-500">Edit Service</span>
                            </h5>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('services.update', $service->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 grid grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                                autofocus :value="old('name', $service->name ?? '')" autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="service_category_id" :value="__('Category')" />
                            <x-select-input name="service_category_id" :options="$serviceCategory" :selected="old('service_category_id', $service->service_category_id ?? '')"
                                class="w-full border p-2" />
                            <x-input-error :messages="$errors->get('service_category_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="person_capacity" :value="__('Person Capacity')" />
                            <x-text-input id="person_capacity" class="mt-1 block w-full" type="number" min=0
                                name="person_capacity" :value="old('person_capacity', $service->person_capacity ?? '')" autocomplete="person_capacity" />
                            <x-input-error :messages="$errors->get('person_capacity')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="fare" :value="__('Base Distance')" />
                            <x-text-input id="fare" class="mt-1 block w-full" :value="old('fare', $service->fare ?? '')" type="number"
                                name="fare" autofocus autocomplete="fare" min=0 step="0.01" />
                            <x-input-error :messages="$errors->get('fare')" class="mt-2" />
                        </div>
                         <div>
                            <x-input-label for="minimum_fee" :value="__('Minimum Fee')" />
                            <x-text-input id="minimum_fee" class="mt-1 block w-full" type="number"
                                name="minimum_fee" min=0 step="0.01" :value="old('minimum_fee', $service->minimum_fee ?? '')"
                                autocomplete="minimum_fee" />
                            <x-input-error :messages="$errors->get('minimum_fee')" class="mt-2" />
                        </div>
                        <div>
                           <x-input-label for="per_hundred_meters" :value="__('Over Distance (meters)')" />
                            <x-text-input id="per_hundred_meters" class="mt-1 block w-full" type="number" min=0
                                step="0.01" name="per_hundred_meters" :value="old('per_hundred_meters', $service->per_hundred_meters ?? '')"
                                autocomplete="per_hundred_meters" />
                            <x-input-error :messages="$errors->get('per_hundred_meters')" class="mt-2" />
                        </div>
                          <div>
                            <x-input-label for="base_fare" :value="__('Extra Charge (meters)')" />
                            <x-text-input id="base_fare" class="mt-1 block w-full" type="number" name="base_fare" min=0
                                step="0.01" :value="old('base_fare', $service->base_fare ?? '')" autocomplete="base_fare" />
                            <x-input-error :messages="$errors->get('base_fare')" class="mt-2" />
                        </div>
                         <div>
                            <x-input-label for="over_minutes" :value="__('Over Duration (minutes)')" />
                            <x-text-input id="over_minutes" class="mt-1 block w-full" type="number" min=0
                                step="0.01" name="over_minutes" :value="old('over_minutes', $service->over_minutes ?? '')" autofocus
                                autocomplete="over_minutes" />
                            <x-input-error :messages="$errors->get('over_minutes')" class="mt-2" />
                        </div>
                        <div>
                           <x-input-label for="per_minute_drive" :value="__('Extra Charge (minutes)')" />
                            <x-text-input id="per_minute_drive" class="mt-1 block w-full" type="number" min=0
                                step="0.01" name="per_minute_drive" :value="old('per_minute_drive', $service->per_minute_drive ?? '')"
                                autocomplete="per_minute_drive" />
                            <x-input-error :messages="$errors->get('per_minute_drive')" class="mt-2" />
                        </div>
                        {{-- <div>
                            <x-input-label for="per_minute_wait" :value="__('Per Minute Wait')" />
                            <x-text-input id="per_minute_wait" class="mt-1 block w-full" type="number" min=0
                                step="0.01" name="per_minute_wait" :value="old('per_minute_wait', $service->per_minute_wait ?? '')"
                                autocomplete="per_minute_wait" />
                            <x-input-error :messages="$errors->get('per_minute_wait')" class="mt-2" />
                        </div> --}}
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea id="description" style="height: 8rem" class="mt-1 block w-full" type="text"
                                name="description" :value="old('description', $service->description ?? '')" autocomplete="name" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="relative mb-4 w-100 mt-4">
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
                                        <img src="{{ $service->servicePicture }}" alt="Current Avatar"
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

                        <div>
                            <label class="text-sm" for="">Two Way Available</label><br>
                            <label class="ant-switch mt-2" id="statusToggle">
                                <input type="checkbox" id="two_way_available" class="hidden"
                                    {{ old('two_way_available', $service->two_way_available) === 1 ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>
                            <input type="hidden" name="two_way_available" id="two_way_available_hidden"
                                value="{{ old('two_way_available', $service->two_way_available) }}">

                            <x-input-error :messages="$errors->get('two_way_available')" class="mt-2" />
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
    // const ids = [
    //     'person_capacity',
    //     'base_fare',
    //     'per_hundred_meters',
    //     'per_minute_drive',
    //     'per_minute_wait',
    //     'minimum_fee',
    // ];

    // ids.forEach(id => {
    //     const input = document.getElementById(id);
    //     if (input) {
    //         input.addEventListener('input', function() {
    //             if (this.value < 1) {
    //                 this.value = '';
    //             }
    //         });
    //     }
    // });
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('two_way_available');
        const hiddenInput = document.getElementById('two_way_available_hidden');
        const toggle = document.getElementById('statusToggle');

        function updateToggle() {
            if (checkbox.checked) {
                toggle.classList.add('active');
                hiddenInput.value = '1';
            } else {
                toggle.classList.remove('active');
                hiddenInput.value = '0';
            }
        }
        checkbox.addEventListener('change', updateToggle);

        // Initial state setup
        updateToggle();
    });
</script>
