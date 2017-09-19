<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>PHPMailer Test</title>
</head>
<body>
<div>
  <p>Подтвердите реестрацию:</p>
  <?php
    $hash = md5(uniqid(rand(), true));
    $hash = 123;
  ?>
  <a href="http://autostop/register/hash?hash=<?=123?>">http://autostop/auth?hash=<?=$hash?></a>
</div>
</body>
</html>
