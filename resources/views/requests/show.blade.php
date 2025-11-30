<x-app-layout>
    @php
        $status = $request->status?->value;

        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'accepted' => 'bg-blue-100 text-blue-800',
            'rejected' => 'bg-red-100 text-red-800',
            'go_to_pickup' => 'bg-indigo-100 text-indigo-800',
            'confirm_arrival' => 'bg-indigo-200 text-indigo-900',
            'picked_up' => 'bg-purple-100 text-purple-800',
            'start_ride' => 'bg-purple-200 text-purple-900',
            'stop_point' => 'bg-gray-200 text-gray-800',
            'in_progress' => 'bg-gray-300 text-gray-900',
            'waiting' => 'bg-yellow-200 text-yellow-900',
            'dropped_off' => 'bg-green-100 text-green-800',
            'completed' => 'bg-green-200 text-green-900',
            'cancelled' => 'bg-red-200 text-red-900',
        ];

        $label = \App\Enums\Status::options()[$status]['name'] ?? ucfirst(str_replace('_', ' ', $status));

        // Color for the badge
        $color = $statusColors[$status] ?? 'bg-red-100 text-red-800';
    @endphp


    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none mb-120">
            <div class="card-body p-6">

                <div class="flex items-center justify-between mb-3">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('request.index') }}"
                            class=" rounded-md flex items-center back-icon justify-center" style="width:40px;">
                            <x-icons.back-button />
                        </a>

                        <h5 class="text-xl font-semibold text-gray-800 ms-3">
                            <span>
                                Request #{{ $request->id }}
                            </span>
                            <span
                                class="inline-flex items-center rounded px-2 ms-3 text-sm font-medium {{ $color }}">
                                {{ $label }}
                            </span>
                        </h5>
                    </div>
                    <div> <span>
                            Cost
                        </span>
                        <h5 class="text-xl font-semibold text-gray-800">
                            ${{ $request->cost_best }}

                        </h5>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-8 mb-5 mt-6">
                    <div class="flex gap-5">
                        <span class="w-50">Request Time
                            <br><strong>{{ $request->created_at->format('n/j/y, g:i A') }}</strong>
                        </span>
                        <span class="w-50">Distance <br><strong>{{ round($request->distance_best) }}m</strong></span>


                    </div>
                    <div class="flex gap-5">
                        <span class="w-50">Service <br><strong>{{ $request->service?->name }}</strong></span>
                        @php
                            $minutes = floor($request->duration_best / 60);
                            $seconds = $request->duration_best % 60;
                        @endphp
                        <span class="w-50">Duration
                            <br><strong>{{ $minutes }}:{{ str_pad($seconds, 2, '0', STR_PAD_LEFT) }}</strong>
                        </span>


                    </div>
                    @php
                        $addresses = is_string($request->addresses)
                            ? json_decode($request->addresses, true)
                            : $request->addresses;
                    @endphp
                    <span>Location <br><strong>{{ $addresses[1] ?? '' }}</strong></span>

                </div>

                <div class="flex gap-5 mb-3 driver-middle-section p-4 rounded-lg">
                    <a href="javascript:void(0);" class="request-button"
                        style="border-bottom:2px solid rgb(194, 197, 201)"
                        data-target="details-section"><strong>Details</strong></a>

                    <a href="javascript:void(0);" class="request-button"
                        data-target="financial-section"><strong>Financial
                            Records</strong></a>
                </div>

                <div id="details-section" style="display: none;">
                    <div class="mb-5 grid grid-cols-4 gap-8 mt-2">
                        <div>
                            <x-input-label for="service_id" :value="__('Service')" />
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$request->service?->name"
                                readonly />
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$request->status->value ?? ''"
                                readonly />
                        </div>
                        <div>
                            <x-input-label :value="__('Distance')" />
                            <x-text-input class="mt-1 block w-full" :value="$request->distance_best" readonly />
                        </div>
                        <div>
                            <x-input-label :value="__('Price')" />
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$request->cost_best"
                                readonly />
                        </div>
                        <div>
                            <x-input-label :value="__('Address')" />
                            @php
                                $addresses = json_decode($request->addresses, true);
                                $pickup = $addresses['pickup_address'] ?? 'N/A';
                                $drop = $addresses['drop_address'] ?? 'N/A';
                            @endphp

                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="'From: ' . $pickup . ' | To: ' . $drop"
                                readonly />

                        </div>
                        <div>
                            <x-input-label :value="__('Payment Gateway')" />
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$request->payment_mode->value .
                                ' ( ' .
                                ($request->payment_status == 0 ? 'Unpaid' : 'Paid') .
                                ')'"
                                readonly />

                        </div>
                    </div>
                    <h5 class="text-xm font-semibold text-gray-800 mt-5">Rider Info</h5>
                    <div class="mb-5 grid grid-cols-4 gap-8 mt-2">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input class="mt-1 block w-full" type="text" name="name" autofocus
                                :value="old('name', $request->rider?->user->name)" readonly />
                        </div>
                        <div>
                            <x-input-label for="mobile" :value="__('Mobile')" />
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="old('mobile', $request->rider?->user->mobile ?? '')"
                                readonly />
                        </div>
                        <div>
                            <x-input-label :value="__('Registered On')" />
                            <x-text-input class="mt-1 block w-full" :value="$request->rider?->user->created_at" readonly />
                        </div>
                        <div>
                            <x-input-label for="address" :value="__('Status')" />

                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$request->rider?->user->status?->name"
                                readonly />
                        </div>
                    </div>

                    <h5 class="text-xm font-semibold text-gray-800">Driver Info</h5>
                    <div class="mb-5 grid grid-cols-4 gap-8 mt-2">
                        <div><x-input-label for="name" :value="__('Name')" />
                            <x-text-input class="mt-1 block w-full" type="text" name="name" autofocus
                                :value="old('name', $request->driver?->user->name)" readonly />
                        </div>
                        <div>
                            <x-input-label for="mobile" :value="__('Mobile')" />
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="old('mobile', $request->driver?->user->mobile ?? '')"
                                readonly />
                        </div>

                        <div>
                            <x-input-label :value="__('Registered On')" />
                            <x-text-input class="mt-1 block w-full" :value="$request->driver?->user->created_at" readonly />
                        </div>

                        <div>
                            <x-input-label :value="__('Status')" />
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$request->driver?->user ? $request->driver->user->status?->name : ''"
                                readonly />
                        </div>
                    </div>
                </div>

                <div id="financial-section" style="display: none;">

                    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
                        @if ($request->payment_mode->value !== 'cash')
                            @foreach ($transactions as $transaction)
                                <div class="card-body p-6">
                                    <div class="flex items-center justify-between">

                                        <h5 class="text-lg font-semibold text-gray-800">
                                             {{ $transaction->transaction === 'debit' ? 'Driver' : 'Admin'}}
                                        </h5>
                                    </div>
                                    <div class="mt-4 overflow-x-auto">
                                        <table
                                            class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                                            <thead>
                                                <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                                    <th class="px-4 py-3 text-left">Amount</th>
                                                    <th class="px-4 py-3 text-left">Type
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-sm text-gray-700">

                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="px-4 py-3 text-left">{{$transaction->amount}}</td>
                                                    <td class="px-4 py-3 text-left">{{ $transaction->method}}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span style="font-size: 22px" class="text-center py-4">Payment completed by cash</span>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const buttons = document.querySelectorAll(".request-button");
        const sections = ["details-section", "financial-section"];

        const savedSection = localStorage.getItem("activeSection");
        const defaultSection = savedSection || "details-section";

        showSection(defaultSection);
        buttons.forEach(button => {
            button.addEventListener("click", function() {
                const targetId = button.getAttribute("data-target");
                localStorage.setItem("activeSection", targetId);
                showSection(targetId);
            });
        });

        function showSection(targetId) {
            sections.forEach(sectionId => {
                const section = document.getElementById(sectionId);
                if (section) {
                    section.style.display = (sectionId === targetId) ? "block" : "none";
                }
            });

            buttons.forEach(btn => {
                if (btn.getAttribute("data-target") === targetId) {
                    btn.style.borderBottom = "2px solid #c2c5c9";
                } else {
                    btn.style.borderBottom = "none";
                }
            });
        }
    });
</script>
