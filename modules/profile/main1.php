<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

#Название страницы
$page = 'profile';

#Заголовок страницы
$tpl->changeTitle('Профиль');

#Навигация
$nav[] = array('url' => '/profile', 'name' => 'Профиль');

#Подключаем файл функций
require_once "modules/profile/function.php";

$css[] = 'jquery.toastmessage-min.css';
$javascript[] = 'jquery.toastmessage-min.js';

$getsmiles = $eng->getsmiles();

$escaped_user = (!empty($_GET['user']) ? intval($_GET['user']) : ($userinfo['group'] ? $userinfo['id'] : 0));
	
$sql = mysql_query("SELECT * FROM `users` WHERE id = '{$escaped_user}'");



# Пользователь существует
if (mysql_num_rows($sql) == 1) 
{
	$row = mysql_fetch_assoc($sql);
	$nav[] = array('name' => $row['login']);
	$sql2 =  mysql_query("SELECT * FROM `online` WHERE `id_user` = '{$row['id']}'") or die(mysql_error());
	$row2 =  mysql_fetch_array($sql2);
	if (mysql_num_rows($sql2) > 0) {
		$online_us = '<th>На данный момент</th><td>Онлайн</td>';
	} else {

		$online_us = '<th>Был в сети</th>
	<td>'.date("d.m.Y в H:i:s", $row['lastseen']).'</td>';
	}

	$tpl->content .=  '
	<div class="box box-solid">
		<div class="box box-solid">
			<div class="box-header">
			<i class="fa fa-user"></i>
				<h3 class="box-title">Профиль пользователя '.$row['login'].'</h3>						
			</div>
			<div class="box-body table-responsive">
			<div class="row">                    
			<div class="col-md-6">
                            <div class="box box-danger">
                                <div class="box-header">
                                   
                                    <h3 class="box-title">Общая информация</h3>';
									if (isset($userinfo['id']) AND $userinfo['id'] != $row['id'])
		$tpl->content .= '<div class="pull-right box-tools">
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm btn-flat hide" id="preloader" disabled=""></button>
					
				</div><button onclick="location.href=\'createdialog_'.$row['id'].'\'" class="btn btn-primary btn-sm btn-flat">Отправить ЛС</button>
					 
					</div>';
									
									
                                $tpl->content .= '</div><!-- /.box-header -->
                                <div class="box-body">
	<table class="table">';if ($userinfo['group'] == 4)  {
					$tpl->content .=  '<tr>
	<th>ID </th>
	<td>'.$row['id'].'</td>
	</tr>'; 
	$tpl->content .=  '<tr>
	<th>Логин</th>
	<td>'.$row['login'].'</td>
	</tr>
	
	'; 
	$useid = $row['id'];
	
					}
	if ($row['name'] == '') {
	$name = '';
	}
	else {$name = '
	<tr>
	<th>Имя</th>
	<td>'.$row['name'].'</td>
	</tr>
	';}
	$tpl->content .= ''.$name.'';
	$tpl->content .= '
	<tr>
	'.$online_us.'
	</tr>
	';
	// Для ранга
	if ($row['nick'] == '') {
	$nick = 'Не указан';
	}
	else {$nick = $row['nick'];}
	//проверка на ник
	if($row['nick'] == '') {
	$nickname = '';
	}
	else {$nickname = '
	<tr>
	<th>Ник в игре</th>
	<td>'.$row['nick'].'</td>
	</tr>
	';}
	$tpl->content .= ''.$nickname.'';
	#ДЛя кол-ва сообщений на форуме
	
	$hoz = $db->num_rows( $db->query("SELECT * FROM forums_messages WHERE `user_id` = '{$row['id']}'") );
		$tpl->content .= '
		<tr>
	<th>Сообщений на форуме</th>
	<td>'.$hoz.'</td>
	</tr>
		';
	
	
	if($row['vk'] == '') {
	$vk = '';
	}
	elseif ($vk = $row['vk']){
	$vk = '
	<tr>
	<th><i class="fa fa-vk"></i></th>
	<td><a target="_blank" rel="nofollow" href="https://'.$row['vk'].'">https://'.$row['vk'].'</a></td>
	</tr>
	';
	}
	$tpl->content .= ''.$vk.'';
	if($row['skype'] == '') {
	$skype = '';
	}
	elseif ($skype = $row['skype']){
	$skype = '
	<tr>
	<th><i class="fa fa-skype"></i></th>
	<td><a href="skype:'.$row['skype'].'?add">'.$row['skype'].'</a></td>
	</tr>
	';
	}
	$tpl->content .= ''.$skype.'';
	
	
	$tpl->content .= '
	<tr>
	<th>Друзья</th>
	<td><a href="http://'.$_SERVER['SERVER_NAME'].'/friends_'.$row['id'].'">Перейти к списку друзей</a></td>
	</tr>
	';
	$queryfr = $db->query("SELECT * FROM `friends` WHERE `id` = '{$row['id']}' AND FIND_IN_SET('{$userinfo['id']}', `friends`)");
	if(!$db->num_rows($queryfr) AND $row['id'] != $userinfo['id'] AND $userinfo['group'])
	$tpl->content .= '
	<tr>
	<th>Добавить друга</th>
	<td><a href="#addfriend" onclick="addfriend('.$row['id'].')">Послать заявку</a></td>
	</tr>
	';
	$tpl->content .= '
	<tr>
	<th>Группа</th>
	<td>'.$us->groupname($row['group_id'], 0).'</td>
	</tr>
	';

	$tpl->content .= '</table></div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
							
                                   <center> <img style=" -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 50%; border: 2px solid '.$us->userstatus($row['id']).';" src="'.$us->avatar($row['id']).'" width="245" height="245"/></center>
                                
						</div>';
						
	$tpl->content .= '					<div class="row">';
	$tpl->content .= adminfo($row['id']); 	
	$sql = $db->query("SELECT * FROM `stats_players` WHERE `user_id`='{$row['id']}'  LIMIT 1 ");
	if($db->num_rows($sql) > 0)
	{
		$servers = array();
		$query = $db->query("SELECT * FROM `servers`");
		while($row = $db->fetch_array($query))
			$servers[$row['id']] = $row['hostname'];
		$tpl->content .= '';	
		$tpl->content .= '<div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header">
                                    <i class="fa fa-bullhorn"></i>
                                    <h3 class="box-title">Игровой профиль</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body"><table class="table table-bordered">
	
		';
		while($row = $db->fetch_array($sql))
		{
			$rquery = $db->query("SELECT COUNT(*) FROM `stats_players`");
			$rowr = $db->fetch_array($rquery);

			$maketime1 = round($row['time']/3600);
			$maketime2 = round($row['time']/60);
			
			if($maketime1 > 0)
				$time = $eng->declOfNum($maketime1, array('час','часа','часов'));
			else {
				$time = $eng->declOfNum($maketime2, array('минута','минуты','минут'));
			}
			if($row['lseen'] > (time()-300))
				$lseen = '<font color="green"><b>Играет</b></font>';
			else
				$lseen = $eng->showtime($row['lseen'], 1);
				
			if($maketime2 != 0)
				$coeff = round($row['frags']/$maketime2,2);
			else
				$coeff = 0;
			$fseen = $eng->showtime($row['fseen'], 1);
			$tpl->content .= '
			<tr><th>Ник</th><td>'.$row['name'].'</td></tr>
			<tr><th>Сервер</th><td>'.$servers[$row['server']].' #'.$row['server'].'</td></tr>
			<tr><th>Фрагов</th><td>'.$row['frags'].'</td></tr>
			<tr><th>Сыграно</th><td>'.$time.'</td></tr>
			<tr><th>Коэф.</th><td>'.$coeff.'</td></tr>
			<tr><th>Первый вход</th><td>'.$fseen.'</td></tr>
			<tr><th>Последний вход</th><td>'.$lseen.'</td></tr>';
		}
		$tpl->content .= '</table></div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    ';
	} else {
	$tpl->content .= '<div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header">
                                    <i class="fa fa-bullhorn"></i>
                                    <h3 class="box-title">Игровой профиль</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
								'.$eng->msg("3", "За вашим ID не прикреплен не один профиль, перейдите в настройки и укажите свой ник в игре", "3").'
								</div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    
								';
	}
	
	$tpl->content .= '	</div>		';
	#$sql = $db->query("SELECT * FROM `add_bans` WHERE `s_id` = '{$row['id']}' ORDER BY `id` DESC LIMIT 10");
	#if($db->num_rows($sql) > 0)
	#{
	#	$tpl->content .= '<legend>Заявки на разбан [10 последних]</legend>';
	#	$tpl->content .= '<table class="table table-bordered"><thead><th>Ник игрока</th><th>Сервер</th><th>Статус</th><th>Дата</th><th>Действие</th></thead><tbody>';
	#	$resultcol = array("", "success", "error");
	#	$userstatuscol = array("На рассмотрении", "<font color='green'>Разбанен</font>", "<font color='red'>Не разбанен</font>");
	#	while($row = $db->fetch_array($sql)) 
	#	{ 
	#		$s_login = $us->username($row['s_id'], 0); 
	#		$tpl->content .= '<tr class="'.$resultcol[$row['type']].'"><td>'.$row['nick'].'</td><td>Пушки + Лазеры от NewCsdm</td><td>'.$userstatuscol[$row['type']].'</td><td>'.$eng->showtime(strtotime($row['date']),1).'</td><td><a href="http://'.$_SERVER['SERVER_NAME'].'/gounban.php?id='.$row['id'].'">Просмотр</a></td></tr>';
	#	}
	#	$tpl->content .= '</tbody></table>';
	#}
	#$sql = $db->query("SELECT * FROM `army_ranks` WHERE `steamid` = '{$nick}'");
	#if($db->num_rows($sql) > 0)
	#{
	#$tpl->content .= '<legend>Ранг</legend>';
	#$tpl->content .= '<table class="table table-bordered"><thead><th>Ник</th><th>Опыт</th><th>Звание</th></thead><tbody>';
	#while($row = $db->fetch_array($sql)) 
	#	{
	#	$name_array = array('Дух','Дух','Рядовой','Ефрейтор','Мл.сержант','Сержант','Ст.сержант','Дембель','Старшина','Прапорщик','Ст.прапорщик',
	#	'Мл.лейтенант','Лейтенант','Ст.лейтенант','Капитан','Майор','Подполковник','Полковник','Генерал','Генерал-лейтенант','Генерал-полковник'
	#	,'Генерал армии','__Маршал__','Максимальное развитие');
	#	$tpl->content .= '<tr><td>'.$row['steamid'].'</td><td>'.$row['exp'].'</td><td>'.$name_array[$row['level']].'</td></tr>';
	#	}
	#	$tpl->content .= '</tbody></table>';
	#}
	#else {
	#$tpl->content .= '<legend>Ранг</legend>';
	#$tpl->content .= $eng->msg("2", "Пользователь не указал <b>Ник в игре</b> или не играл на сервере", "2"); }
			
	$tpl->content .= '</div></div>';
# Пользователь не существует
} else
	$tpl->content .= $eng->msg("2", "Пользователь не существует", "2"); 