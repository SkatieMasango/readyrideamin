<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                         Wallet
                        <span class="text-sm text-gray-500">List of system provider income.</span>
                    </h5>
                   
                </div>

                <div class="mt-4 overflow-x-auto">
                     <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Date & Time</th>
                                <th class="px-4 py-3 text-left">Transaction Type</th>
                                <th class="px-4 py-3 text-left">Payment Method</th>
                                <th class="px-4 py-3 text-left">Amount</th>

                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $accounting)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $accounting['created_at'] }}</td>
                                    <td class="px-4 py-3">{{ $accounting['transaction'] }}</td>
                                    <td class="px-4 py-3">{{ $accounting['method'] }}</td>
                                    <td class="px-4 py-3">{{ $accounting['amount'] }}</td>
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
