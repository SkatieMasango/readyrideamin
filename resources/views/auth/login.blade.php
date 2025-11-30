<x-guest-layout>
    <div class="flex h-full flex-col justify-between py-6 px-6">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <div class="flex justify-between text-white ">
            <p class="text-xs text-center">Powered by RazinSoft ©2024</p>
            <button style="background-color: #FFFFFF14;" class="px-5 text-xs py-1 rounded">V{{ config('app.version') }}</button>
        </div>

        <div>
            <div class="flex items-center justify-center " style="border-bottom: 1px solid #FFFFFF3D">
                <div class="text-center">
                    <div class="flex justify-center mt-4 pt-6 pb-4">
                        <x-application-logo class="w-16" />
                    </div>
                    <div class="mb-6 text-white">
                        <h1 class="mb-2 text-lg ">Welcome to {{ $generalSettings->site_name ?? 'ReadyRidy'}}</h1>
                        <p class="text-2xl">Sign in</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('login-store') }}">
                @csrf

                <!-- Email Address -->

                <div class="text-white mt-6">
                     <label for="email" class="text-lg block mb-1">{{ __('Email') }}</label>
                     <input type="email" name="email" id="email"
                                class=" bg-transparent block w-full rounded-lg p-4 mt-3 focus:border-primary-500 focus:ring-primary-500"
                                value="{{ old('email') }}" autocomplete="text"
                                placeholder="root@readyridy.com" />

                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
                </div>

                <!-- Password -->
                <div class="relative text-white mt-4">
                    <label for="password" class="text-lg block mb-1">{{ __('Password') }}</label>
                     <input type="password" name="password" id="password"
                                class=" bg-transparent block w-full rounded-lg p-4 mt-3 focus:border-primary-500 focus:ring-primary-500"
                                value="{{ old('password') }}" autocomplete="text"
                                placeholder="*******" />
                    <span class="eye absolute" onclick="showHidePassword()">
                       <img id="togglePassword" src="{{ asset('assets/images/eye-disable.svg')}}" alt="" class="bg-transparent" style="filter: brightness(0.5) invert(0.5);">
                    </span>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
                </div>

                <div class="py-6 flex items-center justify-end">
                    <button class="btn rounded-lg w-full py-4 text-white" style="background-color: #1469B5">Sign
                        in</button>

                </div>

                @if (config('app.env') === 'local')
                <div class="flex justify-between text-white p-4 rounded-lg" style="border: 1px solid #FFFFFF29">
                    <div class="text-sm">
                        <p><strong>Email:</strong> <span style="color: #FFFFFF80">root@readyridy.com</span></p>
                        <p><strong>Password:</strong> <span style="color: #FFFFFF80">secret22</span></p>
                    </div>
                    <div class="flex justify-center">
                        <button type="button" class="py-1 px-4 rounded-lg"
                            style="border: 1px solid #2285D5; background-color:#1469B51C"
                            onclick="document.getElementById('email').value = 'root@readyridy.com'; document.getElementById('password').value = 'secret22';">
                            Copy
                        </button>
                    </div>
                </div>
                @endif
                {{-- End of local credentials block --}}

            </form>
        </div>
    </div>
</x-guest-layout>
