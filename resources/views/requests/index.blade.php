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
    </style>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Request
                        <span class="text-sm text-gray-500">List of all order request.</span>
                    </h5>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('request.index') }}">
                            <x-reset-button type="button" style="line-height: 1.5rem"></x-reset-button>
                        </a>
                    </div>
                </div>

                <div class="card driver-middle-section mt-4 rounded-lg" x-data="{ openFilterModal: false }">
                    <div class="card-body p-3">
                        <div class="flex flex-direction items-end lg:items-center justify-end gap-3">
                            <div class=" w-full max-w-300 ">
                                <form action="{{ route('request.index') }}" class="relative tp-rider-form">
                                    <div class="flex w-full">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class=" w-full " placeholder="Search rider name or phone">
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

                                        <a href="{{ route('request.export', array_merge(request()->query(), ['export_type' => 'pdf'])) }}"
                                            class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 flex items-center justify-center p-1 gap-1">
                                            <span>PDF</span>
                                        </a>

                                        <a href="{{ route('request.export', array_merge(request()->query(), ['export_type' => 'csv'])) }}"
                                            class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 flex items-center justify-center p-1 gap-1">
                                            <span>CSV</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Trigger Button -->
                                <x-secondary-button @click="openFilterModal = true" type="button">
                                    Filter
                                </x-secondary-button>
                                <div x-show="openFilterModal" x-cloak x-transition @click.away="openFilterModal = false"
                                    class="absolute mt-7 w-80 bg-white rounded-lg shadow-lg z-50 p-4 modalContent"
                                    style="right:15px" @close-all.window="openFilterModal = false">
                                    <!-- Filter Form -->
                                    <form method="GET" action="{{ route('request.index') }}">
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
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Id</th>
                                <th class="px-4 py-3 text-left">Date & Time</th>
                                <th class="px-4 py-3 text-left">Rider</th>
                                <th class="px-4 py-3 text-left">Driver</th>
                                <th class="px-4 py-3 text-left">Service</th>
                                <th class="px-4 py-3 text-left">Cost</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class=" px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $request)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $request->id }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <strong>{{ \Carbon\Carbon::parse($request['created_at'])->diffForHumans() }}
                                        </strong>
                                    </td>
                                    <td class="px-4 py-3">{{ $request->rider?->user?->name }}
                                    </td>
                                    <td class="px-4 py-3">{{ $request->driver?->user?->name }}
                                    </td>
                                    <td class="px-4 py-3">{{ $request->service?->name }}
                                    </td>
                                    <td class="px-4 py-3">${{ $request->cost_best }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="mr-2 h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400">
                                            </div>
                                            <span class="font-medium text-yellow-600">{{ $request['status'] }}</span>
                                        </div>
                                    </td>
                                    <td class="flex items-center px-4 py-3">
                                        <a type="button" href="{{ route('request.show', $request['id']) }}"
                                            class="w-full text-left text-sm d-flex align-items-center p-1 gap-1">
                                            <i class="fa fa-eye"> Show</i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <x-partials.navigation :data="$data" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
     flatpickr("#joinDate", {
        mode: "range",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {

        }
    });
</script>
