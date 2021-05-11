<?php if (!defined('NEWGUARD'))			exit('Нет доступа');


#Заголовок страницы
$title = 'Регистрация';
	
#Подключаем файл функций
require_once "modules/reg/function.php";


#Стена
if ($userinfo['group'] == 0)
{
	if(!empty($_POST['login']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['rules']))
	{
		$result = validatereg($_POST['login'],$_POST['password'],$_POST['email'],$_POST['rules']);
		$tpl->content .= $eng->msg($result['type'],$result['msg'],$result['type']);
	} 
	else {
		$tpl->content .= formreg();
		
          
	}
} else
	header("Location: ".SITEDIR);