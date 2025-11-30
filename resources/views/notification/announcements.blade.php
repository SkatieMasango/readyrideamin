<x-app-layout>
    <div class="demo_main_content_area">
        <div class="card mt-6 rounded-lg border-none shadow-md mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between">
                    <h5 class="text-lg font-semibold text-gray-800">
                        Notification
                        <span class="text-sm text-gray-500">List of all announcements</span>
                    </h5>
                    <div x-data="{ showModal: false }">
                        <x-secondary-button type="button" @click="showModal = true">
                            {{ __('Add announcement') }}
                        </x-secondary-button>

                        <div x-show="showModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75 modal"
                            x-transition>
                            <div class="bg-white p-6 rounded-lg shadow-lg create-rider modalContent "
                                style="width:25rem">
                                <div class="flex justify-between items-center pb-2">
                                    <h2 class="text-lg font-semibold">Add new Announcement</h2>
                                    <button @click="showModal = false"
                                        class="text-4xl text-gray-500 hover:text-gray-700">
                                        &times;
                                    </button>
                                </div>

                                <form id="form" method="POST" action="{{ route('announcements.store') }}">
                                    @csrf
                                    <div class="relative mt-2 w-100">
                                        <div>
                                            <x-input-label for="title" :value="__('Title')" />
                                            <x-text-input id="title" class="mt-1 block w-full" type="text"
                                                name="title" autofocus autocomplete="title" :value="old('title')" />
                                            <div id="title_error" class="text-sm text-red-600 mt-2 input-error">
                                                @if ($errors->has('title'))
                                                    {{ $errors->first('title') }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <x-input-label for="body" :value="__('Description')" />
                                            <x-textarea id="body" class="mt-1 block w-full" type="text"
                                                name="body" autofocus autocomplete="body" :value="old('body')" />

                                            <div id="body_error" class="text-sm text-red-600 mt-2 input-error">
                                                @if ($errors->has('body'))
                                                    {{ $errors->first('body') }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <x-input-label for="type" :value="__('Annoucement Type')" />
                                            <x-select-input name="type" id="announcementType" :options="\App\Enums\AnnoucementType::options()"
                                                :selected="old('type')" class="mt-1" />
                                        </div>

                                        <div class="relative mt-2" id="userSelectWrapper">
                                            <x-input-label style="margin-top:-12px" for="user_ids"
                                                class="text-gray-600 text-sm" :value="__('Users')" />
                                            <select name="user_ids[]" id="user_ids" autofocus multiple
                                                class="select2 w-full border border-gray-300 rounded pt-5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </select>
                                        </div>

                                    </div>

                                    <div class="flex gap-4 mt-6">
                                        <div class="w-50 ">
                                            <a @click="showModal = false" type="button"
                                                class="w-full px-4 py-3 text-sm text-gray-700 bg-gray-200 rounded-lg text-center">
                                                Cancel
                                            </a>
                                        </div>
                                        <div class="w-50">
                                            <x-primary-button type="button" onclick="submitForm()">
                                                {{ __('Save') }}
                                            </x-primary-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 overflow-x-auto ">
                    <table class="w-100 mb-4">
                        <thead class="text-nowrap">
                            <tr class="text-sm font-medium uppercase tp-summary-header-title-blue">
                                <th class="px-4 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Description</th>

                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($data as $announcement)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($announcement['created_at']->toDateTimeString())->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <strong>{{ $announcement['title'] ?? '' }}
                                        </strong>
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $announcement['body'] ?? '' }}

                                    </td>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        const typeSelect = document.getElementById('announcementType');
        let type = typeSelect.value;

        $('#user_ids').select2({
            allowClear: true,
            width: '100%',
        });


        function fetchUsers(type) {
            $('#user_ids').empty();

            fetch(`/announcements/get-users-by-type/${type}`)
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
            console.log(e, 'kdf');
            fetchUsers(e.target.value);
        });

    });

    $(document).ready(function() {

        $('[id^="announcementTypeEdit_"]').each(function() {
            const modalId = $(this).attr("id").replace("announcementTypeEdit_", "");
            const typeSelectEdit = document.getElementById(`announcementTypeEdit_${modalId}`);
            const userSelect = $(`#user_ids_edit_${modalId}`);

            if (!typeSelectEdit || !userSelect.length) {
                console.warn("Missing elements for modal:", modalId);
                return;
            }

            let typeEdit = typeSelectEdit.value;

            // initialize select2
            userSelect.select2({
                allowClear: true,
                width: "100%",
            });

            function fetchEditUsers(type) {

                fetch(`/announcements/get-users-by-type/${type}`)
                    .then((res) => res.json())
                    .then((data) => {
                        data.forEach((user) => {
                            const newOption = new Option(user.name, user.value, false,
                                false);
                            userSelect.append(newOption);
                        });

                        userSelect.trigger("change");
                    })
                    .catch((err) => console.error("Error fetching users:", err));
            }

            fetchEditUsers(typeEdit);

            typeSelectEdit.addEventListener("change", (e) => {
                fetchEditUsers(e.target.value);
            });
        });
    });
</script>
