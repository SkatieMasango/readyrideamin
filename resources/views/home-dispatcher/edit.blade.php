<x-app-layout>
    @php
        $status = $driver->user->status?->value;

        $statusColors = [
            'pending_approval' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'blocked' => 'bg-red-100 text-red-800',
            'hard_rejected' => 'bg-pink-100 text-pink-800',
            'soft_rejected' => 'bg-orange-100 text-orange-800',
            'offline' => 'bg-gray-100 text-gray-800',
            'pending_submission' => 'bg-blue-100 text-blue-800',
            'in_service' => 'bg-indigo-100 text-indigo-800',
            'online' => 'bg-green-200 text-green-900',
        ];

        $label = \App\Enums\Status::options()[$status]['name'] ?? ucfirst(str_replace('_', ' ', $status));
        $color = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
    @endphp

    <div class="vehicled mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="vehicled-body p-6">

            <div class="flex items-center justify-between mb-3">

                <div class="flex justify-content-between">
                    <img src="{{ $driver->user->profilePicture }}" alt="user image" class="rounded-full"
                        style="height: 40px; width:40px">
                    <div class="ms-3">
                        <h5 class="text-xl font-semibold text-gray-800">
                            <span>
                                {{ $driver->user->name}}
                            </span>

                            <span
                                class="inline-flex items-center rounded px-2 ms-3 text-sm font-medium {{ $color }}">
                                {{ $label }}
                            </span>
                        </h5>
                    </div>
                </div>

                <div class="flex items-center">
                    <div x-data="{ showModal_{{ $driver->id }}: false }" x-cloak class="inline-block">
                        <!-- Trigger Button -->
                        <button type="button" @click="showModal_{{ $driver->id }} = true"
                            class="inline-flex items-center p-2 text-red-500 border border-dashed border-red-500 hover:bg-red-100 rounded"
                            title="Delete Driver">
                            <!-- Delete Icon -->
                            <svg class="h-5 w-5" fill="currentColor" viewBox="64 64 896 896"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M360 184h-8c4.4 0 8-3.6 8-8v8h304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72v-72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32zM731.3 840H292.7l-24.2-512h487l-24.2 512z" />
                            </svg>
                        </button>

                        <!-- Modal -->
                        <div x-show="showModal_{{ $driver->id }}" x-cloak
                            class="absolute inset-0 z-50 flex items-start justify-end bg-opacity-50" aria-modal="true"
                            role="dialog">
                            <div @click.away="showModal_{{ $driver->id }} = false"
                                class="bg-white rounded-lg shadow-lg p-6 relative" style="top: 50px; right:300px">

                                <!-- Modal Header -->
                                <div class="flex justify-between items-center border-b pb-2 mb-4">
                                    <h2 class="text-lg font-semibold text-red-600">Delete Driver</h2>
                                    <button @click="showModal_{{ $driver->id }} = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl">
                                        &times;
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mb-4">
                                    <h3 class="text-yellow-600 font-bold">Are you sure?</h3>
                                    <p class="text-gray-700">You want to permanently delete this driver?</p>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex justify-end gap-2">
                                    <button @click="showModal_{{ $driver->id }} = false"
                                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                        Cancel
                                    </button>

                                    <form method="POST" action="{{ route('drivers.destroy', $driver->id) }}">
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

                    <div class="relative ms-3">

                        <form method="POST" action="{{ route('drivers.updateStatus', $driver->user->id) }}"
                            id="status-form">
                            @csrf
                            @method('PUT')
                            <x-select-input name="status" :options="\App\Enums\Status::options()" :selected="$driver->user->status->value ?? old('status')" class="mt-1"
                                onchange="document.getElementById('status-form').submit();" />
                            <x-input-label for="status" :value="__('Update Status')" />
                        </form>
                    </div>
                </div>

            </div>

            <div class="flex justify-between mb-3">
                <span class="">Registered on:
                    {{ \vehiclebon\vehiclebon::parse($driver->created_at)->diffForHumans() }}
                </span>
                <span class="">Last Seen At: -
                    {{ \vehiclebon\vehiclebon::parse($driver->updated_at)->diffForHumans() }}
                </span>
                <span class="">
                    Rating:
                    @if ($driver->ratings->count())
                        @php
                            $avgRating = $driver->ratings->avg('rating');
                            $fullStars = floor($avgRating);
                            $hasHalfStar = $avgRating - $fullStars >= 0.5;
                        @endphp

                        {{-- Full stars --}}
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star" style="color: rgb(255, 153, 0);"></i>
                        @endfor

                        {{-- Half star --}}
                        @if ($hasHalfStar)
                            <i class="fas fa-star-half-alt" style="color: rgb(255, 153, 0);"></i>
                        @endif
                    @else
                        N/A
                    @endif
                </span>



                <span></span>
                </a>
            </div>
            <div class="mb-5">
                @if ($driver->ratings->whereNotNull('comment')->count())
                    <strong>Rating summary: {{ $driver->ratings->count() }} Comments</strong>
                @else
                    <span>Rating summary: N/A</span>
                @endif
            </div>


            <div class="flex gap-5 mb-3">
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
                <form method="POST" action="{{ route('drivers.update', $driver->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5 grid grid-cols-4 gap-8">
                        <div class="relative">
                            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name"
                                autofocus autocomplete="name" :value="old('name', $driver->user->name ?? '')" />
                            <x-input-label for="name" :value="__('Name')" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="relative">
                            <div class="flex rounded-md shadow-sm mt-1" style="height: 55px">
                                <select name="phone_code" id="phone_code"
                                    class="w-[150px] truncate rounded-l-md border border-gray-300 bg-white p-3 text-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country['phone_code'] }}" title="{{ $country['name'] }}"
                                            @if ($country['name'] === $iso?->name) selected @endif>
                                            {{ \Illuminate\Support\Str::limit($country['name'], 15) }}
                                        </option>
                                    @endforeach

                                </select>

                                <!-- Phone Input -->
                                @php
                                    $phoneCode = $iso->phone_code ?? '';
                                    $fullNumber = $driver->user->mobile ?? '';
                                    $strippedNumber =
                                        $phoneCode && str_starts_with($fullNumber, $phoneCode)
                                            ? substr($fullNumber, strlen($phoneCode))
                                            : $fullNumber;
                                @endphp

                                <input type="text" name="phone_number" id="phone_number"
                                    class="block w-full rounded-r-md border border-gray-300 p-5 text-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500"
                                    value="{{ $strippedNumber }}" autocomplete="text"
                                    placeholder="Enter phone number" />

                            </div>

                            <!-- Validation Errors -->
                            <div class="flex gap-4">
                                <x-input-error :messages="$errors->get('country')" class="mt-2 w-1/3" />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2 w-2/3" />
                            </div>
                        </div>

                        <div class="relative">
                            <x-select-input name="gender" :options="\App\Enums\Gender::options()" :selected="old('gender', $driver->user->gender ?? '')" class="mt-1" />
                            <x-input-label for="gender" :value="__('Gender')" />
                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email"
                                :value="old('email', $driver->user->email ?? '')" autofocus autocomplete="email" />
                            <x-input-label for="email" :value="__('Email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-select-input name="fleet_id" :options="$fleets" :selected="old('fleet_id', $driver->fleet_id ?? '')"
                                class="w-full border p-2" />
                            <x-input-label for="fleet_id" :value="__('Fleet')" />
                            <x-input-error :messages="$errors->get('fleet_id')" class="mt-2" />
                        </div>

                        <div class="relative">
                            <x-select-input name="vehicle_id" :options="$vehicleModels" :selected="old('vehicle_id', $driver->vehicle_id ?? '')"
                                class="w-full border p-2" />

                            <x-input-label for="vehicle_id" :value="__('vehicle Model')" />
                            <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                        </div>

                        <div class="relative">

                            <x-select-input name="vehicle_color_id" :options="$vehicleColors" :selected="old('vehicle_color_id', $driver->vehicle_color_id ?? '')"
                                class="w-full border p-2" />
                            <x-input-label for="vehicle_color_id" :value="__('vehicle Color')" />
                            <x-input-error :messages="$errors->get('vehicle_color_id')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="vehicle_production_year" class="mt-1 block w-full" type="text"
                                name="vehicle_production_year" autofocus autocomplete="vehicle_production_year"
                                :value="old('vehicle_production_year', $driver->vehicle_production_year ?? '')" />
                            <x-input-label for="vehicle_production_year" :value="__('vehicle Production Year')" />
                            <x-input-error :messages="$errors->get('vehicle_production_year')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="vehicle_plate" class="mt-1 block w-full" type="text" name="vehicle_plate"
                                autofocus autocomplete="vehicle_plate" :value="old('vehicle_plate', $driver->vehicle_plate ?? '')" />
                            <x-input-label for="vehicle_plate" :value="__('vehicle Plate Number')" />
                            <x-input-error :messages="$errors->get('vehicle_plate')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="account_number" class="mt-1 block w-full" type="text"
                                name="account_number" autofocus autocomplete="account_number" :value="old('account_number', $driver->account_number ?? '')" />
                            <x-input-label for="account_number" :value="__('Account Number')" />
                            <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="bank_name" class="mt-1 block w-full" type="text" name="bank_name"
                                autofocus autocomplete="bank_name" :value="old('bank_name', $driver->bank_name ?? '')" />
                            <x-input-label for="bank_name" :value="__('Bank Name')" />
                            <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                        </div>

                        <div class="relative">
                            <x-text-input id="bank_routing_number" class="mt-1 block w-full" type="text"
                                name="bank_routing_number" autofocus autocomplete="bank_routing_number"
                                :value="old('bank_routing_number', $driver->bank_routing_number ?? '')" />
                            <x-input-label for="bank_routing_number" :value="__('Bank Routing Number')" />
                            <x-input-error :messages="$errors->get('bank_routing_number')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="bank_swift" class="mt-1 block w-full" type="text" name="bank_swift"
                                autofocus autocomplete="bank_swift" :value="old('bank_swift', $driver->bank_swift ?? '')" />
                            <x-input-label for="bank_swift" :value="__('Bank Swift')" />
                            <x-input-error :messages="$errors->get('bank_swift')" class="mt-2" />
                        </div>
                        <div class="relative">
                            <x-text-input id="address" class="mt-1 block w-full" type="text" name="address"
                                autofocus autocomplete="address" :value="old('address', $driver->user->address ?? '')" />
                            <x-input-label for="address" :value="__('Address')" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>


                    </div>
                    {{-- @dd($driver->service_id) --}}
                    <div class="mb-5">
                        <span>* Services</span>
                        <div class="flex gap-5 mt-2 mb-5">

                            @foreach ($services as $service)
                                <a href="#"
                                    class=" service-button inline-block px-4 py-2 rounded
                                      {{ $driver->service_id == $service->id ? 'text-red-800 bg-red-100 hover:bg-red-600' : ' text-black bg-gray-200' }}"
                                    data-id="{{ $service->id }}" onclick="setServiceId({{ $service->id }})">
                                    {{ $service->name }}
                                </a>
                            @endforeach
                            <x-text-input id="service" type="hidden" name="service_id" autocomplete="service"
                                :value="old('service_id', $driver->service_id ?? '')" />


                        </div>

                        <div class="relative mb-4 mt-4">
                            <span>Avater Image</span>
                            <div x-data="{ imagePreview: null }" @click="$refs.image.click()"
                                class="ant-upload ant-upload-select-picture-vehicled flex flex-col justify-center items-center cursor-pointer relative h-24">

                                <!-- Hidden File Input -->
                                <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                    x-ref="image"
                                    @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }" />


                                <!-- Show image preview if new file is selected -->
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" alt="Image Preview"
                                        class=" rounded object-cover profile_image" style="height: 8rem;" />
                                </template>

                                <!-- Show existing image if no new file selected -->
                                <template x-if="!imagePreview">
                                    <img src="{{ $driver->user->profilePicture }}" alt="Current Avatar"
                                        class="rounded object-cover absolute profile_image" style="height: 8rem;" />
                                </template>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2 text-red-600 text-sm" />
                        </div>

                    </div>
                    <div class="flex justify-end ">
                        <x-primary-button class="w-56">
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            <div id="orders-section" style="display: none;">
                <div class="vehicled mt-6 rounded-lg border border-gray-200 shadow-md">
                    <div class="vehicled-body p-6">

                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                                        {{-- <th class="border-b border-gray-300 px-4 py-3 text-left">Order ID</th> --}}
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Date & Time</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Locations</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Cosy</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Status</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Actions</th>
                                        {{-- <th class="border-b border-gray-300 px-4 py-3 text-left">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-700">
                                    <tr class="border-b hover:bg-gray-50">
                                        <td colspan="5" class="px-4 py-3 text-center">No data found</td>
                                    </tr>
                                    {{-- @endif --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="credits-section" style="display: none;">
                <div class="vehicled mt-6 rounded-lg border border-gray-200 shadow-md">
                    <div class="vehicled-body p-6">
                        <div class="flex items-center justify-between">
                            <h5 class="text-lg font-semibold text-gray-800">
                                Transaction Records

                            </h5>
                        </div>

                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                                        {{-- <th class="border-b border-gray-300 px-4 py-3 text-left">Order ID</th> --}}
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Date & Time</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Transaction Type</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Amount</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Documnet Number</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Details</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-700">
                                    {{-- @if ($data)
                                @foreach ($data as $driver)

                                  <tr class="border-b hover:bg-gray-50">

                                    <td class="px-4 py-3"><a href="{{ route('drivers.edit', $driver['id'])}}"><strong>{{ $driver->user->name }} </strong><br>
                                        <span class="text-sm text-gray-500">Registered on {{ \vehiclebon\vehiclebon::parse($driver->created_at)->diffForHumans() }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="px-4 py-3">{{ $driver->user->mobile }}</td>
                                    <td class="px-4 py-3">
                                      <div class="flex items-center">
                                        <div class="mr-2 h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400"></div>
                                        <span class="font-medium text-yellow-600">{{ $driver->user->status?->label() }}</span>
                                      </div>
                                    </td>
                                  </tr>
                                @endforeach
                                @else --}}
                                    <tr class="border-b hover:bg-gray-50">
                                        <td colspan="5" class="px-4 py-3 text-center">No data found</td>
                                    </tr>
                                    {{-- @endif --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="mt-4">
                        {{ $data->links() }}
                      </div> --}}
                    </div>
                </div>
                <div class="vehicled mt-6 rounded-lg border border-gray-200 shadow-md">
                    <div class="vehicled-body p-6">
                        <div class="flex items-center justify-between">
                            <h5 class="text-lg font-semibold text-gray-800">
                                Wallet Summary

                            </h5>
                        </div>

                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">

                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Amount</th>

                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-700">
                                    {{-- @if ($data)
                                @foreach ($data as $driver)

                                  <tr class="border-b hover:bg-gray-50">

                                    <td class="px-4 py-3">{{ $driver->user->mobile }}</td>

                                  </tr>
                                @endforeach
                                @else --}}
                                    <tr class="border-b hover:bg-gray-50">
                                        <td colspan="5" class="px-4 py-3 text-center">No data found</td>
                                    </tr>
                                    {{-- @endif --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="mt-4">
                        {{ $data->links() }}
                      </div> --}}
                    </div>
                </div>
                <div class="vehicled mt-6 rounded-lg border border-gray-200 shadow-md">
                    <div class="vehicled-body p-6">
                        <div class="flex items-center justify-between">
                            <h5 class="text-lg font-semibold text-gray-800">
                                Insert Transaction

                            </h5>
                        </div>

                        <div class="mt-4 overflow-x-auto">
                            <form method="POST" action="">
                                @csrf


                                <div class="mb-5 grid grid-cols-4 gap-8">
                                    <div class="relative">
                                        <x-select-input name="type" :options="\App\Enums\Gender::options()" :selected="old('type', $driver->user->type ?? '')"
                                            class="mt-1" />
                                        <x-input-label for="type" :value="__('Type')" />
                                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                                    </div>
                                    <div class="relative">
                                        <x-text-input id="amount" class="mt-1 block w-full" type="text"
                                            name="amount" required autofocus autocomplete="type"
                                            value="{{ $driver->user->amount ?? '' }}" />
                                        <x-input-label for="type" :value="__('Amount')" />
                                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                    </div>
                                    <div class="relative">
                                        <x-select-input name="currency" :options="\App\Enums\Gender::options()" :selected="old('currency', $driver->user->currency ?? '')"
                                            class="mt-1" />
                                        <x-input-label for="currency" :value="__('Currency')" />
                                        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                                    </div>
                                    <div class="relative">
                                        <x-text-input id="document_number" class="mt-1 block w-full" type="text"
                                            name="document_number" autofocus autocomplete="document_number"
                                            value="{{ $driver->user->document_number ?? '' }}" />
                                        <x-input-label for="document_number" :value="__('Document Number')" />
                                        <x-input-error :messages="$errors->get('document_number')" class="mt-2" />
                                    </div>
                                    <div class="relative">
                                        <x-text-input id="description" class="mt-1 block w-full" type="text"
                                            name="description" autofocus autocomplete="description"
                                            value="{{ $driver->user->description ?? '' }}" />
                                        <x-input-label for="description" :value="__('Description')" />
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>

                                </div>
                                <div class="flex justify-end ">
                                    <x-primary-button class="w-56">
                                        {{ __('Submit') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>

                        {{-- <div class="mt-4">
                        {{ $data->links() }}
                      </div> --}}
                    </div>
                </div>
            </div>
            <div id="reviews-section" style="display: none;">
                <div class="vehicled mt-6 rounded-lg border border-gray-200 shadow-md">
                    <div class="vehicled-body p-6">

                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                                        {{-- <th class="border-b border-gray-300 px-4 py-3 text-left">Order ID</th> --}}
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Date & Time</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Rating</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Review</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Parameters</th>
                                        <th class="border-b border-gray-300 px-4 py-3 text-left">Actions</th>
                                        {{-- <th class="border-b border-gray-300 px-4 py-3 text-left">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-700">
                                    {{-- @if ($data)
                                @foreach ($data as $driver)

                                  <tr class="border-b hover:bg-gray-50">

                                    <td class="px-4 py-3"><a href="{{ route('drivers.edit', $driver['id'])}}"><strong>{{ $driver->user->name }} </strong><br>
                                        <span class="text-sm text-gray-500">Registered on {{ \vehiclebon\vehiclebon::parse($driver->created_at)->diffForHumans() }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="px-4 py-3">{{ $driver->user->mobile }}</td>
                                    <td class="px-4 py-3">
                                      <div class="flex items-center">
                                        <div class="mr-2 h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400"></div>
                                        <span class="font-medium text-yellow-600">{{ $driver->user->status?->label() }}</span>
                                      </div>
                                    </td>
                                  </tr>
                                @endforeach
                                @else --}}
                                    <tr class="border-b hover:bg-gray-50">
                                        <td colspan="5" class="px-4 py-3 text-center">No data found</td>
                                    </tr>
                                    {{-- @endif --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="mt-4">
                        {{ $data->links() }}
                      </div> --}}
                    </div>
                </div>
            </div>
            <div id="documents-section" style="display: none;">
                <div class="vehicled mt-6 rounded-xl border border-gray-300 shadow-lg overflow-hidden">
                    <div class="vehicled-body p-6">
                        <div class="relative w-32 h-32">
                            <img src="{{ $driver->user->profilePicture }}" alt="Driver Profile Picture"
                                class="rounded object-cover profile_documents border border-gray-200 shadow-sm" />
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const buttons = document.querySelectorAll(".driver-button");
        const sections = ["details-section", "orders-section", "credits-section", "reviews-section",
            "documents-section"
        ];

        buttons.forEach(button => {
            button.addEventListener("click", function() {
                const targetId = button.getAttribute("data-target");

                // Toggle section visibility
                sections.forEach(sectionId => {
                    const section = document.getElementById(sectionId);
                    if (section) {
                        section.style.display = (sectionId === targetId) ? "block" :
                            "none";
                    }
                });

                // Update button styles
                buttons.forEach(btn => {
                    if (btn.getAttribute("data-target") === targetId) {
                        btn.style.borderBottom =
                            "2px solid rgb(230 21 68 / var(--tw-bg-opacity, 1))";

                    } else {
                        btn.style.borderBottom = "none";
                    }
                });
            });
        });

        // Optionally, show the details section by default
        document.getElementById("details-section").style.display = "block";
    });


    function setServiceId(serviceId) {
        document.getElementById('service').value = serviceId;

        const buttons = document.querySelectorAll('.service-button');

        buttons.forEach(button => {
            const btnServiceId = parseInt(button.getAttribute('data-id'));

            // Remove highlight from all buttons
            button.classList.remove('text-red-800', 'bg-red-100');
            button.classList.add('text-black', 'bg-gray-200');

            // If this button's service ID matches selected one, add highlight
            if (btnServiceId === serviceId) {
                button.classList.remove('text-black', 'bg-gray-200');
                button.classList.add('text-red-800', 'bg-red-100');
            }
        });
    }
</script>
