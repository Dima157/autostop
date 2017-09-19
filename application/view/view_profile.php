<?php
123
?>

<script>
    $(document).ready(function(){
        $('.avatar_profile').mouseenter(function(){
            $('.reg_avatar').slideDown("slow");
        });
        $('.avatar_profile').mouseleave(function(){
            $('.reg_avatar').slideUp("slow");
        })
        $('.upload').click(function(){
            $('.upload_avatar').show();
        })
        $('.sub_ava').click(function(){
            var $input = $("#uploadimage");
            var fd = new FormData;
            fd.append('avatar', $input.prop('files')[0]);
            //alert(1);
            $.ajax({
                url: '/photo',
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data){
                    alert(data);
                    data = JSON.parse(data);
                    $('.square').show();
                    $('.inner_square').css('width', data.width);
                    var str = "<img src='/" + data.path + "' class='upload'>";
                    $('.inner_square').append(str);
                    $('.id_photo').val(data.id);
                    $('.width').val(data.width);
                    $('.path').val(data.path);
                    if($('.all_photo').text() == 'ALL_PHOTO'){
                        var children = $('.all_photo_user').children();
                        children[4].remove();
                        var str = "<div class=inner_photo_block><input type='hidden'><img src='/" + data.path + "' class='upload'></div>";
                        $('.all_photo_user').prepend()
                    }
                }
            })
        });

        $('.sub_photo').click(function(){
            var id = $('.id_photo').val();
            var photo = $('.square_photo');
            var left = photo.css('left');
            var top = photo.css('top');
            var path = $('.path').val();
            var width = $('.width').val();
            console.log(width);
            var obj = {
                id : id,
                left : left,
                top : top,
                width: width
            };
            console.log(obj);
            obj = JSON.stringify(obj);
            $.ajax({
                url : '/avatar',
                dataType : 'JSON',
                data : 'obj=' + obj,
                type : 'POST'
            })
            $('.photo_wrapper').remove();
            console.log(left);
            var str = "<div class='photo_wrapper'><div style='position: absolute; width: " + width + "px; left:-"+ left +"; top: -"+ top +";'><img src='/"+ path +"'style='width: 100%' alt='no'></div></div>"
            $('.avatar_profile').append(str);
        })

        $('.next_photo').click(function(){
            var item = $('.item').text();
            var count = $('.count_photo_user').text();
            if(item != count) {
                item = parseInt(item, 10) + 1;
                $('.item').text(item);
            }
            var url = location.href;
            url = url.split('/');
            var id_user = url[url.length - 1];
            $.ajax({
                url: '/photo/get_one_photo',
                type: 'POST',
                data: 'id_user=' + id_user + "&item=" + item,
                success: function(data){
                    $('.img_show').remove();
                    var str = "<img src='/"+ data +"' class='img_show'>";
                    $('.show_photo_wrapper').append(str);
                }

            })
        });

        $('.prev_photo').click(function(){
            var item = $('.item').text();
            if(item != 0) {
                item = parseInt(item, 10) - 1;
                $('.item').text(item);
            }

            var url = location.href;
            url = url.split('/');
            var id_user = url[url.length - 1];
            $.ajax({
                url: '/photo/get_one_photo',
                type: 'POST',
                data: 'id_user=' + id_user + "&item=" + item,
                success: function(data){
                    $('.img_show').remove();
                    var str = "<img src='/"+ data +"' class='img_show'>";
                    $('.show_photo_wrapper').append(str);
                }

            })
        });

        $('.all').click(function(){
            var text = $(this).text();
            if(text == 'ALL_PHOTO') {
                $(this).text('HIDE');
                $.ajax({
                    url: "/photo/show",
                    data: 'all=1',
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        data = JSON.parse(data);

                        var str;
                        for (var i = 0; i < data.photos.length; i++) {
                            str = "<div><div class='inner_photo_block'><img src='/" + data.photos[i] + "' style='width: 100%' alt=''></div></div>";
                            $('.all_photo_user').append(str);
                        }
                    }
                });
            }else{
                $(this).text("ALL_PHOTO");
                var children = $('.all_photo_user').children();
                for(var i = children.length - 1; i >=5; i--){
                    children[i].remove();
                }
            }
        })

        $('.upload_img').click(function(){
            $('.upload_img').show();
        });

        $('.wrapper_inner_photo_block').click(function () {
            $('.show_photo').show();
            var all_photo = $('.all_photo_user');
            var i = $(this).index('.wrapper_inner_photo_block');
            alert(i);
            var count = $('.count_photo').val();
            count = parseInt(count, 10) + 5;
            $('.count_photo_user').text(count);
            $('.item').text(i);
            var url = location.href;
            url = url.split('/');
            var id_user = url[url.length - 1];
            $.ajax({
                url: '/photo/get_one_photo',
                type: 'POST',
                data: 'id_user=' + id_user + "&item=" + i,
                success: function(data){
                    $('.img_show').remove();
                    var str = "<img src='/"+ data +"' class='img_show'>";
                    $('.show_photo_wrapper').append(str);
                }

            })
        })


        $('.upload_file').click(function(){
            var form = new FormData;
            var file = $('.img').prop('files');
            //form.append('img', file.prop('file')[0]);
            var count = file.length;
            form.append('count', count);
            for(var i = 0; i < count; i++){
                form.append('img-' + i, file[i]);
            }
            $.ajax({
                url: "/photo/upload",
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    data = JSON.parse(data);
                    var  children = $('.all_photo_user').children();
                    if(data.result instanceof Array){
                        var num = data.result.length;
                        var count = 0;
                        for(var i = children.length - 1; i >= 0; i--){
                            if(count == num) break;
                            children[i].remove();
                            count++;
                        }
                        for(var i = 0; i < data.result.length; i++){
                            var str = "<div><div class='inner_photo_block'><img class='clock_photo' src='/" + data.result[i] + "'style='width: 100%' alt=''></div></div>"
                            $('.all_photo_user').prepend(str);
                        }
                    }else{
                        alert(1);
                        children[children.length - 1].remove();
                        var str = "<div><div class='inner_photo_block'><img class='click_photo' src='/" + data.result + "'style='width: 100%' alt=''></div></div>"
                        $('.all_photo_user>div').prepend(str);
                    }
                }
            })
        });

        $('.click_photo').click(function(){
            var id = $('.id_profile').text();
            id = JSON.parse(id);
            console.log(id.photo);
            $('.show_photo').show();
        })
        $(".square_photo").draggable({containment: '.inner_square'});
    })
</script>
<div>
    <div class="top_profile">
        <div class="left_profile">
            <div class="avatar_profile" style="float: left; margin-right: 10px">
                <div class="photo_wrapper">
                    <?
                    //echo $param->getPhoto();
                    $avatar = '';
                    if($param->getAvatar()) {
                        $avatar = $param->getAvatar()->getPath($param->getPhotos());
                    }
                    if(isset($avatar) && !empty($avatar)){
                        echo "<div style='position: absolute; width:". $param->getAvatar()->getWidth() ."px;left: -". $param->getAvatar()->getLeft() ."px;top: -".$param->getAvatar()->getTop()."px'><img src=\"/$avatar\"style='width: 100%' alt=\"no-img\"></div>";
                    }else{
                        echo "<img src=\"/images/no_img.jpg\" alt=\"no-img\">";
                    }
                    ?>
                </div>
                <?if(Model_Auth::currentUser($param->getId())):?>
                    <div class="reg_avatar">
                        <div class="upload">upload</div>
                        <div class="change">change</div>
                    </div>
                <?endif;?>
            </div>
            <div class="info_user" style="float: left; width: 600px">
                <div style="font: 15px 'Segoe Print';"><span>Имя: </span><?=$param->getName();?> <?=$param->getSurname();?></div>
                <div style="font: 15px 'Segoe Print';"><span>Город: </span><?=$param->getCity();?></div>
                <div style="font: 15px 'Segoe Print';"><span>Дата рождения: </span><?=$param->getBirthday();?></div>
                <div style="font: 15px 'Segoe Print';">Мои автостопы:</div>
                <div>
                    <span><a href="">ЛьвовГоу</a></span>
                    <span><a href="">Житомир/Киев</a></span>
                    <span><a href="">Днепро</a></span>
                </div>
                <div>
                    <?if(count($param->getMyAutostop()) > 0):?>
                        <?for($i = 0; $i < count($param->getMyAutostop()); $i++):?>
                            <?$obj = Model_Group::getGroup($param->getMyAutostop()[$i]);?>
                            <span><a href="/group/show/<?=$obj->getId();?>"><?=$obj->getName();?></a></span>
                        <?endfor;?>
                    <?else:?>
                        <div>Нет автостопов</div>
                    <?endif;?>
                </div>
            </div>
        </div>
        <div class="right_profile" style="clear: both"></div>
        <div style="width: 200px; height: 40px; background-color: #086cff; text-align: center; line-height: 40px; border-radius: 5px; display: none;" class="all">ALL_PHOTO</div>
        <?if(Model_Auth::currentUser($param->getId())):?>
            <div style="width: 200px; height: 40px; background-color: #086cff; text-align: center; line-height: 40px;border-radius: 5px; margin: 10px 0 0 800px; font: 15px 'Segoe Print';;" class="upload_img">Загрузить фото</div>
        <?endif;?>
        <div style="width: 100%; height: 30px; line-height: 30px; color: white; background-color: #086cff; text-align: center; font: 15px 'Segoe Print';">Мои фото</div>
        <div class="all_photo_user">
            <?if($param->getPhotos()):?>
            <?if(count($param->getPhotos()->getPhotos()) == 0):?>
            <div>НЕТ ФОТО</div>
            <?endif;?>
                <?if(count($param->getPhotos()->getPhotos()) >= 1):?>
                    <?for($i = 0; $i < count($param->getPhotos()->showPhoto(5)); $i++):?>
                        <div class="wrapper_inner_photo_block">
                            <div class="inner_photo_block" style="background-color: white">
                                <img class="click_photo" src="/<?= $param->getPhotos()->showPhoto()[$i] ?>"style="width: 100%" alt="no">
                            </div>
                        </div>
                    <?endfor;?>
                <?endif;?>
            <?else:?>
                <div>НЕТ ФОТО</div>
            <?endif;?>
        </div>
    </div>

</div>


<div class="upload_avatar">
    <p>Загрузите фото для вашей аватарки</p>
    <form enctype="multipart/form-data" id="photo_form" method="post" >
        <input type="file"name="login" id='uploadimage'> <br>
        <div class="sub_ava">Sub</div>
    </form>
    <div class="res"></div>
</div>


<div class="square" style="display: none">
    <div class="inner_square">
        <input type="hidden" class="id_photo">
        <input type="hidden" class="width">
        <input type="hidden" class="path">
        <input type="hidden"class="count_photo"value="<?=$param->getPhotos()->getCountPhotos()?>">
        <div class="square_photo">
            <div class="id_photo" style="display: none"></div>
        </div>

    </div>
    <div class="sub_photo">SUB_PHOTO</div>
</div>

<div class="all_photo">

</div>

<div class="upload_img" style="display: none; position: absolute">
    <form method="post" enctype="multipart/form-data">
        <input type="file"multiple class="img">
        <div class="upload_file">UPLOAD</div>
    </form>
</div>


<div class="show_photo" >
    <div class="show_photo_wrapper" style="text-align: center">

    </div>
    <div class="prev_photo" style="float: left; width: 80px; height: 80px;background-image: url('/images/design/photo/left.png');margin-left: 315px"></div>
    <div class="photo_item" style="float: left;line-height: 78px;font-size: 21px;">
        <div class="item" style="float: left;"></div>
        <div style="float: left;">/</div>
        <div style="float: left;" class="count_photo_user"></div>
    </div>
    <div class="next_photo" style="float: left; width: 80px; height: 80px;background-image: url('/images/design/photo/right.png');"></div>
</div>