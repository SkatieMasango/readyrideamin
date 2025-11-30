<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between">
                <h5 class="text-lg font-semibold text-gray-800">
                    SOS
                    <span class="text-sm text-gray-500">Distress Signals submitted by users</span>
                </h5>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Date & Time</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm text-gray-700">
                        @foreach ($sosList as $sos)
                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-4 py-3"><a
                                        href="{{ route('sos.show', $sos['id']) }}"><strong>{{ \Carbon\Carbon::parse($sos['created_at'])->diffForHumans() }}
                                        </strong>
                                    </a>
                                </td>
                                <td class="px-4 py-3"><a href="{{ route('sos.show', $sos['id']) }}">
                                        <div class="flex items-center">
                                            <div class="mr-2 h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400">
                                            </div>
                                            <span class="font-medium text-yellow-600">{{ $sos['status'] }}</span>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{-- {{ $sosList->links() }} --}}
            </div>
        </div>
    </div>
</x-app-layout>
