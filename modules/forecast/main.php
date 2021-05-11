<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
$title = 'Главная';
$tpl->content .= '

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Нерассчитанные</a></li>    
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
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
						$ar_count = DB::query("SELECT COUNT(*) FROM `stats` WHERE `result` = '0'");
			if ($ar_count->fetchColumn() > 0) 
			{
						$ar = DB::query("SELECT * FROM stats WHERE `result` = '0' order by id desc");
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
}
else
						{
							$tpl->content .= $eng->msg(3,'Ещё нет добавленных прогнозов', 3);		
									}
									
					$tpl->content .= '</tbody>
				</table>
              </div>
              </div>
              <!-- /.tab-pane -->
            
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->

';
          ?>