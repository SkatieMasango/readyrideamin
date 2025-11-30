<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex">
                    <a href="{{ route('cancel-reason.index') }}"
                        class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center" style="width:30px">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h5 class="text-lg font-semibold text-gray-800 ms-3">
                        Cancel Reason
                        <span class="text-sm text-gray-500">
                            Reason for cancellation that users will encounter and can choose from when canceling a ride
                        </span>
                    </h5>
                </div>

            </div>

            <form method="POST" action="{{ route('cancel-reason.store') }}">
                @csrf
                <div class="mb-4 space-y-4">
                    <div class="relative">
                        <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                            :value="old('title')" autofocus autocomplete="title" />
                        <x-input-label for="title" :value="__('Title')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-select-input name="user_type" :options="[['value' => 'rider', 'name' => 'Rider'], ['value' => 'driver', 'name' => 'Driver']]" :selected="old('user_type', $user->user_type ?? 'Rider')"
                            class="w-full border p-2" />

                        <x-input-label for="user_type" :value="__('User Type')" />
                        <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="status" value="0">
                        <input class="mr-1.5 h-4 w-4 rounded" name="status" type="checkbox" value="1"
                            {{ old('status', $model->status ?? false) ? 'checked' : '' }}>

                        <p>Visibility Status</p>
                        <x-input-error :messages="$errors->get('status')" />
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
