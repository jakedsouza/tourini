<div id="map-container" >
	<div id="map_canvas" style="width: 320px; height: 320px;" ></div>
	<div>
		
		<input id="address" type="textbox" >
		<input type="submit" value="Search Location"  onclick="codeAddress()">
		
	</div>
</div>

<!-- <script type="text/javascript" src="../js/googleMaps.js"></script> -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false""></script>
<script type="text/javascript" charset="utf-8">
  var markers = [];
    var geocoder;
    var map; {
        navigator.geolocation.getCurrentPosition(initialize);
    };
    function initialize(position) {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        var myOptions = {
            zoom : 15,
            center : latlng,
            mapTypeId : google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        //        var marker = new google.maps.Marker({
        //            position : latlng,
        //            map : map,
        //            title : "You are here"
        //        })

        codeAddress(latlng.toString());
    }

    function codeAddress(address) {
		 markers = [];
        if(address == null) {
            address = document.getElementById("address").value;
        }
        geocoder.geocode({
            'address' : address
        }, function(results, status) {
            if(status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                $("#map-address").val(results[0].formatted_address);
                $("#map-latlng").val(results[0].geometry.location.toString());
                var marker = new google.maps.Marker({
                    map : map,
                    position : results[0].geometry.location
                });
                markers.push(marker);
            } else {
                notify("Geocode was not successful for the following reason: " + status);
                
            }
        });
    }
</script>