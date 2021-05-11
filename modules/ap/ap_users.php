<?php  if (!defined('NEWGUARD'))			exit('Нет доступа');

require_once "core/maincore.php";

global $db,$eng,$msg,$nav;
	
# Редактирование пользователя
	    if (!empty($_GET['id'])) {
		    $id_edit = intval($_GET['id']);
		    if($id_edit != 1 || $userinfo['id'] == 1) {
			$sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$id_edit}'");
			$sql1 = DB::query("SELECT COUNT(*) FROM `users` WHERE `id` = '{$id_edit}'");
			if($sql1->fetchColumn() > 0) {
		        if (isset($_POST['login']) AND isset($_POST['group_id']) AND isset($_POST['email']) AND isset($_POST['name']) AND isset($_POST['bk']))	{
                    $group_id = $_POST['group_id'];
					$login = $_POST['login'];
					$bk = $_POST['bk'];
					if (isset($_POST['email'])) {
	    $email = $_POST['email'];
		$email = trim(htmlspecialchars(stripslashes($email)));
		}
		if (isset($_POST['name'])) {
	    $name = $_POST['name'];
		$name = trim(htmlspecialchars(stripslashes($name)));
		}
        if (isset($_POST['vk'])) { 
			$vk = $_POST['vk']; 
			$vk = trim(htmlspecialchars(stripslashes($vk)));
		}
		if (isset($_POST['money'])) { 
			$money = $_POST['money']; 
			$money = trim(htmlspecialchars(stripslashes($money)));
		}
                    if ( empty($login)) 
                    {
                        echo $eng->msg("4", "Не все поля были заполнены, повторите попытку $login", "4"); 
						echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/ap?act=users&id='.$id_edit.'">';						
						exit();
                    }
					$group_id = intval($group_id);
					$login = trim(htmlspecialchars(stripslashes($login)));
					# Создаем пустой массив ошибок
					$err = array();
					# Валиден ли логин
					if (!preg_match('/^[A-Za-z0-9_\+-\.,\[\]\)\(@!\?\$\*~\s]{3,15}$/i', $login)) {
						$err[] = 'Логин не должен содержать запрещенные символы и его длина должна быть от 3 до 15 символов';
					} 
					# Валиден ли почтовый ящик
					if(!preg_match("/^[A-Z0-9._-]+@[A-Z0-9.-]{1,61}\.[A-Z]{2,6}$/i", $email)){ 
						$err[] = 'Формат почтового ящика не корректен';
					} 	
					# Если ошибок нет
					if(count($err) == 0) {
						$sql = DB::query ("UPDATE `users` SET  `login` =  '{$login}', `email` =  '{$email}', `name` =  '{$name}', `bk` =  '{$bk}', `vk` =  '{$vk}', `group_id` =  '{$group_id}', `user_money` =  '{$money}' WHERE id = '{$id_edit}'");
						$eng->bd_log("[USERS] Изменение данных пользователю ".$login."",$userinfo['id'],time(),"fa-wrench");
						if ($sql)
						{
							echo $eng->msg("1", "Данные пользователя ".$login." успешно обновлены", "1");
							$redirect = '/ap?act=users';
						} else {
							echo $eng->msg("2", "Данные не были обновлены", "2");
							$redirect = '/ap?act=users';
						}
					# Если ошибки есть
					} else {
						$errormsg = '';
						foreach($err AS $error)
						{
							$errormsg .= $error."<br>";
						}
						echo $eng->msg("2", $errormsg, "2");
						$redirect = '/ap?act=users';
					}
					echo '<meta http-equiv="refresh" content="1;URL=http://'.$_SERVER['SERVER_NAME'].''.$redirect.'">';
					exit();
				} else {
					$row = $sql->fetch();
					echo '
					<div class="box box-solid">
		<div class="box box-solid">
			<div class="box-header">
			<h3 class="box-title">Редактирование профиля '.$row['login'].'</h3>
			<div class="pull-right box-tools">
				
				<button onclick="location.href=\'http://'.$_SERVER['SERVER_NAME'].'/ap?act=users\'" class="btn btn-primary btn-sm btn-flat">Назад</button>
					
					</div>				
		</div>
			<div class="box-body table-responsive">
					<form  action="" method="post" autocomplete="off">
										<div class="form-group">
                                            <label>Логин</label>
                                            <input name="login" id="login" type="text" class="form-control" value="'.$row['login'].'" placeholder="Введите логин">
                                        </div>
                                        <fieldset>
                                        <div class="form-group">
                                            <label>Группа</label>
                                            <select class="form-control" name="group_id" onchange="if (this.options[this.selectedIndex].value == \'1\') { UnToggle(add_comm) } else { ToToggle(add_comm)}">';
                                              $gresult = DB::query('SELECT * FROM `groups` ORDER BY `group_id` ASC');
											  while($rowg = $gresult->fetch()) { 
													if ($rowg['group_id'] == $row['group_id']){ 
														echo '<option selected value="'.$rowg['group_id'].'">'.$us->groupname($rowg['group_id'], 0).'</option>'; 
													} else { 
														echo '<option value="'.$rowg['group_id'].'">'.$us->groupname($rowg['group_id'], 0).'</option>'; 
															} 
													}
                                            echo'</select>
                                        </div>
        <div id="add_comm" style="display:none;">
        <div class="form-group">
            <label>Срок отключения (дней)</label>
            <input type="text" class="form-control" name="ban_time" placeholder="Введине время на которое будет забанен пользователь" value="">
        </div>
        <div class="form-group">
            <label>Причина</label>
            <input type="text" class="form-control" name="ban_reason" placeholder="Введите причину по которой будет забанен пользователь" value="">
        </div>
        </div>
        </fieldset>
                                        <div class="form-group">
                                            <label>Почтовый ящик</label>
                                            <input name="email" id="email" type="text" class="form-control" placeholder="введите почтовый ящик" value="'.$row['email'].'">
                                        </div>
                                        <div class="form-group">
                                            <label>Имя</label>
                                            <input name="name" id="name" type="text" class="form-control" placeholder="Введите имя пользователя" value="'.$row['name'].'">
                                        </div>
                                        <div class="form-group">
                                            <label>БК</label>
                                            <input name="bk" id="bk" type="text" class="form-control" placeholder="Введите ник пользователя" value="'.$row['bk'].'">
                                        </div>
                                        <div class="form-group">
                                            <label>Ссылка на профиль в vk</label>
                                            <input name="vk" id="vk" type="text" class="form-control" placeholder="Введите ссылку на профиль в VK" value="'.$row['vk'].'">
                                        </div>
                                        <div class="form-group">
                                            <label>Баланс</label>
                                            <input name="money" id="money" type="text" class="form-control" placeholder="Баланс игрока на сайте" value="'.$row['user_money'].'">
                                        </div>
					<p><input type="submit" class="btn btn-info" name="submit" value="Подтвердить"></p></form>
					</div></div></div>';
				}
			} else { 
				echo $eng->msg("2", "Пользователь не найден", "2"); 
			}
		} else {
			echo $eng->msg("3", "Вы не имеете прав для редактирования данного пользователя", "3"); 
			echo '<meta http-equiv="refresh" content="1;URL=http://'.$_SERVER['SERVER_NAME'].'/ap?act=users">';
		}
		}
	    # Поиск пользователя
	    else if (!empty($_POST['search'])) {
	        $search = $eng->input($_POST['search']);
            $sql = DB::query("SELECT * FROM users WHERE login LIKE '%{$search}%' ORDER BY `id` ASC LIMIT 20");
			$sql1 = DB::query("SELECT COUNT(*) FROM `users` WHERE login LIKE '%{$search}%'");
			$sql2 = DB::query("SELECT COUNT(*) FROM `users` WHERE login LIKE '%{$search}%'");
		    echo '
		    <div class="box box-solid">
	<div class="box-header">
		<i class="fa fa fa-th"></i>
		<h3 class="box-title">Найдено записей: '.$sql1->fetchColumn().'</h3>
	</div>
	<div class="box-body clearfix" >	
		<div id="findinput">
			<label>Логин пользователя</label>
			<form method="POST">
			<div class="form-group">			
				<input type="text" name="search" class="form-control" value="'.$search.'">
			</div>
		</div>
	</div>
	<div class="box-footer unbanbot">
		<div class="pull-left" id="act_addunban"></div>
		<div class="pull-right">
			<button type="submit" class="btn btn-info">Найти пользователя</button></form>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>';
		    if ($sql2->fetchColumn() > 0) {
		        echo '<div class="box box-solid">
		<div class="box box-solid">
			<div class="box-header">
			<i class="fa fa fa-list"></i>
				<h3 class="box-title">Список пользователей</h3>						
			</div>
			<div class="box-body table-responsive">
    		<table class="table table-bordered">
    		<thead>
    		<th>№</th>
    		<th>Ник</th>
    		<th>Группа</th>
    		</thead><tbody>';
                while($sql->fetch()) {
	                $groupname= $us->groupname($row['group_id'], 0);
                    echo '<tr><td><span class="badge">'.$row['id'].'</span></td><td><img style="margin-right: 5px;" src="'.$us->avatar($row['id']).'" width="20" height="20"/> <a href="http://'.$_SERVER['SERVER_NAME'].'/ap?act=users&id='.$row['id'].'">'.$us->name_user($row['id'], 1).'</td> <td>'.$groupname.'</td></tr>';
                }
			    echo '</tbody></table></div></div></div>';
		    } else {
		        echo $eng->msg("3", "Результатов не найдено", "3"); 
		    }
	    }
		# список пользователей
	    else {
            echo '<div class="box box-solid">
	<div class="box-header">
		<i class="fa fa fa-th"></i>
		<h3 class="box-title">Найти игрока</h3>
	</div>
	<div class="box-body clearfix" >	
		<div id="findinput">
			<label>Логин пользователя</label>
			<form method="POST">
			<div class="form-group">			
				<input type="text" name="search" class="form-control" placeholder="Введите логин пользователя">
			</div>
		</div>
	</div>
	<div class="box-footer unbanbot">
		<div class="pull-left" id="act_addunban"></div>
		<div class="pull-right">
			<button type="submit" class="btn btn-info">Найти пользователя</button></form>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="box box-solid">
		<div class="box box-solid">
			<div class="box-header">
			<i class="fa fa fa-list"></i>
				<h3 class="box-title">Список пользователей</h3>						
			</div>
			<div class="box-body table-responsive">
    		<table class="table table-bordered">
    		<thead>
    		<th>№</th>
    		<th>Ник</th>
    		<th>Группа</th>
    		</thead><tbody>';
            if (isset($_GET['page'])) $page_sel=(intval($_GET['page'])-1); else $page_sel=0;
			$num_post = 20; // количество записей на странице
            $start=abs($page_sel*$num_post);
            $sql = DB::query("SELECT * FROM `users` ORDER BY `id` ASC LIMIT $start,$num_post");
            while($row= $sql->fetch()) {
    	        $groupname= $us->groupname($row['group_id'], 0);
                echo '<tr><td><span class="badge">'.$row['id'].'</span></td><td><img style="margin-right: 5px; border-radius: 50px;" src="'.$us->avatar($row['id']).'" width="20" height="20"/> <a href="http://'.$_SERVER['SERVER_NAME'].'/ap?act=users&id='.$row['id'].'">'.$us->name_user($row['id'], 1).'</td> <td>'.$groupname.'</td></tr>';
            }
        	echo '</tbody></table></div></div></div>';
            $sql= DB::query("SELECT count(*) FROM `users`");
            $row= $sql->fetch();
            $total_rows=$row[0];
			echo $eng->pagination($total_rows,$num_post,$page_sel,"/ap?act=users&page=");
	    }


?>