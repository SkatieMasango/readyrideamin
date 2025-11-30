<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">


                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Users
                        <span class="text-sm text-gray-500">Role definition for admin panel</span>
                    </h5>
                    <div class="">

                         <x-secondary-button type="button" x-data
                            @click="window.location.href = '{{ route('management.user-roles.create') }}'">
                            {{ __('Add Role') }}
                        </x-secondary-button>
                    </div>
                </div>
                <div class="mt-4 overflow-x-auto">
                     <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($roles as $role)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <strong>{{ $role['name'] ?? '' }}</strong>
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 tp-btn-action ">
                                        <div class="tp-order d-flex align-items-center justify-content-center relative">
                                            <a type="submit" href="{{ route('management.user-roles.edit', $role['id']) }}"
                                                    class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                    <i class="fa fa-edit"></i><span>Edit</span>
                                                </a>
                                        </div>
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
