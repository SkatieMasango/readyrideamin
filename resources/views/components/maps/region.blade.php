<div id="map" class="mb-4 h-96 w-full"></div>
<input type="hidden" name="polygon_coordinates" id="polygon_coordinates" />

<script>
  let map;
  let drawingManager;
  let selectedShape;

  function initMap() {
    const defaultCenter = { lat: 23.8103, lng: 90.4125 }; // Dhaka, Bangladesh

    map = new google.maps.Map(document.getElementById('map'), {
      center: defaultCenter,
      zoom: 12,
    });

    drawingManager = new google.maps.drawing.DrawingManager({
      drawingMode: google.maps.drawing.OverlayType.POLYGON,
      drawingControl: true,
      drawingControlOptions: {
        position: google.maps.ControlPosition.TOP_CENTER,
        drawingModes: [google.maps.drawing.OverlayType.POLYGON],
      },
      polygonOptions: {
        editable: true,
      },
    });

    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
      if (event.type === google.maps.drawing.OverlayType.POLYGON) {
        if (selectedShape) {
          selectedShape.setMap(null); // Remove the previous polygon
        }
        selectedShape = event.overlay;
        updatePolygonCoordinates();
      }
    });

    google.maps.event.addListener(map, 'click', function () {
      if (selectedShape) {
        updatePolygonCoordinates();
      }
    });
  }

  function updatePolygonCoordinates() {
    const coordinates = selectedShape
      .getPath()
      .getArray()
      .map((latLng) => {
        return { lat: latLng.lat(), lng: latLng.lng() };
      });
      
    document.getElementById('polygon_coordinates').value = JSON.stringify(coordinates);
  }
</script>

<script
  src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=drawing&callback=initMap"
  async
  defer
></script>
