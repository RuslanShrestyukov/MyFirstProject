<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
require_once "core/maincore.php";
global $db,$eng,$msg,$tpl;
	
if(!empty($_POST['id_delete'])) {
    			$del_id = intval($_POST['id_delete']);
				$stats_pr = DB::query("DELETE FROM `stats` WHERE `id` = '{$del_id}'");
				echo $eng->msg("1", "Прогноз успешно удален", "1"); 
				echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/ap?act=forecasts">';
            } else if(!empty($_POST['id_update'])) {
				if(!empty($_POST['match'])) {
	$upd_id = intval($_POST['id_update']);
	$match = $eng->input($_POST['match']);
	$forecast = $eng->input($_POST['forecast']);
	$coefficient = $eng->input($_POST['coefficient']);
	$type = $eng->input($_POST['type']);
	$score = $eng->input($_POST['score']);
	$result = $eng->input($_POST['result']);;
	$date_upd = intval($_POST['date_update']);
	// Если надо, обновляем время
	if($date_upd == 1) {
		#Получаем время
		$d = $eng->input($_POST['d']); #День
	$m = $eng->input($_POST['m']); #Месяц
	$g = $eng->input($_POST['g']); #Год
	$ch = $eng->input($_POST['ch']); #Часы
	$min = $eng->input($_POST['min']); #Минуты
	$date_month = mktime ($ch,$min,0,$m,$d,$g);
	$sql = DB::query("UPDATE `stats` SET `date_month` = '$date_month' WHERE `id` = '{$upd_id}'");
	}
	#Получаем время
	$date_day = date("m_Y");
	$date = time();				
					$sql = DB::query("UPDATE `stats` SET `date`='$date', `match`='$match', `forecast`='$forecast', `coefficient`='$coefficient', 
					`score`='$score', `result`='$result',  `date_day`='$date_day', `type`='$type' WHERE `id` = '{$upd_id}'");
				echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/ap?act=forecasts">';
				echo $eng->msg("1", "Прогноз успешно обнавлен", "1"); 
	
} else {
    			$upd_id = intval($_POST['id_update']);
				$ar = DB::query("SELECT * FROM `stats` WHERE `id` = '{$upd_id}'");
						$row = $ar->fetch();
						
				echo '
				
				<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Обновление</h3>
			  <div class="pull-right box-tools">
		
					<a href="/ap?act=forecasts"><button class="btn btn-primary">Назад</button></a>
			</div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form  method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label>Матч</label>
                  <input type="text" name="match" class="form-control" placeholder="Пример ЦСКА-Спартак..." value="'.$row['match'].'">
                </div>
                <div class="form-group">
                  <label>Прогноз</label>
                  <input type="text" name="forecast" class="form-control"placeholder="Прогноз..." value="'.$row['forecast'].'">
                </div>
				 <div class="form-group">
                  <label>Коэффициент</label>
                  <input type="text" name="coefficient" class="form-control"placeholder="Коэффициент..." value="'.$row['coefficient'].'">
                </div>
				<div class="form-group">
                  <label>Дата матча</label>
                  <input type="text"  class="form-control" value="'.$eng->showtime($row['date_month'], 1).'" disabled>
                </div>
				<div class="form-group">
                  <label>Счет</label>
                  <input type="text" name="score"  class="form-control" value="'.$row['score'].'">
                </div>
				<div class="form-group">
						<label>Исход</label>
							<select name="result" class="form-control">
								<option value="0" '.($row['result'] == '0' ? "selected" : "").'>Ожидание</option>
								<option value="1" '.($row['result'] == '1' ? "selected" : "").'>Прошел</option>
								<option value="2" '.($row['result'] == '2' ? "selected" : "").'>Возврат</option>
								<option value="3" '.($row['result'] == '3' ? "selected" : "").'>Не прошел</option>
							</select>
					</div>
					<div class="form-group">
						<label>Тип прогноза</label>
							<select name="type" class="form-control">
								<option value="1" '.($row['type'] == '1' ? "selected" : "").'>Платные</option>
								<option value="2" '.($row['type'] == '2' ? "selected" : "").'>Бесплатные</option>
							</select>
					</div>
					<input type="hidden" name="id_update" value="'.$row['id'].'">
					<div class="form-group">
            <label>Обновить дату начала матча</label>
           		<select class="form-control" name="date_update" onchange="if (this.options[this.selectedIndex].value == \'1\') { UnToggle(add_comm) } else { ToToggle(add_comm)}">
                	<option value="0">Не обновлять</option>
			  		<option value="1">Обновить</option>
            </select>
        </div>
		 <div id="add_comm" style="display:none;">
				<hr>
				<label>Начало матча</label>
				<div class="row">
				<div class="col-md-2">
					<div class="form-group">
						<label>День</label>
							<select name="d" class="form-control">
								';
							for($i= 1; $i<32; $i++)
							{
								echo '<option value="'.$i.'" '.($i == date("d") ? "selected" : "").'>'.$i.'</option>';
							}
							echo '
							</select>
					</div>
                </div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Месяц</label>
							<select name="m" class="form-control">';
							for($i= 1; $i<13; $i++)
							{
								$date = array("Ничего","Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сетнябрь","Октябрь","Ноябрь","Декабрь");
								echo '<option value="'.$i.'" '.($i == date("m") ? "selected" : "").'>'.$date[$i].'</option>';
							}
							echo '</select>
					</div>
                </div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Год</label>
							<select name="g" class="form-control">
								<option value="2018">2018</option>
							</select>
					</div>
                </div>
					<div class="col-md-2">
					<div class="form-group">
						<label>Часы</label>
						<select name="ch" class="form-control">';
							for($i= 0; $i<25; $i++)
							{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							echo '</select>
					</div>
                </div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Минуты</label>
						<select name="min" class="form-control">';
							for($i= 0; $i<61; $i++)
							{
								echo '<option value="'.$i.'">'.$i.'</option>';
							}
							echo '</select>
					</div>
                </div>
                </div>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Обновить</button>
				</form>
			</div>
          </div>

';
				
}	
				
            }
			else
			{
echo '

<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-list"></i> Прогнозы</h3>	
<div class="pull-right box-tools">
		
					<a href="/ap?act=forecast"><button class="btn btn-primary">Добавить</button></a>
			</div>				
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
							<td colspan="2"><b>Действие</b></td>		
						</tr>
						
						';
						$ar = DB::query("SELECT * FROM stats order by id desc");
						while ($row = $ar->fetch())
{
						$array_header = array(0 => 'primary',1 => 'warning', 2 => 'success', 3 => 'danger');
						$array_status = array(0 => 'Ожидание',1 => 'Прошел', 2 => 'Возврат', 3 => 'Не прошел');
						if(isset($array_status[$row['result']]))
							$status = $array_status[$row['result']];
						if(isset($array_header[$row['result']]))
							$header = $array_header[$row['result']];
						
						echo '
						<tr> 
							<td>'.$eng->showtime($row['date_month'], 1).'</td>
							<td>'.$row['match'].'</td>
							<td>'.$row['forecast'].'</td>	
							<td>'.$row['coefficient'].'</td>	
							<td>'.$row['score'].'</td>	
							<td><small class="label label-'.$header.'">'.$status.'</small></td>		
							<td>  
								<form method="POST" action="">
									<input type="hidden" name="id_update" value="'.$row['id'].'">
									<input type="submit" value="Обновить" class="btn btn-default btn-block">
								</form>
							</td>
							<td>
								<form method="POST" action="">
									<input type="hidden" name="id_delete" value="'.$row['id'].'">
									<input type="submit" value="Удалить" class="btn btn-default btn-block">
								</form>
					</td>							
						</tr>	
						';
}
					
					
									
					echo '</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

';
			}
          ?>