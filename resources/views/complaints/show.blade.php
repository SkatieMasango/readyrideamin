<x-app-layout>
    @php
        $status = $complaint->status->value;

        $statusColors = [
            'under_investigation' => 'bg-red-100 text-red-800',
            'resolved' => 'bg-green-100 text-green-800',
        ];

        $label = \App\Enums\Status::options()[$status]['name'] ?? ucfirst(str_replace('_', ' ', $status));
        $color = $statusColors[$status] ?? 'bg-red-100 text-red-800';
    @endphp

    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">

            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center">
                    <a href="{{ route('complaints.index') }}"
                        class=" rounded-md flex items-center bg-gray-50 justify-center" style="width:40px;">
                        <img src="{{ asset('assets/images/angle-left.svg') }}" alt=""
                            style="width: 40px; height:40px">
                    </a>
                    <div class="ms-3">
                        <h5 class="text-xl font-semibold text-gray-800">
                            <span class="ms-3">
                                {{ $complaint->report_type }}
                            </span>
                            <span
                                class="inline-flex items-center rounded px-2 ms-3 text-sm font-medium {{ $color }}">
                                {{ $label }}
                            </span>
                        </h5>
                    </div>
                </div>

                <div class="relative ms-3">

                    <form method="POST" action="{{ route('complaints.updateStatus', $complaint->id) }}"
                        id="status-form">
                        @csrf
                        @method('PUT')
                        <x-select-input name="status" :options="\App\Enums\ComplaintStatus::options()" :selected="$complaint->status->value ?? old('status')" class="mt-1"
                            onchange="document.getElementById('status-form').submit();" />

                        <x-input-label for="status" :value="__('Update Status')" />
                    </form>
                </div>

            </div>

            <div class="grid grid-cols-3 gap-8 mb-5">
                <span class="">Inscription Time :
                    {{ $complaint->created_at ? $complaint->created_at->format('n/j/y, g:i A') : '' }}
                </span>
                <span class="">Content : {{ $complaint->note }}
                </span>
                <span class="">Submitted by : {{ $complaint->complaint_by === 1 ? 'Rider' : 'Driver' }}
                </span>
            </div>


            <div id="details-section">

                <div class="flex">
                    <h5 class="text-xm font-semibold text-gray-800 mb-4">Request Info</h5>
                    <a class="ms-2" style="color : #1469B5;"
                        href="{{ route('request.show', $complaint->request?->id) }}">(View)</a>
                </div>

                <div class="mb-5 grid grid-cols-3 gap-8">
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" name="created_at" autofocus
                            :value="$complaint->request?->created_at
                                ? $complaint->request?->created_at->format('n/j/y, g:i A')
                                : ''" readonly />
                        <x-input-label for="created_at" :value="__('Expected Time')" />

                    </div>
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" name="start_time" autofocus
                            :value="$complaint->request?->created_at
                                ? $complaint->request?->created_at->format('n/j/y, g:i A')
                                : ''" readonly />
                        <x-input-label :value="__('Start Time')" />
                    </div>

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" :value="$complaint->request?->updated_at
                            ? $complaint->request?->updated_at->format('n/j/y, g:i A')
                            : ''" readonly />
                        <x-input-label :value="__('Finished Time')" />
                    </div>

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$complaint->request?->cost_after_coupon" readonly />
                        <x-input-label :value="__('Cost After Coupon')" />

                    </div>


                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$complaint->request?->status->name" readonly />
                        <x-input-label :value="__('Status')" />

                    </div>

                </div>

                @if ($complaint->complaint_by === 1)
                    <div class="flex">
                        <h5 class="text-xm font-semibold text-gray-800 mb-4">Rider Info (Sender)</h5>
                        <a class="ms-2" style="color : #1469B5;"
                            href="{{ route('riders.edit', $complaint->request?->rider?->id) }}">(View)</a>
                    </div>

                    <div class="mb-5 grid grid-cols-3 gap-8">
                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" type="text" name="name" autofocus
                                :value="old(
                                    'name',
                                    $complaint->request?->rider->user->name ?? '',
                                )" readonly />
                            <x-input-label for="name" :value="__('Name')" />

                        </div>
                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="old('mobile', $complaint->request?->rider?->user->mobile ?? '')"
                                readonly />
                            <x-input-label for="mobile" :value="__('Mobile')" />
                        </div>

                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" :value="$complaint->request?->rider?->user->created_at ?? ''" readonly />
                            <x-input-label :value="__('Registered On')" />
                        </div>

                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$complaint->request?->rider?->user->status?->name"
                                readonly />
                            <x-input-label for="address" :value="__('Status')" />

                        </div>
                    </div>
                @else
                    <div class="flex">
                        <h5 class="text-xm font-semibold text-gray-800 mb-4">Driver Info (Sender)</h5>
                        <a class="ms-2" style="color : rgb(238 69 107 / var(--tw-text-opacity, 1));"
                            href="{{ route('drivers.edit', $complaint->request?->driver?->id) }}">(View)</a>
                    </div>


                    <div class="mb-5 grid grid-cols-3 gap-8">
                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" type="text" name="name" autofocus
                                :value="old(
                                    'name',
                                    $complaint->request?->driver?->user->name ?? '' ,
                                )" readonly />
                            <x-input-label for="name" :value="__('Name')" />

                        </div>
                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="old('mobile', $complaint->request?->driver?->user->mobile ?? '')"
                                readonly />
                            <x-input-label for="mobile" :value="__('Mobile')" />
                        </div>

                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" :value="$complaint->request?->updated_at
                                ? $complaint->request?->updated_at->format('n/j/y, g:i A')
                                : ''" readonly />
                            <x-input-label :value="__('Registered On')" />
                        </div>

                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$complaint->request->driver->user->status
                                ? $complaint->request->driver->user->status->name
                                : ''"
                                readonly />
                            <x-input-label :value="__('Status')" />

                        </div>


                    </div>
                @endif


            </div>

        </div>
    </div>
</x-app-layout>

<script></script>
