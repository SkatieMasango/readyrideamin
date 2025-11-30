<style>
    .one {
        background-color: rgb(230 21 68 / var(--tw-bg-opacity, 1));
        border: none;
        color: #fff !important;
    }
</style>
<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between gap-8 p-4 text-sm text-gray-300">
                <!-- Step 1 -->
                <div class="flex items-start gap-2">
                    <div class="step-circle one flex items-center justify-center w-8 h-8 border border-gray-400 text-black rounded-full text-xm font-bold"
                        data-step="1">
                        1
                    </div>
                    <div>
                        <strong class="text-black">Rider</strong>
                        <div class="text-black text-xm">Select rider to assign request</div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="flex-grow h-px bg-gray-600"></div>

                <!-- Step 2 -->
                <div class="flex items-start gap-2">
                    <div class="step-circle flex items-center justify-center w-8 h-8 border border-gray-400 text-black rounded-full text-xm font-bold"
                        data-step="2">
                        2
                    </div>
                    <div>
                        <strong class="text-black">Location</strong>
                        <div class="text-black text-xm">Pickup & Drop-off location(s)</div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="flex-grow h-px bg-gray-600"></div>

                <!-- Step 3 -->
                <div class="flex items-start gap-2">
                    <div class=" step-circle flex items-center justify-center w-8 h-8 border border-gray-400 text-black rounded-full text-xm font-bold"
                        data-step="3">
                        3
                    </div>
                    <div>
                        <strong class="text-black">Service</strong>
                        <div class="text-black text-xm">Service to be requested</div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="flex-grow h-px bg-gray-600"></div>

                <!-- Step 4 -->
                <div class="flex items-start gap-2">
                    <div class="step-circle flex items-center justify-center w-8 h-8 border border-gray-400 text-black rounded-full text-xm font-bold"
                        data-step="4">
                        4
                    </div>
                    <div>
                        <strong class="text-black">Looking</strong>
                        <div class="text-black text-xm">Searching for eligible driver</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('dashboard.home-dispatcher.store') }}" id="service-form">
                @csrf
                <div class="mt-4 overflow-x-auto" id="rider">
                    <table class="min-w-full table-auto border-collapse rounded-lg border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-sm font-medium uppercase text-gray-600">
                                <th class="border-b border-gray-300 px-4 py-3 text-left">Name</th>
                                <th class="border-b border-gray-300 px-4 py-3 text-left">Mobile</th>
                                <th class="border-b border-gray-300 px-4 py-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @foreach ($riders as $rider)
                                <tr class="border-b hover:bg-gray-50">

                                    <td class="px-4 py-3">
                                        <a href="#" class="driver-edit-link"
                                            data-user-id="{{ $rider->user->id }}">
                                            <strong>{{ $rider->user->name }}</strong><br>
                                            <span class="text-sm text-gray-500">
                                                Registered on
                                                {{ \Carbon\Carbon::parse($rider->created_at)->diffForHumans() }}
                                            </span>
                                        </a>
                                    </td>

                                    <td class="px-4 py-3">{{ $rider->user->mobile }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="mr-2 h-2.5 w-2.5 animate-pulse rounded-full bg-yellow-400">
                                            </div>
                                            <span
                                                class="font-medium text-yellow-600">{{ $rider->user->status?->label() }}</span>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 overflow-x-auto" id="location" style="display: none">
                    <div class="relative mb-4">
                        <x-text-input id="title" class="mt-1 block w-full" type="text" name="title" autofocus
                            autocomplete="title" value="{{ old('title') }}" />
                        <x-input-label for="title" :value="__('Title')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Map Container -->
                    <div id="map" class="mb-4 h-96 w-full"></div>

                    <!-- Selected Location -->
                    <div id="selected-location" class="mt-3 text-sm text-gray-700"></div>

                    <!-- Pickup -->
                    <input type="hidden" name="pickup_location[]" id="pickup-location-lat">
                    <input type="hidden" name="pickup_location[]" id="pickup-location-lon">
                    <input type="hidden" name="pickup_address" id="pickup-address">

                    <!-- Drop -->
                    <input type="hidden" name="drop_location[]" id="drop-location-lat">
                    <input type="hidden" name="drop_location[]" id="drop-location-lon">
                    <input type="hidden" name="drop_address" id="drop-address">

                    <!-- Wait -->
                    <input type="hidden" name="wait_location[]" id="wait-location-lat">
                    <input type="hidden" name="wait_location[]" id="wait-location-lon">
                    <input type="hidden" name="wait_address" id="wait-address">

                    <!-- Other required fields -->
                    <input type="hidden" name="service_id" id="hidden-service-id">
                    <input type="hidden" name="payment_mode" value="cash">


                    <input type="hidden" name="user_id" id="user-id">

                    <!-- Buttons -->
                    <div class="flex items-center gap-4 mt-4">
                        <button id="remove-point" type="button"
                            class="px-4 py-2 border border-primary-500 text-primary-500 rounded hover:bg-red-700">
                            Remove Last Point
                        </button>
                        <button id="next-step" type="button"
                            class="px-4 py-2 bg-primary-500 text-white rounded hover:bg-blue-700">
                            Next
                        </button>
                    </div>
                </div>
                <div class="mt-4 overflow-x-auto" id="service" style="display: none; margin-left:20px">
                    <div class="mb-6 text-lg font-semibold text-gray-700">Select a Service</div>

                    <div id="service-container" class="grid grid-cols-4 gap-8  mt-6"></div>


                </div>


            </form>
            <div class="mt-4">

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const driverLinks = document.querySelectorAll('.driver-edit-link');

        driverLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const userId = this.getAttribute('data-user-id');
                document.getElementById('user-id').value = userId;

                // Show the location section
                const locationDiv = document.getElementById('location');
                if (locationDiv) {
                    locationDiv.style.display = 'block';
                }

                // Hide the rider section
                const riderDiv = document.getElementById('rider');
                if (riderDiv) {
                    riderDiv.style.display = 'none';
                }

                // Optional: scroll to the map section
                locationDiv.scrollIntoView({
                    behavior: 'smooth'
                });


                document.querySelectorAll('.step-circle').forEach(circle => {
                    circle.classList.remove('one');
                });

                // Add 'one' class to step 2
                const step2 = document.querySelector('.step-circle[data-step="2"]');
                if (step2) {
                    step2.classList.add('one');
                }

                // Optionally follow the link
                window.location.href = link.href;
            });
        });
    });
</script>

<script>
    let map;
    let markers = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize map
        map = L.map('map').setView([23.8103, 90.4125], 13); // Dhaka
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add marker on click
        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
            const marker = L.marker([lat, lng]).addTo(map);
            markers.push(marker);

            // Reverse geocode to get address
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    const locationDiv = document.getElementById('selected-location');
                    const newPoint = document.createElement('div');
                    newPoint.style.marginTop = '10px';

                    if (data && data.display_name) {
                        newPoint.innerText = `● ${data.display_name}`;
                    } else {
                        newPoint.innerText = `● Lat ${lat.toFixed(5)}, Lng ${lng.toFixed(5)}`;
                    }


                    locationDiv.appendChild(newPoint);
                })
                .catch(error => {
                    console.error('Error fetching location name:', error);
                });
        });

        // Remove last marker and address
        document.getElementById('remove-point').addEventListener('click', function() {
            const lastMarker = markers.pop();
            const locationDiv = document.getElementById('selected-location');
            if (lastMarker) {
                map.removeLayer(lastMarker);

                // Remove last address div
                if (locationDiv.lastElementChild) {
                    locationDiv.removeChild(locationDiv.lastElementChild);
                }
            }
        });


        document.getElementById('next-step').addEventListener('click', async function() {
            if (markers.length >= 2) {
                const first = markers[0].getLatLng(); // Pickup
                const last = markers[markers.length - 1].getLatLng(); // Drop

                // Set lat/lon values
                document.getElementById('pickup-location-lat').value = first.lat;
                document.getElementById('pickup-location-lon').value = first.lng;
                document.getElementById('drop-location-lat').value = last.lat;
                document.getElementById('drop-location-lon').value = last.lng;

                // Get pickup and drop addresses via reverse geocoding
                const pickupAddressRes = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${first.lat}&lon=${first.lng}`
                );
                const pickupAddressData = await pickupAddressRes.json();
                document.getElementById('pickup-address').value = pickupAddressData.display_name ||
                    '';

                const dropAddressRes = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${last.lat}&lon=${last.lng}`
                );
                const dropAddressData = await dropAddressRes.json();
                document.getElementById('drop-address').value = dropAddressData.display_name || '';

                // Wait location
                if (markers.length >= 3) {
                    const middleIndex = Math.floor(markers.length / 2);
                    const wait = markers[middleIndex].getLatLng();

                    document.getElementById('wait-location-lat').value = wait.lat;
                    document.getElementById('wait-location-lon').value = wait.lng;

                    const waitAddressRes = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${wait.lat}&lon=${wait.lng}`
                    );
                    const waitAddressData = await waitAddressRes.json();
                    document.getElementById('wait-address').value = waitAddressData.display_name ||
                        '';
                } else {
                    document.getElementById('wait-location-lat').value = '';
                    document.getElementById('wait-location-lon').value = '';
                    document.getElementById('wait-address').value = '';
                }

                // Show service selection step
                document.getElementById('location').style.display = 'none';
                document.getElementById('rider').style.display = 'none';
                document.getElementById('service').style.display = 'block';

                // Update step indicator
                document.querySelectorAll('.step-circle').forEach(circle => {
                    circle.classList.remove('one');
                });
                document.querySelector('.step-circle[data-step="3"]').classList.add('one');

                // Fetch services
                fetch(
                        `/home-dispatcher/fares?pickup_location[]=${first.lat}&pickup_location[]=${first.lng}&drop_location[]=${last.lat}&drop_location[]=${last.lng}`
                    )
                    .then(res => res.json())
                    .then(data => {
                        const serviceContainer = document.getElementById('service-container');
                        const selectedServiceInput = document.getElementById(
                            'hidden-service-id');
                        serviceContainer.innerHTML = '';


                        if (data.success && data.data && data.data.services.length > 0) {
                            data.data.services.forEach(service => {
                                const card = document.createElement('div');
                                card.className =
                                    'flex border p-4 rounded shadow hover:border-blue-500 cursor-pointer mb-3';
                                card.setAttribute('data-id', service.id);
                                card.innerHTML = `
                            <div class="flex items-center gap-3">
                                <img src="${service.logo}" class="w-12 h-12 object-contain" alt="${service.name}">
                                <div>
                                    <h4 class="font-bold">${service.name}</h4>
                                    <p class="text-sm text-gray-600">Capacity: ${service.person_capacity} person(s)</p>
                                    <p class="text-sm text-green-600">৳${service.total_fare}</p>
                                </div>
                            </div>
                        `;
                                serviceContainer.appendChild(card);

                                card.addEventListener('click', function() {
                                    document.querySelectorAll(
                                        '#service-container > div').forEach(
                                        c => {
                                            c.classList.remove('ring-2',
                                                'ring-blue-300');
                                        });

                                    this.classList.add('ring-2',
                                        'ring-blue-300');
                                    selectedServiceInput.value = this.dataset
                                        .id;
                                    // document.getElementById('service-form')
                                    //     .submit();


                                    const form = document.getElementById(
                                        'service-form');
                                    const formData = new FormData(form);

                                    fetch(form.action, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document
                                                    .querySelector(
                                                        'input[name="_token"]'
                                                    ).value,
                                            },
                                            body: formData,
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Notification Sent',
                                                    text: data
                                                        .message ||
                                                        'Form submitted successfully!',
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: data
                                                        .message ||
                                                        'Something went wrong!',
                                                });
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                        });

                                });
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'No Services Found',
                                text: data.message ||
                                    'No fare services could be calculated.',
                            });
                        }
                    })
                    .catch(err => {
                        console.error('Error fetching fares:', err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to fetch fare services.',
                        });
                    });
            } else {
                Swal.fire({
                    icon: 'warning',
                    text: 'Please select at least 2 points on the map (Pickup and Drop-off).',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            }
        });




    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Service selection (only one card active at a time)
        const serviceCards = document.querySelectorAll('.service-card');
        const selectedServiceInput = document.getElementById('selected-service-id');

        serviceCards.forEach(card => {
            card.addEventListener('click', function() {


                // Save selected service ID
                const serviceId = this.dataset.id;
                selectedServiceInput.value = serviceId;


                // Fetch available drivers
                fetch(`/home-dispatcher/drivers-by-service/${serviceId}`)
                    .then(response => response.json())
                    .then(drivers => {
                        const driverList = document.getElementById('driver-list');
                        driverList.innerHTML = ''; // clear existing

                        const locationDiv = document.getElementById('location');
                        const riderDiv = document.getElementById('rider');
                        const service = document.getElementById('service');
                        const driverSection = document.getElementById('driver-section');
                        if (locationDiv) {
                            riderDiv.style.display = 'none';
                            locationDiv.style.display = 'none';
                            service.style.display = 'none';
                        }

                        if (driverSection) {
                            driverSection.style.display = 'block';
                        }
                        document.querySelectorAll('.step-circle').forEach(circle => {
                            circle.classList.remove('one');
                        });

                        // Add 'one' class to step 2
                        const step4 = document.querySelector('.step-circle[data-step="4"]');
                        if (step4) {
                            step4.classList.add('one');
                        }
                        console.log(drivers, 'dksfjkd');

                        if (drivers.length > 0) {
                            drivers.forEach(driver => {
                                const item = document.createElement('div');
                                item.className = 'p-2 border rounded mb-2';
                                item.innerHTML =
                                    `<strong>${driver.user.name}</strong><br>
                                          <small>Registered: ${new Date(driver.created_at).toLocaleDateString()}</small>`;
                                driverList.appendChild(item);
                            });
                        } else {
                            driverList.innerHTML =
                                `<p class="text-sm text-red-500">No drivers available for this service.</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching drivers:', error);
                    });
            });
        });

    });
</script>
