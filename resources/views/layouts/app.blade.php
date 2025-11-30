<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'ReadyRide') }}</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/ant-design-icons/4.7.0/ant-design-icons.min.css">
    <!-- Font Awesome CDN (version 4.7) for 'fa fa-ellipsis-h' -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />


    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrapA.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jqueryA-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styleA.css') }}">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-primary-10 {
            background-color: #bec0c3ed !important
        }

        /* .border-red-500 {
            border-color: #0E2743;
        } */

        .focus\:ring-primary-500:focus {
            --tw-ring-color: #1469B5;
        }

        .focus\:border-primary-500:focus {
            border: 1px splid #1469B5 !important;
        }

        select:focus {
            border: none
        }

        select,
        input {
            height: 48px;
            border: 1px solid rgb(229 231 235 / var(--tw-border-opacity, 1))
        }

        .select2-container--default {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            border: 1px solid #dadfe9;
            width: 200px !important
        }

        .select2-container--open {
            border: 1px solid #1469B5
        }

        #userSelectWrapper .select2-container--default {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        #userSelectWrapper .select2-container--focus {
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;

        }

        #userSelectWrapper .select2 {
            width: 100% !important;
            /* border-color: #dadfe9 !important; */
        }

        select {
            line-height: 1rem !important;
        }

        [type=text],
        [type=email],
        [type=number],
        [type=date],
        [type=time],
        [name="country_code"] {
            border-color: #e4e5e9 !important;
            background: white;
        }

        [name=search] {
            border-color: #1469B5 !important;
            background: #white
        }


        .bg-primary {
            background-color: #0E2743 !important;
        }

        .btn-secondary {
            border: 1px solid #1469B5;
            color: #1469B5
        }

        .btn-primary {
            background-color: #1469B5;
            border: 1px solid #1469B5;
        }

        .border-primary {
            border: 10px solid #0E2743
        }

        .bg-primary-50 {
            background-color: #153D65 !important
        }

        [x-cloak] {
            display: none !important;
        }

        .light-mode {
            position: relative;
            display: inline-block;
            width: 70px;
            height: 32px;
            background: radial-gradient(circle, white, rgba(223 222 222) 100%);
            border-radius: 100px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .light-mode-inner {
            position: absolute;
            left: 1px;
            width: 34px;
            height: 34px;
            transition: all 0.2s;
        }

        .ant-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 22px;
            background-color: rgba(87, 83, 83, 0.3);
            border-radius: 100px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .ant-switch-inner {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 18px;
            height: 18px;
            background: #fff;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .ant-switch.active {
            background-color: rgb(230 21 68 / var(--tw-bg-opacity, 1));
        }

        .ant-switch.active .ant-switch-inner {
            left: 24px;
        }


        .anticon {
            display: inline-flex;
            align-items: center;
            /* color: blue; */
            font-style: normal;
            line-height: 10px;
            text-align: center;
            text-transform: none;
            vertical-align: -.125em;
        }

        .ant-upload.ant-upload-select-picture-card {
            margin-right: 8px;
            margin-bottom: 8px;
            margin-top: 10px;
            text-align: center;
            vertical-align: top;
            background-color: rgba(255, 255, 255, .04);
            border-radius: 2px;
            cursor: pointer;
            transition: border-color .3s;
        }

        .ant-upload .file-input {
            display: none;
        }

        .profile_documents {
            max-width: 10rem !important;
        }

        .profile_image {
            max-width: 16rem !important;
        }

        .driver-button:hover {
            border-bottom: 2px solid rgb(230 21 68 / var(--tw-bg-opacity, 1))
        }

        .select2-container--default .select2-selection--single {
            background-color: transparent !important;
            border: none !important;
        }

        .select2-container .select2-selection--multiple {
            min-height: 44px !important;

        }

        #userSelectWrapper .select2-selection__choice__display {
            font-size: 14px
        }

        .select2-results__options li {
            font-size: 14px;
        }

        .select2-results__options {
            border: none
        }

        .select2-container--focus {
            border-radius: 8px
        }

        .select2-selection__choice__display {
            padding-top: 20px
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin-top: 10px !important;
        }

        .select2-container--default .select2-selection--multiple {
            border-radius: 8px !important;
            border: none !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-top: 10px;
            color: black;
            font-size: 14px
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 90% !important
        }

        .select2-container--default .select2-results__option--selected {
            background: none
        }

        .select2-container--default .select2-results>.select2-results__options {
            height:8rem;
            background: rgb(231 233 235 / 92%);
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background: #0E2743 !important;
            color: white;
        }

        .select2-results__option {
            padding: 9px;
        }

        .select2-dropdown {
            border: none !important;
        }
    </style>


</head>

<body class="font-sans antialiased body-area">
    {{-- <div id="loading">
        <div id="loading-center">
            <div id="loading-center-absolute">
                <div class="object" id="object_four"></div>
                <div class="object" id="object_three"></div>
                <div class="object" id="object_two"></div>
                <div class="object" id="object_one"></div>
            </div>
        </div>
    </div> --}}

    <div class="dashboard-wrapper">
        <x-partials.sidebar />

        <!-- overlay- -->
        <div class="tp-sidebar-overlay d-md-block d-lg-none"></div>

        <main class="page__body-wrapper">
            <x-partials.header />
            <div class="overflow-x-hidden overflow-y-auto " style="height: 100svh">
                <div class="relative mx-auto flex flex-1 flex-col gap-4  pt-0 ">
                    {{ $slot }}
                </div>
            </div>

        </main>
    </div>


    @stack('scripts')
    <!-- Load Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-messaging-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-analytics-compat.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>


    <script>
        // action section
        $(".tp-order").on("click", function(e) {
            e.stopPropagation();

            $(".tp-order").not(this).removeClass("tp-order-open");

            $(this).toggleClass("tp-order-open");
              window.dispatchEvent(new Event('close-all'));
        });
        $(document).on("click", function() {
            $(".tp-order").removeClass("tp-order-open");

        });

        // create modal
        function submitForm() {

            const form = document.getElementById('form');
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(async response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        const data = await response.json();
                        if (data.errors) {
                            showValidationErrors(data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Submission error:', error);
                });
        }

        function showValidationErrors(errors) {
            document.querySelectorAll('.input-error').forEach(el => el.innerHTML = '');
            Object.keys(errors).forEach(key => {


                const el = document.getElementById(`${key}_error`);
                if (el) {
                    el.innerHTML = errors[key].join('<br>');
                }
            });
        }


        // edit modal
        function submitEditForm(event, id) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            const form = document.getElementById('formEdit_' + id);
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(async response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        const data = await response.json();
                        if (data.errors) {
                            showValidationEditErrors(data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Submission error:', error);
                });
        }

        function showValidationEditErrors(errors) {
            document.querySelectorAll('.input-error-edit').forEach(el => el.innerHTML = '');
            Object.keys(errors).forEach(key => {


                const el = document.getElementById(`${key}_error-edit`);
                if (el) {
                    el.innerHTML = errors[key].join('<br>');
                }
            });
        }


        document.addEventListener("DOMContentLoaded", function() {
            const toggle = document.getElementById("darkModeToggle");
            const title = document.querySelector(".tp-header-icon-title");

            const savedTheme = localStorage.getItem("theme");


            if (savedTheme === "dark") {
                document.body.classList.add("dark-theme");
                toggle.classList.add("dark-mode");
                if (title) title.textContent = "Dark";
            } else {
                document.body.classList.remove("dark-theme");
                toggle.classList.remove("dark-mode");
                if (title) title.textContent = "Light";
            }

            // Toggle theme on click
            toggle.addEventListener("click", function(e) {
                e.preventDefault();
                const isDark = document.body.classList.toggle("dark-theme");
                toggle.classList.toggle("dark-mode");

                // Update title text
                if (title) {
                    title.textContent = isDark ? "Dark" : "Light";
                }

                // Save preference to localStorage
                localStorage.setItem("theme", isDark ? "dark" : "light");

            });
        });



        function formatLanguage(lang) {
            if (!lang.id) {
                return lang.text;
            }
            var image = $(lang.element).data('image');
            if (!image) {
                return lang.text;
            }
            var $lang = $(
                '<span><img src="' + image + '" class="inline-block w-4 h-4 mr-2"/>' + lang.text + '</span>'
            );
            return $lang;
        };

        // $('#language-select').select2({
        //     templateResult: formatLanguage,
        //     templateSelection: formatLanguage,
        //     minimumResultsForSearch: Infinity,
        //     dropdownAutoWidth: true,
        //     width: '100%' // Ensures full width
        // });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollTarget = localStorage.getItem('scrollTo');
            if (scrollTarget) {
                const el = document.getElementById(scrollTarget);

                if (el) {
                    el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                localStorage.removeItem('scrollTo');
            }

            // Capture clicks
            document.querySelectorAll('[data-scroll-id]').forEach(link => {
                link.addEventListener('click', function() {

                    localStorage.setItem('scrollTo', this.getAttribute('data-scroll-id'));
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Your Firebase configuration
            const firebaseConfig = {
                apiKey: "AIzaSyBwRqHpYDUz8oTbnVZbBZ_eha92GukMyIs",
                authDomain: "job-portal-395305.firebaseapp.com",
                projectId: "job-portal-395305",
                storageBucket: "job-portal-395305.firebasestorage.app",
                messagingSenderId: "1061105446757",
                appId: "1:1061105446757:web:3e6787a4fa5e15d64f3b8c",
                measurementId: "G-YHB84QE626"
            };

            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);

            // Initialize Firebase Analytics (requires compat SDK)
            const analytics = firebase.analytics();
            console.log("Firebase Analytics Initialized:", analytics);

            // Initialize Firebase Messaging
            const messaging = firebase.messaging();
            console.log("Firebase Messaging Initialized:", messaging);

            // Check if messaging is available
            if (messaging) {
                console.log("Firebase Messaging service is ready.");

                // Request permission for notifications
                Notification.requestPermission().then((permission) => {
                    if (permission === 'granted') {
                        messaging.getToken({
                                vapidKey: 'BCHwVhPZR2A0ZqgigK-bg2V38jIsbTP_a_TrkIFTFCJZmrKo3yPOxy-5_7yTHkUCpR9reEXFb1HSzUEFy9qDahA'
                            })
                            .then((currentToken) => {
                                if (currentToken) {
                                    console.log('FCM Token:', currentToken);

                                } else {
                                    console.warn(' No FCM token available.');
                                }
                            })
                            .catch((err) => {
                                console.error(' Error retrieving FCM token:', err);
                            });
                    } else {
                        console.warn(' Notification permission denied.');
                    }
                });
            } else {
                console.error("Firebase Messaging service failed to initialize.");
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                toastr.success(@json(session('success')));
            @endif

            @if (session('error'))
                toastr.error(@json(session('error')));
            @endif

            @if (session('warning'))
                toastr.warning(@json(session('warning')));
            @endif

            @if (session('info'))
                toastr.info(@json(session('info')));
            @endif
        });
    </script>

</body>

</html>
