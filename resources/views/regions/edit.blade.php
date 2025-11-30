<x-app-layout>
    <div class="card mt-6 rounded-lg border border-gray-200 bg-white shadow-md">
        <div class="card-body p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex">
                    <a href="{{ route('regions.index') }}"
                        class=" rounded-md bg-pink-100 text-pink-500 flex items-center justify-center" style="width:30px">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>

                    </a>
                    <h5 class="text-lg font-semibold text-gray-800 ms-3">
                        Regions
                        <span class="text-sm text-gray-500">Edit Region</span>
                    </h5>
                </div>

                  <div class="flex items-center">
                    <div x-data="{ showModal_{{ $region->id }}: false }" x-cloak class="inline-block">
                        <!-- Trigger Button -->
                        <button type="button" @click="showModal_{{ $region->id }} = true"
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
                        <div x-show="showModal_{{ $region->id }}" x-cloak
                            class="absolute inset-0 z-50 flex items-start justify-end bg-opacity-50" aria-modal="true"
                            role="dialog">
                            <div @click.away="showModal_{{ $region->id }} = false"
                                class="bg-white rounded-lg shadow-lg p-6 relative" style="top: 50px; right:100px">

                                <!-- Modal Header -->
                                <div class="flex justify-between items-center border-b pb-2 mb-4">
                                    <h2 class="text-lg font-semibold text-red-600">Delete region</h2>
                                    <button @click="showModal_{{ $region->id }} = false"
                                        class="text-gray-500 hover:text-gray-700 text-2xl">
                                        &times;
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mb-4">
                                    <h3 class="text-yellow-600 font-bold">Are you sure?</h3>
                                    <p class="text-gray-700">You want to permanently delete this region?</p>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex justify-end gap-2">
                                    <button @click="showModal_{{ $region->id }} = false"
                                        class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                        Cancel
                                    </button>

                                    <form method="POST" action="{{ route('regions.destroy', $region->id) }}">
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

            <form method="POST" action="{{ route('regions.update', $region['id']) }}">
                @csrf
                <div class="mb-4 grid grid-cols-2 gap-8">
                    <div class="relative">
                        <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" required
                            autofocus autocomplete="name" :value="old('name', $region->name ?? '')" />
                        <x-input-label for="name" :value="__('Name')" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="relative">
                        <x-select-input name="currency" :options="$currencies" :selected="old('currency', $region->currency)" class="w-full border p-2" />
                        <x-input-label for="name" :value="__('Currency')" />
                        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                    </div>
                    <div class="block">
                        <label for="is_active" class="inline-flex items-center">
                            <input id="is_active" type="checkbox"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500"
                                name="is_enabled" value="1"
                                {{ old('is_active', $region->is_active == 1) ? 'checked' : '' }} />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Is Enabled') }}</span>

                        </label>
                    </div>
                    @php
                        $coordinates = json_decode($region->polygon_coordinates, true);
                    @endphp

                    <div class="relative col-span-2">
                        <p class="pb-2 text-sm text-gray-900">Geofence</p>

                        <x-maps.region :coordinates="$coordinates" />

                        {{-- <x-maps.region /> --}}
                        <x-input-error :messages="$errors->get('polygon_coordinates')" class="mt-2" />

                        <a id="remove-polygon-btn" class="mb-2 px-4 py-2 bg-black text-white rounded">Remove
                            Polygon</a>

                        {{-- <div id="map" class="h-96 w-full"></div> --}}
                        <input type="hidden" name="polygon_coordinates" id="polygon_coordinate" />


                    </div>
                </div>
                <div class="flex justify-end">
                    <x-primary-button class="w-56">
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

{{-- <script>
    const polygonCoords = @json($coordinates);

    document.addEventListener("DOMContentLoaded", function() {
        const map = L.map('map').setView([polygonCoords[0].lat, polygonCoords[0].lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        const polygonLatLngs = polygonCoords.map(point => [point.lat, point.lng]);

        // Store polygon in a variable accessible to button handler
        let polygon = L.polygon(polygonLatLngs, {
            color: 'blue',
            fillOpacity: 0.4
        }).addTo(map);

        map.fitBounds(polygon.getBounds());


        // Button to remove polygon
        document.getElementById('remove-polygon-btn').addEventListener('click', () => {
            if (polygon) {
                map.removeLayer(polygon);
                polygon = null; // Clear reference so it won't try to remove twice
            }
        });
    });
</script> --}}

<script>
    const polygonCoords = @json($coordinates);

    document.addEventListener("DOMContentLoaded", function () {
        // Set default center
        const defaultCenter = polygonCoords.length > 0
            ? [polygonCoords[0].lat, polygonCoords[0].lng]
            : [23.8103, 90.4125];

        const map = L.map('map').setView(defaultCenter, 13);

        // Tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
        }).addTo(map);

        // Feature group to hold the drawn polygon
        const drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        let polygonLayer = null;

        // Show the existing polygon
        if (polygonCoords.length > 0) {
            const latlngs = polygonCoords.map(coord => [coord.lat, coord.lng]);
            polygonLayer = L.polygon(latlngs, { color: 'blue', fillOpacity: 0.4 });
            drawnItems.addLayer(polygonLayer);
            map.fitBounds(polygonLayer.getBounds());
        }

        // Add draw control
        const drawControl = new L.Control.Draw({
            draw: {
                polygon: true,
                polyline: false,
                rectangle: false,
                circle: false,
                marker: false,
            },
            edit: {
                featureGroup: drawnItems,
                remove: false
            }
        });
        map.addControl(drawControl);

        // Handle new polygon creation
        map.on(L.Draw.Event.CREATED, function (event) {
            if (polygonLayer) {
                drawnItems.removeLayer(polygonLayer);
            }

            polygonLayer = event.layer;
            drawnItems.addLayer(polygonLayer);

            const latlngs = polygonLayer.getLatLngs()[0].map(latlng => ({
                lat: latlng.lat,
                lng: latlng.lng
            }));


            document.getElementById('polygon_coordinate').value = JSON.stringify(latlngs);
        });

        // Handle remove polygon button
        document.getElementById('remove-polygon-btn').addEventListener('click', () => {
            if (polygonLayer) {
                drawnItems.removeLayer(polygonLayer);
                polygonLayer = null;
                document.getElementById('polygon_coordinates').value = '';
            }
        });
    });
</script>
