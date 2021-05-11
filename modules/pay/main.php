<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
$title = 'Покупка подписки';

#Подключаем файл функций
require_once "modules/pay/function.php";

	if ($userinfo['group'] > 0)
{	
#Получаем $_GET
if(!empty($_GET['id']))
{
	$id_pay = $_GET['id'];
}

if(!empty($id_pay)) {
	// Получаем название новости
		$tpl->content .= pay_id($id_pay);
	#Список новостей
	} else {
		$tpl->content .= pay_null();
	}

	}else
{
$tpl->content .= $eng->msg(3,'Вы не авторизованы', 3);
}
          ?>