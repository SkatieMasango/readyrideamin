<x-app-layout>
    <div class="demo_main_content_area">

        @php
            $setting = App\Models\Settings::first();
            $value = $setting->value;
            $decoded = json_decode($value, true);

            $status = $rider->user?->status?->value;

            $statusColors = [
                'Pending Approval' => 'back-icon text-gray-800',
                'Approved' => 'bg-green-200 text-green-900',
            ];

            $color = $statusColors[$status] ?? 'back-icon text-gray-800';
        @endphp

        <div class="card mt-6 rounded-lg border-none mb-120">
            <div class="card-body p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('riders.index') }}"
                            class=" rounded-md flex items-center back-icon justify-center" style="width:40px;">
                            <x-icons.back-button />
                        </a>
                        <div class="ms-3 ">
                            <h5 class="text-md text-gray-800 ">
                                <span class="font-medium">
                                    {{ $rider->user?->name }}
                                </span>
                                <br>
                                <span class="inline-flex items-start rounded px-2 text-xs {{ $color }}">
                                    {{ $rider->user->status }}
                                </span>
                            </h5>
                        </div>
                    </div>
                    <div class="flex items-center ">
                        <div class="relative ms-3" style="width:160px">
                            <form method="POST" action="{{ route('riders.updateStatus', $rider->user?->id) }}"
                                id="status-form">
                                @csrf
                                @method('PUT')
                                <x-select-input name="status" :options="\App\Enums\Status::optionsWithout('pending_approval')" :selected="$rider->user?->status->value ?? old('status')" class="mt-1"
                                    onchange="document.getElementById('status-form').submit();" />
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mb-4">
                    <span class="">Mobile No: {{ $rider->user->mobile }}
                    </span>
                    <span class="">Registered on:
                        {{ \Carbon\Carbon::parse($rider->created_at)->diffForHumans() }}
                    </span>
                    <span class="">Last Seen At: -
                        {{ \Carbon\Carbon::parse($rider->updated_at)->diffForHumans() }}
                    </span>
                    <span></span>
                    </a>
                </div>
                <div class="flex gap-5 mb-3 driver-middle-section p-4 rounded-lg">
                    <a href="javascript:void(0);" class="rider-button"
                        style="border-bottom:2px solid rgb(230 21 68 / var(--tw-bg-opacity, 1))"
                        data-target="details-section"><strong>Details</strong></a>
                    <a href="javascript:void(0);" class="rider-button"
                        data-target="orders-section"><strong>Orders</strong></a>
                    <a href="javascript:void(0);" class="rider-button" data-target="credits-section"><strong>Credit
                            Records</strong></a>

                </div>

                <div id="details-section" style="display: none;">
                    <div class=" mt-6 rounded-lg border border-gray-200">
                        <div class="p-6">
                            <form method="POST" action="{{ route('riders.update', $rider->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3 grid grid-cols-4 gap-6">
                                    <div class="relative">
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" class="mt-1 block w-full" type="text"
                                            name="name" autofocus autocomplete="name" :value="old('name', $rider->user->name ?? '')" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div style="height: 55px">
                                        <x-input-label for="email" :value="__('Mobile Number')" />
                                        <div class="flex rounded-md shadow-sm mt-1">
                                            <select name="country_code" id="country_code"
                                                class="select2 truncate rounded-l-md border border-gray-300 bg-white p-3 text-sm focus:border-primary-500 focus:ring-primary-500">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country['phone_code'] }}"
                                                        title="{{ $country['name'] }}"
                                                        {{ $iso->phone_code == $country['phone_code'] ? 'selected' : '' }}
                                                        @if ($country['name'] === $iso?->name) selected @endif>
                                                        {{ \Illuminate\Support\Str::limit($country['code'], 15) }}
                                                         ({{ $country['phone_code'] }})
                                                    </option>
                                                @endforeach
                                            </select>

                                            @php
                                                $phoneCode = $iso->phone_code ?? '';
                                                $fullNumber = $rider->user?->mobile ?? '';
                                                $strippedNumber =
                                                    $phoneCode && str_starts_with($fullNumber, $phoneCode)
                                                        ? substr($fullNumber, strlen($phoneCode))
                                                        : $fullNumber;
                                            @endphp

                                            <input type="number" name="mobile" id="mobile"
                                                class="block w-full rounded-r-md border border-gray-300 p-5 text-sm focus:border-primary-500 focus:ring-primary-500"
                                                value="{{ old('mobile', $strippedNumber) }}" autocomplete="text"
                                                placeholder="Enter phone number" />
                                        </div>

                                        <div class="flex gap-4">
                                            <x-input-error :messages="$errors->get('country')" class="mt-2 w-1/3" />
                                            <x-input-error :messages="$errors->get('mobile')" class="mt-2 w-2/3" />
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <x-input-label for="gender" :value="__('Gender')" />
                                        <x-select-input name="gender" :options="\App\Enums\Gender::options()" :selected="old('gender', $rider->user->gender ?? '')"
                                            class="mt-1" />
                                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                    </div>
                                    <div class="relative">
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="mt-1 block w-full" type="email"
                                            name="email" :value="old('email', $rider->user->email ?? '')" autofocus autocomplete="email" />

                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div class="relative">
                                        <x-input-label for="address" :value="__('Address')" />
                                        <x-text-input id="address" class="mt-1 block w-full" type="text"
                                            name="address" autofocus autocomplete="address" :value="old('address', $rider->user->address ?? '')" />

                                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="flex justify-start mt-6">
                                    <x-primary-button class="w-auto">
                                        {{ __('Update') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="orders-section" style="display: none;">
                    <div class=" mt-6 rounded-lg border border-gray-200">
                        <div class="p-6">
                            <div class="mt-4 overflow-x-auto">
                                <table class="w-100">
                                    <thead class="text-nowrap">
                                        <tr class="text-sm font-medium uppercase tp-summary-header-title-blue ">
                                            <th class="px-4 py-3 text-left">Date & Time</th>
                                            <th class="px-4 py-3 text-left">Locations</th>
                                            <th class="px-4 py-3 text-left">Cost</th>
                                            <th class="px-4 py-3 text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm text-gray-700">
                                        @if ($orders->isNotEmpty())
                                            @foreach ($orders as $order)
                                                <tr class="border-b hover:bg-gray-50">

                                                    <td class="px-4 py-3">
                                                        <a href="{{ route('request.show', $order['id']) }}">
                                                            {{ $order->created_at }}</a>
                                                    </td>
                                                    <td class="px-4 py-3">

                                                        @php
                                                            $addresses = is_string($order->addresses)
                                                                ? json_decode($order->addresses, true)
                                                                : $order->addresses;
                                                        @endphp

                                                        <div><strong>Pickup:</strong>
                                                            {{ $addresses['pickup_address'] ?? '-' }}
                                                        </div>
                                                        <div><strong>Drop:</strong>
                                                            {{ $addresses['drop_address'] ?? '-' }}
                                                        </div>
                                                        @if (!empty($addresses['wait_address']))
                                                            <div><strong>Wait:</strong>
                                                                {{ $addresses['wait_address'] }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        {{ $decoded['currency'] }}{{ $order->cost_best }}
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <div class="flex items-center">
                                                            <div
                                                                class="mr-2 h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400">
                                                            </div>
                                                            <span
                                                                class="font-medium text-yellow-600">{{ $order->status?->label() }}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="border-b hover:bg-gray-50">
                                                <td colspan="5" class="px-4 py-3 text-center">No data found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="credits-section" style="display: none;">
                    <div class="mt-4 overflow-x-auto overflow-y-hidden border-none">
                        <div class="mt-4 overflow-x-auto">
                            <div class="flex items-center justify-between">
                                <h5 class="text-lg font-semibold text-gray-800">
                                    Transaction Records

                                </h5>
                            </div>

                            <div class="mt-4 overflow-x-auto">
                                <table class="w-100">
                                    <thead class="text-nowrap">
                                        <tr class="text-sm font-medium uppercase tp-summary-header-title-blue ">
                                            <th class="px-4 py-3 text-left">Date & Time</th>
                                            <th class="px-4 py-3 text-left">Transaction Type</th>
                                            <th class="px-4 py-3 text-left">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm text-gray-700">
                                        @if ($transactions->isNotEmpty())
                                            @foreach ($transactions as $transaction)
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="px-4 py-3">{{ $transaction['created_at'] }}
                                                    </td>
                                                    <td class="px-4 py-3">{{ $transaction['transaction'] }}</td>
                                                    <td class="px-4 py-3">
                                                        {{ $decoded['currency'] }}{{ $transaction['amount'] }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="border-b hover:bg-gray-50">
                                                <td colspan="5" class="px-4 py-3 text-center">No data found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 rounded-lg border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h5 class="text-lg font-semibold text-gray-800">
                                    Wallet Summary

                                </h5>
                            </div>

                            <div class="mt-4 overflow-x-auto">
                                <table class="w-100">
                                    <thead class="text-nowrap">
                                        <tr class="text-sm font-medium uppercase tp-summary-header-title-blue ">

                                            <th class=" px-4 py-3 text-left">Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-sm text-gray-700">
                                        @if ($wallet)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="px-4 py-3">{{ $decoded['currency'] }}{{ $wallet->amount }}
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="border-b hover:bg-gray-50">
                                                <td colspan="5" class="px-4 py-3 text-center">No data found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#country_code').select2({
            width: 'resolve'
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const buttons = document.querySelectorAll(".rider-button");
        const sections = ["details-section", "orders-section", "credits-section"];
        const savedSection = localStorage.getItem("activeSection");
        const defaultSection = savedSection || "details-section";

        showSection(defaultSection);
        buttons.forEach(button => {
            button.addEventListener("click", function() {
                const targetId = button.getAttribute("data-target");
                localStorage.setItem("activeSection", targetId);
                showSection(targetId);
            });
        });

        function showSection(targetId) {
            sections.forEach(sectionId => {
                const section = document.getElementById(sectionId);
                if (section) {
                    section.style.display = (sectionId === targetId) ? "block" : "none";
                }
            });
            buttons.forEach(btn => {
                if (btn.getAttribute("data-target") === targetId) {
                    btn.style.borderBottom = "2px solid #c2c5c9";
                } else {
                    btn.style.borderBottom = "none";
                }
            });
        }
    });
</script>
