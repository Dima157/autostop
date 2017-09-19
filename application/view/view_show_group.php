<style>

    .panel{


        margin-right: 3px;
    }

    .button {
        background-color: #545e7b;
        border: none;
        color: white;
        margin-right: 30%;
        margin-left: 31%;
        text-decoration: none;
        display: block;
        font-size: 16px;
        cursor: pointer;
        width:30%;
        height:40px;
        margin-top: 5px;

    }
    .box{
        display: none;
    }
    ul{
        list-style: none;
    }
    .corner{
        display: none;
    }
    input[type=text]{
        width:100%;
        margin-top:5px;

    }

    select{
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none;
    }
    .select:after{
        content: "▼";
        padding: 0 8px;
        font-size: 12px;
        position: absolute;
        right: 143px;
        top: 235px;
        z-index: 1;
        text-align: center;
        width: 10%;
        height: 100%;
        pointer-events: none;
        box-sizing: border-box;
    }
    :focus {outline:none;}
    .chat {
        width: 400px;
        height:472px;
        background: #086cff;
        border: 1px solid #999999;
        padding: 10px;
        font: 14px 'lucida grande',tahoma,verdana,arial,sans-serif;
        box-sizing: border-box;
    }
    .chat .message_chat {
        background: #F7F7F7;
        height:350px;
        overflow: auto;
        padding: 10px 10px 20px 10px;
        border: 1px solid #999999;
    }
    .chat  input{
    //padding: 2px 2px 2px 5px;
    }
    .block_inner{
        width: 33.3%;
        float: left;
    }
    .system_msg{color: #BDBDBD;font-style: italic;}
    .user_name{font-weight:bold;}
    .user_message{color: #88B6E0;}



</style>
<div class="name_group" style="font: 16px 'Segoe Print';"><?echo $param->getName()." (".$param->getParticipantCount()."/".$param->getCount().")";?></div>
<div style="font: 16px 'Segoe Print';">Администратор: <a href="/profile/show/<?=$param->getCreator()->getId()?>"><?=$param->getCreator()->getName().' '.$param->getCreator()->getSurname();?></a></div>
<?=$param->getVote()->check_vote($param->getId());?>
<div id="map-canvas" style="width: 100%; height: 500px"></div>
    <div class="vote" style="width: 1000px; height: 800px; background-color: gray; top: 0;display: none;">
        <div id="map-canvas-vote" style="width: 1000px; height: 500px"></div>
        <div class="sub_waypoints">SUB WAYPOINTS</div>
        <div class="getInfo">getInfo</div>
    </div>
<?if($enter):?>
    <?if($param->getVote()->check_vote($param->getId())):?>
        <div class="is_vote">Предлоежение изменить маршрут</div>
    <?endif;?>
    <div class="map_vote"style="width: 1000px; height: 800px; background-color: gray; top: 0; display: none;">
        <div id="map-vote-canvas"style="width: 1000px; height: 500px"></div>
        <div class="sub_map_vote"></div>
        <?if(!$param->getVote()->checkVotesUser()):?>
            <?=$param->getVote()->checkVotesUser()?>
            <div class="answer">
                <div class="yes">yes</div>
                <div class="no">no</div>
            </div>
        <?else:?>
            <div class="result">
                <?$res = $param->getVote()->getStatistic($param->getCount());?>
                <div style="width: 200px; height: 35px; border: 1px solid black">
                    <div style="width: <?=$res['yes']?>%;height: 100%; background-color: blue;"></div>
                </div>
                <div style="width: 200px; height: 35px; border: 1px solid black">
                    <div style="width: <?=$res['no']?>%;height: 100%; background-color: blue;"></div>
                </div>
            </div>
        <?endif;?>
        <div class="res_vote">

        </div>
    </div>
    <div class="edit_route">edit route</div>
    <?if($param->checkAdmin()):?>
        <div class="ban_lis">
            <div>Бан учасников</div>
            <div>

            </div>
        </div>
     <?endif;?>
<div class="content_inner">
        <div class="participants block_inner" style=" min-height: 400px; box-sizing: border-box; padding-right: 40px; 17px'Segoe UI Light'">
            <div style="border: 1px solid black;min-height: 440px; font: 17px'Segoe UI Light';">
                <div style="width: 100%; text-align: center; height: 30px; line-height: 30px; background-color:#086cff;color: white ">Список учасников</div>
                <?if($param->getParticipantCount()):?>
                    <?$users = $param->getParticipants();?>
                    <?for($i = 0; $i < $param->getParticipantCount(); $i++):?>
                        <div class="info_user"><a href="/profile/show/<?=$users[$i]->getId()?>" class="user"><?=$users[$i]->getName()." ".$users[$i]->getSurname()?></a><?if($param->checkAdmin()):?><span class="ban">Бан</span><?endif;?></div>
                    <?endfor;?>
                <?else:?>
                    <div style="line-height: 440px; text-align: center">Список пуст</div>
                <?endif;?>
            </div>
        </div>
        <div class="parse block_inner">a
            <div style="width: 300px; box-sizing: border-box; border:1px solid black; position: relative; height: 472px;">
                <div style="position: absolute; top: 7px; right: 55px;">▼</div>
                <div style='height: 30px; text-align: center; line-height: 30px; border-bottom: 1px solid gray'>
                    <select class="all_city" style="border: 0">
                        <?for($i = 0; $i < count($parser->getCity()); $i++):?>
                            <option value="<?=$parser->getCity()[$i]?>"><?=$parser->getCity()[$i]?></option>
                        <?endfor;?>
                    </select>
                </div>
                    <div class="wrapper_info">
                        <div class="info">
                            <?$info = $parser->getPlace($parser->getCity()[0]);?>
                            <?for($i = 0; $i < count($info); $i++):?>
                                <?=$info[$i];?>
                            <?endfor;?>
                        </div>
                    </div>
            </div>
        </div>
        <div class="chat block_inner">
        <div class="message_chat" id="message_chat">
            <?for($i = 0; $i < count($param->getChat()->getUser()); $i++):?>
                <div>
                    <span class="user_name"><?=$param->getChat()->getUser()[$i]->getName().' '.$param->getChat()->getUser()[$i]->getSurname();?></span>
                    <span> : </span>
                    <span class="user_message"><?=$param->getChat()->getMess()[$i]?></span>
                </div>
            <?endfor;?>
        </div>
        <div class="panel">
            <input type="text" name="name" id="name" placeholder="Your Name" maxlength="15" value="<?$model = Model_User::getUser($_SESSION['id']);echo $model->getName().' '.$model->getSurname();?>" />

            <input type="text" name="message" id="message" placeholder="Message" maxlength="80"
                   onkeydown = "if (event.keyCode == 13)document.getElementById('send-btn').click()"  />

        </div>

        <button id="send-btn" class=button>Send</button>

    </div>


</div>
<?endif;?>





<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCH6nHRmOU7pux4sUM92tPBQG984iJJrjs&callback=initMap" async defer></script>
<script>
    $(document).ready(function(){
        //create a new WebSocket object.
        var wsUri = "ws://localhost:9000/autostop/server.php";
        websocket = new WebSocket(wsUri);

        var url = location.href;
        url = url.split('/');
        var id_gr = url[url.length - 1];
        $('#name').val();
        $('#name').hide();
        $('#send-btn').click(function(){
            var mymessage = $('#message').val();
            var myname = $('#name').val();
            $.ajax({
                url: '/chat/add_mess',
                type: 'POST',
                data:  'message=' + mymessage + '&id_group=' + id_gr,
                success: function(){}
            })
            if(mymessage == ""){
                alert("Enter Some message Please!");
                return;
            }


            var objDiv = document.getElementById("message_chat");
            objDiv.scrollTop = objDiv.scrollHeight;
            var msg = {
                message: mymessage,
                name: myname,
                color : '<?php echo $colours[$user_colour]; ?>',
                id_group: id_gr
            };
            websocket.send(JSON.stringify(msg));
        });
        websocket.onmessage = function(ev) {
            var msg = JSON.parse(ev.data);
            var type = msg.type;
            var umsg = msg.message;
            var uname = msg.name;
            var ucolor = msg.color;
            var check_group = msg.id_group;
            if(check_group == id_gr) {


                if (type == 'usermsg') {
                    $('#message_chat').append("<div><span class=\"user_name\" style=\"color:#" + ucolor + "\">" + uname + "</span> : <span class=\"user_message\">" + umsg + "</span></div>");
                }
                if (type == 'system') {
                    $('#message_chat').append("<div class=\"system_msg\">" + umsg + "</div>");
                }
            }
            $('#message').val(''); //reset text

            var objDiv = document.getElementById("message_chat");
            objDiv.scrollTop = objDiv.scrollHeight;
        };

        websocket.onerror	= function(ev){$('#message_chat').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");};
        websocket.onclose 	= function(ev){$('#message_chat').append("<div class=\"system_msg\">Connection Closed</div>");};
    });


    function initMap() {
        var map, markers = [], waypoints = [];
        var canvas = document.getElementById('map-canvas');
        var data = createMap(canvas);
        var directionsDisplay2 = new google.maps.DirectionsRenderer();
        var directionsService2 = new google.maps.DirectionsService();
        var url  = location.href;
        var id = url.split('/');
        var marker;

        id = id[id.length - 1];
        $.ajax({
            url: '/map/get/' + id,
            type: 'POST',
            data: 'id=' + id,
            async: false,
            success: function(data){
                data = JSON.parse(data);
                markers.push(data.marker_start);
                markers.push(data.marker_end);
                if(data.waypoints.length > 0){
                    for(var i = 0; i < data.waypoints.length; i++){
                        waypoints.push(data.waypoints[i]);
                    }
                }
            }
        });
        var lt = addMarker(data.map, markers);
        var mass_waypoints = addWaypoints(data.map, waypoints);

        showRoute(lt[0], lt[1], mass_waypoints, data.service, data.render, data.map);
        $('.add_to_group').click(function(){
            var url = location.href;
            var all_elem = url.split('/');
            var id = all_elem[all_elem.length - 1];
            $.ajax({
                url: '/group/add',
                type: 'POST',
                data: 'id_group=' + id,
                success: function(data){
                    alert(data);
                }
            })
        })



        var newWaypoints = [];
        var url = location.href;
        url = url.split('/');
        var id_group = url[url.length - 1];
        var canvasVote ,dataVote, newLt, new_waypoints_vote;
        $('.edit_route').click(function(){
            $('.vote').show();
            canvasVote = document.getElementById('map-canvas-vote');
            dataVote = createMap(canvasVote);
            newLt = addMarker(dataVote.map, markers);
            new_waypoints_vote = addWaypoints(dataVote.map, waypoints);
            showRoute(newLt[0], newLt[1], new_waypoints_vote, dataVote.service, dataVote.render, dataVote.map);
            var top = $(window).scrollTop();
            $('.vote').css('top', top);
            dataVote.map.addListener('click', function(e){
                var pos = e.latLng;
                console.log(pos);
                new_waypoints_vote.push({location: {lat: e.latLng.lat(), lng: e.latLng.lng()}});
                dataVote.render.setMap(null);
                var marker = new google.maps.Marker({
                    position: pos,
                    map: dataVote.map,
                    icon: '/images/marker/mapmarker.png'
                });
                showRoute(newLt[0], newLt[1], new_waypoints_vote, dataVote.service, dataVote.render, dataVote.map);
            });
        });
        $('.sub_waypoints').click(function(){
            if(new_waypoints_vote.length >= 1){
                var data = JSON.stringify(new_waypoints_vote);
                var url = location.href;
                url = url.split('/');
                var id_group = url[url.length - 1];
                $.ajax({
                    url: '/vote/vote_create',
                    type: 'POST',
                    data: 'data=' + data + '&id=' + id_group,
                    success: function(data){
                        alert(data);
                    }
                })
            }
        });



        $('.ban').click(function(){
            var a = $(this).parent().find('a');
            var set = a.attr('href');
            var mass = set.split('/');
            var id_user = mass[mass.length - 1];
            $.ajax({
                url: '/group/add_ban',
                type: 'POST',
                data: 'id_user=' + id_user + '&id_group=' + id,
                success: function(data){
                    alert(data);
                }
            });
        })

        $('.is_vote').click(function(){
            $('.map_vote').show();
            var newVoteWaypoints = [];
            var canvasIsVote = document.getElementById('map-vote-canvas');
            var dataIsVote = createMap(canvasIsVote);
            var newVoteLt = addMarker(dataIsVote.map, markers);
            var waypoints_vote = addWaypoints(dataIsVote.map, waypoints);
            var vote_waypoints_copy = waypoints.slice(0);
            var vote_waypoints = [];
            $.ajax({
                url: '/vote/get_vote_waypoints',
                type: 'POST',
                data: 'id_group=' + id_group,
                async: false,
                success: function(data){
                    alert(id_group);
                    data = JSON.parse(data);
                    if(data.length > 1){
                        for(var i = 0; i < data.length; i++){
                            vote_waypoints_copy.push({location: {lat: parseFloat(data[i].lat), lng: parseFloat(data[i].lng)}});
                            vote_waypoints.push(data[i]);
                        }

                    }else{
                        vote_waypoints_copy.push({location: {lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lng)}});
                        vote_waypoints.push(data[0]);
                    }
                }
            });
            addMarkerVote(dataIsVote.map, vote_waypoints);
            showRoute(newVoteLt[0], newVoteLt[1], vote_waypoints_copy, dataIsVote.service, dataIsVote.render, dataIsVote.map);
        });


        $('.all_city').change(function(){
            $('.info').remove();
            $('.wrapper_info').append("<div class='info'></div>");
            var city = $('.all_city').val();
            $.ajax({
                url: '/parse',
                type: 'POST',
                data: 'city=' + city,
                success: function(data){
                    alert(data);
                    $('.info').append(data)
                }
            })
        })

        $('.yes').click(function(){
            var data = {
                id_group: id_group,
                answer: 1
            };
            data = JSON.stringify(data);
            $.ajax({
                url: '/vote/choose',
                type: 'POST',
                data: 'data=' + data,
                success: function(data){
                    data = JSON.parse(data);
                    var str = "<div style='width: 200px; border: 1px solid black; height: 35px'><div style='width: " + data.yes + "%;height: 100%; background-color: blue'></div><div style='width: 200px; border: 1px solid black; height: 35px'><div style='height: 100%; width: " + data.no + "%; background-color: blue'></div></div>"
                    $('.res_vote').append(str);
                    $('.answer').hide();
                }
            })
        });

        $('.no').click(function(){
            var data = {
                id_group: id_group,
                answer: 2
            };
            data = JSON.stringify(data);
            $.ajax({
                url: '/vote/choose',
                type: 'POST',
                data: 'data=' + data,
                success: function(data){
                    data = JSON.parse(data);
                    var str = "<div style='width: 200px; border: 1px solid black; height: 35px'><div style='width: " + data.yes + "%;height: 100%; background-color: blue'></div><div style='width: 200px; border: 1px solid black; height: 35px'><div style='height: 100%; width: " + data.no + "%; background-color: blue'></div></div>"
                    $('.res_vote').append(str);
                    $('.answer').hide();
                }
            })
        });
    }


    function createMap(canvas){
        var mapOptions = {
            zoom: 7,
            center: new google.maps.LatLng(49.500768, 31.333709)
        };
        var map = new google.maps.Map(canvas, mapOptions);
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var directionsService = new google.maps.DirectionsService();

        var obj = {
            map: map,
            render: directionsDisplay,
            service: directionsService
        };

        return obj;
    }


    function showRoute(start, finish, waypoints, directionsService, directionsDisplay, map) {
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
        directionsDisplay.setMap(map);
        directionsDisplay.setOptions( { suppressMarkers: true, suppressInfoWindows: true } );
    }
    function addMarker(map, markers){
        var myLatlng;
        var lt = [];
        for(var i = 0; i < markers.length; i++){
            myLatlng = new google.maps.LatLng(markers[i].lat, markers[i].lng);
            lt.push(myLatlng);
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });
        }
        return lt;
    }

    function addMarkerVote(map, markers){
        var myLatlng;
        var lt = [];
        for(var i = 0; i < markers.length; i++){
            myLatlng = new google.maps.LatLng(markers[i].lat, markers[i].lng);
            lt.push(myLatlng);
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: '/images/marker/mapmarker.png'
            });
        }
        return lt;
    }

    function addWaypoints(map, waypoints){
        var mass_waypoints = [];
        var myLatlng;
        if(waypoints.length > 0){
            for(var i = 0; i < waypoints.length; i++){
                myLatlng = new google.maps.LatLng(waypoints[i].lat, waypoints[i].lng);
                var lat = parseFloat(myLatlng.lat().toFixed(4));
                var lng = parseFloat(myLatlng.lng().toFixed(4));
                mass_waypoints.push({location: {lat: lat, lng: lng}});
                marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map
                });
            }
        }
        return mass_waypoints;
    }
    google.maps.event.addDomListener(window, 'load', initialize);




</script>
<?if(!$enter):?>
    <div class="add_to_group">ADD TO GROUP</div>
<?endif;?>
