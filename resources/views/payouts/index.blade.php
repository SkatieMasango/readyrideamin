<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between">
                <h5 class="text-lg font-semibold text-gray-800">
                    Payouts
                    <span class="text-sm text-gray-500">Manage and track payouts for service providers</span>
                </h5>
                <div>
                    <div class="relative ms-3">

                        <form method="POST" action="" id="status-form">
                            @csrf
                            @method('PUT')
                            <x-select-input name="status" :options="\App\Enums\Status::options()" :selected="$driver->user?->status->value ?? old('status')" class="mt-1"
                                onchange="document.getElementById('status-form').submit();" />
                            <x-input-label for="status" :value="__('Update Status')" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex ">
                {{-- <div>
                    <span class="text-sm">Pending</span>
                    <h5 class="text-lg font-semibold text-gray-800">
                        $5,20,000
                    </h5>
                </div>
                <div class="ms-3 px-4">
                    <span class="text-sm">Last Payout</span>
                    <h5 class="text-lg font-semibold text-gray-800">
                        $0.00
                    </h5>
                </div> --}}

                <div class="bg-gray-900 rounded-md w-full max-w-4xl ">
                    <h2 class="text-sm mb-2">Payout Methods</h2>
                    @php
                        $totalAmount = $methodAmounts->sum('method_amount');
                        $base = $totalAmount / 3;

                        $methodAmounts->each(function ($item) use ($base) {
                            $item->percentage = round(($item->method_amount / $base) * 100, 2);
                        });
                    @endphp

                    @foreach ($methodAmounts as $item)
                    @endforeach

                    <!-- Horizontal Bar -->
                    <div class="w-full h-4 flex rounded overflow-hidden bg-gray-700 mt-4">
                        @foreach ($methodAmounts as $item)
                            <div
                                style="
                                    width: {{ $item->percentage }}%;
                                    background-color:
                                        @if ($item->method === 'bank_transfer') rgb(238, 69, 107);
                                        @elseif($item->method === 'stripe') rgb(223, 115, 138);
                                        @else rgb(231, 181, 192); @endif
                                ">
                            </div>
                        @endforeach
                    </div>


                    <!-- Legend -->
                    <div class="flex items-center space-x-4 mt-4 text-sm">
                        <div class="flex items-center space-x-1">
                            <span class="inline-block rounded-sm"
                                style="background-color: rgb(231, 181, 192); width: 10px; height:10px; margin-right:4px"></span>
                            <span>Without payout method</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <span class="inline-block rounded-sm"
                                style="background-color: rgb(223, 115, 138); width: 10px; height:10px; margin-right:4px"></span>
                            <span>Stripe Connect</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <span class="inline-block rounded-sm"
                                style="background-color: rgb(238, 69, 107); width: 10px; height:10px; margin-right:4px"></span>
                            <span>Bank Transfer</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Created at</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Total Amount</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm text-gray-700">
                        @foreach ($withdraws as $withdraw)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3"><a
                                        href="{{ route('payouts.show', ['date' => $withdraw->date, 'id' => $withdraw->id]) }}">{{ \Carbon\Carbon::parse($withdraw->date)->diffForHumans() }}</a>
                                </td>
                                <td class="px-4 py-3"><a
                                        href="{{ route('payouts.show', ['date' => $withdraw->date, 'id' => $withdraw->id]) }}">{{ $withdraw['amount'] }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">

            </div>
        </div>
    </div>
</x-app-layout>
