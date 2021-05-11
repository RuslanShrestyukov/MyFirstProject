<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

# NEWGUARD v2 
/*
Описание: Получает информацию о админках пользователя
Параметры: $id (число) - номер пользователя
*/
function adminfo($id) 
{
	global $db,$eng,$us;
	
	$snservers = array();
	$query = $db->query("SELECT * FROM `servers`");
	while($row = $db->fetch_array($query))
		$snservers[$row['id']] = $row['shortname'];
		
	$sql = $db->query("SELECT * FROM `accounts` WHERE `user_id` = '{$id}'");
	$result = '';
	if($db->num_rows($sql)) 
	{
		$result .= '';
		$result .= '
                        <div class="col-md-6">
                            <div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-star-half-o"></i>
                                    <h3 class="box-title">Админ профиль</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive"><table class="table table-bordered">
						<thead>
							<tr>
										<th>SteamID/Ник/IP</th>
										<th>Группа</th>
										<th>Опции</th>
										<th>Дата окончания</th>
									</tr>
						</thead>
					<tbody>';
		while($row = $db->fetch_array($sql)) 
		{
			if(!$row['date_end']) 
			{
				$accstatus = '<span class="label label-primary">Навсегда</span>';
				$date_end = 9999999999;
			} else {
				$date_out = round(($row['date_end']-time())/3600/24);
				if(time() > $row['date_end'])
					$accstatus = '<span class="label label-danger">Аккаунт просрочен</span>';
				else if($date_out == 0)
					$accstatus = '<font color="label label-danger">Осталось совсем немного</font>';
				else if($row['date_end'] > time())
					$accstatus = '<span class="label label-warning"> '.$eng->declOfNum($date_out, array("день", "дня", "дней")).''; 
			}
			// Преобразуем тип подключения
				if($row['type'] == 'ac') {
				$type = '<span class="label label-success">По SteamID</span>';
				}
				elseif($row['type'] == 'ad') {
				$type = '<span class="label label-warning">По IP</span>';
				}
				elseif($row['type'] == 'a') {
				$type = '<span class="label label-primary">По нику</span>';
				}
				
			
			
			$result .= '<tr><td>'.$row['value'].'</td><td><center>'.$us->uflags($row['option']).'</center></td><td><center>'.$type.'</center></td><td><center>'.$accstatus.'</center></td></tr>';
		}
		$result .= '</tbody></table></div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->';
	} else {
	$result .= '
	<div class="col-md-6">
                            <div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-star-half-o"></i>
                                    <h3 class="box-title">Админ профиль</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
								'.$eng->msg("3", "На данный момент игрок не владеет правами администратора", "3").'
								</div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
	';
	}


		
	return $result;
}
