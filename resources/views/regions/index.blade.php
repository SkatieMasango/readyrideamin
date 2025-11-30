<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between">
                <h5 class="text-lg font-semibold text-gray-800">
                    Regions
                    <span class="text-sm text-gray-500">List of all regions</span>
                </h5>
                <div class="w-28">
                    <x-primary-button type="button" x-data
                        @click="window.location.href = '{{ route('regions.create') }}'">
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Name</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Currency</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @foreach ($regions as $region)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3"><a href="{{ route('regions.edit', $region['id']) }}">
                                        {{ $region['name'] }}</a></td>
                                <td class="px-4 py-3"><a href="{{ route('regions.edit', $region['id']) }}">
                                        {{ $region['currency'] }}</a></td>
                                <td class="px-4 py-3">

                                    <a href="{{ route('regions.edit', $region['id']) }}">
                                        <div class="flex items-center">
                                            <div
                                                class="{{ $region['is_active'] ? 'bg-green-600' : 'bg-yellow-600' }} mr-2 h-2.5 w-2.5 animate-pulse rounded-full">
                                            </div>
                                            <span
                                                class="{{ $region['is_active'] ? 'text-green-600' : 'text-yellow-600' }} font-medium">
                                                {{ $region['is_active'] ? 'Active' : 'In Active' }}
                                            </span>
                                        </div>
                                    </a>


                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $regions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
