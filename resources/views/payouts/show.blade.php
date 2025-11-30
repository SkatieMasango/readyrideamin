<x-app-layout>
    <div class="px-4" style="width: 50%">
        <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Payout session # {{ $id }}
                        <span class="text-sm text-gray-500">Create a payout section using filters below</span>
                    </h5>

                </div>
                <!-- Legend -->
                <div class="flex mt-4">
                    <div>
                        <span class="text-sm">Total Amount</span>
                        <h5 class="text-lg font-semibold text-gray-800">
                            ${{ $withdraws->sum('amount') }}
                        </h5>
                    </div>
                    <div class="ms-3 px-4">
                        <span class="text-sm">Paid Amount</span>
                        <h5 class="text-lg font-semibold text-gray-800">
                            $0.00
                        </h5>
                    </div>
                    <div class="ms-3 px-4">
                        <span class="text-sm">Unpaid Amount</span>
                        <h5 class="text-lg font-semibold text-gray-800">
                            ${{ $withdraws->sum('amount') - 0.0 }}
                        </h5>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                                <th class="border-b border-gray-300 px-4 py-3 text-left">Driver</th>
                                <th class="border-b border-gray-300 px-4 py-3 text-left">Amount</th>
                                <th class="border-b border-gray-300 px-4 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($withdraws as $withdraw)
                                <tr class="border-b hover:bg-gray-50">

                                    <td class="px-4 py-3">
                                        <a href=""><strong>{{ $withdraw->driver->user->name ?? '' }}
                                               </strong>

                                        </a>
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $withdraw->amount }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
