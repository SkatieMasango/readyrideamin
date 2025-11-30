<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Promotionals
                        <span class="text-sm text-gray-500">List of all promotionals</span>
                    </h5>
                    <div x-data="{ openModal: false }">
                        <div>
                            <x-secondary-button type="button"
                                @click="openModal = true">{{ __('Add banner ') }}</x-secondary-button>
                        </div>

                        <!-- Modal -->
                        <div x-show="openModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75"
                            x-transition>
                            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md" style="width: 30%">
                                <div class="flex justify-between items-center pb-2">
                                    <h2 class="text-lg font-semibold">Add promotional banner</h2>
                                    <button @click="openModal = false"
                                        class="text-4xl text-gray-500 hover:text-gray-700">
                                        &times;
                                    </button>
                                </div>

                                <form id="form" action="{{ route('marketing-promotionals.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="relative mt-2 w-100">
                                        <div x-data="{ imagePreview: null }" @click="$refs.image.click()"
                                            class="ant-upload ant-upload-select-picture-card flex flex-col justify-center items-center cursor-pointer relative h-32 w-100">

                                            <!-- Hidden File Input -->
                                            <input id="image" name="image" type="file" class="hidden"
                                                accept="image/*" x-ref="image"
                                                @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }" />

                                            <!-- Show image preview if new file is selected -->
                                            <template x-if="imagePreview">
                                                <img :src="imagePreview" alt="Image Preview"
                                                    class=" rounded object-cover " style="height: 8rem;" />
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
                                                        <div class="text-md"><span>Select your banner image</span></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <div id="image_error" class="text-sm text-red-600 mt-2 input-error">
                                            @if ($errors->has('image'))
                                                {{ $errors->first('image') }}
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex gap-4 mt-6">
                                        <div class="w-50">
                                            <a @click="openModal = false" type="button"
                                                class="w-full px-4 py-3 text-sm text-gray-700 bg-gray-200 rounded-lg text-center ">
                                                Cancel
                                            </a>
                                        </div>
                                        <div class="w-50 ">
                                            <x-primary-button type="button" onclick="submitForm()">
                                                {{ __('Save') }}
                                            </x-primary-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8">
                        @foreach ($promos as $promo)
                            <div class="bg-white border-none rounded-lg relative promo-container" data-id="{{ $promo->id }}">

                                @php $modalKey = 'showModal_'.$promo['id']; @endphp
                                <div x-data="{ showModal: false }" x-cloak >
                                    <!-- Dropdown: Delete button inside -->
                                    <button type="button" @click.stop="showModal = true"
                                        class="hover-button absolute top-2 px-3 text-red-500 rounded hidden"
                                        style="margin-left:90%; title="Delete Promo">
                                        <i class="fa fa-trash p-1 rounded" style="color:red; width:100%; background-color:#fff"></i>
                                    </button>

                                    <!-- Modal Outside Dropdown -->
                                    <div x-show="showModal" @click.away="showModal = false" x-transition
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                                        aria-modal="true" role="dialog">
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md">
                                            <div class="mb-4 text-center">
                                                <h3 class="text-xl font-bold">Are you sure?</h3>
                                                <p class="text-gray-700 mt-2 text-md">
                                                    You want to permanently delete this banner?
                                                </p>
                                            </div>

                                            <div class="flex justify-center gap-3">
                                                <button @click="showModal = false"
                                                    class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                    Cancel
                                                </button>
                                                <form method="POST"
                                                    action="{{ route('marketing-promotionals.destroy', $promo->id) }}">
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

                                <!-- Promo Image -->
                                <div class="promo-image">
                                    @if ($promo->media)
                                        <img src="{{ asset('storage/' . $promo->media->path) }}" alt="Promo Image"
                                            class="w-full object-cover rounded " style="height: 12rem" data-id="{{ $promo->id }}">
                                    @else
                                        <div
                                            class="w-full h-40 flex items-center justify-center bg-gray-100 text-gray-400 italic rounded">
                                            No image
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const promoContainers = document.querySelectorAll('.promo-container');

        promoContainers.forEach(container => {
            const image = container.querySelector('.promo-image');
            const button = container.querySelector('.hover-button');

            if (image && button) {
                image.addEventListener('mouseenter', () => {
                    button.classList.remove('hidden');
                });

                image.addEventListener('mouseleave', () => {
                    button.classList.add('hidden');
                });

                // Optional: Also hide when mouse leaves the button
                button.addEventListener('mouseenter', () => {
                    button.classList.remove('hidden');
                });
            }
        });
    });
</script>
