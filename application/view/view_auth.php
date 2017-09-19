<script>
    $(document).ready(function(){
        $('.sub_auth').click(function(){
            var res = $('.auth').serialize();
            $.ajax({
                url: '/account/login',
                type: 'POST',
                data: res,
                success: function(res){
                    if(res == true){
                        location.href = '/profile';
                    }
                }
            })
        });
    });
</script>
<div class="message"></div>
<div style="height: 420px; position:relative;">
    <div class="auth">
        <form method="post" class="auth">
            <input type="email"placeholder="email"name="login"> <br>
            <input type="password"placeholder="pass"name="pass"> <br>
            <div class="sub_auth">Sub</div>
        </form>
        <div class="reg" style="position: absolute; top: 139px; left: 147px;"><a href="/register">Зареестрироваться?</a></div>
    </div>
</div>