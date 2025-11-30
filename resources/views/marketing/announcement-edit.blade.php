<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">

        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex">
                        <a href="{{ route('announcements.index') }}"
                            class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center"
                            style="width:30px">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>

                        </a>
                        <h5 class="text-lg font-semibold text-gray-800 ms-3">
                            Marketing
                            <span class="text-sm text-gray-500">List of all announcements</span>
                        </h5>
                    </div>

                </div>

                <div class="flex items-center">
                    <div x-data="{ showModal_{{ $announcement->id }}: false }" x-cloak class="inline-block">
                        <!-- Trigger Button -->
                        <button type="button" @click="showModal_{{ $announcement->id }} = true"
                            class="inline-flex items-center p-2 text-red-500 border border-dashed border-red-500 hover:bg-red-100 rounded"
                            title="Delete Annoucement">
                            <!-- Delete Icon -->
                            <svg class="h-5 w-5" fill="currentColor" viewBox="64 64 896 896"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z" />
                            </svg>
                        </button>

                        <!-- Modal -->
                        <div x-show="showModal_{{ $announcement->id }}" x-cloak
                            class="absolute inset-0 z-50 flex items-start justify-end bg-opacity-50" aria-modal="true"
                            role="dialog">
                            <div @click.away="showModal_{{ $announcement->id }} = false"
                                class="bg-white rounded-lg shadow-lg p-6 relative" style="top: 50px; right:100px">

                                <!-- Modal Header -->
                                <div class="flex justify-between items-center border-b pb-2 mb-4">
                                    <h2 class="text-lg font-semibold text-red-600">Delete Announcement</h2>
                                    <button @click="showModal_{{ $announcement->id }} = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl">
                                        &times;
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mb-4">
                                    <h3 class="text-yellow-600 font-bold">Are you sure?</h3>
                                    <p class="text-gray-700">You want to permanently delete this announcement?</p>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex justify-end gap-2">
                                    <button @click="showModal_{{ $announcement->id }} = false"
                                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                        Cancel
                                    </button>

                                    <form method="POST"
                                        action="{{ route('announcements.destroy', $announcement->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <form method="POST" action="{{ route('announcements.update', $announcement->id) }}">
                @csrf
                <div class="mb-5 grid grid-cols-2 gap-8">
                    <div class="relative">
                        <x-text-input id="title" class="mt-1 block w-full" type="text" name="title" autofocus
                            autocomplete="title" :value="old('title', $announcement->title ?? '')" />
                        <x-input-label for="title" :value="__('Title')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="body" class="mt-1 block w-full" type="text" name="body" autofocus
                            autocomplete="body" :value="old('body', $announcement->body ?? '')" />
                        <x-input-label for="body" :value="__('Description')" />
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-select-input name="type" id="announcementType" :options="\App\Enums\AnnoucementType::options()" :selected="old('type', $announcement->type ?? '')"
                            class="mt-1" />
                        <x-input-label for="type" :value="__('Annoucement Type')" />
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>


                    <div class="relative mt-1" id="userSelectWrapper">
                        <select name="user_ids[]" id="user_ids" multiple
                            class=" w-full border border-gray-300 rounded pt-5 px-3">

                            @php
                                $selectedUserIds = is_array($announcement->user_ids)
                                    ? $announcement->user_ids
                                    : explode(',', $announcement->user_ids ?? '');
                            @endphp

                            @foreach ($users as $user)
                                @if (in_array($user['value'], $selectedUserIds))
                                    <option value="{{ $user['value'] }}" selected>
                                        {{ $user['name'] }}
                                    </option>
                                @endif
                            @endforeach

                        </select>

                        <x-input-label style="margin-top:-12px" for="user_ids" class="text-gray-600 text-sm"
                            :value="__('Users')" />
                        <x-input-error :messages="$errors->get('user_ids')" class="mt-2" />
                    </div>

                </div>
                <div class="flex justify-end ">
                    <x-primary-button class="w-56">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        const typeSelect = document.getElementById('announcementType');
        let type = typeSelect.value;

        // Initialize Select2
        $('#user_ids').select2({
            allowClear: true,
            width: '100%',
        });

        function fetchUsers(type) {

            fetch(`/marketing/get-users-by-type/${type}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(user => {
                        const newOption = new Option(user.name, user.value, false, false);
                        $('#user_ids').append(newOption);
                    });

                    $('#user_ids').trigger('change');

                });

        }

        fetchUsers(type);

        typeSelect.addEventListener('change', (e) => {
            fetchUsers(e.target.value);
            $('#user_ids').empty();
        });
    });
</script>
