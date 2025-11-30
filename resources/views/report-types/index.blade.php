<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Report
                        <span class="text-sm text-gray-500">List of all types</span>
                    </h5>
                    <div x-data="{ openModal: false }">
                        <!-- Button to open modal -->
                        <div class="w-42">
                            <x-secondary-button type="button" @click="openModal = true">
                                {{ __('Add Report Type') }}
                            </x-secondary-button>
                        </div>

                        <!-- Modal -->
                        <div x-show="openModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                            x-transition>
                            <div class="bg-white p-6 rounded-lg shadow-lg create-rider modalContent "
                                style="width:25rem">

                                <!-- Modal Header -->
                                <div class="flex justify-between items-center pb-2 mb-4">
                                    <h2 class="text-lg font-semibold">Add new Type</h2>
                                    <button @click="openModal = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                                </div>

                                <form id="form" action="{{ route('report-types.store') }}" method="POST">
                                    @csrf

                                    <!-- Payment Type Input -->

                                    <div class="relative mb-4">
                                        <x-input-label :value="__('Report type')" />
                                        <x-text-input class="mt-1 block w-full" type="text" name="report_type"
                                            id="report_type" :value="old('report_type')" />
                                        <div id="report_type_error" class="text-sm text-red-600 mt-2 input-error">
                                            @if ($errors->has('report_type'))
                                                {{ $errors->first('report_type') }}
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Submit Button -->

                                    <div class="flex gap-4 mt-6">
                                        <div class="w-50 ">
                                            <a @click="openModal = false" type="button"
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
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left w-100">Name</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $report)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $report['report_type'] }}</td>

                                     <td class="flex items-center justify-end space-x-3 px-4 py-3">
                                        <div x-data="{ showModal: false }" x-cloak>
                                            <!-- Dropdown: Delete button inside -->
                                            <button type="button" @click.stop="showModal = true"
                                                class="w-full text-left text-sm text-gray-700 d-flex align-items-center p-1 gap-1">
                                                <i class="fa fa-trash" style="color:red; width:24px"></i>
                                            </button>

                                            <div x-show="showModal" @click.away="showModal = false" x-transition
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                                                aria-modal="true" role="dialog">
                                                <div class="bg-white rounded-lg shadow-lg p-6 w-[90%] max-w-md">
                                                    <div class="mb-4 text-center">
                                                        <h3 class="text-xl font-bold">Are you sure?</h3>
                                                        <p class="text-gray-700 mt-2 text-md">
                                                            You want to permanently delete this type?
                                                        </p>
                                                    </div>

                                                    <div class="flex justify-center gap-3">
                                                        <button @click="showModal = false"
                                                            class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                            Cancel
                                                        </button>
                                                        <form method="POST"
                                                            action="{{ route('report-types.destroy', $report->id) }}">
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

                <x-partials.navigation :data="$data" />
            </div>
        </div>
    </div>
</x-app-layout>
