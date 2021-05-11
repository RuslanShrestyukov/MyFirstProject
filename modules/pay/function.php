<?php if (!defined('NEWGUARD'))			exit('Нет доступа');



function pay_id($id_pay) {
	global  $eng, $us, $tpl;
	$userinfo = $us->chauth();
	#$tpl->content .= $eng->msg("1", "Тип подписки равен {$id_pay}", "1");
	//Проверяем, существует ли данная подписка
	$sql = DB::query("SELECT COUNT(*) FROM `podpiska` WHERE `id` = '{$id_pay}'");
	if($sql->fetchColumn() > 0)
	{
		$sql = DB::query("SELECT * FROM `podpiska` WHERE `id` = '{$id_pay}'");
		$row = $sql->fetch();
		
		$users = DB::query("SELECT * FROM `users` WHERE `id` = '{$userinfo['id']}'");
		$user = $users->fetch();
			//Проверяем, хватает ли денег для покупки, если нет то перекидываем на страницу пополнения
			if($user['user_money'] >= $row['cost']) {
				
				//Проверяем существует ли подписка
				$sql = DB::query("SELECT COUNT(*) FROM `accounts` WHERE `user_id` = '{$userinfo['id']}'");
					if($sql->fetchColumn() > 0)
					{	
						$dats = DB::query("SELECT * FROM `accounts` WHERE `user_id` = '{$userinfo['id']}'");
						$dats_1 = $dats->fetch();
						$date_end = $dats_1['date_end'] + ($row['date_num']*24*3600);
						$sql = DB::query("UPDATE `accounts` SET  `date_end` =  '{$date_end}', `type` = '{$row['id']}' WHERE user_id = '{$userinfo['id']}'");
						
						$new_money = $user['user_money'] - $row['cost'];
							$sql = DB::query("UPDATE `users` SET  `user_money` =  '{$new_money}' WHERE id = '{$userinfo['id']}'");
						
						$tpl->content .= $eng->msg("1", "Ваша подписка продлена на срок: {$row['date']}<br>Стоимость: {$row['cost']} ", "1");
					} else {
				//Переменные
				$new_money = $user['user_money'] - $row['cost'];
				$date_start = time();
				$date_end = $date_start + ($row['date_num']*24*3600);
				
					$sql = DB::query("UPDATE `users` SET  `user_money` =  '{$new_money}' WHERE id = '{$userinfo['id']}'");
					$tpl->content .= $eng->msg("1", "Вы успешно купили услугу: <br>{$row['name']}<br>Срок: {$row['date']}<br>Цена: {$row['cost']} ", "1");
					//Заносим в базу 
					$sql = "INSERT INTO `accounts` (`user_id`, `type`, `date_start`, `date_end`) 
				VALUES(:user_id, :type, :date_start, :date_end )";
				$q = DB::prepare($sql);
				$q->execute(array(':user_id'=>$userinfo['id'],
									':type'=>$row['id'],
									':date_start'=>$date_start,
									':date_end'=>$date_end
									));
					}
					$tpl->content .= '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/">';
			} else {
				$tpl->content .= $eng->msg("3", "Пополните баланс, для совершение операции.", "3");
				$tpl->content .= '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/balance">';
			}
	} else {
		$tpl->content .= $eng->msg("2", "Данная подписка не найдена.", "2");
		$tpl->content .= '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/">';

	}

}

function pay_null() {
	global  $eng, $us, $tpl;
	$tpl->content .= $eng->msg("3", "Не выбран тип подписки на прогноз. Перейдите на главную траницу, для оформления прогноза", "3"); 
}

          ?>