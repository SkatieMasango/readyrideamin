<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-between">
                         <a href="{{ route('management.user-roles.index') }}"
                            class=" rounded-md flex items-center bg-gray-50 back-icon justify-center" style="width:40px;">
                            <x-icons.back-button />
                        </a>
                        <h5 class="text-lg font-semibold text-gray-800 ms-3">
                            User Role
                            <span class="text-sm text-gray-500">Admin panel user role definition.</span>
                        </h5>
                    </div>

                </div>

                <form method="POST" action="{{ route('management.user-roles.store') }}">
                    @csrf
                    <div class="mb-5 grid grid-cols-4 gap-8">
                        <div class="relative">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                                :value="old('title')" autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <div class="grid grid-cols-4 gap-8">
                            @foreach ($groupedPermissions as $group => $perms)
                                <div class="bg-white shadow rounded-lg p-4 mb-6 ">
                                    <div class="mb-3 border-b pb-1">
                                        <h3 class="text-lg font-semibold text-gray-700">
                                            {{ ucfirst($group) }}
                                        </h3>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        @foreach ($perms as $permission)
                                            @php
                                                $parts = explode('.', $permission->name);
                                                $action = ucfirst($parts[1] ?? 'Unknown');
                                            @endphp

                                            <label for="permission_{{ $permission->id }}"
                                                class="flex items-center space-x-2">
                                                <input type="checkbox" id="permission_{{ $permission->id }}"
                                                    name="permissions[]" value="{{ $permission->id }}"
                                                    class="form-checkbox h-4 w-4 text-blue-600">
                                                <span class="text-sm text-gray-800">{{ $action }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-start ">
                        <x-primary-button class="w-auto">
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
