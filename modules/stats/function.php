<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
function liststats() 
{
		global  $eng, $us, $tpl;
		
		$userinfo = $us->chauth();
$ar = DB::query("SELECT * FROM stats order by id desc");

$tpl->content .= '

<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-list"></i> Статистика</h3>						
			</div>
			<div class="box-body table-responsive">	
			
			<div class="btn-group" style="margin-bottom: 20px">
				<button id="srvtitle" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Архив статистики</button>
				<button class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu srvlist" role="menu">
				';
						$stats = DB::query("SELECT * FROM stats_days");
						while ($rows = $stats->fetch())
{
						$tpl->content .= '
						<li><a href="stats_'.$rows['date_day'].'">'.$rows['name'].'</a></li>
						';
}
					
					
									
					$tpl->content .= '
				</ul>
				</div>
				<table class="table table-bordered" style="text-align: center;">
					<tbody>	
						<tr> 
							<td><b>Дата</b></td>
							<td><b>Матч</b></td>
							<td><b>Прогноз</b></td>	
							<td><b>Коэф</b></td>	
							<td><b>Счет</b></td>	
							<td><b>Исход</b></td>		
						</tr>
						
						';
						
						$accounts_num = DB::query("SELECT COUNT(*) FROM `accounts` WHERE `user_id` = '{$userinfo['id']}'");
						if ($accounts_num->fetchColumn() > 0) 
						{
							$podpiska = 1;
						} else {
							$podpiska = 0;	
						}
						while ($row = $ar->fetch())
						{
							
							$array_header = array(0 => 'primary',1 => 'warning', 2 => 'success', 3 => 'danger');
						$array_status = array(0 => 'Ожидание',1 => 'Прошел', 2 => 'Возврат', 3 => 'Не прошел');
								if(isset($array_status[$row['result']]))
									$status = $array_status[$row['result']];
								if(isset($array_header[$row['result']]))
									$header = $array_header[$row['result']];
								if($row['type'] == 1 AND $podpiska == 0 AND $row['result'] == 0) 
								{
									$tpl->content .= '
								<tr> 
								<td>'.$eng->showtime($row['date_month'], 1).'</td>
									<td colspan="5"><b>Платный прогноз. Для просмотра необходимо купить подписку.<b></td>				
								</tr>	';
								} else {
									$tpl->content .= '
								<tr> 
									<td>'.$eng->showtime($row['date_month'], 1).'</td>
									<td>'.$row['match'].'</td>
									<td>'.$row['forecast'].'</td>	
									<td>'.$row['coefficient'].'</td>	
									<td>'.$row['score'].'</td>	
									<td><small class="label label-'.$header.'">'.$status.'</small></td>			
								</tr>	';
								}
							
}
					
					
									
					$tpl->content .= '</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

';
}

function  viewstats($date_day) {
	
			global  $eng, $us, $tpl;
			$userinfo = $us->chauth();
// Проверяем есть ли записи за данное число 
$stats_pr = DB::query("SELECT COUNT(*) FROM `stats` WHERE `date_day` = '{$date_day}'");
if($stats_pr->fetchColumn() > 0) {	
$ar = DB::query("SELECT * FROM `stats` WHERE `date_day` = '{$date_day}'");

$tpl->content .= '

<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-list"></i> Статистика</h3>						
			</div>
			<div class="box-body table-responsive">	
			
			<div class="btn-group" style="margin-bottom: 20px">
				<button id="srvtitle" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Архив статистики</button>
				<button class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu srvlist" role="menu">
				';
						$stats = DB::query("SELECT * FROM stats_days");
						while ($rows = $stats->fetch())
{
						$tpl->content .= '
						<li><a href="stats_'.$rows['date_day'].'">'.$rows['name'].'</a></li>
						';
}
					
					
									
					$tpl->content .= '
				</ul>
				</div>
				<table class="table table-bordered" style="text-align: center;">
					<tbody>	
						<tr> 
							<td><b>Дата</b></td>
							<td><b>Матч</b></td>
							<td><b>Прогноз</b></td>	
							<td><b>Коэф</b></td>	
							<td><b>Счет</b></td>	
							<td><b>Исход</b></td>		
						</tr>
						
						';
						
						$accounts_num = DB::query("SELECT COUNT(*) FROM `accounts` WHERE `user_id` = '{$userinfo['id']}'");
						if ($accounts_num->fetchColumn() > 0) 
						{
							$podpiska = 1;
						} else {
							$podpiska = 0;	
						}
						while ($row = $ar->fetch())
						{
							
							$array_header = array(0 => 'primary',1 => 'warning', 2 => 'success', 3 => 'danger');
						$array_status = array(0 => 'Ожидание',1 => 'Прошел', 2 => 'Возврат', 3 => 'Не прошел');
								if(isset($array_status[$row['result']]))
									$status = $array_status[$row['result']];
								if(isset($array_header[$row['result']]))
									$header = $array_header[$row['result']];
								if($row['type'] == 1 AND $podpiska == 0 AND $row['result'] == 0) 
								{
									$tpl->content .= '
								<tr> 
								<td>'.$eng->showtime($row['date_month'], 1).'</td>
									<td colspan="5"><b>Платный прогноз. Для просмотра необходимо купить подписку.<b></td>			
								</tr>	';
								} else {
									$tpl->content .= '
								<tr> 
									<td>'.$eng->showtime($row['date_month'], 1).'</td>
									<td>'.$row['match'].'</td>
									<td>'.$row['forecast'].'</td>	
									<td>'.$row['coefficient'].'</td>	
									<td>'.$row['score'].'</td>	
									<td><small class="label label-'.$header.'">'.$status.'</small></td>			
								</tr>	';
								}
}
					
					
									
					$tpl->content .= '</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

';
} 
else 
{
	$tpl->content .= $eng->msg("3", "За данный месяц прогнозов не нейдено. Выберите другой месяц", "3"); 
	$tpl->content .=  '<meta http-equiv="refresh" content="3;URL=http://'.$_SERVER['SERVER_NAME'].'/stats">';
}
}

?>