<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .flex-direction {
            flex-direction: column;
        }

        .max-w-300 {
            max-width: 300px;
        }

        .bg-opacity-0 {
            --tw-bg-opacity: 0
        }

        @media (min-width: 768px) {
            .flex-direction {
                flex-direction: row;
            }
        }

        select {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>

    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mt-4" x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }} }">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Drivers
                        <span class="text-sm text-gray-500">List of all drivers</span>
                    </h5>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('drivers.view') }}">
                            <x-reset-button type="button" style="line-height: 1.5rem"></x-reset-button>
                        </a>
                        <x-secondary-button type="button" @click="openModal = true">
                            {{ __('Add driver ') }}
                        </x-secondary-button>
                    </div>

                    <!-- Modal -->
                    <div x-show="openModal" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                        x-transition>
                        <div class="bg-white p-6 rounded-lg shadow-lg create-driver modalContent" style="width:25rem">
                            <div class="flex justify-between items-center pb-2">
                                <h2 class="text-lg font-semibold">Add new driver</h2>
                                <button @click="openModal = false" class="text-4xl text-gray-500 hover:text-gray-700">
                                    &times;
                                </button>
                            </div>
                            <form id="form" method="POST" action="{{ route('drivers.store') }}">
                                @csrf
                                <div class="relative mt-2 w-100">
                                    <div>
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" class="mt-1 block w-full" type="text"
                                            name="name" :value="old('name')" autofocus autocomplete="name" />
                                    </div>
                                    <div class="mt-2">
                                        <x-input-label for="country_code" :value="__('Mobile Number')" />
                                        <div class="flex rounded-md  mt-1">
                                            <select name="country_code" id="country_code"
                                                class="select2 w-[200px] h-[55px] truncate rounded-l-md bg-white p-3 text-sm focus:border-primary-500 focus:ring-primary-500">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country['phone_code'] }}"
                                                        title="{{ $country['name'] }}"
                                                        {{ old('country_code') == $country['phone_code'] ? 'selected' : '' }}>
                                                        {{ \Illuminate\Support\Str::limit($country['code'], 15) }}
                                                        ({{ $country['phone_code'] }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="number" name="mobile" id="mobile"
                                                class="block w-full rounded-r-md text-sm focus:border-primary-500 focus:ring-primary-500"
                                                value="{{ old('mobile') }}" autocomplete="text"
                                                placeholder="Enter phone number" />
                                        </div>

                                        <div class="flex gap-4">
                                            <div id="mobile_error" class="text-sm text-red-600 mt-2 input-error">
                                                @if ($errors->has('mobile'))
                                                    {{ $errors->first('mobile') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <x-input-label for="gender" :value="__('Gender')" />
                                        <x-select-input name="gender" :options="\App\Enums\Gender::options()" :selected="old('gender')"
                                            class="mt-1" />
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
                <div class="card driver-middle-section mt-4 rounded-lg " x-data="{ openFilterModal: false }">
                    <div class="card-body p-3">
                        <div class="flex flex-direction items-end lg:items-center justify-end gap-3">
                            <div class=" w-full max-w-300 ">
                                <form action="{{ route('drivers.view') }}" class="relative tp-driver-form">
                                    <div class="flex w-full">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class=" w-full " placeholder="Search driver name or phone">
                                        <x-search></x-search>
                                    </div>
                                </form>
                            </div>

                            <div class="flex justify-between gap-3">
                                <div x-data="{ openExportModal: false }" @close-all.window="openExportModal = false">
                                    <x-primary-button @click="openExportModal = true" type="button"
                                        style="line-height: 1.5rem; height: 48px"><i
                                            class="fa fa-download"></i>Export</x-primary-button>
                                    <div x-show="openExportModal" x-cloak x-transition
                                        @click.away="openExportModal = false"
                                        class="absolute mt-2 w-20 bg-white rounded-lg shadow-lg z-50 p-2 modalContent"
                                        style="right:125px">
                                        {{-- PDF Export --}}
                                        <a href="{{ route('drivers.export', array_merge(request()->query(), ['export_type' => 'pdf'])) }}"
                                            class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 flex items-center justify-center p-1 gap-1">
                                            <span>PDF</span>
                                        </a>
                                        {{-- CSV Export --}}
                                        <a href="{{ route('drivers.export', array_merge(request()->query(), ['export_type' => 'csv'])) }}"
                                            class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 flex items-center justify-center p-1 gap-1">
                                            <span>CSV</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Filter Button -->
                                <x-secondary-button @click="openFilterModal = true" type="button">
                                    Filter
                                </x-secondary-button>
                                <div x-show="openFilterModal" x-cloak x-transition @click.away="openFilterModal = false"
                                    class="absolute mt-7 w-80 bg-white rounded-lg shadow-lg z-50 p-4 modalContent"
                                    style="right:15px"  @close-all.window="openFilterModal = false">
                                    <form method="GET" action="{{ route('drivers.view') }}">
                                        <div>
                                            <x-input-label for="joinDate" :value="__('Join Date')" />
                                            <input id="joinDate" class="block w-full rounded" type="text"
                                                name="join_date" value="{{ request('join_date') }}"
                                                autocomplete="join_date" placeholder="Start date - End date" />
                                            <x-input-error :messages="$errors->get('join_date')" class="mt-2" />
                                        </div>

                                        <div class="mt-2">
                                            <x-input-label for="orderBy" :value="__('Order By')" />
                                            <select name="order_by" id="orderBy"
                                                class=" w-full rounded mt-1 focus:border-primary-500 focus:ring-primary-500 "
                                                style="padding:8px">
                                                <option value="">{{ request('order_by') ?? 'Order By' }}
                                                </option>
                                                <option value="latest">Latest</option>
                                                <option value="oldest">Oldest</option>
                                            </select>
                                            <x-input-error :messages="$errors->get('order_by')" class="mt-2" />
                                        </div>

                                        <!-- Buttons -->
                                        <div class="flex justify-end gap-3 mt-3" style="height:40px">
                                            <button type="button" @click="openFilterModal = false"
                                                class="px-4  bg-gray-200 border-none rounded text-sm w-full">
                                                Close
                                            </button>
                                            <x-primary-button type="submit" class="w-full">
                                                {{ __('Apply') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto overflow-y-hidden">
                    <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class=" text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class=" px-4 py-3 text-left">Serial No</th>
                                <th class=" px-4 py-3 text-left">Number</th>
                                <th class=" px-4 py-3 text-left">Name</th>
                                <th class=" px-4 py-3 text-left">Contact info</th>
                                <th class=" px-4 py-3 text-left">Total Trip</th>
                                <th class=" px-4 py-3 text-left">Status</th>
                                <th class=" px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $driver)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">#{{ $driver->id ?? '' }}
                                    </td>
                                    <td class="px-4 py-3">{{ $driver->user?->mobile ?? '' }}
                                    </td>
                                    <td class="px-4 py-3"><strong>{{ $driver->user?->name ?? '' }}
                                        </strong><br>
                                        <span class="text-sm text-gray-500">Registered on
                                            {{ \Carbon\Carbon::parse($driver->created_at)->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $driver->user?->address ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3">{{ count($driver->orders ?? []) }}</td>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="font-medium ">{{ $driver->user?->status?->label() }}</span>
                                        </div>
                                    </td>

                                    <td class=" tp-btn-action ">
                                        <div
                                            class="tp-order d-flex align-items-center justify-content-center relative">
                                            <x-action-button></x-action-button>
                                            <div class="tp-order-thumb-more absolute">
                                                <a type="submit" href="{{ route('drivers.edit', $driver['id']) }}"
                                                    class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                    <i class="fa fa-edit"></i><span>Edit</span>
                                                </a>
                                                @php $modalId = 'showModal_' . $driver->id; @endphp
                                                <div x-data="{ showModal: false }" x-cloak >
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
                                                                    You want to permanently delete this driver?
                                                                </p>
                                                            </div>

                                                            <div class="flex justify-center gap-3">
                                                                <button @click="showModal = false"
                                                                    class="px-3 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                                                    Cancel
                                                                </button>
                                                                <form method="POST"
                                                                    action="{{ route('drivers.destroy', $driver->id) }}">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    flatpickr("#joinDate", {
        mode: "range",
        dateFormat: "Y-m-d",
        // onChange: function(selectedDates, dateStr, instance) {

        // }
    });

    $(document).ready(function() {
        $('#country_code').select2({
            width: '100%'
        });
    });

    // export section
    $(".filter-btn").on("click", function(e) {
        e.stopPropagation();

        $(".filter-btn").not(this).removeClass("tp-filter-open");

        $(this).toggleClass("tp-filter-open");
    });
    $(document).on("click", function() {
        $(".filter-btn").removeClass("tp-filter-open");
    });
</script>
