<x-app-layout>
    <div class="demo_main_content_area">
        <div class="vehicled card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="vehicled-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Vehicle
                        <span class="text-sm text-gray-500">Basic list of models</span>
                    </h5>
                    <div x-data="{ showModal: false }">
                        <x-secondary-button type="button" @click="showModal = true">
                            {{ __('Add Model') }}
                        </x-secondary-button>

                        <div x-show="showModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                            x-transition>
                            <div class="bg-white p-6 rounded-lg shadow-lg create-rider modalContent "
                                style="width:20rem">
                                <div class="flex justify-between items-center pb-2">
                                    <h2 class="text-lg font-semibold">Add new Model</h2>
                                    <button @click="showModal = false"
                                        class="text-4xl text-gray-500 hover:text-gray-700">
                                        &times;
                                    </button>
                                </div>

                                <form id="form" method="POST" action="{{ route('vehicle-model.store') }}">
                                    @csrf
                                    <div class="mb-4 grid grid-cols-1 ">
                                        <div class="relative">
                                            <x-input-label for="vehicle_brand_id" :value="__('Vehicle Brand')" />
                                            <x-select-input name="vehicle_brand_id" :options="$vehicleBrands" :selected="old('vehicle_brand_id')"
                                                class="w-full border p-2 mt-1" />
                                        </div>
                                        <div class="relative mt-3">
                                            <x-input-label for="name" :value="__('Name')" />
                                            <x-text-input id="name" class="mt-1 block w-full" type="text"
                                                name="name" :value="old('name')" autofocus autocomplete="name" />

                                            <div id="name_error" class="text-sm text-red-600 mt-2 input-error">
                                                @if ($errors->has('name'))
                                                    {{ $errors->first('name') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex gap-4 mt-6">
                                        <div class="w-50 ">
                                            <a @click="showModal = false" type="button"
                                                class="w-full px-4 py-3 text-sm text-gray-700 bg-gray-200 rounded-lg text-center">
                                                Cancel
                                            </a>
                                        </div>
                                        <div class="w-50">
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

                <div class="mt-4 overflow-x-auto">
                    <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class=" text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Brands</th>
                                <th class="px-4 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($vehicleModels as $model)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $model['name'] }}</td>
                                    <td class="px-4 py-3">{{ $model->brand['name'] ?? 'N/A' }}</td>
                                    <td class="flex items-center justify-end space-x-3 px-4 py-3">
                                        <div x-data="{ showModal: false }" x-cloak>
                                            <!-- Dropdown: Delete button inside -->
                                            <button type="button" @click.stop="showModal = true"
                                                class="w-full text-left text-sm text-gray-700 d-flex align-items-center p-1 gap-1">
                                                <i class="fa fa-trash" style="color:red; width:24px"></i>
                                            </button>

                                            <!-- Modal Outside Dropdown -->
                                            <div x-show="showModal" @click.away="showModal = false" x-transition
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                                                aria-modal="true" role="dialog">
                                                <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md">
                                                    <div class="mb-4 text-center">
                                                        <h3 class="text-xl font-bold">Are you sure?</h3>
                                                        <p class="text-gray-700 mt-2 text-md">
                                                            You want to permanently delete this vehicle model?
                                                        </p>
                                                    </div>

                                                    <div class="flex justify-center gap-3">
                                                        <button @click="showModal = false"
                                                            class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                            Cancel
                                                        </button>
                                                        <form method="POST"
                                                            action="{{ route('vehicle-model.destroy', $model->id) }}">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
