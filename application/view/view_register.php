<script>
$(document).ready(function(){
    $('.sub_reg_form').click(function(){
        var res = $('#register_form_inner').serialize();
        alert(res);
        $.ajax({
            url: '/register',
            type: 'POST',
            data: res,
            success: function(res){
                $('.res').append(res);
            }
        })
    })
})
</script>
<div class="res">

</div>
<div class="register_form">
    <div class="wrapper_form_register">
        <form id="register_form_inner" method="post" enctype="multipart/form-data">
            <input type="text"name="login"placeholder="ведите апш логин"> <br>
            <input type="text"name="name_user" placeholder="Введите Ваше имя"> <br>
            <input type="text"name="surname_user" placeholder="Введите Вашу фамилию"> <br>
            <input type="date"name="birthday"> <br>
            <div class="select">
                <select name="city_user" class="select_inner">
                    <option value="Житомир">Житомир</option>
                    <option value="Киев">Киев</option>
                    <option value="Львов"selected="selected">Львов</option>
                </select> <br>
            </div>
            <input type="email"name="email_user" placeholder="Введите Ваш email"> <br>
            <input type="password"name="pass_user" placeholder="Пароль"> <br>
            <input type="password"name="pass_again_user" placeholder="Повторите пароль">
            <div class="sub_reg_form">Sub</div>
        </form>
    </div>
</div>