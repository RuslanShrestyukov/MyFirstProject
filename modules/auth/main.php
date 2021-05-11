<?php
$title = 'Авторизация';

#Подключаем файл функций
require_once "modules/auth/function.php";
if ($userinfo['group'])
{
	#Выход
	if(isset($_GET['logout']))
		logout($userinfo['id']);
	else
		header("Location: ".SITEDIR);
} 
else 
{
if (!empty($_POST['login']) AND !empty($_POST['password'])) 
	{ 
		$login = trim($_POST['login']); 
		$password = trim($_POST['password']);
		$auth = auth($login,$password);
		if($auth['type'] == 'success')
			header("Location: ".SITEDIR);
		else
			$tpl->content .= $eng->msg(2,$auth['msg'], 2);
	} 
	else
	{
		$tpl->content .= $eng->msg(2,'Не все данные введены. Попробуйте снова', 2);
	}
}


          ?>