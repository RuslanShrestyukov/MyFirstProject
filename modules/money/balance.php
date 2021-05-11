<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

require_once "modules/money/function.php";
#Заголовок страниц
$title = 'Баланс';

global $eng,$msg,$nav;

if ($userinfo['group'] > 0) 
	{
		if($userinfo['group'] AND !empty($_POST))
			{	
				require_once "modules/money/action.php";
			} 
		else 
			{
				$tpl->content .= showmoney();
			}	
	}
else 
	{
		$tpl->content .=  $eng->msg("2", "Авторизуйтесь для просмотра данной страницы", "2"); 
	} 


?>