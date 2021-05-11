<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
$ar = DB::query("SELECT * FROM stats order by id desc LIMIT 10");

$tpl->content .= '

<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-list"></i> Статистика последних 10 матчей</h3>						
			</div>
			<div class="box-body table-responsive">			
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
				<div style="text-align:center;margin-top:20px;margin-bottom:10px;"><a href="/stats" class="btn btn-success btn-lg">Полная статистика</a></div>
			</div>
		</div>
	</div>
</div>';
          ?>