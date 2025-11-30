<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Complaints
                        <span class="text-sm text-gray-500">submitted by riders or drivers</span>
                    </h5>
                </div>
                <div class="card driver-middle-section mt-4 rounded-lg ">
                    <div class="card-body p-3">
                        <div class="flex flex-direction items-end lg:items-center justify-end gap-3">
                            <div class=" w-half max-w-300 ">
                                <form action="{{ route('complaints.index') }}" class="relative tp-driver-form">
                                    <div class="flex w-full">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class=" w-full " placeholder="Search complaint">
                                        <x-search></x-search>
                                    </div>
                                </form>
                            </div>
                            <a href="{{ route('complaints.index') }}">
                                <x-reset-button type="button" style="line-height: 1.8rem"></x-reset-button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Request Id</th>
                                <th class="px-4 py-3 text-left">Report Type</th>
                                <th class="px-4 py-3 text-left">Content</th>
                                <th class="px-4 py-3 text-left">Complaint By</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>

                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $complaint)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $complaint['request_id'] }}</td>
                                    <td class="px-4 py-3">{{ $complaint['report_type'] }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $complaint['note'] }}</span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <strong>
                                            {{ $complaint['complaint_by'] == 1
                                                ? 'Rider (' . ($complaint->rider->user->name ?? 'N/A') . ')'
                                                : 'Driver (' . ($complaint->driver->user->name ?? 'N/A') . ')' }}
                                        </strong>
                                    </td>

                                    <td class="px-4 py-3">
                                        @php
                                            $status = $complaint['status'];
                                            $statusOptions = \App\Enums\ComplaintStatus::options();
                                        @endphp

                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400">
                                            </div>
                                            <span class="font-medium text-yellow-600 ms-2">
                                                {{ $statusOptions[$status->value]['name'] ?? ucfirst($status->value) }}
                                            </span>

                                        </div>


                                    </td>
                                    <td class="flex items-center px-4 py-3">
                                        <div x-data="{ showModal_: false }" x-cloak>
                                            <!-- Dropdown: Delete button inside -->
                                            <button type="button" @click.stop="showModal_ = true"
                                                class="w-full text-left text-sm d-flex align-items-center p-1 gap-1">
                                                <i class="fa fa-eye"> Show</i>
                                            </button>

                                            <div x-show="showModal_" @click.away="showModal_ = false" x-cloak
                                                x-transition
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal">

                                                <div class="bg-white p-6 rounded-lg shadow-lg create-rider modalContent"
                                                    style="width:25rem">
                                                    <div class="flex justify-between items-center pb-2">
                                                        <h2 class="text-lg font-semibold">Show Complaint</h2>
                                                        <button @click="showModal_ = false"
                                                            class="text-4xl text-gray-500 hover:text-gray-700">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <!-- Form -->

                                                    <div class=" w-100 text-left" @click.stop="showEditModal_ = true">

                                                        <div>
                                                            <span><strong>Request Id:</strong>
                                                                {{ $complaint['request_id'] }}</span>
                                                        </div>
                                                        <div class="mt-1">
                                                            <span><strong>Report Type:</strong>
                                                                {{ $complaint['report_type'] }}</span>
                                                        </div>
                                                        <div class="mt-1">
                                                            <span><strong>Content:</strong>
                                                                {{ $complaint['note'] }}</span>
                                                        </div>
                                                        <div class="mt-1"><span><strong>Complaint By:</strong>
                                                                {{ $complaint['complaint_by'] == 1
                                                                    ? 'Rider (' . ($complaint->rider->user->name ?? 'N/A') . ')'
                                                                    : 'Driver (' . ($complaint->driver->user->name ?? 'N/A') . ')' }}
                                                            </span>
                                                        </div>
                                                        <div class="mt-1">
                                                            <span><strong>Submitted At:</strong>
                                                                {{ $complaint['created_at'] }}</span>
                                                        </div>
                                                        <div class="mt-1">
                                                            <span><strong>Last modified At:</strong>
                                                                {{ $complaint['updated_at'] }}</span>
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
