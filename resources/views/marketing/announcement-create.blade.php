<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">

        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex">
                   <a href="{{ route('announcements.index') }}"
                        class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center" style="width:30px">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>

                    </a>
                    <h5 class="text-lg font-semibold text-gray-800 ms-3">
                        Marketing
                        <span class="text-sm text-gray-500">List of all announcements</span>
                    </h5>
                </div>

            </div>

            <form method="POST" action="{{ route('announcements.store') }}">
                @csrf
                <div class="mb-5 grid grid-cols-2 gap-8">
                    <div class="relative">
                        <x-text-input id="title" class="mt-1 block w-full" type="text" name="title" autofocus
                            autocomplete="title" :value="old('title')" />
                        <x-input-label for="title" :value="__('Title')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-text-input id="body" class="mt-1 block w-full" type="text" name="body" autofocus
                            autocomplete="body" :value="old('body')" />
                        <x-input-label for="body" :value="__('Description')" />
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-select-input name="type" id="announcementType" :options="\App\Enums\AnnoucementType::options()" :selected="old('type')"
                            class="mt-1" />
                        <x-input-label for="type" :value="__('Annoucement Type')" />
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>
                    <div class="relative mt-1" id="userSelectWrapper">
                        <select name="user_ids[]" id="user_ids" autofocus multiple
                            class="select2 w-full border border-gray-300 rounded pt-5 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
            // Clear existing options
            $('#user_ids').empty();

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
        });
    });
</script>
