<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

class Users
{
	
	# NEWGUARD v2 
	/*
	Описание: Авторизация пользователей в системе
	Параметры: Остутствуют
	*/
	static function chauth()
	{
		if (isset($_COOKIE["id"]) && isset($_COOKIE["hash"])) 
		{
			$id = $_COOKIE['id'];
			$hash = $_COOKIE['hash'];
			//$sql = $db->query("SELECT `users`.*, `groups`.`access` AS `gaccess` FROM `users`,`groups` WHERE `users`.`id` = '{$id}' AND FIND_IN_SET('{$hash}', `users`.`hash`) AND `users`.`group_id` = `groups`.`group_id`");
			$user_num = DB::query("SELECT COUNT(*) FROM `users` WHERE `id` = '{$id}' AND `hash` = '{$hash}'");
			if ($user_num->fetchColumn() > 0) 
				{
				$sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$id}' AND `hash` = '{$hash}'");
				$row = $sql->fetch();
				return array('group' => $row['group_id'], 'login' => $row['login'], 'id' => $row['id']);
			} else
				return array('group' => 0, 'id' => 0);
		} else
			return array('group' => 0, 'id' => 0);
	}
	
	# NEWGUARD v2 
	/*
	Описание: Ссылка на аватар пользователя
	Параметры: $id (число)  - номер пользователя
	*/	
	static function avatar($id) 
	{
		$filename = $_SERVER['DOCUMENT_ROOT'].BASEDIR.'/main/avatar/'.$id.'.jpg';
		if (file_exists($filename))
			return SITEDIR.BASEDIR.'/main/avatar/'.$id.'.jpg';
		else
			return SITEDIR.BASEDIR.'/main/avatar/noavatar.jpg';
	}
	
	# NEWGUARD v2 
	/*
	Описание: Получение имени пользователя
	Параметры: $intid (число)  - номер пользователя ( берется из базы)
			   $status (число)  1 - с применением цвета
								0 - без цвета
	*/	
	static function name_user($id, $status) {
		$intid = intval($id);
		$user_num = DB::query("SELECT COUNT(*) FROM `users` WHERE  `id` = {$intid}");
			if ($user_num->fetchColumn() == 1) 
				{
				$sql = DB::query("SELECT * FROM `users` WHERE  `id` = {$intid}");
				$row = $sql->fetch();			
				$group_id = $row['group_id'];
					$sql1 = DB::query("SELECT * FROM `groups` WHERE  `group_id` = {$group_id}");
					$row1 = $sql1->fetch();
					if($status == '1') 
						{
							return "<font color='".$row1['color']."'>".$row['login']."</font>";			
						}	 
					else 
						{
							return $row['login'];
						}
				
		}	 else {
			return "Неизвестно";
		}
	}
	
	
	# NEWGUARD v2 
	/*
	Описание: Получение названия группы пользователя
	Параметры: $intid (число)  - номер группы пользователя ( берется из базы)
			   $status (число)  1 - с применением цвета
								0 - без цвета
	*/	
	static function groupname($intid, $status) {
		$intid = intval($intid);
		$user_num = DB::query("SELECT COUNT(*) FROM `groups` WHERE  `group_id` = {$intid}");
			if ($user_num->fetchColumn() == 1) 
				{
				$sql = DB::query("SELECT * FROM `groups` WHERE  `group_id` = {$intid}");
				$row = $sql->fetch();
			if($status == '1' AND $row['group_id'] > 2) {
				return "<font color='".$row['color']."'>".$row['group_name']."</font>";			
			} else {
				return $row['group_name'];
			}
		} else {
			return "Ошибка";
		}
	}
	
	/*
	
	*/
	static function news_count($newsid)
	{
		$news_num = DB::query("SELECT COUNT(*) FROM `news` WHERE  `id` = {$newsid}");
			if ($news_num->fetchColumn() > 0) 
				{
				$sql = DB::query("SELECT * FROM `news` WHERE  `id` = {$newsid}");
				$row = $sql->fetch();	
				$count = $row['count'] + 1;
				$sql1 = DB::query("UPDATE `news` SET  `count` =  '{$count}' WHERE id = '{$newsid}'");
				}
	}
	
}
?>