<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between">
                <h5 class="text-lg font-semibold text-gray-800">
                    Sms Providers
                    <span class="text-sm text-gray-500">Manage SMS providers for sending verification codes</span>
                </h5>
                <div class="w-28">
                    <x-primary-button type="button" x-data
                        @click="window.location.href = '{{ route('sms-configs.create') }}'">
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Title</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @foreach ($smsConfigs as $smsConfig)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('sms-configs.edit', $smsConfig['id']) }}"><strong>{{ $smsConfig->name ? $smsConfig->name : 'N/A' }}
                                            ({{ $smsConfig->type?->label() ?? 'N/A' }})</strong>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $smsConfigs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
