<x-app-layout>
    <div class="demo_main_content_area">
        @php
            $status = $driver->user?->status?->value;

            $statusColors = [
                'Offline' => 'back-icon text-gray-800',
                'Online' => 'bg-green-200 text-green-900',
            ];

            $color = $statusColors[$driver->driver_status] ?? 'back-icon text-gray-800';
        @endphp

        <div class="card mt-6 rounded-lg border-none mb-120">
            @php
                $setting = App\Models\Settings::first();
                $value = $setting->value;
                $decoded = json_decode($value, true);
            @endphp
            <div class="card-body p-6 ">

                <div class="flex items-center justify-between mb-3">

                    <div class="flex justify-between items-center">
                        <a href="{{ route('drivers.view') }}"
                            class=" rounded-md flex items-center back-icon justify-center" style="width:40px;">
                            <x-icons.back-button />
                        </a>
                        <img class="ms-3" src="{{ $driver->user?->profilePicture }}" alt="user image"
                            class="rounded-full" style="height: 40px; width:40px">
                        <div class="ms-3 ">
                            <h5 class="text-md text-gray-800 ">
                                <span class="font-medium">
                                    {{ $driver->user?->name }}
                                </span>
                                <br>
                                <span class="inline-flex items-start rounded px-2 text-xs {{ $color }}">
                                    {{ $driver->driver_status }}
                                </span>
                            </h5>
                        </div>
                    </div>

                    <div class="flex items-center ">

                        <div class="relative ms-3" style="width:160px">

                            <form method="POST" action="{{ route('drivers.updateStatus', $driver->user?->id) }}"
                                id="status-form">
                                @csrf
                                @method('PUT')
                                <x-select-input name="status" :options="\App\Enums\Status::options()" :selected="$driver->user?->status->value ?? old('status')" class="mt-1"
                                    onchange="document.getElementById('status-form').submit();" />

                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mb-4">
                    <span class="">Registered on:
                        {{ \Carbon\Carbon::parse($driver->created_at)->diffForHumans() }}
                    </span>
                    <span class="">Last Seen At: -
                        {{ \Carbon\Carbon::parse($driver->updated_at)->diffForHumans() }}
                    </span>
                    <span class="flex items-center justify-center">
                        Rating:
                        @if ($driver->ratings->count())
                            @php
                                $avgRating = $driver->ratings->avg('rating');
                                $fullStars = floor($avgRating);
                                $hasHalfStar = $avgRating - $fullStars >= 0.5;
                            @endphp

                            {{-- Full stars --}}
                            @for ($i = 0; $i < $fullStars; $i++)
                                <img src="{{ asset('assets/images/dashboard/Rating unit.svg') }}" alt=""
                                    class="rounded object-cover w-4 h-4" />
                            @endfor

                            {{-- Half star --}}
                            @if ($hasHalfStar)
                                <img src="{{ asset('assets/images/dashboard/Rating unit (1).svg') }}" alt=""
                                    class="rounded object-cover w-4 h-4" />
                            @endif
                        @else
                            N/A
                        @endif
                        <span class="text-gray-500">
                            ({{ $driver->ratings->count() }})
                        </span>

                    </span>

                    <span></span>
                    </a>
                </div>

                <div class="flex gap-5 mb-3 driver-middle-section p-4 rounded-lg">
                    <a href="javascript:void(0);" class="driver-button"
                        style="border-bottom:2px solid rgb(230 21 68 / var(--tw-bg-opacity, 1))"
                        data-target="details-section"><strong>Details</strong></a>
                    <a href="javascript:void(0);" class="driver-button"
                        data-target="orders-section"><strong>Orders</strong></a>
                    <a href="javascript:void(0);" class="driver-button" data-target="credits-section"><strong>Credit
                            Records</strong></a>
                    <a href="javascript:void(0);" class="driver-button"
                        data-target="reviews-section"><strong>Reviews</strong></a>
                    <a href="javascript:void(0);" class="driver-button"
                        data-target="documents-section"><strong>Documents</strong></a>
                </div>

                <div id="details-section" style="display: none;">
                    <div class=" mt-6 rounded-lg border border-gray-200">
                        <div class="p-6">
                            <form method="POST" action="{{ route('drivers.update', $driver->id) }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3 grid grid-cols-4 gap-6">
                                    <div>
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" class="mt-1 block w-full" type="text"
                                            name="name" autofocus autocomplete="name" :value="old('name', $driver->user?->name ?? '')" />

                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="mt-1 block w-full" type="email"
                                            name="email" :value="old('email', $driver->user?->email ?? '')" autofocus autocomplete="email" />

                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <div style="height:48px">
                                        <x-input-label for="email" :value="__('Mobile Number')" />
                                        <div class="flex rounded-md mt-1">

                                            <select name="country_code" id="country_code"
                                                class=" truncate rounded-l-md border border-gray-300 bg-white p-3 text-sm focus:border-primary-500 focus:ring-primary-500">
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
                                                $fullNumber = $driver->user?->mobile ?? '';
                                                $strippedNumber =
                                                    $phoneCode && str_starts_with($fullNumber, $phoneCode)
                                                        ? substr($fullNumber, strlen($phoneCode))
                                                        : $fullNumber;
                                            @endphp

                                            <input type="number" name="mobile" id="mobile"
                                                class="block w-full rounded-r-md text-sm focus:border-primary-500 focus:ring-primary-500"
                                                value="{{ old('mobile', $strippedNumber) }}" autocomplete="text"
                                                placeholder="Enter phone number" />
                                        </div>

                                        <div class="flex gap-4">
                                            <x-input-error :messages="$errors->get('country')" class="mt-2 w-1/3" />
                                            <x-input-error :messages="$errors->get('mobile')" class="mt-2 w-2/3" />
                                        </div>
                                    </div>

                                    <div>
                                        <x-input-label for="gender" :value="__('Gender')" />
                                        <x-select-input name="gender" :options="\App\Enums\Gender::options()" :selected="old('gender', $driver->user?->gender ?? '')"
                                            class="mt-1" />

                                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="address" :value="__('Address')" />
                                        <x-text-input id="address" class="mt-1 block w-full" type="text"
                                            name="address" autofocus autocomplete="address" :value="old('address', $driver->user?->address ?? '')" />

                                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="service_id" :value="__('Service Name')" />
                                        <x-select-input name="service_id" :options="$services" :selected="old('service_id', $driver->service_id ?? '')"
                                            class="w-full p-2 mt-1" />

                                        <x-input-error :messages="$errors->get('vehicle_color_id')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="vehicle_id" :value="__('Vehicle Model')" />
                                        <x-select-input name="vehicle_id" :options="$vehicleModels" :selected="old('vehicle_id', $driver->vehicle_id ?? '')"
                                            class="w-full p-2 mt-1" />

                                        <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="vehicle_color_id" :value="__('Vehicle Color')" />
                                        <x-select-input name="vehicle_color_id" :options="$vehicleColors" :selected="old('vehicle_color_id', $driver->vehicle_color_id ?? '')"
                                            class="w-full p-2 mt-1" />

                                        <x-input-error :messages="$errors->get('vehicle_color_id')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="name" :value="__('Vehicle Production Year')" />
                                        <x-text-input id="vehicle_production_year" class="mt-1 block w-full"
                                            type="number" name="vehicle_production_year" autofocus
                                            autocomplete="vehicle_production_year" :value="old(
                                                'vehicle_production_year',
                                                $driver->vehicle_production_year ?? '',
                                            )" />

                                        <x-input-error :messages="$errors->get('vehicle_production_year')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="vehicle_plate" :value="__('Vehicle Plate Number')" />
                                        <x-text-input id="vehicle_plate" class="mt-1 block w-full" type="text"
                                            name="vehicle_plate" autofocus autocomplete="vehicle_plate"
                                            :value="old('vehicle_plate', $driver->vehicle_plate ?? '')" />

                                        <x-input-error :messages="$errors->get('vehicle_plate')" class="mt-2" />
                                    </div>
                                    {{-- <div>
                                        <x-input-label for="fleet_id" :value="__('Fleet')" />
                                        <x-select-input name="fleet_id" :options="$fleets" :selected="old('fleet_id', $driver->fleet_id ?? '')"
                                            class="w-full p-2 mt-1" />

                                        <x-input-error :messages="$errors->get('fleet_id')" class="mt-2" />
                                    </div> --}}
                                    <div>
                                        <x-input-label for="account_number" :value="__('Account Number')" />
                                        <x-text-input id="account_number" class="mt-1 block w-full" type="text"
                                            name="account_number" autofocus autocomplete="account_number"
                                            :value="old('account_number', $driver->account_number ?? '')" />

                                        <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="bank_name" :value="__('Bank Name')" />
                                        <x-text-input id="bank_name" class="mt-1 block w-full" type="text"
                                            name="bank_name" autofocus autocomplete="bank_name" :value="old('bank_name', $driver->bank_name ?? '')" />

                                        <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="bank_routing_number" :value="__('Bank Routing Number')" />
                                        <x-text-input id="bank_routing_number" class="mt-1 block w-full"
                                            type="text" name="bank_routing_number" autofocus
                                            autocomplete="bank_routing_number" :value="old('bank_routing_number', $driver->bank_routing_number ?? '')" />

                                        <x-input-error :messages="$errors->get('bank_routing_number')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="bank_swift" :value="__('Bank Swift')" />
                                        <x-text-input id="bank_swift" class="mt-1 block w-full" type="text"
                                            name="bank_swift" autofocus autocomplete="bank_swift"
                                            :value="old('bank_swift', $driver->bank_swift ?? '')" />

                                        <x-input-error :messages="$errors->get('bank_swift')" class="mt-2" />
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

                    <div class="mt-4 overflow-x-auto overflow-y-hidden border-none">
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
                                                        {{-- <div
                                                                class="mr-2 h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400">
                                                            </div> --}}
                                                        <span
                                                            class="font-medium">{{ $order->status?->label() }}</span>
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
                                            <th class=" px-4 py-3 text-left">Date & Time</th>
                                            <th class=" px-4 py-3 text-left">Transaction Type
                                            </th>
                                            <th class=" px-4 py-3 text-left">Amount</th>
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
                    <div class=" mt-6 rounded-lg border border-gray-200">
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
                    <div class=" mt-6 rounded-lg border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <h5 class="text-lg font-semibold text-gray-800">
                                    Insert Transaction
                                </h5>
                            </div>
                            <div class="mt-4 overflow-x-auto">
                                <form method="POST" action="{{ route('drivers.transaction') }}">
                                    @csrf
                                    <div class="mb-4 grid grid-cols-2 gap-8">
                                        <div>
                                            @php
                                                $options = array_merge(
                                                    [['value' => 'debit', 'name' => 'Deduct']],
                                                    [['value' => 'credit', 'name' => 'Recharge']],
                                                );
                                            @endphp
                                            <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                                            <x-input-label for="type" :value="__('Type')" />
                                            <x-select-input name="type" :options="$options" :selected="old('type', '')"
                                                class="mt-1 ms-1" />

                                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="type" :value="__('Amount')" />
                                            <x-text-input id="amount" class="mt-1 block w-full" type="text"
                                                name="amount" required autofocus autocomplete="type"
                                                value="{{ $driver->user->amount ?? '' }}" />

                                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                        </div>


                                    </div>
                                    <div class="flex justify-start">
                                        <x-primary-button class="w-auto">
                                            {{ __('Submit') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="reviews-section" style="display: none;">
                    <div class=" mt-4 rounded-lg">
                        <div class="">

                            <div class="mt-4 overflow-x-auto">
                                <table class="w-100">
                                    <thead class="text-nowrap">
                                        <tr class="text-sm font-medium uppercase tp-summary-header-title-blue ">
                                            <th class="px-4 py-3 text-left">Date & Time</th>
                                            <th class="px-4 py-3 text-left">Rating</th>
                                            <th class="px-4 py-3 text-left">Review</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm text-gray-700">
                                        @if ($ratings->isNotEmpty())
                                            @foreach ($ratings as $rating)
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="px-4 py-3">{{ $rating->created_at }}
                                                    </td>
                                                    <td class="px-4 py-3">{{ $rating->rating }}</td>
                                                    <td class="px-4 py-3">{{ $rating->comment }}</td>
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

                <div id="documents-section" style="display: none;">
                    <div class=" mt-8 rounded-xl">

                        <form method="POST" action="{{ route('drivers.update.documents', $driver->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-4 gap-5 pe-2">

                                @php
                                    $documentTypes = [
                                        'profile_picture' => 'Profile Picture',
                                        'nid' => 'NID Picture',
                                        'license' => 'License Picture',
                                        'vehicle_paper' => 'Vehicle Picture',
                                    ];

                                    $documentsByType = $driver->user->documents->keyBy('type');

                                    $missingDocuments = [];

                                    foreach ($documentTypes as $key => $label) {
                                        if (!isset($documentsByType[$key])) {
                                            $missingDocuments[] = $key;
                                        }
                                    }
                                @endphp

                                @foreach ($documentTypes as $type => $label)
                                    <div class="relative mb-2 w-full">
                                        <span class="block mb-2 font-semibold">{{ $label }}</span>

                                        @if ($documentsByType->has($type))
                                            @php $document = $documentsByType->get($type); @endphp
                                            <div
                                                class="relative w-auto h-40 flex justify-center items-center border border-dashed border-gray-500">
                                                <img src="{{ asset('storage/' . $document->path) }}"
                                                    alt="{{ $label }}" class=" object-cover w-full h-full" />
                                            </div>
                                        @else
                                            <div class="relative w-100">

                                                <div x-data="{ imagePreview: null }" @click="$refs.image.click()"
                                                    class=" ant-upload ant-upload-select-picture-card flex flex-col justify-center items-center cursor-pointer relative h-40 w-100">

                                                    <!-- Hidden File Input -->
                                                    <input id="image" name="{{ $type }}" type="file"
                                                        class="hidden" accept="image/*" x-ref="image"
                                                        @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }" />

                                                    <!-- Show image preview if new file is selected -->
                                                    <template x-if="imagePreview">
                                                        <div class=" mt-4 relative inline-block"
                                                            style="height: 10rem;">
                                                            <img :src="imagePreview" alt="Image Preview"
                                                                class=" object-cover w-full h-full" />

                                                        </div>
                                                    </template>


                                                    <!-- Show existing image if no new file selected -->
                                                    <template x-if="!imagePreview">
                                                        <div class=" z-10 text-black object-cover absolute flex items-center justify-center"
                                                            style="height: 10rem; width:100%; border: 1px dashed #434343;">
                                                            <div>
                                                                <div class="flex items-center justify-center mb-2">
                                                                    <svg class="svg-icon"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" width="24"
                                                                        height="24">
                                                                        <g id="Layer_53" data-name="Layer 53">
                                                                            <path
                                                                                d="M22,9.25a.76.76,0,0,0-.75.75v6l-4.18-4.78a2.84,2.84,0,0,0-4.14,0L10.06,14.5l-.94-1.14a2.76,2.76,0,0,0-4.24,0L2.75,15.93V6A3.26,3.26,0,0,1,6,2.75h8a.75.75,0,0,0,0-1.5H6A4.75,4.75,0,0,0,1.25,6V18a.09.09,0,0,0,0,.05v0A4.75,4.75,0,0,0,6,22.75H18a4.75,4.75,0,0,0,4.74-4.68s0,0,0,0V10A.76.76,0,0,0,22,9.25Zm-4,12H6a3.25,3.25,0,0,1-3.23-3L6,14.32a1.29,1.29,0,0,1,1.92,0l1.51,1.82a.74.74,0,0,0,.57.27.86.86,0,0,0,.57-.26l3.44-3.94a1.31,1.31,0,0,1,1.9,0l5.27,6A3.24,3.24,0,0,1,18,21.25Z" />
                                                                            <path
                                                                                d="M4.25,7A2.75,2.75,0,1,0,7,4.25,2.75,2.75,0,0,0,4.25,7Zm4,0A1.25,1.25,0,1,1,7,5.75,1.25,1.25,0,0,1,8.25,7Z" />
                                                                            <path
                                                                                d="M16,5.75h2.25V8a.75.75,0,0,0,1.5,0V5.75H22a.75.75,0,0,0,0-1.5H19.75V2a.75.75,0,0,0-1.5,0V4.25H16a.75.75,0,0,0,0,1.5Z" />
                                                                        </g>
                                                                    </svg>

                                                                </div>
                                                                <div class="text-md"><span>Select your profile
                                                                        image</span></div>
                                                            </div>
                                                        </div>

                                                    </template>
                                                </div>
                                                <x-input-error :messages="$errors->get('image')" class="mt-2 text-red-600 text-sm" />
                                            </div>
                                        @endif
                                    </div>
                                @endforeach


                            </div>
                            @if (count($missingDocuments) > 0)
                                <div class="flex justify-start">
                                    <x-primary-button class="w-auto">
                                        {{ __('Save') }}
                                    </x-primary-button>
                                </div>
                            @endif
                        </form>
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
        const buttons = document.querySelectorAll(".driver-button");
        const sections = ["details-section", "orders-section", "credits-section", "reviews-section",
            "documents-section"
        ];
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
