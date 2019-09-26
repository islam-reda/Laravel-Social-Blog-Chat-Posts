<style type="text/css">
    #map_canvas {
        height: 200px;
        width: 300px;
        padding-bottom: 3px;
    }
</style>
<div id="map_canvas">
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWI31oNQLgMHtLSargzOFCeNE02o2wHBA&callback=initialize"
        async defer></script>
<script>
    var marker;

    function initialize() {
        //26.7078014,25.8117374,6z
        var store_loc_lat = $('#store_loc_lat').val();
        var store_loc_lon = $('#store_loc_lon').val();
        if(store_loc_lat && store_loc_lon){

            var latlng = new google.maps.LatLng(store_loc_lat,store_loc_lon);

        }else {

            var latlng = new google.maps.LatLng(30.17837864237516,31.425393842806784);

        }

        var myOptions = {
            zoom: 6,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
            mapTypeControl: false,
        };

        var map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);


        marker = new google.maps.Marker({
            position: latlng,
            map: map,
            animation: google.maps.Animation.DROP,
        });

        google.maps.event.addListener(map, 'click', function(event) {
            placeMarker(event.latLng);

            //alert( 'Lat: ' + event.latLng.lat() + ' and Longitude is: ' + event.latLng.lng() );

            $("#store_loc_lat").val(event.latLng.lat());

            $("#store_loc_lon").val(event.latLng.lng());

        });

        function placeMarker(location) {

            if (marker == undefined){
                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    animation: google.maps.Animation.DROP,
                });

                //console.log(location);

            }
            else{
                marker.setPosition(location);
            }
            map.setCenter(location);
        }
    }

    function initMap() {
        var myLatlng = {lat: -25.363, lng: 131.044};

        var map = new google.maps.Map(document.getElementById('map_canvas'), {
            zoom: 4,
            center: myLatlng
        });

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Click to zoom'
        });

        map.addListener('center_changed', function() {
            // 3 seconds after the center of the map has changed, pan back to the
            // marker.
            window.setTimeout(function() {
                map.panTo(marker.getPosition());
            }, 3000);
        });

        marker.addListener('click', function() {
            map.setZoom(8);
            map.setCenter(marker.getPosition());
        });
    }

</script>
