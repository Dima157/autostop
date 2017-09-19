<div class="res"></div>
<form method="POST">
    <p>Name Group</p>
    <input type="text"class="name_group">
    <p>Count Users</p>
    <input type="number" class="count">
    <p>date start</p>
    <input type="date"class="start">
</form>
<div id="map-canvas" style='width: 100%; height: 400px'></div>
<div class="sub">SUB INFO</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCH6nHRmOU7pux4sUM92tPBQG984iJJrjs&callback=initMap" async defer></script>
<script>
    var map;
    var markers = [];
    function initMap() {
        var mapOptions = {
            zoom: 7,
            center: new google.maps.LatLng(49.500768, 31.333709)
        };
        var m = document.getElementById('map-canvas');
        map = new google.maps.Map(m, mapOptions);
        map.addListener('click', function(e){
            var lt = e.latLng;
            if(markers.length <= 1) {
                markers.push(lt);
                var marker = new google.maps.Marker({
                    position: lt,
                    map: map
                });
            }
        })
        $('.sub').click(function(){
            var info = {
                name_group: $('.name_group').val(),
                count_users: $('.count').val(),
                start: $('.start').val(),
                markers : markers
            };
            $.ajax({
                url: '/group/create_group',
                type: 'POST',
                data: 'info=' + JSON.stringify(info),
                success: function(data){
                    data = JSON.parse(data);
                    if(data.create == false){
                        $('.res').append(data.error);
                    }else{
                        alert(1)
                        location.href = data.url;
                    }
                }
            })
        })
    }

    function showRoute(start, finish, waypoints, directionsService, directionsDisplay){
        var request = {
            origin: start,
            destination: finish,
            travelMode: 'DRIVING',
            waypoints: waypoints,
            optimizeWaypoints: true
        };
        directionsService.route(request, function (result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);

            }
        });
    }
</script>
