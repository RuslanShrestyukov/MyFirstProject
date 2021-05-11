<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
$title = 'Партнерская программа';
if ($userinfo['group'] > 0) {
$tpl->content .= $eng->msg("3", "Ваша партнерская ссылка находится в <a href='http://{$_SERVER['SERVER_NAME']}/settings'>настройках</a> ", "3") ;
}

$tpl->content .= '

<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-users"></i> Партнерская программа</h3>						
			</div>
			<div class="box-body table-responsive">	
			<p class="lead"><b>Хотите начать зарабатывать не вкладывая деньги ???</b> <br><br>

У нас на сайте это возможно! Стать партнером может любой желающий. Для этого достаточно сделать несколько шагов:<br><br>

1) Зарегистрироваться у нас на сайте<br>
2) Активировать партнерский аккаунт<br>
3) Начать привлекать клиентов<br><br>

После активации партнерской программы вам будет выдана реферальная ссылка по которой
 вы сможете привлекать посетителей на сайт. За каждого привлеченного вами клиента 
 вы будете получать <b>20%</b> партнерских отчислений. И самое главное, что данные люди становятся вашими клиентами на постоянной основе. А это значит, что при всех последующих покупках, вы так же будете получать свои проценты!
</p>

				</div>
		</div>
	</div>
</div>

';

if ($userinfo['group'] > 0) {
$tpl->content .= '

<div class="box box-solid">
		<div class="box box-solid">
			<div class="box-header">
			<i class="fa fa fa-list"></i>
				<h3 class="box-title">Партнерская программа</h3>						
			</div>
			<div class="box-body table-responsive">
		
';
$sql = DB::query("SELECT COUNT(*) FROM `users_res` WHERE `user_id` = '{$userinfo['id']}'  order by id desc");
      if($sql->fetchColumn() > 0){     
	  $tpl->content .= '<table class="table table-bordered">
				<thead>
					<th>Пользователь</th>
					<th>Дата регистрации</th>
					<th>Доход</th>
				</thead>
			<tbody>';
			$sql = DB::query("SELECT * FROM `users_res` WHERE `user_id` = '{$userinfo['id']}'  order by id desc");
	while ($row = $sql->fetch())
	{	
	$tpl->content .= '<tr>
				<td>'.$row['login'].'</td>
				<td>'.$eng->showtime($row['time'], 1).'</td>
				<td>'.$row['money'].'</td>
				</td>
			</tr>';	
	} 
	$tpl->content .= '</tbody>
	</table></div></div></div>';
	} else
	$tpl->content .=  $eng->msg("3", "У вас еще нет рефералов", "3")	;
}
          ?>