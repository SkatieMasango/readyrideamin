<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Wallet
                        <span class="text-sm text-gray-500">List of system provider income.</span>
                    </h5>

                    <a href="{{ route('accounting.admin', ['name' => request()->name]) }}">
                        <x-reset-button type="button" style="line-height: 1.8rem"></x-reset-button>
                    </a>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Date & Time</th>
                                <th class="px-4 py-3 text-left">Name</th>
                                <th class="px-4 py-3 text-left">Amount</th>
                                <th class="px-4 py-3 text-left">Currency</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        {{-- @dd($data) --}}
                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $accounting)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $accounting['created_at'] }}</td>
                                    <td class="px-4 py-3">{{ $accounting->user['name'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-3">{{ $accounting['amount'] }}</td>
                                    <td class="px-4 py-3">{{ $generalSettings->currency }}</td>

                                    <td class="px-4 py-3">
                                        @if ($accounting->user->getRoleNames()[0] === 'driver' && $accounting->user->driver && request()->name === 'drivers')
                                            <a href="{{ route('drivers.edit', $accounting->user?->driver?->id) }}">
                                                <i class="fa fa-eye"> Driver</i>
                                            </a>
                                        @elseif($accounting->user->getRoleNames()[0] === 'rider' && $accounting->user->rider && request()->name === 'riders')
                                            <a href="{{ route('riders.edit', $accounting->user?->rider?->id) }}">
                                                <i class="fa fa-eye"> Rider</i>
                                            </a>
                                        {{-- @elseif($accounting->user->getRoleNames()[0] === 'fleet' && $accounting->user->fleet)
                                            <a href="{{ route('fleets.edit', $accounting->user?->fleet?->id) }}">
                                                <i class="fa fa-eye"> Fleet</i>
                                            </a> --}}
                                        @endif
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
