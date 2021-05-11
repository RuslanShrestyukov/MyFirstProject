<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
$title = 'Статистика';

#Подключаем файл функций
require_once "modules/stats/function.php";

#Получаем $_GET
if(!empty($_GET['id']))
{
	$date_day = $_GET['id'];
}

if(!empty($date_day)) {
	// Получаем название новости
		$tpl->content .= viewstats($date_day);
		$sql2 = DB::query("SELECT * FROM `stats_days` WHERE `date_day` = '{$date_day}'");
				$row2 = $sql2->fetch();
				$title = 'Статистика за '.$row2['name'].'';
	#Список новостей
	} else {
		$title = 'Статистика';
		$tpl->content .= liststats();
	}

          ?>