<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Service
                        <span class="text-sm text-gray-500">List of all category</span>
                    </h5>
                    <div x-data="{ showModal: false }">
                        <!-- Trigger Button -->
                        <x-secondary-button type="button" @click="showModal = true">
                            {{ __('Add category') }}
                        </x-secondary-button>


                        <!-- Modal -->
                        <div x-show="showModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                            x-transition>
                            <div class="bg-white p-6 rounded-lg shadow-lg create-rider modalContent "
                                style="width:25rem">

                                <!-- Modal Header -->
                                <div class="flex justify-between items-center pb-2 mb-4">
                                    <h2 class="text-lg font-semibold">Add new Category</h2>
                                    <button @click="showModal = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                                </div>

                                <!-- Modal Body (form goes here) -->
                                <form id="form" method="POST" action="{{ route('services-category.store') }}">
                                    @csrf

                                    <div class="mb-4 grid grid-cols-1">
                                        <div>
                                            <x-input-label for="name" :value="__('Name')" />
                                            <x-text-input id="name" class="mt-1 block w-full" type="text"
                                                name="name" :value="old('name')" autofocus autocomplete="name" />
                                            <div id="name_error" class="text-sm text-red-600 mt-2 input-error">
                                                @if ($errors->has('name'))
                                                    {{ $errors->first('name') }}
                                                @endif
                                            </div>
                                        </div>

                                        <div>
                                            <x-input-label for="description" :value="__('Description')" />
                                            <x-textarea id="description" class="mt-1 block w-full" type="text"
                                                name="description" autofocus autocomplete="description"
                                                :value="old('description')" />
                                            <div id="description_error" class="text-sm text-red-600 mt-2 input-error">
                                                @if ($errors->has('description'))
                                                    {{ $errors->first('description') }}
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                    <!-- Modal Footer -->
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
                <div class="mt-4 overflow-x-hidden overflow-y-hidden">
                    <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Description</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $service)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <strong>{{ $service['name'] ?? '' }}</strong>
                                    </td>
                                    <td class="px-4 py-3">{{ $service['description'] }}</td>
                                    <td class=" tp-btn-action ">
                                        <div class="tp-order d-flex align-items-center justify-content-center relative">
                                            <x-action-button></x-action-button>
                                            <div class="tp-order-thumb-more absolute">

                                                @php $modalId = 'showEditModal_' . $service->id; @endphp
                                                <div x-data="{ {{ $modalId }}: false }">
                                                    <!-- Edit Button -->
                                                    <button type="button" @click.stop="{{ $modalId }} = true"
                                                        class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                        <i class="fa fa-edit"></i><span>Edit</span>
                                                    </button>

                                                    <div x-show="{{ $modalId }}" @click.away="{{ $modalId }} = false"
                                                        x-cloak x-transition
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal">

                                                        <div class="bg-white p-6 rounded-lg shadow-lg create-rider modalContent"
                                                            style="width:25rem">
                                                            <div class="flex justify-between items-center pb-2">
                                                                <h2 class="text-lg font-semibold">Edit Category</h2>
                                                                <button @click="{{ $modalId }} = false"
                                                                    class="text-4xl text-gray-500 hover:text-gray-700">
                                                                    &times;
                                                                </button>
                                                            </div>

                                                            <!-- Form -->
                                                            <form id="formEdit_{{ $service->id }}" method="POST"
                                                                action="{{ route('services-category.update', $service->id) }}">
                                                                @csrf
                                                                <div class="mt-2 w-100 text-left"
                                                                    @click.stop="{{ $modalId }} = true">

                                                                    <div>
                                                                        <x-input-label for="name"
                                                                            :value="__('Name')" />
                                                                        <x-text-input id="name"
                                                                            class="mt-1 block w-full" type="text"
                                                                            name="name" autofocus autocomplete="name"
                                                                            :value="old(
                                                                                'name',
                                                                                $service->name ?? '',
                                                                            )" />
                                                                        <div id="name_error-edit"
                                                                            class="text-sm text-red-600 mt-2 input-error-edit">
                                                                            @if ($errors->has('name'))
                                                                                {{ $errors->first('name') }}
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <!-- Description Field -->
                                                                    <div class="mt-2">
                                                                        <x-input-label for="body"
                                                                            :value="__('Description')" />
                                                                        <x-textarea id="description"
                                                                            class="mt-1 block w-full" type="text"
                                                                            name="description" autofocus
                                                                            autocomplete="description"
                                                                            :value="old(
                                                                                'description',
                                                                                $service->description ?? '',
                                                                            )" />
                                                                        <div id="description_error-edit"
                                                                            class="text-sm text-red-600 mt-2 input-error-edit">
                                                                            @if ($errors->has('description'))
                                                                                {{ $errors->first('description') }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="flex gap-4 mt-6">
                                                                    <div class="w-50">
                                                                        <a @click="{{ $modalId }} = false"
                                                                            type="button"
                                                                            class="w-full px-4 py-3 text-sm text-gray-700 bg-gray-200 rounded-lg text-center">
                                                                            Cancel
                                                                        </a>
                                                                    </div>
                                                                    <div class="w-50">
                                                                        <x-primary-button type="button"
                                                                            onclick="submitEditForm(event,{{ $service->id }})">
                                                                            {{ __('Update') }}
                                                                        </x-primary-button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                @php $modalId = 'showModal_' . $service->id; @endphp
                                                <div x-data="{ showModal: false }" x-cloak>
                                                    <!-- Dropdown: Delete button inside -->
                                                    <button type="button" @click.stop="showModal = true"
                                                        class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                        <i class="fa fa-trash"
                                                            style="color:red; width:14px"></i><span>Delete</span>
                                                    </button>

                                                    <!-- Modal Outside Dropdown -->
                                                    <div x-show="showModal" @click.stop
                                                        x-transition
                                                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                                                        aria-modal="true" role="dialog">
                                                        <div
                                                            class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md">
                                                            <div class="mb-4 text-center">
                                                                <h3 class="text-xl font-bold">Are you sure?</h3>
                                                                <p class="text-gray-700 mt-2 text-md">
                                                                    You want to permanently delete this category?
                                                                </p>
                                                            </div>

                                                            <div class="flex justify-center gap-3">
                                                                <button @click="showModal = false"
                                                                    class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                                    Cancel
                                                                </button>
                                                                <form method="POST"
                                                                    action="{{ route('services-category.destroy', $service->id) }}">
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
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <x-partials.navigation :data="$data" />
            </div>
        </div>
    </div>
</x-app-layout>
<script>

</script>
