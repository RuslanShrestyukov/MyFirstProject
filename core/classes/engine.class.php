<?php if (!defined('NEWGUARD'))			

exit('Нет доступа');

class Engine
{

	function alert_mess($mess)
    {
        return "\r\n\t\t\t<script type='text/javascript'>\r\n\t\t\t\t\$(document).ready(function(){\r\n\t\t\t\t\t\$('#mess').jGrowl('<center><strong>" . $mess . "</strong></center>', { life: 5000 });\r\n\t\t\t\t});\r\n\t\t\t</script>";
    }
	
# NEWGUARD v2 
	/*
	Описание: Логирование действий
	Параметры: $contents (текст)   - номер пользователя 
			   $file (текст) - название файла без расширения
	*/		
	function log($contents, $file) 
	{
		file_put_contents($_SERVER['DOCUMENT_ROOT'].BASEDIR.'/main/logs/'.$file.'.txt', $contents, FILE_APPEND);	
	}
	
	# NEWGUARD v2 
	/*
	Описание: Логирование действий V2 в базу данных
	Параметры: $text (текст)   - Текст логирования
			   $user_id (текст) - id пользователя
			   $time (текст) - время
			   $icons (текст) - иконка
	*/		
	function bd_log($text, $user_id, $time, $icons) 
	{
		$sql = DB::query("INSERT INTO `ap_logs` (`text`,`user_id`,`time`,`icons`) VALUES('{$text}', '{$user_id}', '{$time}' ,'{$icons}' )");
	}
	
	# NEWGUARD v2 
	/*
	Описание: Генерация пароля с солью
	Параметры: $password - пароль
	password_verify($password, $hash) - проверка пароля на правильность
	*/	
	function GeneratePassword($password) 
	{
	return password_hash($password, PASSWORD_DEFAULT);
	}
	
	# NEWGUARD v2 
	/*
	Описание: Проверка пароля на правильность
	Параметры: $password - пароль в исходном виде
			   $hash - пароль из базы данных
	password_verify($password, $hash) - проверка пароля на правильность
	*/
	function UnGeneratePassword($password, $hash) 
	{
		if (password_verify($password, $hash))
			{
				return true;
			}	
		else 
			{
				return false;
			}
	}
	 
	# NEWGUARD v2 
	/*
	Описание: Генерация ключа
	Параметры: $length (число)   - длина ключа
	*/			
	function GenerateKey($length) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;  
		while (strlen($code) < $length)
			$code .= $chars[mt_rand(0,$clen)];  
		return md5($code);
	}
	
	# NEWGUARD v2 
	/*
	Описание: Навигация страниц
	Параметры: $num (число)    	-        Количество записей
		$step (число)   		-        Шаг
		$cur_page (число)   	-        Текущая страница
		$put (текст)			-		 Ссылка до страницы
	*/
	function pagination($num, $step, $cur_page, $put) 
	{
		$num_pages=ceil($num/$step);
		if ($num_pages > 1) 
		{
			$result = '<center><div class="dataTables_paginate paging_bootstrap"><ul class="pagination">';
			if(($cur_page+1) == 1)
				$result .= '<li class="prev disabled"><a>Назад</a></li>';
			else	
				$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.''.$cur_page.'">Назад</a></li>';
			if($num_pages > 10) 
			{
				if(($cur_page+1) >= ($num_pages-3)) 
				{
					$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.'1">1</a></li>';
					$result .=  '<li class="prev disabled"><a>...</a></li>';		
					for($i=($num_pages-4);$i<=$num_pages;$i++) 
					{
						if ($i-1 == $cur_page)
							$result .= '<li class="active"><a>'.$i.'</a></li>';
						else
							$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.''.$i.'">'.$i.'</a></li>';
					}				
				} else if(($cur_page+1) > 4) {
					$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.'1">1</a></li>';
					$result .=  '<li class="prev disabled"><a>...</a></li>';
					for($i=($cur_page-1);$i<=($cur_page+3);$i++) 
					{
						if ($i-1 == $cur_page)
							$result .= '<li class="active"><a>'.$i.'</a></li>';
						else
							$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.''.$i.'">'.$i.'</a></li>';
					}
					$result .=  '<li class="prev disabled"><a>...</a></li>';
					$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.''.$num_pages.'">'.$num_pages.'</a></li>';
				} else {
					for($i=1;$i<=5;$i++) 
					{
						if ($i-1 == $cur_page)
							$result .= '<li class="active"><a>'.$i.'</a></li>';
						else
							$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.''.$i.'">'.$i.'</a></li>';
					}
					$result .=  '<li class="prev disabled"><a>...</a></li>';
					$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.''.$num_pages.'">'.$num_pages.'</a></li>';
				}
			} else {
				for($i=1;$i<=$num_pages;$i++) 
				{
					if ($i-1 == $cur_page)
						$result .= '<li class="active"><a>'.$i.'</a></li>';
					else
						$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.''.$i.'">'.$i.'</a></li>';
				}
			}
			if($num_pages == ($cur_page+1)) 
				$result .= '<li class="prev disabled"><a>Вперед</a></li>';
			else 
				$result .= '<li><a href="'.SITEDIR.''.BASEDIR.''.$put.''.($cur_page+2).'">Вперед</a></li>';
			$result .= "</ul></div></center>\n";
		} else 
			$result = '';
		return $result;
	}
	
	# NEWGUARD v2 
	/*
	Описание: Вывод времени
	Параметры: $timestamp (число)   - время в формате timestamp
			   $type (число)  - переключатель ~ 1 - со временем 0 - без
	*/		
	function showtime($timestamp, $type) 
	{
		$date = date("d.m.Y", $timestamp);
		$yesterday = date("d.m.Y", mktime(0, 0, 0, date("m"), date("d")-1, date("Y"))); 
		if ($date == date("d.m.Y")) 
		{
			if($type == '1')
				$date = date("Сегодня в H:i", $timestamp);
			else
				$date = date("H:i", $timestamp);
		} else if ($yesterday == $date)
			$date = date("Вчера в H:i", $timestamp);
		else {
			if($type == '1')
				$date = date("d.m.Y в H:i", $timestamp);
			else if($type == '2')
				$date = date("m.Y", $timestamp);
			else
				$date = date("d.m.Y", $timestamp);
		}
		return $date;
	}
	
	# NEWGUARD v2 
	/*
	Описание: Вывод сообщений
	Параметры: 
	*/		
	function msg($header, $msg, $status) 
	{
		$array_status = array(1 => 'success', 2 => 'danger', 3 => 'info', 4 => 'warning');
		$array_icons = array(1 => 'check', 2 => 'ban', 3 => 'info', 4 => 'warning');
		$array_header = array(1 => 'Поздравляем!', 2 => 'Ошибка!', 3 => 'Информация', 4 => 'Предупреждение');
		if(isset($array_icons[$status]))
			$icons = $array_icons[$status];
		if(isset($array_status[$status]))
			$status = $array_status[$status];
		else
			$status = 4;
		if(isset($array_header[$header]))
			$header = $array_header[$header];
		
		return "<div class='alert alert-{$status} alert-dismissable'><i class='fa fa-{$icons}'></i><strong>{$header}</strong><br />{$msg}</div>";
	}
	
	# NEWGUARD v2 
	/*
	Описание: PDO и запросы INSERT/UPDATE
	Параметры: $allowed (массив)   - Переменные и название строк в таблице (должны совпадать)
			   $type (число)  - переключатель ~ 1 - со временем 0 - без
	*/		
	
	function pdoSet($allowed, &$values, $source = array()) 
	{
		$set = '';
		$values = array();
		if (!$source) $source = &$_POST;
		foreach ($allowed as $field) {
			if (isset($source[$field])) {
			$set.="`".str_replace("`","``",$field)."`". "=:$field, ";
			$values[$field] = $source[$field];
			}
  }
  return substr($set, 0, -2); 
	}
	
	# NEWGUARD v2 
/*
Описание: Узнать браузер и ОС пользователя
Параметры: Отсутствуют
*/
function checkguestinfo()
{
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$browsers = array(
		'firefox' => 'Mozilla Firefox',
		'opera' => 'Opera',
		'chrome' => 'Google Chrome',
		'msie' => 'Internet Explorer',
		'safari' => 'Safari',
		'netscape' => 'Netscape',	
		'opera mini' => 'Opera Mini',
		'NetPositive' => 'NetPositive',
		'blackberry' => 'BlackBerry',
		'flock' => 'Flock',
		'konqueror' => 'Konqueror',
		'Nokia' => 'Nokia Браузер',
		'lynx' => 'Lynx',
		'amaya' => 'Amaya',
		'omniweb' => 'Omniweb',
		'aol' => 'AOL'		
	);
	foreach($browsers AS $key => $value)
	{
		if (strpos($useragent, $key) !== false)
		{
			$browser = $value;
			break;
		}
	}
	$oses = array(
		'iPad' => '/(ipad)/',
		'iPhone' => '/(iphone)/',
		'WindowsPhone' => '/(windowsphone)/',
		'Symbian' => '/(symbian)/',
		'Android' => '/(android)/',
		'Windows 3.11' => '/win16/',
		'Windows 95' => '/(windows 95)|(win95)|(windows_95)/',
		'Windows 98' => '/(windows 98)|(win98)/',
		'Windows 2000' => '/(windows nt 5.0)|(windows 2000)/',
		'Windows XP' => '/(windows nt 5.1)|(windows XP)/',
		'Windows 2003' => '/(windows nt 5.2)/',
		'Windows Vista' => '/(windows nt 6.0)|(windows vista)/',
		'Windows 7' => '/(windows nt 6.1)|(windows 7)/',
		'Windows 8' => '/(windows nt 6.2)|(windows 8)/',
		'Windows NT 4.0' => '/(windows nt 4.0)|(winnt4.0)|(winnt)|(windows nt)/',
		'Windows ME' => '/windows me/',
		'Open BSD'=>'/openbsd/',
		'Sun OS'=>'/sunos/',
		'Linux'=>'/(linux)|(x11)/',
		'Safari' => '/(safari)/',
		'Macintosh'=>'/(mac_powerpc)|(macintosh)/',
		'QNX'=>'/qnx/',
		'BeOS'=>'/beos/',
		'OS/2'=>'/os/2/',
		'Бот'=>'/(nuhk)|(googlebot)|(yammybot)|(openbot)|(slurp/cat)|(msnbot)|(ia_archiver)/'
	);
	foreach($oses AS $key => $value)
	{
		if (preg_match($value, $useragent))
		{
			$os = $key;
			break;
		}
	}
	if(!isset($browser))
		$browser = 'Неизвестно';
	if(!isset($os))
		$os = 'Неизвестно';
	return array('browser' => $browser, 'os' => $os);
	}
	
	function replaceBBCode($text_post) {
		$str_search = array(
		"#\[b\](.+?)\[\/b\]#is",
		"#\[i\](.+?)\[\/i\]#is",
		"#\[u\](.+?)\[\/u\]#is",
		"#\[url=((?:http|https):\/\/[^\s]+)\](.+?)\[\/url\]#is",
		"#\[url\]((?:http|https):\/\/[^\s]+)\[\/url\]#is",
		"#http://[a-z]{0,3}.youtube.com/watch\?v=([0-9a-zA-Z_-]{1,11})#is",
		"#\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[\/img\]#is",
		"#\[size=(.+?)\](.+?)\[\/size\]#is",
		"#\[color=(\#[0-9A-F]{6}|[a-z]+)\](.*?)\[\/color\]#is",
		"#\[quote\](.+?)\[\/quote\]#is",
		"#\[code\](.+?)\[\/code\]#is",
		"#\[center\](.+?)\[\/center\]#is",
		"#\[left\](.+?)\[\/left\]#is",
		"#\[right\](.+?)\[\/right\]#is",
		"#\[s\](.+?)\[\/s\]#is",
		"#\[list\](.+?)\[\/list\]#is",
 		 "#\[list=(1|a|I)\](.+?)\[\/list\]#is",
 		 "#\[*]\](.*)#"
		);
		$str_replace = array(
		"<b>\\1</b>",
		"<i>\\1</i>",
		"<span style='text-decoration:underline'>\\1</span>",
		"<a rel='nofollow' target='_blank' href='\\1'>\\2</a>",
		"<a rel='nofollow' target='_blank' href='\\1'>\\1</a>",
		"<iframe width='400' height='300' src='http://www.youtube.com/embed/\\1' frameborder='0' allowfullscreen></iframe>",
		'<img src="\\1" alt="..." width="150" height="100"  tabindex="0" class="margin">',
		"<font size='\\1'>\\2</font>",
		"<span style='color:\\1'>\\2</span>",
		"<blockquote><small>Цитата</small><p>\\1</p></blockquote>",
		"<pre class='pre-scrollable'>\\1</pre>",
		"<p style='text-align:center;'>\\1</p>",
		"<p style='text-align:left;'>\\1</p>",
		"<del>\\1</del>",
		"<ul>\\1</ul>",
  		"<ol type='\\1'>\\2</ol>",
  		"<li>\\1</li>",
		);
		return preg_replace($str_search, $str_replace, $text_post);
	}
	
	# NEWGUARD v2 
	/*
	Описание: Форматирование текста
	Параметры: $text (текст)   - текст сообщения
	*/		
	function input($text) 
	{
		$text = trim($text);
		$text = htmlspecialchars($text);
		$text = str_replace("\r\n", "<br />", $text);
		return $text;
	}

	# NEWGUARD v2 
	/*
	Описание: Форматирование текста (VARCHAR)
	Параметры: $text (текст)   - текст сообщения
			   $strlen (число)  - переключатель ~ 1 - обрезать 0 - не обрезать
			   $length (число)  - длина, до которой обрежится текст
	*/		
	function inputvar($text, $strlen = false, $length = 30) 
	{
		$text = trim($text);
		$text = htmlspecialchars($text);
		$text = str_replace("\r\n", "", $text);
		if(strlen($text) > $length)
            $text = mb_substr($text, 0, $length, 'UTF-8');
		return $text;
	}
	
	# NEWGUARD v2 
	/*
	Описание: Редактирование форматирование текста
	Параметры: $text (текст)   - текст сообщения
	*/		
	function editinput($text) 
	{
		$text = str_replace("<br />", "\r\n", $text);
		return $text;
	}
	
	
}
?>