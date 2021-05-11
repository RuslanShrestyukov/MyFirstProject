<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

function auth($login,$password) 
{  
global $eng;
		//$pass = $eng->GeneratePassword($password);
	$user_num = DB::query("SELECT COUNT(*) FROM `users` WHERE `login` = '{$login}' OR `email` = '{$login}'");

	if ($user_num->fetchColumn() > 0) 
	{
		$sql = DB::query("SELECT * FROM `users` WHERE `login` = '{$login}' OR `email` = '{$login}'");
		$row = $sql->fetch();
		$unpass = $eng->UnGeneratePassword($password, $row['password']);
			if($unpass == true)
			{
				$hash = $eng->GenerateKey(10);
				setcookie("hash", $hash, time()+2592000, "/");
				setcookie("id", $row['id'], time()+2592000, "/");
		
				// Обновление хеша
				$sql = "UPDATE `users` SET  `hash` = :hash WHERE `id` = '{$row['id']}'";
				$q = DB::prepare($sql);
				$q->execute(array(':hash'=>$hash));
		
				//Получаем информацию о браузере
				$data = $eng->checkguestinfo();
		
				//$db->query("INSERT INTO `log_auth` (`id`, `user_id`, `hash`, `browser`, `os`, `ip`, `lastseen`) VALUES (NULL, '{$row['id']}', '{$hash}', '{$data['browser']}', '{$data['os']}', '".USER_IP."', '".time()."')");
				$id = $row['id'];
				$browser = $data['browser'];
				$os = $data['os'];
				$ip = USER_IP;
				$time = time();
				$sql = "INSERT INTO `log_auth` (`id`, `user_id`, `hash`, `browser`, `os`, `ip`, `lastseen`) VALUES (NULL, :id, :hash, :browser, :os, :ip, :time)";
				$q = DB::prepare($sql);
				$q->execute(array(':id'=>$id,
									':hash'=>$hash,
									':browser'=>$browser,
									':os'=>$os,
									':ip'=>$ip,
									':time'=>$time));
			header("Location: ".SITEDIR);							
			} 
			else 
			{
				return array('type' => 'error', 'msg' => "Неверный логин или пароль");
			}
	} 
	else {
		return array('type' => 'error', 'msg' => "Пользователь с таким логином не найден.");
	}
}

# NEWGUARD v2 
/*
Описание: Выход из профиля
Параметры: $user_id (число)   - номер пользователя
*/
function logout($user_id)
{	
	$user_id = intval($user_id);
	$hash = $_COOKIE['hash'];
	
    session_unset();
    session_destroy();
	setcookie('id', '', 0, "/");
	setcookie('hash', '', 0, "/");
	
	$user_num = DB::query("SELECT COUNT(*) FROM `users` WHERE `id` = '{$user_id}'");

	if ($user_num->fetchColumn() > 0) 
	{
		$sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$user_id}' AND `hash` = '{$hash}'");
		$row = $sql->fetch();
		$check = explode(",", $row['hash']);
		if($key = array_search($hash, $check) AND isset($check[$key])) 
			unset($check[$key]);
		$newhash = implode(',',$check);
		$sql1 = "UPDATE `users` SET  `hash` = :hash WHERE `id` = :id";
				$q = DB::prepare($sql1);
				$q->execute(array(':hash'=>$newhash,
									':id'=>$user_id
				));
				
	}
	$sql2 = "DELETE FROM `log_auth` WHERE `hash` = :hash ";
				$q = DB::prepare($sql2);
				$q->execute(array(':hash'=>$hash
				));
	
    header("Location: ".SITEDIR);
	exit();
}

          ?>