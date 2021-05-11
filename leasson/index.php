<?php
session_start();
header("Content-type:text/html;charset=utf-8");

if(isset($_POST['login']) && isset($_POST['password']))
{
$login = $_POST['login'];
$password = $_POST['password'];
 session_start();
    if (isset($_POST['remember']))
    {
        setcookie("login",$_POST['login'],time()+3600**24*7);
    }
    header("Location: ../leasson/hello.php");
$_SESSION['login'] = $_POST['login'];  
$_SESSION['password'] = $_POST['password']; 

} 
elseif (isset($_COOKIE['login']))
{
 header("Location: ../leasson/hello.php");
}
else
{

echo '
<!DOCTYPE html>
<html>
<head>
	<title> Главная</title>
</head>
<body>

<form method="POST">
	<label>Логин : <input type="text" name="login"><br></label>
	<label>Пароль : <input type="password" name="password"><br></label>
	<input type="checkbox" name="check" value="1">Запомнить меня
	<input type="submit" value="Отправить">

</form>


</body>
</html>
';

}


?>