<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('services.index') }}"
                            class=" rounded-md flex items-center bg-gray-50 back-icon justify-center" style="width:40px;">
                            <x-icons.back-button />
                        </a>

                        <h5 class="text-lg font-semibold text-gray-800 ms-3 ">
                            Services
                            <span class="text-sm text-gray-500 ">Create Service</span>
                        </h5>
                    </div>

                </div>

                <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 grid grid-cols-4 gap-8">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                                :value="old('name')" autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="service_category_id" :value="__('Category')" />
                            <x-select-input name="service_category_id" :options="$serviceCategory" :selected="old('service_category_id')"
                                class="w-full border p-2" />
                            <x-input-error :messages="$errors->get('service_category_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="person_capacity" :value="__('Person Capacity')" />
                            <x-text-input id="person_capacity" class="mt-1 block w-full" type="number" min=1
                                name="person_capacity" :value="old('person_capacity')" autofocus autocomplete="person_capacity" />
                            <x-input-error :messages="$errors->get('person_capacity')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="fare" :value="__('Base Distance')" />
                            <x-text-input id="fare" class="mt-1 block w-full" :value="old('fare')" type="number"
                                name="fare" autofocus autocomplete="fare" min=0 step="0.01" />
                            <x-input-error :messages="$errors->get('fare')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="minimum_fee" :value="__('Minimum Fee')" />
                            <x-text-input id="minimum_fee" class="mt-1 block w-full" type="number" name="minimum_fee"
                                :value="old('minimum_fee')" autofocus autocomplete="minimum_fee" min=0 step="0.01" />
                            <x-input-error :messages="$errors->get('minimum_fee')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="per_hundred_meters" :value="__('Over Distance (meters)')" />
                            <x-text-input id="per_hundred_meters" class="mt-1 block w-full" type="number" min=0
                                step="0.01" name="per_hundred_meters" :value="old('per_hundred_meters')" autofocus
                                autocomplete="per_hundred_meters" />
                            <x-input-error :messages="$errors->get('per_hundred_meters')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="base_fare" :value="__('Extra Charge (meters)')" />
                            <x-text-input id="base_fare" class="mt-1 block w-full" :value="old('base_fare')" type="number"
                                name="base_fare" autofocus autocomplete="base_fare" min=0 step="0.01" />
                            <x-input-error :messages="$errors->get('base_fare')" class="mt-2" />
                        </div>
                         <div>
                            <x-input-label for="over_minutes" :value="__('Over Duration (minutes)')" />
                            <x-text-input id="over_minutes" class="mt-1 block w-full" type="number" min=0
                                step="0.01" name="over_minutes" :value="old('over_minutes')" autofocus
                                autocomplete="over_minutes" />
                            <x-input-error :messages="$errors->get('over_minutes')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="per_minute_drive" :value="__('Extra Charge (minutes)')" />
                            <x-text-input id="per_minute_drive" class="mt-1 block w-full" type="number" min=0
                                step="0.01" name="per_minute_drive" :value="old('per_minute_drive')" autofocus
                                autocomplete="per_minute_drive" />
                            <x-input-error :messages="$errors->get('per_minute_drive')" class="mt-2" />
                        </div>


                        {{-- <div>
                            <x-input-label for="per_minute_wait" :value="__('Per Minute Wait')" />
                            <x-text-input id="per_minute_wait" class="mt-1 block w-full" type="number" min=0
                                step="0.01" name="per_minute_wait" :value="old('per_minute_wait')" autofocus
                                autocomplete="per_minute_wait" />
                            <x-input-error :messages="$errors->get('per_minute_wait')" class="mt-2" />
                        </div> --}}


                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-textarea id="description" style="height: 8rem;" class="mt-1 block w-full" type="text"
                                name="description" :value="old('description')" autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class=" mb-4 w-100 mt-4">
                            <div x-data="{ imagePreview: null }" @click="$refs.image.click()"
                                class="ant-upload ant-upload-select-picture-card flex flex-col justify-center items-center cursor-pointer relative h-32 w-100 image-preview">

                                <!-- Hidden File Input -->
                                <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                    x-ref="image"
                                    @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }" />

                                <!-- Show image preview if new file is selected -->
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" alt="Image Preview" class=" rounded object-cover "
                                        style="height: 8rem; width:100%" />
                                </template>

                                <!-- Show existing image if no new file selected -->
                                <template x-if="!imagePreview">
                                    <div class="z-10 text-black rounded object-cover absolute flex items-center justify-center"
                                        style="height: 8rem; width:100%; border: 1px dashed #434343;">
                                        <div>
                                            <div class="flex items-center justify-center mb-2">
                                                {{-- <img src="{{ asset('assets/images/image.svg') }}" alt=""
                                                    style="width: 8%"> --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    width="20" height="20">
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

                                            <div class="text-md"><span>Select your service image</span></div>
                                        </div>

                                    </div>

                                </template>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2 text-red-600 text-sm" />
                        </div>


                        <div class=" mt-4">
                            <label class="text-sm" for="">Two Way Available</label><br>

                            <label class="ant-switch mt-2" id="statusToggle">
                                <input type="checkbox" id="two_way_available" class="hidden"
                                    {{ old('two_way_available', 'inactive') === 'active' ? 'checked' : '' }} />
                                <span class="ant-switch-inner"></span>
                            </label>

                            <input type="hidden" name="two_way_available" id="two_way_available_hidden"
                                value="{{ old('two_way_available', 'active') }}">

                            <x-input-error :messages="$errors->get('two_way_available')" class="mt-2" />
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
    //                 this.value = 0.;
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
