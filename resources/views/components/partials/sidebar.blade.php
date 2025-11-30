<div class="tp-sidebar-area">
    <div class="tp-deashboard-head">
        <a href="#" class="tp-deashboard-logo mb-4">
            <img src="{{ asset('assets/img/logo/logo.png') }}" alt="">
        </a>
    </div>
    <form action="#" class="relative tp-deashboard-form">

        <input type="text" class="focus:border-primary-500 focus:ring-primary-500" placeholder="Search ">
        <svg class="tp-deashboard-form-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
            viewBox="0 0 20 20" fill="none">
            <path
                d="M19.53 18.47L15.689 14.629C16.973 13.106 17.75 11.143 17.75 9C17.75 4.175 13.825 0.25 9 0.25C4.175 0.25 0.25 4.175 0.25 9C0.25 13.825 4.175 17.75 9 17.75C11.143 17.75 13.106 16.973 14.629 15.689L18.47 19.53C18.616 19.676 18.808 19.75 19 19.75C19.192 19.75 19.384 19.677 19.53 19.53C19.823 19.238 19.823 18.763 19.53 18.47ZM1.75 9C1.75 5.002 5.002 1.75 9 1.75C12.998 1.75 16.25 5.002 16.25 9C16.25 12.998 12.998 16.25 9 16.25C5.002 16.25 1.75 12.998 1.75 9Z"
                fill="#8A94A6" />
        </svg>
    </form>
    <div class="tp-sidebar-menu">
        <nav>
            <ul>
                {{-- @can('dashboard') --}}
                    <li class="tp-dropdown__menu-item dashboard  {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="tp-dropdown-toggle-dashboard toggle-dashboard">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.dashboard />
                                <span class="tp-sidebar-menu-list-title ml-7">Dashboard</span>
                            </div>
                        </a>
                        <div style="display: none;padding: 0 8px" class="display-none d-dashboard">
                            <x-icons.dashboard />
                        </div>

                        <ul class="tp-dropdown__menu-single-dashboard  ">
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <div class="d-flex align-items-center">
                                        <p class="tp-sidebar-menu-list-title ">Dashboard</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                {{-- @endcan --}}
                @can('drivers.view')
                    <li class="tp-dropdown__menu-item driver {{ request()->routeIs('drivers.*') ? 'active' : '' }}">
                        <a href="{{ route('drivers.view') }}" class="tp-dropdown-toggle-driver tp-menu-link toggle-driver">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.driver class="h-6 w-6" />
                                <span class="tp-sidebar-menu-list-title ml-7">All Driver</span>
                            </div>
                        </a>
                        <div style="display: none;padding: 0 8px" class="display-none d-driver">
                            <x-icons.driver />
                        </div>
                        <ul class="tp-dropdown__menu-single-driver ">
                            <li>
                                <a href="{{ route('drivers.view') }}">
                                    <div class="d-flex align-items-center">
                                        <p class="tp-sidebar-menu-list-title ">All Driver</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('riders.index')
                    <li class="tp-dropdown__menu-item rider {{ request()->routeIs('riders.*') ? 'active' : '' }}">
                        <a href="{{ route('riders.index') }}" class="tp-dropdown-toggle-rider tp-menu-link toggle-rider">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.riders class="h-6 w-6" />
                                <span class="tp-sidebar-menu-list-title ml-7">All Rider</span>
                            </div>
                        </a>
                        <div style="display: none;padding: 0 8px" class="display-none d-rider">
                            <x-icons.riders />
                        </div>
                        <ul class="tp-dropdown__menu-single-rider ">
                            <li>
                                <a href="{{ route('riders.index') }}">
                                    <div class="d-flex align-items-center">
                                        <p class="tp-sidebar-menu-list-title ">All Rider</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany(['marketing-promotionals.index', 'marketing-coupons.index', 'marketing-gift-cards.index'])
                    <li class="tp-dropdown__menu-item {{ request()->routeIs('marketing*') ? 'open' : '' }}">
                        <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.marketing class="h-6 w-6" />
                                <span class="tp-sidebar-menu-list-title ml-7"> Marketing Hub</span>
                            </div>
                            <i class="dropdown-icon"><x-icons.chevron /></i>

                        </a>

                        <ul class="tp-dropdown__menu ">
                            <li class="{{ request()->routeIs('marketing-promotionals.*') ? 'active' : '' }}">
                                <a href="{{ route('marketing-promotionals.index') }}">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Banner Setup</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('marketing-coupons.*') ? 'active' : '' }}">
                                <a href="{{ route('marketing-coupons.index') }}">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Coupon Setup</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('marketing-gift-cards.*') ? 'active' : '' }}">
                                <a href="{{ route('marketing-gift-cards.index') }}">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">

                                        <span class="tp-sidebar-menu-list-title ml-7">Gift Cards</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @canany(['vehicle-category.index', 'vehicle-brand.index', 'vehicle-model.index', 'vehicle-color.index'])
                    <li class="tp-dropdown__menu-item {{ request()->routeIs('vehicle*') ? 'open' : '' }}">
                        <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.vehicle class="h-6 w-6" />

                                <span class="tp-sidebar-menu-list-title ml-7">Vehicle Management</span>
                            </div>
                            <i class="dropdown-icon"><x-icons.chevron /></i>
                        </a>

                        <ul class="tp-dropdown__menu ">
                            <li class="{{ request()->routeIs('vehicle-category.*') ? 'active' : '' }}">
                                <a href="{{ route('vehicle-category.index') }}" id="vehicle-category.index"
                                    data-scroll-id="vehicle-category.index">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">

                                        <span class="tp-sidebar-menu-list-title ml-7">Vehicle Category</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('vehicle-brand.*') ? 'active' : '' }}">
                                <a href="{{ route('vehicle-brand.index') }}" id="vehicle-brand.index"
                                    data-scroll-id="vehicle-brand.index">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Vehicle Brand</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('vehicle-model.*') ? 'active' : '' }}">
                                <a href="{{ route('vehicle-model.index') }}" id="vehicle-model.index"
                                    data-scroll-id="vehicle-model.index">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Vehicle Model</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('vehicle-color.*') ? 'active' : '' }}">
                                <a href="{{ route('vehicle-color.index') }}" id="vehicle-color.index"
                                    data-scroll-id="vehicle-color.index">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Vehicle Color</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @can('announcements.index')
                    <li
                        class="tp-dropdown__menu-item notification {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
                        <a href="{{ route('announcements.index') }}"
                            class="tp-dropdown-toggle-rider tp-menu-link toggle-notification">
                            <div class="tp-sidebar-menu-notification d-flex align-items-center">
                                <x-icons.notification class="h-6 w-6" />
                                <span class="tp-sidebar-menu-list-title ml-7">Notification Management</span>
                            </div>
                        </a>
                        <div style="display: none;padding: 0 8px" class="display-none d-notification">
                            <x-icons.notification />
                        </div>
                        <ul class="tp-dropdown__menu-single-notification ">
                            <li>
                                <a href="{{ route('announcements.index') }}">
                                    <div class="d-flex align-items-center">
                                        <p class="tp-sidebar-menu-list-title ">Notification Management</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('request.index')
                    <li class="tp-dropdown__menu-item dashboard  {{ request()->routeIs('request.*') ? 'active' : '' }}">
                        <a href="{{ route('request.index') }}" class="tp-dropdown-toggle-ride toggle-ride">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.marketing />
                                <span class="tp-sidebar-menu-list-title ml-7">Ride Request</span>
                            </div>
                        </a>
                        <div style="display: none;padding: 0 8px" class="display-none d-dashboard">
                            <x-icons.marketing />
                        </div>

                        <ul class="tp-dropdown__menu-single-ride  ">
                            <li>
                                <a href="{{ route('request.index') }}">
                                    <div class="d-flex align-items-center">
                                        <p class="tp-sidebar-menu-list-title ">Ride Request</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @canany(['services-category.index', 'services-option.index', 'services.index'])
                    <li class="tp-dropdown__menu-item {{ request()->is('services*') ? 'open' : '' }}">
                        <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.service class="h-6 w-6" />
                                <span class="tp-sidebar-menu-list-title ml-7">Service Management</span>
                            </div>
                            <i class="dropdown-icon"><x-icons.chevron /></i>
                        </a>

                        <ul class="tp-dropdown__menu ">
                            <li class="{{ request()->routeIs('services-category.*') ? 'active' : '' }}">
                                <a href="{{ route('services-category.index') }}" id="services-category"
                                    data-scroll-id="services-category">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Service Category</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('services-option.*') ? 'active' : '' }}">
                                <a href="{{ route('services-option.index') }}" id="services-option"
                                    data-scroll-id="services-option">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Services Options</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
                                <a href="{{ route('services.index') }}" id="services" data-scroll-id="services">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Services </span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany
                @can('complaints.index')
                    <li class="tp-dropdown__menu-item complaint {{ request()->routeIs('complaints.*') ? 'active' : '' }}">
                        <a href="{{ route('complaints.index') }}"
                            class="tp-dropdown-toggle-complaint tp-menu-link toggle-complaint">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.complaints class="h-6 w-6" />
                                <span class="tp-sidebar-menu-list-title ml-7">Complaints</span>
                            </div>
                        </a>
                        <div style="display: none;padding: 0 8px" class="display-none d-complaint">
                            <x-icons.complaints />
                        </div>
                        <ul class="tp-dropdown__menu-single-complaint ">
                            <li>
                                <a href="{{ route('complaints.index') }}">
                                    <div class="d-flex align-items-center">
                                        <p class="tp-sidebar-menu-list-title ">Complaints</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- <li class="tp-dropdown__menu-item sos {{ request()->routeIs('sos.*') ? 'active' : '' }}">
                    <a href="{{ route('sos.index') }}" class="tp-dropdown-toggle-sos tp-menu-link toggle-sos">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <x-icons.sos class="h-6 w-6" />
                            <span class="tp-sidebar-menu-list-title ml-7">SOS</span>
                        </div>
                    </a>
                    <div style="display: none;padding: 0 8px" class="display-none d-sos">
                        <x-icons.sos />
                    </div>
                    <ul class="tp-dropdown__menu-single-sos ">
                        <li>
                            <a href="{{ route('sos.index') }}">
                                <div class="d-flex align-items-center">
                                    <p class="tp-sidebar-menu-list-title ">SOS</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                @can('report-types.index')
                    <li
                        class="tp-dropdown__menu-item report-types {{ request()->routeIs('report-types.*') ? 'active' : '' }}">
                        <a href="{{ route('report-types.index') }}"
                            class="tp-dropdown-toggle-report-types tp-menu-link toggle-report-types">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.complaints class="h-6 w-6" />
                                <span class="tp-sidebar-menu-list-title ml-7">Report Types</span>
                            </div>
                        </a>
                        <div style="display: none;padding: 0 8px" class="display-none d-report-types">
                            <x-icons.complaints />
                        </div>
                        <ul class="tp-dropdown__menu-single-report-types ">
                            <li>
                                <a href="{{ route('report-types.index') }}">
                                    <div class="d-flex align-items-center">
                                        <p class="tp-sidebar-menu-list-title ">Report Types</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('accounting.admin')
                    <li class="tp-dropdown__menu-item {{ request()->routeIs('accounting*') ? 'open' : '' }}">
                        <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                            <div class="tp-sidebar-menu-left d-flex align-items-center">
                                <x-icons.accounting class="h-6 w-6" />
                                <span class="tp-sidebar-menu-list-title ml-7">Accounting</span>
                            </div>
                            <i class="dropdown-icon"><x-icons.chevron /></i>
                        </a>

                        <ul class="tp-dropdown__menu tp-dropdown__menu-item-last">
                            <li class="{{ request()->route('name') === 'admin' ? 'active' : '' }}">
                                <a href="{{ route('accounting.admin', ['name' => 'admin']) }}" id="admin"
                                    data-scroll-id="admin">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Admin</span>
                                    </div>
                                </a>
                            </li>
                            {{-- <li class="{{ request()->route('name') === 'fleets' ? 'active' : '' }}">
                            <a href="{{ route('accounting.admin', ['name' => 'fleets']) }}" id="fleets"
                                data-scroll-id="fleets">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <span class="tp-sidebar-menu-list-title ml-7">Fleets</span>
                                </div>
                            </a>
                        </li> --}}
                            <li class="{{ request()->route('name') === 'drivers' ? 'active' : '' }}">
                                <a href="{{ route('accounting.admin', ['name' => 'drivers']) }}" id="drivers"
                                    data-scroll-id="drivers">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Drivers</span>
                                    </div>
                                </a>
                            </li>
                            <li class="{{ request()->route('name') === 'riders' ? 'active' : '' }}">
                                <a href="{{ route('accounting.admin', ['name' => 'riders']) }}" id="riders"
                                    data-scroll-id="riders">
                                    <div class="tp-sidebar-menu-left d-flex align-items-center">
                                        <span class="tp-sidebar-menu-list-title ml-7">Riders</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                {{-- @canany(['management.payment-gateways.index', 'management.user-roles.index']) --}}

                {{-- @endcanany --}}
                <li class="tp-dropdown__menu-item {{ request()->routeIs('management*') ? 'open' : '' }}">
                    <a href="#" class="tp-dropdown-toggle" data-toggle="dropdown">
                        <div class="tp-sidebar-menu-left d-flex align-items-center">
                            <x-icons.accounting class="h-6 w-6" />
                            <span class="tp-sidebar-menu-list-title ml-7"> Settings & Configs</span>
                        </div>
                        <i class="dropdown-icon"><x-icons.chevron /></i>
                    </a>

                    <ul class="tp-dropdown__menu tp-dropdown__menu-item-last">
                        <li class="{{ request()->routeIs('management.settings.*') ? 'active' : '' }}">
                            <a href="{{ route('management.settings.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <span class="tp-sidebar-menu-list-title ml-7"> Web Setting</span>
                                </div>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('management.payment-gateways.*') ? 'active' : '' }}">
                            <a href="{{ route('management.payment-gateways.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <span class="tp-sidebar-menu-list-title ml-7"> Payment Getway Setup</span>
                                </div>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('management.user-roles.*') ? 'active' : '' }}">
                            <a href="{{ route('management.user-roles.index') }}">
                                <div class="tp-sidebar-menu-left d-flex align-items-center">
                                    <span class="tp-sidebar-menu-list-title ml-7">User Permission </span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
    </div>
</div>
