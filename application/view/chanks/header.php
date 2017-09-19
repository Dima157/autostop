<div id="header">
    <div class="left">
        <a href="/"><img src="/images/design/logo2.png"height="45x" style="margin-left: -1px" alt="no" class="logo"></a>
    </div>
    <div class="right">
        <ul class="menu">
            <li class="menu_inner">
                <a href="/group">Группы</a>
            </li>
            <li class="menu_inner">
                <a href="/view/view_register.php">Регестрация</a>
            </li>
            <li class="menu_inner slide">
                Управление
                <ul class="slide_menu">
                    <li class="slide_menu_inner">
                        <a href="/account">Войти</a>
                    </li>
                    <li class="slide_menu_inner">
                        <a href="/account/logout">Выйти</a>
                    </li>
                    <li class="slide_menu_inner">
                        <a href="/profile/show/<?=$_SESSION['id']?>">Профиль</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>