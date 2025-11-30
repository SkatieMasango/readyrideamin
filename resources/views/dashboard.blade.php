<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .cronjob-note {
            background-color: #e9dbdb;
            padding: 16px;
            margin: 20px 0;
            border-radius: 6px;
            font-size: 15px;
            line-height: 1.5;
        }

        .cronjob-note code {
            background-color: #f8f9fa;
            padding: 2px 4px;
            font-size: 14px;
        }
    </style>

    <div class="demo_main_content_area">

        @if (!$cronIsRunning)
        <div class="cronjob-note">
            <strong>⚠️ Important:</strong> Your cron job is currently <strong>not running</strong>.
            This may prevent ride assignments from being processed automatically.

            To fix this, make sure you add the following line to your <strong>root directory</strong>:
            <pre class="mt-1"><code>php artisan order:assign-to-driver</code></pre>
        </div>

        @endif



        <!-- ride-counter-start -->
        <section class="tp-ride-counter-area mt-6 mb-4">
            <div class="container-fluids">
                <div class="row">
                    <div class="col-xl-12 col-12">
                        <div class="tp-ride-counter-wrapper d-flex align-items-center justify-content-between">
                            <div class="tp-ride-counter-item">
                                <h4 class="tp-ride-counter">
                                    <span><i class="purecounter" data-purecounter-duration="3"
                                            data-purecounter-end="{{ count($approvedDrivers) }}">{{ count($approvedDrivers) }}</i></span>
                                </h4>
                                <div class="tp-ride-counter-text d-flex align-items-center justify-content-between">
                                    <span>
                                        Active Drivers
                                    </span>
                                    <div class="tp-ride-counter-icon">
                                        <img src="assets/img/icon/counter-icon-01.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="tp-ride-counter-item">
                                <h4 class="tp-ride-counter">
                                    <span><i class="purecounter" data-purecounter-duration="3"
                                            data-purecounter-end="{{ count($onWayOrder) }}">{{ count($onWayOrder) }}</i></span>
                                </h4>
                                <div class="tp-ride-counter-text d-flex align-items-center justify-content-between">
                                    <span>
                                        Active Rides
                                    </span>
                                    <div class="tp-ride-counter-icon">
                                        <img src="assets/img/icon/counter-icon-02.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="tp-ride-counter-item">
                                <h4 class="tp-ride-counter">
                                    <span><i class="purecounter" data-purecounter-duration="3"
                                            data-purecounter-end="{{ count($completedOrder) }}">{{ count($completedOrder) }}</i></span>
                                </h4>
                                <div class="tp-ride-counter-text d-flex align-items-center justify-content-between">
                                    <span>
                                        Completed Rides
                                    </span>
                                    <div class="tp-ride-counter-icon">
                                        <img src="assets/img/icon/counter-icon-03.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="tp-ride-counter-item">
                                <h4 class="tp-ride-counter">
                                    <span><i class="purecounter" data-purecounter-duration="3"
                                            data-purecounter-end="{{ count($complaints) }}">{{ count($complaints) }}</i></span>
                                </h4>
                                <div class="tp-ride-counter-text d-flex align-items-center justify-content-between">
                                    <span>
                                        Unreviewed Complaints
                                    </span>
                                    <div class="tp-ride-counter-icon">
                                        <img src="assets/img/icon/counter-icon-04.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ride-counter-end -->

        <!--analytics-start -->
        <section class="tp-analytics-area mb-4 fix">
            <div class="container-fluids">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="tp-analytics-wrapper" style="padding-bottom: 12px">
                            <h3 class="tp-analytics-title mb-4">
                                Ride Analytics
                            </h3>
                            <div class="tp-analytics-item d-flex align-items-center justify-content-between ">
                                <div class="tp-analytics-left d-flex align-items-center">
                                    <img src="assets/img/analise/analytic-01.png" alt="">
                                    <h4 class="tp-analytics-title-2">
                                        Accepted Ride
                                    </h4>
                                </div>
                                <div class="tp-analytics-number text-end">
                                    <span>
                                        {{ count($acceptOrder) }}
                                    </span>
                                </div>
                            </div>
                            <div class="tp-analytics-item d-flex align-items-center justify-content-between">
                                <div class="tp-analytics-left d-flex align-items-center">
                                    <img src="assets/img/analise/analytic-03.png" alt="">
                                    <h4 class="tp-analytics-title-2">
                                        On The Way
                                    </h4>
                                </div>
                                <div class="tp-analytics-number text-end">
                                    <span>
                                        {{ count($onWayOrder) }}
                                    </span>
                                </div>
                            </div>
                            <div class="tp-analytics-item d-flex align-items-center justify-content-between">
                                <div class="tp-analytics-left d-flex align-items-center">
                                    <img src="assets/img/analise/analytic-02.png" alt="">
                                    <h4 class="tp-analytics-title-2">
                                        Confirm Ride Arrival
                                    </h4>
                                </div>
                                <div class="tp-analytics-number text-end">
                                    <span>
                                        {{ count($confirmArrivalOrder) }}
                                    </span>
                                </div>
                            </div>

                            <div class="tp-analytics-item d-flex align-items-center justify-content-between">
                                <div class="tp-analytics-left d-flex align-items-center">
                                    <img src="assets/img/analise/analytic-04.png" alt="">
                                    <h4 class="tp-analytics-title-2">
                                        Pickup
                                    </h4>
                                </div>
                                <div class="tp-analytics-number text-end">
                                    <span>
                                        {{ count($pickedOrder) }}
                                    </span>
                                </div>
                            </div>
                            <div class="tp-analytics-item d-flex align-items-center justify-content-between">
                                <div class="tp-analytics-left d-flex align-items-center">
                                    <img src="assets/img/analise/analytic-05.png" alt="">
                                    <h4 class="tp-analytics-title-2">
                                        Starting Ride
                                    </h4>
                                </div>
                                <div class="tp-analytics-number text-end">
                                    <span>
                                        {{ count($startRideOrder) }}
                                    </span>
                                </div>
                            </div>
                            <div class="tp-analytics-item d-flex align-items-center justify-content-between">
                                <div class="tp-analytics-left d-flex align-items-center">
                                    <img src="assets/img/analise/analytic-06.png" alt="">
                                    <h4 class="tp-analytics-title-2">
                                        Completed Ride
                                    </h4>
                                </div>
                                <div class="tp-analytics-number text-end">
                                    <span data-border-color="#36B37E">
                                        {{ count($completedOrder) }}
                                    </span>
                                </div>
                            </div>
                            <div class="tp-analytics-item d-flex align-items-center justify-content-between">
                                <div class="tp-analytics-left d-flex align-items-center">
                                    <img src="assets/img/analise/analytic-07.png" alt="">
                                    <h4 class="tp-analytics-title-2">
                                        Cancelled Ride
                                    </h4>
                                </div>
                                <div class="tp-analytics-number text-end">
                                    <span data-border-color="#FF5630">
                                        {{ count($cancelledOrder) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="tp-analytics-wrapper mb-4 pb-2">
                            <h3 class="tp-analytics-title mb-4">
                                User Overview
                            </h3>

                            <div class="tp-ride-user br-8 d-flex align-items-center justify-content-between mb-4">
                                <div class="tp-ride-user-content">
                                    <span class="tp-ride-user-text">
                                        Total User
                                    </span>
                                    <span class="tp-ride-total-user">
                                        <i class="purecounter" data-purecounter-duration="3"
                                            data-purecounter-end="{{ count($totalRiders) }}">{{ count($totalRiders) }}</i>
                                    </span>
                                </div>
                                <div class="tp-ride-user-icon">
                                    <img src="assets/img/icon/users-icon.png" alt="">
                                </div>
                            </div>

                            <div class="row gx-0 mt-3">
                                <div class="col-6">
                                    <div class="tp-ride-user-box br-8 mr-8">
                                        <h5 class="tp-ride-user-member">
                                            <span class="tp-ride-total-user">
                                                <i class="purecounter" data-purecounter-duration="3"
                                                    data-purecounter-end="{{ count($totalRiders) }}">{{ count($totalRiders) }}</i>
                                            </span>
                                        </h5>
                                        <span>
                                            Users
                                        </span>
                                        @php
                                            $totalRider = 100;
                                            $percentageRider =
                                                $totalRider > 0 ? (count($totalRiders) / $totalRider) * 100 : 0;
                                        @endphp

                                        <div class="w-full bg-gray-200 rounded-full mt-1" style="height:4px">
                                            <div class=" rounded-full"
                                                style="width: {{ $percentageRider }}%;height:4px;background-color:#1469B5">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tp-ride-user-box br-8">
                                        <h5 class="tp-ride-user-member">
                                            <span class="tp-ride-total-user">
                                                <i class="purecounter" data-purecounter-duration="3"
                                                    data-purecounter-end="{{ count($approvedDrivers) }}"
                                                    data-color="#8154DA">{{ count($approvedDrivers) }}</i>
                                            </span>
                                        </h5>
                                        <span>
                                            Drivers
                                        </span>
                                        @php
                                            $totalDrivers = 100;
                                            $percentage =
                                                $totalDrivers > 0 ? (count($approvedDrivers) / $totalDrivers) * 100 : 0;
                                        @endphp
                                        <div class="w-full bg-gray-200 rounded-full mt-1" style="height:4px">
                                            <div class="rounded-full"
                                                style="width: {{ $percentage }}%; height:4px; background-color:#8154DA">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class=" px-0 mt-3 w-full max-w-md">
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <p style="font-size: 14px; line-height:22px">Realtime users</p>

                                        <div class="flex gap-1">
                                            @php
                                                $realTimeRidersCount = count($realTimeRiders);
                                                $totalRidersCount = count($totalRiders);
                                                $percentageRider =
                                                    $totalRidersCount > 0
                                                        ? round(($realTimeRidersCount / $totalRidersCount) * 100, 1)
                                                        : 0;
                                            @endphp

                                            <p class=" text-sm" style="color:#4BB543">+{{ $percentageRider }}%
                                            </p>
                                            <img class="pb-1"
                                                src="{{ asset('assets/images/dashboard/Arrow.svg') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <p class="text-2xl font-bold">{{ count($realTimeRiders) }}</p>
                                </div>

                                <canvas id="realtimeChart1" style="height:126px !important; width:100%"></canvas>
                                <hr class="mt-1 mb-2" style="border:1px solid #3B82F6; opacity:0.5">
                            </div>
                        </div>
                        {{-- </div> --}}
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="tp-analytics-wrapper tp-analytics-wrapper-end mb-4">
                            <h3 class="tp-analytics-title mb-4">
                                Admin Wallet
                            </h3>
                            <div class="tp-analytics-wrapper-2 ">
                                <div class="tp-admin-wallet">
                                    <h3 class="tp-admin-wallet-price">
                                        {{ $commission->amount ?? 0}}
                                    </h3>
                                    <div
                                        class="tp-ride-earning-bottom-content d-flex align-items-center justify-content-between">
                                        <div class="tp-ride-earning">
                                            @php

                                                $percentageEarning =
                                                    $totalEarning > 0
                                                        ? round(($totalCommision / $totalEarning) * 100, 1)
                                                        : 0;
                                            @endphp
                                            <span>+{{ $percentageEarning }}%
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="11"
                                                    viewBox="0 0 15 11" fill="none">
                                                    <path
                                                        d="M5.56072 6.50979C4.76773 7.30391 4.00923 8.06466 3.24999 8.82578C2.6001 9.47567 1.95021 10.1246 1.30032 10.7725C1.08773 10.9835 0.831269 11.0488 0.542193 10.9637C0.253116 10.8786 0.0810205 10.6735 0.0172812 10.3836C-0.0442085 10.1017 0.0633984 9.87035 0.260615 9.67126C1.16196 8.77041 2.06256 7.86932 2.96241 6.96797C3.62955 6.30108 4.29719 5.63457 4.96532 4.96843C5.33164 4.60474 5.75569 4.60287 6.1205 4.9628C6.62742 5.46272 7.13096 5.96639 7.63112 6.4738C7.68774 6.53079 7.72336 6.6084 7.76348 6.66839L11.9763 2.45185C11.9163 2.4481 11.8585 2.44173 11.8004 2.44135C11.313 2.44135 10.8256 2.44623 10.3382 2.43835C10.0161 2.43348 9.77351 2.27713 9.64116 1.98431C9.51481 1.7046 9.5568 1.43315 9.75364 1.19469C9.82425 1.10631 9.91422 1.03533 10.0166 0.987224C10.119 0.939119 10.2311 0.915174 10.3442 0.917236C11.511 0.914611 12.6808 0.912362 13.8491 0.918361C14.2904 0.92061 14.6169 1.2558 14.6184 1.69635C14.6222 2.85866 14.6222 4.02096 14.6184 5.18327C14.6184 5.62494 14.2724 5.97064 13.8532 5.96689C13.434 5.96314 13.1108 5.63319 13.1033 5.19039C13.0962 4.71572 13.1015 4.24068 13.1015 3.76563V3.56879L13.0332 3.52455C12.9908 3.59136 12.9434 3.6549 12.8915 3.71464C11.3997 5.20914 9.90687 6.70251 8.41287 8.19476C8.02406 8.58282 7.60375 8.58357 7.21644 8.19814C6.70778 7.69172 6.19999 7.18368 5.69308 6.67402C5.64958 6.63015 5.61471 6.57616 5.56072 6.50979Z"
                                                        fill="#4BB543" />
                                                </svg>
                                            </span>
                                            <span class="tp-ride-earning-text">Total Earning</span>
                                        </div>
                                        <div class="tp-admin-wallet-icon">
                                            <img src="assets/img/icon/wallet-icon.png" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="tp-withdraw-box box-1 mt-4">
                                        <h3
                                            class="tp-withdraw-amount d-flex align-items-center justify-content-between">
                                            {{ $completeWithdraw }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.4"
                                                    d="M21 7V11.98C21 12.19 20.8 12.32 20.6 12.26C20.1 12.09 19.56 12 19 12C16.24 12 14 14.24 14 17C14 17.19 14.01 17.38 14.03 17.57C14.04 17.61 14.05 17.65 14.05 17.69C14.05 17.86 13.91 18 13.74 18H6C4 18 3 17 3 15V7C3 5 4 4 6 4H18C20 4 21 5 21 7Z"
                                                    fill="#2BBA45" />
                                                <path
                                                    d="M12 14C13.6569 14 15 12.6569 15 11C15 9.34315 13.6569 8 12 8C10.3431 8 9 9.34315 9 11C9 12.6569 10.3431 14 12 14Z"
                                                    fill="#2BBA45" />
                                                <path
                                                    d="M6 11.999C6.55228 11.999 7 11.5513 7 10.999C7 10.4467 6.55228 9.99902 6 9.99902C5.44772 9.99902 5 10.4467 5 10.999C5 11.5513 5.44772 11.999 6 11.999Z"
                                                    fill="#2BBA45" />
                                                <path
                                                    d="M21.5301 17.47C21.2371 17.177 20.762 17.177 20.469 17.47L19.749 18.19V15C19.749 14.586 19.413 14.25 18.999 14.25C18.585 14.25 18.249 14.586 18.249 15V18.189L17.529 17.469C17.236 17.176 16.761 17.176 16.468 17.469C16.175 17.762 16.175 18.237 16.468 18.53L18.468 20.53C18.614 20.676 18.806 20.75 18.998 20.75C19.19 20.75 19.382 20.677 19.528 20.53L21.528 18.53C21.823 18.238 21.8231 17.762 21.5301 17.47Z"
                                                    fill="#2BBA45" />
                                            </svg>
                                        </h3>
                                        <div class="tp-withdraw-text">
                                            <p>
                                                Already Withdraw
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tp-withdraw-box box-2 mt-4">
                                        <h3
                                            class="tp-withdraw-amount d-flex align-items-center justify-content-between">
                                            {{ $pendingWithdraw }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path d="M20 7V9H2V7C2 5 3 4 5 4H17C19 4 20 5 20 7Z" fill="#FB5E61" />
                                                <path opacity="0.4"
                                                    d="M20 9V11.45C20 11.62 19.86 11.75 19.69 11.75C19.65 11.75 19.61 11.74 19.57 11.73C19.07 11.58 18.55 11.5 18 11.5C14.97 11.5 12.5 13.97 12.5 17C12.5 17.23 12.51 17.46 12.54 17.69C12.54 17.86 12.4 18 12.23 18H5C3 18 2 17 2 15V9H20Z"
                                                    fill="#FB5E61" />
                                                <path
                                                    d="M9 14.75H6C5.586 14.75 5.25 14.414 5.25 14C5.25 13.586 5.586 13.25 6 13.25H9C9.414 13.25 9.75 13.586 9.75 14C9.75 14.414 9.414 14.75 9 14.75Z"
                                                    fill="#FB5E61" />
                                                <path
                                                    d="M18 13C15.79 13 14 14.79 14 17C14 19.21 15.79 21 18 21C20.21 21 22 19.21 22 17C22 14.79 20.21 13 18 13ZM19.35 17.65C19.55 17.84 19.55 18.16 19.35 18.35C19.26 18.45 19.13 18.5 19 18.5C18.87 18.5 18.74 18.45 18.65 18.35L18 17.7L17.35 18.35C17.26 18.45 17.13 18.5 17 18.5C16.87 18.5 16.74 18.45 16.65 18.35C16.45 18.16 16.45 17.84 16.65 17.65L17.3 17L16.65 16.35C16.45 16.16 16.45 15.84 16.65 15.65C16.84 15.45 17.16 15.45 17.35 15.65L18 16.3L18.65 15.65C18.84 15.45 19.16 15.45 19.35 15.65C19.55 15.84 19.55 16.16 19.35 16.35L18.7 17L19.35 17.65Z"
                                                    fill="#FB5E61" />
                                            </svg>
                                        </h3>
                                        <div class="tp-withdraw-text">
                                            <p>
                                                Pending Withdraw
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tp-withdraw-box box-1 mt-2">
                                        <h3
                                            class="tp-withdraw-amount d-flex align-items-center justify-content-between">
                                            {{ $totalCommision }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.4"
                                                    d="M21 21H4.5C2.958 21 2 20.042 2 18.5V4C2 3.448 2.448 3 3 3C3.552 3 4 3.448 4 4V18.5C4 18.949 4.051 19 4.5 19H21C21.552 19 22 19.448 22 20C22 20.552 21.552 21 21 21Z"
                                                    fill="#9747FF" />
                                                <path
                                                    d="M13 17C12.448 17 12 16.552 12 16V12C12 11.448 12.448 11 13 11C13.552 11 14 11.448 14 12V16C14 16.552 13.552 17 13 17ZM19 16V10C19 9.448 18.552 9 18 9C17.448 9 17 9.448 17 10V16C17 16.552 17.448 17 18 17C18.552 17 19 16.552 19 16ZM9 16V14C9 13.448 8.552 13 8 13C7.448 13 7 13.448 7 14V16C7 16.552 7.448 17 8 17C8.552 17 9 16.552 9 16Z"
                                                    fill="#9747FF" />
                                                <path
                                                    d="M18.923 3.61804C18.822 3.37404 18.627 3.17903 18.382 3.07703C18.26 3.02603 18.13 3 18 3H15C14.448 3 14 3.448 14 4C14 4.552 14.448 5 15 5H15.586L13.668 6.91797C13.572 7.01297 13.405 7.01397 13.307 6.91797L12.157 5.76794C11.278 4.88794 9.84599 4.88794 8.96799 5.76794L7.29301 7.44299C6.90201 7.83399 6.90201 8.46606 7.29301 8.85706C7.48801 9.05206 7.74401 9.15002 8.00001 9.15002C8.25601 9.15002 8.51201 9.05206 8.70701 8.85706L10.382 7.18201C10.48 7.08401 10.646 7.08401 10.743 7.18201L11.893 8.33203C12.772 9.21103 14.203 9.21103 15.082 8.33203L17 6.41394V7C17 7.552 17.448 8 18 8C18.552 8 19 7.552 19 7V4C19 3.87 18.973 3.74004 18.923 3.61804Z"
                                                    fill="#9747FF" />
                                            </svg>
                                        </h3>
                                        <div class="tp-withdraw-text">
                                            <p>
                                                Total Commission
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="tp-withdraw-box box-2 mt-2">
                                        <h3
                                            class="tp-withdraw-amount d-flex align-items-center justify-content-between">
                                            {{ $rejectedWithdraw }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.4"
                                                    d="M20 9V10.98C20 11.188 19.797 11.323 19.599 11.258C18.471 10.885 17.152 10.883 15.861 11.47C14.827 11.941 13.977 12.783 13.494 13.812C12.882 15.117 12.881 16.456 13.258 17.598C13.323 17.796 13.189 17.999 12.98 17.999H5C3 17.999 2 16.999 2 14.999V8.99902H20V9Z"
                                                    fill="#FF7E3B" />
                                                <path d="M20 7V9H2V7C2 5 3 4 5 4H17C19 4 20 5 20 7Z" fill="#FF7E3B" />
                                                <path
                                                    d="M9 14.75H6C5.586 14.75 5.25 14.414 5.25 14C5.25 13.586 5.586 13.25 6 13.25H9C9.414 13.25 9.75 13.586 9.75 14C9.75 14.414 9.414 14.75 9 14.75Z"
                                                    fill="#FF7E3B" />
                                                <path
                                                    d="M22.693 18.713C22.809 18.993 22.745 19.3161 22.53 19.5301L21.53 20.5301C21.384 20.6761 21.192 20.75 21 20.75C20.808 20.75 20.616 20.6771 20.47 20.5301C20.259 20.3191 20.2 20.014 20.293 19.75H17.5C16.259 19.75 15.25 18.741 15.25 17.5V17C15.25 16.586 15.586 16.25 16 16.25C16.414 16.25 16.75 16.586 16.75 17V17.5C16.75 17.914 17.086 18.25 17.5 18.25H22C22.303 18.25 22.577 18.433 22.693 18.713ZM20.5 13.75H17.708C17.801 13.486 17.742 13.181 17.531 12.97C17.238 12.677 16.763 12.677 16.47 12.97L15.47 13.97C15.256 14.184 15.191 14.507 15.307 14.787C15.423 15.067 15.697 15.25 16 15.25H20.5C20.914 15.25 21.25 15.586 21.25 16V16.5C21.25 16.914 21.586 17.25 22 17.25C22.414 17.25 22.75 16.914 22.75 16.5V16C22.75 14.759 21.741 13.75 20.5 13.75Z"
                                                    fill="#FF7E3B" />
                                            </svg>
                                        </h3>
                                        <div class="tp-withdraw-text">
                                            <p>
                                                Rejected Withdraw
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--analytics-start -->

        <!--total-orders-start -->
        <div class="tp-total-orders-area mb-8">
            <div class="container-fluids">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <div class="tp-total-orders-tab">
                            <h4 class="tp-total-orders-tab-title">
                                Statistics
                            </h4>
                            <div
                                class="tp-total-orders-tab-button d-flex align-items-center justify-content-end ml-30">
                                <a href="{{ route('dashboard', ['type' => 'daily']) }}"
                                    class="tp-total-orders-tab-button {{ request()->type == 'daily' || is_null(request()->type) ? 'selected' : '' }}">
                                    Daily
                                </a>
                                <a href="{{ route('dashboard', ['type' => 'monthly']) }}"
                                    class="tp-total-orders-tab-button {{ request()->type == 'monthly' ? 'selected' : '' }}">Monthly</a>
                                <a href="{{ route('dashboard', ['type' => 'yearly']) }}"
                                    class="tp-total-orders-tab-button {{ request()->type == 'yearly' ? 'selected' : '' }}">Yearly</a>
                            </div>
                            <div class="tp-total-orders-tab-date d-flex align-items-center"
                                style="position:relative;">
                                <span class=" d-flex align-items-center justify-content-center"
                                    style="cursor:pointer;">
                                    {{-- <input type="date" id="datePicker" class="custom-date-input"
                                        style="border: none; height: 20px; width: 85%; margin-top:2% ; padding:0; margin-left:17%"
                                        value="{{ request()->type ?? '' }}"> --}}
                                    <input type="date" id="datePicker" class="custom-date-input"
                                        placeholder="Select a date" value="{{ request('type') ?? '' }}"
                                        style="border: none; height: 20px; width: 85%;  padding:15px 8px; margin-left:17%">
                                </span>
                                </span>
                            </div>

                        </div>
                        <div class="card total-orders-card p-4 fix">
                            <div id="total-orders-chart"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12">
                        <div class="tp-ride-driver-wrapper  br-8 mb-4">
                            <h3 class="tp-ride-driver-title">
                                Top Driver
                            </h3>
                            @if ($topDrivers->isEmpty())
                                <p class="text-white">No driver available</p>
                            @else
                                @foreach ($topDrivers as $driver)
                                    <div
                                        class="tp-ride-driver-list-item  d-flex align-items-center justify-content-between">
                                        <div class="tp-ride-driver-list-item-left d-flex align-items-center">
                                            <div class="tp-ride-driver-author mr-4 ">
                                                <img src="{{ $driver->driver?->user?->profilePicture }}"
                                                    alt="" class="rounded-circle"
                                                    style="width: 3rem; height:3rem">
                                            </div>
                                            <div class="tp-ride-driver-info">
                                                <h4 class="tp-ride-driver-author-title">
                                                    <a href="#">
                                                        {{ $driver->driver->user->name ?? '' }}
                                                    </a>
                                                </h4>
                                                @php
                                                    $rating = $driver->driver->rating ?? 0;
                                                    $fullStars = floor($rating);
                                                    $hasHalfStar = $rating - $fullStars >= 0.5;
                                                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                                @endphp

                                                <div class="tp-ride-driver-author-rating" style="display: flex">

                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <img src="{{ asset('assets/img/icon/rating.svg') }}"
                                                            alt="">
                                                    @endfor

                                                    @if ($hasHalfStar)
                                                        <img src="{{ asset('assets/img/icon/rating-2.svg') }}"
                                                            alt="">
                                                    @endif

                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <img src="{{ asset('assets/img/icon/rating-empty.svg') }}"
                                                            alt="">
                                                    @endfor

                                                    <span class="ms-1">
                                                        {{ number_format($rating, 1) }}

                                                        <i>({{ $driver->ratings->count() ?? 0 }})</i>
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tp-ride-driver-list-item-right">
                                            <div class="tp-ride-km">
                                                <span>
                                                    Ride : {{ $driver->total ?? '' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--total-orders-end -->

        <!--summary-start -->
        <section class="tp-summary-area mb-120 mt-4 ">
            <div class="container-fluids">
                <div class="row">
                    <div class="col-12">
                        <div class="ride-summary">
                            <h3 class="tp-summary-title">Ride Summary <span>( Latest 5 Ride )</span></h3>
                            <div class="ride-table-wrapper">
                                <table class="ride-table">
                                    <thead>
                                        <tr class="tp-summary-header-title-blue">
                                            <th class="tp-summary-header-title tp-summary-width-1">ORDER ID</th>
                                            <th class="tp-summary-header-title tp-summary-width-2">Location</th>
                                            <th class="tp-summary-header-title tp-summary-width-3">Service</th>
                                            <th class="tp-summary-header-title tp-summary-width-4">Requested At
                                            </th>
                                            <th class="tp-summary-header-title tp-summary-width-4">Amount</th>
                                            <th class="tp-summary-header-title tp-summary-width-4">Status</th>
                                            <th class="tp-summary-header-title tp-summary-width-5">Payment
                                                Method</th>
                                            <th class="tp-summary-header-title tp-summary-width-3 text-center ">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="tp-ride-order-id-title">#{{ $order->id }}</td>
                                                <td class="tp-ride-order-location">

                                                    @php
                                                        $addresses = is_string($order->addresses)
                                                            ? json_decode($order->addresses, true)
                                                            : $order->addresses;
                                                    @endphp

                                                    <div><strong>Pickup:</strong>
                                                        {{ $addresses['pickup_address'] ?? '-' }}
                                                    </div>
                                                    <div><strong>Drop:</strong> {{ $addresses['drop_address'] ?? '-' }}
                                                    </div>
                                                    @if (!empty($addresses['wait_address']))
                                                        <div><strong>Wait:</strong> {{ $addresses['wait_address'] }}
                                                        </div>
                                                    @endif
                                                </td>

                                                </td>
                                                <td class="tp-ride-order-service">{{ $order->service->name ?? '' }}
                                                </td>
                                                <td class="tp-ride-order-time"> {{ $order->created_at }}</td>
                                                <td class="tp-ride-order-amount">${{ $order->cost_best }}</td>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'text-gray-500 bg-gray-100',
                                                            'accepted' => 'text-blue-600 bg-blue-100',
                                                            'rejected' => 'text-red-600 bg-red-100',
                                                            'go_to_pickup' => 'text-dark bg-indigo-100',
                                                            'confirm_arrival' => 'text-dark bg-indigo-100',
                                                            'start_ride' => 'text-indigo-600 bg-indigo-100',
                                                            'in_progress' => 'text-yellow-600 bg-yellow-100',
                                                            'picked_up' => 'text-purple-600 bg-purple-100',
                                                            'completed' => 'text-green-600 bg-green-100',
                                                            'cancelled' => 'text-red-500 bg-red-100',
                                                        ];

                                                        $status = is_object($order->status)
                                                            ? $order->status->value
                                                            : $order->status;
                                                        $statusClass =
                                                            $statusColors[$status] ?? 'text-gray-600 bg-gray-100';
                                                    @endphp

                                                    <span class="tp-ride-order-status px-2 {{ $statusClass }}">
                                                        {{ ucwords(str_replace('_', ' ', $status)) }}
                                                    </span>
                                                </td>
                                                <td class="tp-ride-order-payment">{{ $order->payment_mode ?? 'N/A' }}
                                                </td>
                                                <td class=" tp-btn-action ">
                                                    <div
                                                        class="tp-order d-flex align-items-center justify-content-center relative">
                                                        <x-action-button></x-action-button>
                                                        <div class="tp-order-thumb-more absolute">
                                                            <a type="submit"
                                                                class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                                <i class="fa fa-edit"></i><span>Edit</span>
                                                            </a>
                                                            <a type="submit"
                                                                class="w-full text-left text-sm text-gray-700 hover:bg-gray-100 d-flex align-items-center p-1 gap-1">
                                                                <i class="fa fa-download"></i>Download
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</x-app-layout>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#datePicker", {});
    });
    //Date picker
    document.getElementById('datePicker').addEventListener('change', function() {
        const selectedDate = this.value;
        if (selectedDate) {
            window.location.href = `{{ route('dashboard') }}?type=${selectedDate}`;
        }
    });


    // realtimeChart
    const ctx = document.getElementById('realtimeChart1').getContext('2d');
    const dataPoints = @json($dataPoints);

    function hexToRGBA(hex, opacity) {
        hex = hex.replace('#', '');
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);

        return `rgba(${r}, ${g}, ${b}, ${opacity})`;
    }

    const gridColor = '#d4d5d9';
    const gridColorWithOpacity = hexToRGBA(gridColor, 0.3);

    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(20, 105, 181, 0.33)');
    gradient.addColorStop(0.3, 'rgba(227, 241, 253, 0.33)');
    gradient.addColorStop(0.8, 'rgba(250, 253, 255, 0.33)');

    const realtimeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                '', '', '06 - 12 pm', '', '', '', '', '', '12 - 06 pm', '', '', '', '', '', '06 - 12 am',
                '', '',
                '',
                '', '', '12 - 06 am', '', '', '',
            ],
            datasets: [{
                label: 'Users',
                data: dataPoints,
                borderColor: '#3B82F6',
                backgroundColor: gradient,
                fill: true,
                tension: 0.8,
                pointRadius: 0,
                spanGaps: true,
                borderWidth: 2
            }]

        },
        options: {
            responsive: false,

            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: true,
                        color: gridColorWithOpacity,
                        drawBorder: false,
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 0,
                        minRotation: 0,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: gridColorWithOpacity,
                        drawBorder: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        display: false,

                    }
                }
            }
        }


    });

    // graph

    const filterOrders = @json($filterOrders);
    const totalOrders = filterOrders.values.reduce((sum, val) => sum + val, 0);

    // const lightColors = ['#F1F7FE', '#E3EEFB', '#C0DDF7', '#89C1F0', '#1469B5'];
    const lightColors = ['#89C1F0', '#4D7AA3', '#3C5A75', '#2D3E50', '#33475B', '#3C5A75'];
    const darkColors = ['#2D3E50', '#33475B', '#3C5A75', '#4D7AA3', '#d0bb5bff'];

    document.getElementById("darkModeToggle").addEventListener("click", function() {
        const isDark = document.body.classList.contains("dark-theme");

        chart.updateOptions({
            colors: !isDark ? darkColors : lightColors,
        });
    });
    const values = filterOrders.values;
    const maxSegments = 100;
    const segments = [];

    for (let segmentIndex = 0; segmentIndex < maxSegments; segmentIndex++) {
        const segmentData = values.map(val => {
            const remaining = val - segmentIndex * 2;
            if (remaining >= 2) return 2;
            else if (remaining > 0) return remaining;
            else return null;
        });
        if (segmentData.every(d => d === null)) break;
        segments.push({
            name: `Segment ${segmentIndex + 1}${segmentIndex === 0 ? ' (Bottom)' : ''}`,
            data: segmentData
        });
    }

    var options = {
        series: segments,
        chart: {
            type: 'bar',
            height: 398,
            stacked: true,
            toolbar: {
                show: false
            }
        },
        colors: lightColors,
        plotOptions: {
            bar: {
                columnWidth: '57px',
                borderRadius: 8,
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'last',
            }
        },
        responsive: [{
                breakpoint: 768,
                options: {
                    plotOptions: {
                        bar: {
                            columnWidth: '50px'
                        }
                    }
                }
            },
            {
                breakpoint: 480,
                options: {
                    plotOptions: {
                        bar: {
                            columnWidth: '30px',
                            borderRadius: 5
                        }
                    }
                }
            }
        ],
        xaxis: {
            categories: filterOrders.labels,
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    fontSize: '14px',
                    colors: '#727273'
                }
            }
        },
        yaxis: {
            min: 0,
            max: 10,
            tickAmount: 5,
            labels: {
                style: {
                    fontSize: '14px',
                    colors: '#727273'
                }
            },
            yaxis: {
                min: 0,
                max: 10,
                tickAmount: 5,
                labels: {
                    formatter: function(val) {
                        return val.toString();
                    },
                    style: {
                        fontSize: '14px',
                        colors: '#727273'
                    }
                }
            }
        },

        dataLabels: {
            enabled: true,
            formatter: function() {
                return '';
            },
            offsetY: -5,
            style: {
                fontSize: '12px',
                colors: ['#687387']
            }
        },

        grid: {
            show: true,
            borderColor: '#f0f0f0',
            strokeDashArray: 5,
            position: 'back',
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },

        legend: {
            show: false
        },
        tooltip: {
            enabled: true,
            y: {
                formatter: val => val.toFixed(0)
            }
        },

        title: {
            text: totalOrders,
            align: 'left',
            offsetY: 0,
            style: {
                fontSize: '32px',
                fontWeight: '700',
                color: '#727273'

            }
        },
        subtitle: {
            text: 'Total Orders',
            align: 'left',
            offsetY: 45,
            style: {
                fontSize: '16px',
                fontWeight: '400',
                color: '#727273'
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#total-orders-chart"), options);
    chart.render();
</script>
