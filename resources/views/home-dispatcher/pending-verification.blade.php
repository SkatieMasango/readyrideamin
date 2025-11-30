<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between">
                <h5 class="text-lg font-semibold text-gray-800">
                    Drivers
                    <span class="text-sm text-gray-500">List of all pending drivers registered.</span>
                </h5>
                <div class="w-28">
                    <x-primary-button type="button" x-data
                        @click="window.location.href = '{{ route('drivers.create') }}'">
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                            {{-- <th class="border-b border-gray-300 px-4 py-3 text-left">Order ID</th> --}}
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Name</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Mobile</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Status</th>
                            {{-- <th class="border-b border-gray-300 px-4 py-3 text-left">Action</th> --}}
                        </tr>
                    </thead>

                    <tbody class="text-sm text-gray-700">
                        @foreach ($data as $driver)
                            <tr class="border-b hover:bg-gray-50">
                                {{-- <td class="px-4 py-3">{{ $driver['id'] }}</td> --}}
                                <td class="px-4 py-3"><a
                                        href="{{ route('drivers.edit', $driver['id']) }}"><strong>{{ $driver->user->name}}
                                        </strong><br>
                                        <span class="text-sm text-gray-500">Registered on
                                            {{ \Carbon\Carbon::parse($driver->created_at)->diffForHumans() }}
                                        </span>
                                    </a>
                                </td>
                                <td class="px-4 py-3">{{ $driver->user->mobile }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="mr-2 h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400"></div>
                                        <span
                                            class="font-medium text-yellow-600">{{ $driver->user->status->label() }}</span>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
