<x-app-layout>
    <div class="demo_main_content_area">
        <div class="vehicled card mt-6 rounded-lg border-none shadow-md mb-120 p-5">
            <form class="mt-4" method="POST" action="{{ route('management.settings.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-5 grid grid-cols-3">
                    <div>
                        <h1>Basic Information</h1>
                    </div>
                    <div class="col-span-2 rounded bg-white p-6 shadow">
                        <div class="space-y-4">
                            <div class="relative">
                                <x-text-input id="site_name" class="mt-1 block w-full" type="text" name="site_name"
                                    :value="old('site_name', $generalSettings?->site_name)" required autofocus autocomplete="site_name" />
                                <x-input-label for="site_name" :value="__('Website Name')" />
                                <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                            </div>
                            <div class="relative">
                                <x-text-input id="site_title" class="mt-1 block w-full" type="text" name="site_title"
                                    :value="old('site_title', $generalSettings?->site_title)" required autofocus autocomplete="site_title" />
                                <x-input-label for="site_title" :value="__('Website Title')" />
                                <x-input-error :messages="$errors->get('site_title')" class="mt-2" />
                            </div>
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <div class="relative">
                                    <x-text-input id="currency" class="mt-1 block w-full" type="text"
                                        name="currency" :value="old('currency', $generalSettings->currency)" required autofocus autocomplete="currency" />
                                    <x-input-label for="currency" :value="__('Currency Symbol')" />
                                    <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                                </div>
                                <div class="relative">
                                    <x-text-input id="commision" class="mt-1 block w-full" type="text"
                                        name="commision" :value="old('commision', $generalSettings->commision)" required autofocus
                                        autocomplete="commision" />
                                    <x-input-label for="commision" :value="__('Commision')" />
                                    <x-input-error :messages="$errors->get('commision')" class="mt-2" />
                                </div>
                                <div>
                                    <div class="flex items-center space-x-5 pl-12">
                                        <div
                                            class="text-on-surface has-disabled:opacity-75 flex items-center justify-start gap-2 font-medium">
                                            <input id="radioPrimaryLeft" type="radio" value="left"
                                                class="before:content[''] border-outline bg-surface-alt before:bg-on-primary-500 focus:outline-outline-strong relative h-6 w-6 appearance-none rounded-full border before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-2.5 before:w-2.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full checked:border-primary checked:bg-primary-500 checked:before:visible focus:outline-2 focus:outline-offset-2 checked:focus:outline-primary disabled:cursor-not-allowed"
                                                name="currency_position"
                                                {{ $generalSettings->currency_position == 'left' ? 'checked' : '' }} />
                                            <label for="radioPrimaryLeft" class="text-lg">Left</label>
                                        </div>
                                        <div
                                            class="text-on-surface has-disabled:opacity-75 flex items-center justify-start gap-2 font-medium">
                                            <input id="radioPrimary" type="radio" value="right"
                                                class="before:content[''] border-outline bg-surface-alt before:bg-on-primary-500 focus:outline-outline-strong relative h-6 w-6 appearance-none rounded-full border before:invisible before:absolute before:left-1/2 before:top-1/2 before:h-2.5 before:w-2.5 before:-translate-x-1/2 before:-translate-y-1/2 before:rounded-full checked:border-primary checked:eb2e61 checked:before:visible focus:outline-2 focus:outline-offset-2 checked:focus:outline-primary disabled:cursor-not-allowed"
                                                {{ $generalSettings->currency_position == 'right' ? 'checked' : '' }}
                                                name="currency_position" />
                                            <label for="radioPrimary" class="text-lg">Right</label>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('currency_position')" class="mb-2 text-center" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Media section --}}
                <div class="mb-5 grid grid-cols-3">
                    <div>
                        <h1>Media section</h1>
                    </div>

                    <div class="col-span-2 rounded bg-white p-6 shadow">
                        <div class="grid grid-cols-3 gap-8">
                            <x-file-input id="site_logo" name="website_logo" label="Website Logo"
                                src="{{ $generalSettings->website_logo }}" />
                            <x-file-input id="site_favicon" name="site_favicon" label="Favicon"
                                src="{{ $generalSettings?->site_favicon ?? '#' }}" />
                            <x-file-input id="site_app_logo" name="site_app_logo" label="App Logo"
                                src="{{ $generalSettings?->site_app_logo ?? '#' }}" />
                        </div>
                    </div>
                </div>

                {{-- Contact section --}}
                <div class="mb-5 grid grid-cols-3">
                    <div>
                        <h1>Contact section</h1>
                    </div>
                    <div class="col-span-2 rounded bg-white p-6 shadow">
                        <div class="space-y-4">
                            <div class="relative">
                                <x-text-input id="site_phone" class="mt-1 block w-full" type="text" name="site_phone"
                                    :value="old('site_phone', $generalSettings->site_phone)" required autofocus autocomplete="site_phone" />
                                <x-input-label for="site_phone" :value="__('Mobile Number')" />
                                <x-input-error :messages="$errors->get('site_phone')" class="mt-2" />
                            </div>
                            <div class="relative">
                                <x-text-input id="site_email" class="mt-1 block w-full" type="email" name="site_email"
                                    :value="old('site_email', $generalSettings->site_email)" required autofocus autocomplete="site_email" />
                                <x-input-label for="site_email" :value="__('Email')" />
                                <x-input-error :messages="$errors->get('site_email')" class="mt-2" />
                            </div>
                            <div class="relative">
                                <x-text-input id="site_address" class="mt-1 block w-full" type="text"
                                    name="site_address" :value="old('site_address', $generalSettings->site_address)" required autofocus
                                    autocomplete="site_address" />
                                <x-input-label for="site_address" :value="__('Address')" />
                                <x-input-error :messages="$errors->get('site_address')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                {{-- App section --}}
                <div class="mb-5 grid grid-cols-3">
                    <div>
                        <h1>App section</h1>
                    </div>
                    <div class="col-span-2 rounded bg-white p-6 shadow">
                        <div class="space-y-4">
                            <div class="relative">
                                <x-text-input id="android_app_link" class="mt-1 block w-full" type="text"
                                    name="android_app_link" :value="old('android_app_link', $generalSettings->android_app_link)" required autofocus
                                    autocomplete="android_app_link" />
                                <x-input-label for="android_app_link" :value="__('Google PlayStore App Link')" />
                                <x-input-error :messages="$errors->get('android_app_link')" class="mt-2" />
                            </div>
                            <div class="relative">
                                <x-text-input id="apple_app_link" class="mt-1 block w-full" type="text"
                                    name="ios_app_link" :value="old('apple_app_link', $generalSettings->ios_app_link)" required autofocus
                                    autocomplete="ios_app_link" />
                                <x-input-label for="apple_app_link" :value="__('Apple Store App Link')" />
                                <x-input-error :messages="$errors->get('ios_app_link')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-3">
                    <div></div>
                    <div class="col-span-2">
                        <div class="my-4 flex items-center justify-end">
                            <x-primary-button class="w-44">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
