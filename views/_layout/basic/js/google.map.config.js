(function($){
    $(document).ready(function(){

        // Google Maps
        //-----------------------------------------------
        if ($("#map-canvas").length>0) {
            var map, myLatlng, myZoom, marker;
            // Set the coordinates of your location
            myLatlng = new google.maps.LatLng(37.561924, 126.946848);
            myZoom = 15;
            function initialize() {
                var mapOptions = {
                    zoom: myZoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    center: myLatlng,
                    scrollwheel: false
                };
                map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);
                marker = new google.maps.Marker({
                    map:map,
                    draggable:true,
                    animation: google.maps.Animation.DROP,
                    position: myLatlng
                });
                google.maps.event.addDomListener(window, "resize", function() {
                    map.setCenter(myLatlng);
                });
            }
            google.maps.event.addDomListener(window, "load", initialize);
        }
    }); // End document ready

})(this.jQuery);


(function($){
    $(document).ready(function(){
        if ($("#map-canvas2").length>0) {
            var map, myLatlng, myZoom, marker;
            // Set the coordinates of your location
            myLatlng = new google.maps.LatLng(36.538720, 126.706552);
            myZoom = 15;
            function initialize() {
                var mapOptions = {
                    zoom: myZoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    center: myLatlng,
                    scrollwheel: false
                };
                map = new google.maps.Map(document.getElementById("map-canvas2"),mapOptions);
                marker = new google.maps.Marker({
                    map:map,
                    draggable:true,
                    animation: google.maps.Animation.DROP,
                    position: myLatlng
                });
                google.maps.event.addDomListener(window, "resize", function() {
                    map.setCenter(myLatlng);
                });
            }
            google.maps.event.addDomListener(window, "load", initialize);
        }
    }); // End document ready

})(this.jQuery);
