<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex justify-between mb-5">
                <div class="flex items-center justify-between">
                    <div class="flex">
                        <a href="{{ route('cancel-reason.index') }}"
                            class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center"
                            style="width:30px">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h5 class="text-lg font-semibold text-gray-800 ms-3">
                            Cancel Reason
                            <span class="text-sm text-gray-500">
                                Reason for cancellation that users will encounter and can choose from when canceling a
                                ride
                            </span>
                        </h5>
                    </div>

                </div>
                <div class="flex items-center">
                    <div x-data="{ showModal_{{ $cancelReason->id }}: false }" x-cloak class="inline-block">
                        <!-- Trigger Button -->
                        <button type="button" @click="showModal_{{ $cancelReason->id }} = true"
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
                        <div x-show="showModal_{{ $cancelReason->id }}" x-cloak
                            class="absolute inset-0 z-50 flex items-start justify-end bg-opacity-50" aria-modal="true"
                            role="dialog">
                            <div @click.away="showModal_{{ $cancelReason->id }} = false"
                                class="bg-white rounded-lg shadow-lg p-6 relative" style="top: 50px; right:100px">

                                <!-- Modal Header -->
                                <div class="flex justify-between items-center border-b pb-2 mb-4">
                                    <h2 class="text-lg font-semibold text-red-600">Delete cancel reason</h2>
                                    <button @click="showModal_{{ $cancelReason->id }} = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl">
                                        &times;
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mb-4">
                                    <h3 class="text-yellow-600 font-bold">Are you sure?</h3>
                                    <p class="text-gray-700">You want to permanently delete this cancel reason?</p>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex justify-end gap-2">
                                    <button @click="showModal_{{ $cancelReason->id }} = false"
                                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                        Cancel
                                    </button>

                                    <form method="POST"
                                        action="{{ route('cancel-reason.destroy', $cancelReason->id) }}">
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
            <form method="POST" action="{{ route('cancel-reason.update', $cancelReason->id) }}">
                @csrf
                <div class="mb-4 space-y-4">
                    <div class="relative">
                        <x-text-input id="title" class="mt-1 block w-full" type="text" name="title"
                            :value="old('title', $cancelReason->title)" autofocus autocomplete="title" />
                        <x-input-label for="title" :value="__('Title')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="relative">
                        <x-select-input name="user_type" :options="[['value' => 'rider', 'name' => 'Rider'], ['value' => 'driver', 'name' => 'Driver']]" :selected="old('user_type', $cancelReason->user_type)"
                            class="w-full border p-2" />

                        <x-input-label for="user_type" :value="__('User Type')" />
                        <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
                    </div>

                    <div class="flex items-center">
                        <input type="hidden" name="status" value="0">
                        <input class="mr-1.5 h-4 w-4 rounded" name="status" type="checkbox" value="1"
                            {{ old('status', $cancelReason->status ?? false) ? 'checked' : '' }}>

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
