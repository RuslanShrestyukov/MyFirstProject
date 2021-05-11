<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
#Подключаем файл функций
require_once "modules/news/function.php";

#Получаем $_GET
if(!empty($_GET['id']))
{
	$newsid = intval($_GET['id']);
}

#Присутствует ли $_POST запрос
if($userinfo['group'] AND !empty($_POST))
{
	require_once "modules/news/action.php";
}

if(!empty($newsid)) {
	// Получаем название новости
			$news_num2 = DB::query("SELECT COUNT(*) FROM `news` WHERE `id` = '{$newsid}'");
			if ($news_num2->fetchColumn() > 0) 
			{
				$sql2 = DB::query("SELECT * FROM `news` WHERE `id` = '{$newsid}'");
				$row2 = $sql2->fetch();
				$title = ''.$row2['name'].' | Новости';
			} else
			{
				$title = 'Новости';
			}
		
		$tpl->content .= viewnews($newsid);
	#Список новостей
	} else {
		$title = 'Новости';
		$tpl->content .= listnews();
	}
       ?>