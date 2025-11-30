<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex">
                     <a href="{{ route('review-parameter.index') }}"
                        class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center" style="width:30px">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h5 class="text-lg font-semibold text-gray-800 ms-3">
                        Review Parameter
                        <span class="text-sm text-gray-500">Create new Service</span>
                    </h5>
                </div>

            </div>

            <form method="POST" action="{{ route('review-parameter.store') }}">
                @csrf
                <div class="mb-4 space-y-4">
                    <div class="relative">
                        <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                            :value="old('title')" autofocus autocomplete="title" />
                        <x-input-label for="title" :value="__('Title')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <label for="">Is Good</label><br>

                        <label class="ant-switch mt-2" id="typeToggle">
                            <input type="checkbox" id="type" class="hidden"
                                {{ old('type', 'active') === 'active' ? 'checked' : '' }} />
                            <span class="ant-switch-inner"></span>
                        </label>

                        <input type="hidden" name="type" id="type_hidden" value="{{ old('type', 'active') }}">

                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                </div>
                <div class="flex justify-end">
                    <x-primary-button class="w-56">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('type');
        const hiddenInput = document.getElementById('type_hidden');
        const toggle = document.getElementById('typeToggle');

        function updateToggle() {
            if (checkbox.checked) {
                toggle.classList.add('active');
                hiddenInput.value = '1';
            } else {
                toggle.classList.remove('active');
                hiddenInput.value = '0';
            }
        }
        checkbox.addEventListener('change', updateToggle);

        // Initial state setup
        updateToggle();
    });
</script>
