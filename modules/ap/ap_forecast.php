<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
require_once "core/maincore.php";
global $db,$eng,$msg,$tpl;

if(!empty($_POST['match'])) {
	$match = $eng->input($_POST['match']);
	$forecast = $eng->input($_POST['forecast']);
	$coefficient = $eng->input($_POST['coefficient']);
	$comment = $_POST['comment'];
	$type = $eng->input($_POST['type']);
	$score = "-:-";
	$result = "0";
	#Получаем время
	$d = $eng->input($_POST['d']); #День
	$m = $eng->input($_POST['m']); #Месяц
	$g = $eng->input($_POST['g']); #Год
	$ch = $eng->input($_POST['ch']); #Часы
	$min = $eng->input($_POST['min']); #Минуты
	$date_day = date("m_Y");
	$date_month = mktime ($ch,$min,0,$m,$d,$g);
	$date = time();
	$eng->bd_log("[ПРОГНОЗ] Добавление прогноза на сайте",$userinfo['id'],time(),"fa-check-square");					
					$sql = "INSERT INTO `stats` (`date`, `match`, `forecast`, `coefficient`, `comment`, `score`, `result`, `date_month`, `date_day`, `type`) 
				VALUES(:date, :match, :forecast, :coefficient, :comment, :score, :result, :date_month, :date_day, :type )";
				$q = DB::prepare($sql);
				$q->execute(array(':date'=>$date,
									':match'=>$match,
									':forecast'=>$forecast,
									':coefficient'=>$coefficient,
									':comment'=>$comment,
									':score'=>$score,
									':result'=>$result,
									':date_month'=>$date_month,
									':date_day'=>$date_day,
									':type'=>$type));
				echo $eng->msg("1", "Прогноз успешно добавлен", "1"); 
				echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/ap?act=forecasts">';
$comments = '
'.$comment.'
				'	;
$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($comments)); //Если нашли ошибку отправляем  
//$tbot1 = file_get_contents("https://api.telegram.org/bot".$token."/sendPhoto?chat_id=".$chatid."&caption=".urlencode($comment)."&photo=".urlencode($photo)); //Если нашли ошибку отправляем  
						
	
} else {
	
	echo '
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Добавить прогноз</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form  method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label>Матч</label>
                  <input type="text" name="match" class="form-control" placeholder="Пример ЦСКА-Спартак...">
                </div>
                <div class="form-group">
                  <label>Прогноз</label>
                  <input type="text" name="forecast" class="form-control"placeholder="Прогноз...">
                </div>
				 <div class="form-group">
                  <label>Коэффициент</label>
                  <input type="text"  name="coefficient" class="form-control"placeholder="Коэффициент...">
                </div>
                 <div class="form-group">
                  <label>Описание для Telegram</label>
                  <textarea type="text" name="comment" class="form-control"placeholder="Описание для Telegram"></textarea>
                </div>
					<div class="form-group">
						<label>Тип прогноза</label>
							<select name="type" class="form-control">
								<option value="1">Платные</option>
								<option value="2">Бесплатные</option>
							</select>
					</div>
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
							<select name="m" class="form-control">
							';
							$date = array("Ничего","Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сетнябрь","Октябрь","Ноябрь","Декабрь");
							for($i= 1; $i<13; $i++)
							{
								
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
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Создать</button>
              </div>
            </form>
          </div>

';
}
          ?>