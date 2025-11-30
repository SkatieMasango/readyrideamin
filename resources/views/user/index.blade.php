<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between">
                <h5 class="text-lg font-semibold text-gray-800">
                    Users
                    <span class="text-sm text-gray-500">List of all the users registered</span>
                </h5>
                <div class="">
                    <x-primary-button type="button" x-data @click="window.location.href = '{{ route('users.create') }}'">
                        {{ __('Add') }}
                    </x-primary-button>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Name</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Email</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Phone Number</th>
                            <th class="border-b border-gray-300 px-4 py-3 text-left">Address</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm text-gray-700">
                        @foreach ($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('users.edit', $user['id']) }}"><strong>{{ $user['name'] ?? '' }}
                                           </strong>
                                    </a>
                                </td>
                                <td class="px-4 py-3"> <a
                                        href="{{ route('users.edit', $user['id']) }}">{{ $user['email'] }}</a></td>
                                <td class="px-4 py-3"> <a
                                        href="{{ route('users.edit', $user['id']) }}">{{ $user['mobile'] }}</a></td>
                                <td class="px-4 py-3"> <a
                                        href="{{ route('users.edit', $user['id']) }}">{{ $user['address'] }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
