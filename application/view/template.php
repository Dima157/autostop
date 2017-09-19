<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/font/font.css">
    <script src="/js/jquery.bxslider.js"></script>
    <script>
        $(document).ready(function(){
            $('.bxslider').bxSlider({
                pager: false, // отключаем индикатор количества слайдов
                nextText: '', // отключаем текст кнопки Next
                prevText: '' // отключаем текст кнопки Prev

            });
        });
    </script>
</head>
<body>
<div id="wrapper">
    <div>
        <?require_once 'application/view/chanks/header.php'?>
    </div>

    <div id="content">
        <?require_once "application/view/$view_file"?>
    </div>

    <div>
        <?require_once 'application/view/chanks/footer.php'?>
    </div>
</div>
</body>
</html>