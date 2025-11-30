<x-app-layout>
    @php
        $status = $sos->status;

        $statusColors = [
            'submitted' => 'bg-green-100 text-green-800',
            'resolved' => 'bg-yellow-100 text-yellow-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];

        $label = \App\Enums\Status::options()[$status]['name'] ?? ucfirst(str_replace('_', ' ', $status));
        $color = $statusColors[$status] ?? 'bg-red-100 text-red-800';
    @endphp

    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">

            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center justify-between">
                    <a href="{{ route('sos.index') }}"
                        class=" rounded-md flex items-center bg-gray-50 justify-center" style="width:40px;">
                        <img src="{{ asset('assets/images/angle-left.svg') }}" alt=""
                            style="width: 40px; height:40px">
                    </a>

                    <h5 class="text-xl font-semibold text-gray-800 ms-3">
                        <span>
                            Sos #{{ $sos->id }}
                        </span>
                        <span
                            class="inline-flex items-center rounded px-2 ms-3 text-sm font-medium {{ $color }}">
                            {{ $label }}
                        </span>
                    </h5>
                </div>
            </div>

            <div class="flex justify-between mb-5">
                <span class="">Inscription Time : {{ $sos->created_at->format('n/j/y, g:i A') }}
                </span>
                <span class="">Submitted by : {{ $sos->submitted_by_rider === 1 ? 'Rider' : 'Driver' }}
                </span>
                <span></span>
            </div>

            <div class="flex gap-5 mb-3">
                <a href="javascript:void(0);" class="sos-button"
                    style="border-bottom:2px solid #1469B5;"
                    data-target="details-section"><strong>Details</strong></a>
            </div>

            <div id="details-section">
                <div class="flex">
                    <h5 class="text-xm font-semibold text-gray-800 mb-4">Request Info</h5>
                    <a class="ms-2" style="color : #1469B5;"
                        href="{{ route('request.show', $sos->request?->id) }}">(View)</a>
                </div>

                <div class="mb-5 grid grid-cols-3 gap-8">
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" name="created_at" autofocus
                            :value="$sos->request?->created_at->format('n/j/y, g:i A')" readonly />
                        <x-input-label for="created_at" :value="__('Expected Time')" />
                    </div>
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" name="start_time" autofocus
                            :value="$sos->request?->created_at->format('n/j/y, g:i A')" readonly />
                        <x-input-label :value="__('Start Time')" />
                    </div>

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" :value="$sos->request?->updated_at->format('n/j/y, g:i A')" readonly />
                        <x-input-label :value="__('Finished Time')" />
                    </div>

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$sos->request?->cost_after_coupon" readonly />
                        <x-input-label :value="__('Cost After Coupon')" />

                    </div>
                    @php
                        $addresses = is_string($sos->request?->addresses)
                            ? json_decode($sos->request?->addresses, true)
                            : $sos->request?->addresses;
                    @endphp

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$sos->request?->status->name" readonly />
                        <x-input-label :value="__('Status')" />

                    </div>

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$addresses['pickup_address'] . ' to ' . $addresses['drop_address']" readonly />
                        <x-input-label :value="__('Locations')" />

                    </div>
                </div>


                <div class="flex">
                    <h5 class="text-xm font-semibold text-gray-800 mb-4">Rider Info</h5>
                    <a class="ms-2" style="color : #1469B5;"
                        href="{{ route('riders.edit', $sos->request?->rider?->id) }}">(View)</a>
                </div>

                <div class="mb-5 grid grid-cols-3 gap-8">
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" name="name" autofocus
                            :value="old(
                                'name',
                                $sos->request?->rider->user->name,
                            )" readonly />
                        <x-input-label for="name" :value="__('Name')" />
                    </div>
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" autofocus :value="old('mobile', $sos->request?->rider?->user->mobile ?? '')" readonly />
                        <x-input-label for="mobile" :value="__('Mobile')" />
                    </div>

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" :value="$sos->request?->rider?->user->created_at" readonly />
                        <x-input-label :value="__('Registered On')" />
                    </div>

                </div>

                <div class="flex">
                    <h5 class="text-xm font-semibold text-gray-800 mb-4">Driver Info</h5>
                    <a class="ms-2" style="color : #1469B5;"
                        href="{{ route('drivers.edit', $sos->request?->driver?->id) }}">(View)</a>
                </div>


                <div class="mb-5 grid grid-cols-3 gap-8">
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" name="name" autofocus
                            :value="old(
                                'name',$sos->request?->driver?->user->name)" readonly />
                        <x-input-label for="name" :value="__(' Name')" />
                    </div>
                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" autofocus :value="old('mobile', $sos->request?->driver?->user->mobile ?? '')" readonly />
                        <x-input-label for="mobile" :value="__('Mobile')" />
                    </div>

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" :value="$sos->request?->driver?->user->created_at" readonly />
                        <x-input-label :value="__('Registered On')" />
                    </div>

                    <div class="relative">
                        <x-text-input class="mt-1 block w-full" type="text" autofocus :value="$sos->request->driver->user->status ? $sos->request->driver->user->status->name : ''" readonly />
                        <x-input-label :value="__('Status')" />

                    </div>

                </div>
            </div>

            <div id="activity-section">
                <div class="mb-4">
                    <div class="flex">
                        <h5 class="text-xm font-semibold text-gray-800 mb-3">Activities</h5>

                    </div>

                    <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                                <th class="border-b border-gray-300 px-4 py-3 text-left">Title</th>
                                <th class="border-b border-gray-300 px-4 py-3 text-left">Note</th>
                            </tr>
                        </thead>

                        <tbody id="sos-activity-body">
                            @foreach ($sosActivites as $sosActivity)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $sosActivity['status'] }}
                                        <br> <span style="font-size: 12px" class="text-gray-500">
                                            {{ \Carbon\Carbon::parse($sosActivity['created_at'])->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ $sosActivity['note'] }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <h5 class="text-xm font-semibold text-gray-800 mb-3">Insert Activity</h5>
                <form id="sosForm" method="POST" action="{{ route('sos-activity.save') }}">
                    @csrf
                    <div class="mb-5 grid grid-cols-2 gap-8">

                        <input type="hidden" name="sos_id" value="{{ $sos->id }}">
                        <div class="relative">
                            <x-select-input name="action" :options="\App\Enums\SOSActivity::options()" :selected="old('action')" class="mt-1" />
                            <x-input-label for="action" :value="__('Action')" />
                            <x-input-error :messages="$errors->get('action')" class="mt-2" />
                        </div>

                        <div class="relative">
                            <x-text-input class="mt-1 block w-full" type="text" name="note" :value="old('note')" />
                            <x-input-label :value="__('Note')" />
                        </div>
                        <div class="flex justify-start">
                            <x-primary-button style="width: 100px" id="submitButton">
                                {{ __('Submit') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
<script>
      dayjs.extend(dayjs_plugin_relativeTime);
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('sosForm');
        const submitButton = document.getElementById('submitButton');

        submitButton.addEventListener('click', async function(event) {
            event.preventDefault();

            const formData = new FormData(form);
            const url = form.getAttribute('action'); // ✅ Safe way to get URL

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                if (response.ok) {
                    const result = await response.json();
                    console.log(result, response, 'sdf');

                    const tbody = document.querySelector(
                        '#sos-activity-body'); // make sure tbody has this ID

                    const row = document.createElement('tr');
                    row.className = 'border-b hover:bg-gray-50';
                    const createdAtHuman = dayjs(result.data.created_at).fromNow();

                    row.innerHTML = `
    <td class="px-4 py-3">
        ${result.data.status}
        <br>
        <span style="font-size: 12px" class="text-gray-500">${createdAtHuman}</span>
    </td>
    <td class="px-4 py-3">
        <div class="flex items-center">
            <span class="font-medium">${result.data.note}</span>
        </div>
    </td>
`;

                    tbody.appendChild(row);


                } else {
                    const error = await response.text();

                }

            } catch (err) {
                console.error('JavaScript error:', err);
                alert('Unexpected error occurred.');
            }
        });
    });
</script>
