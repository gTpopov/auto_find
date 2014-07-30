/*
 * Upload google map for select user
 */

var geocoder;
var map;

function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(50,30);
    var mapOptions = {
        zoom: 16,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
}


function codeAddress(address) {

    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);

            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
        } else {
            //alert("Geocode was not successful for the following reason: " + status);
            document.getElementById("map_canvas").innerHTML="Error";
        }
    });
}
//google.maps.event.addDomListener(window, 'load', initialize);
