<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
#Подключаем файл функций
require_once "modules/pages/docs.php";
$docsid = "";
#Получаем $_GET
if(!empty($_GET['id']))
{
	$docsid = intval($_GET['id']);
}

if($docsid == 1) {
		$title = 'Согласие на обработку персональных данных';		
		$tpl->content .= doc_1();
	#Список новостей
	} else
if($docsid == 2)  {
		$title = 'Политика конфиденциальности';
		$tpl->content .= doc_2();
	} 
	else {
		$title = 'Договор оферты';
		$tpl->content .= doc();
	}


          ?>