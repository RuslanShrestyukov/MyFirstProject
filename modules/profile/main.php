<?php


$escaped_user = (!empty($_GET['user']) ? intval($_GET['user']) : ($userinfo['group'] ? $userinfo['id'] : 0));
$user_num = DB::query("SELECT COUNT(*) FROM `users` WHERE `id` = '{$escaped_user}'");

	if ($user_num->fetchColumn() > 0) 
	{
$sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$escaped_user}'");
$row = $sql->fetch();
if($row['vk'] != '') {
	$vk = '<li><b>VK:</b> <a href="'.$row['vk'].'">'.$row['vk'].'</a></li>';
} else {
	$vk = '';
}
if($row['bk'] != '') {
	$bk = '<li><b>Букмекерская контора:</b> '.$row['bk'].'</li>';
} else {
	$bk = '';
}
if($row['name'] != '') {
	$name = '<li><b>Полное имя:</b> '.$row['name'].'</li>';
} else {
	$name = '';
}
$title = 'Профили';

$tpl->content .= '
<div class="row">
	<div class="col-xs-12">
		<h2 class="page-header">
			<i class="fa fa-user"></i> Профиль пользователя '.$us->name_user($row['id'], 1).'
			<small class="pull-right badge bg-black">№ '.$row['id'].'</small>
		</h2>
	</div>
</div>

<div class="box box-solid col-md-12">
	<div class="box-body">
		<div class="col-md-6">
			<legend>Основная информация</legend>
			<img src="'.$us->avatar($row['id']).'" width="65px" height="65px" class="img-circle pull-right">
			<ul class="listnone">
				'.$name.'
				<li><b>Регистрация:</b> '.$row['date_reg'].'</li>
				<li><b>Был в сети:</b> '.$eng->showtime($row['lastseen'], 1).'</li>
				'.$bk.'
				'.$vk.'
				
				<br>
				<li><b>Группа:</b> '.$us->groupname($row['group_id'], 1).'</li>
				
			</ul>

				
		</div>	
		<div class="col-md-6">
			<legend>Последние прогнозы</legend>
						
			
			<div class="alert alert-info alert-dismissable">
                    <i class="fa fa-info"></i>
					
                    Не найдено сообщений
                </div>
				
			
			<legend>Последние подписки</legend>';
			$accounts_num = DB::query("SELECT COUNT(*) FROM `accounts` WHERE `user_id` = '{$escaped_user}'");
	if ($accounts_num->fetchColumn() > 0) 
	{
$sql_1 = DB::query("SELECT * FROM  `accounts` WHERE `user_id` = '{$escaped_user}'");
$row_1 = $sql_1->fetch();

$sql_2 = DB::query("SELECT * FROM `podpiska` WHERE `id` = '{$row_1['type']}'");
$row_2 = $sql_2->fetch();
$tpl->content .='
<div class="table-responsive">
					
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Тариф</th>		
							<th>Срок</th>		
							<th>Дата окончания</th>	
							</tr>
						</thead>
						<tbody>
							
							<tr>
								<td>'.$row_2['name'].'</td>		
							<td>'.$row_2['date'].'</td>		
							<td>'.$eng->showtime($row_1['date_end'], 1).'</td>		
						</tr>
							</tr>
							
						</tbody>
					</table>
				</div>
';
	} else {
			$tpl->content .= $eng->msg("3", "Подписок не найдено.", "3");
	}
		$tpl->content .= '	
			
			
		</div>	
	</div>
</div>
';
} else 
{
$title = 'Профиль';
$tpl->content .= $eng->msg(3,'Пользователь не найден', 3);
}

          ?>