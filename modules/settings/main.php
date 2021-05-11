<?php
$title = 'Настройки';
if ($userinfo['group'] > 0)
{
	if (isset($_POST['login']))	{
		
		$user_info = DB::query("SELECT * FROM `users` WHERE `id` = '{$userinfo['id']}'");
		$row = $user_info->fetch();
	    # Присваиваем переменным значение
		$login = $_POST['login'];
		
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
        if (isset($_POST['bk'])) { 
			$bk = $_POST['bk']; 
			$bk = trim(htmlspecialchars(stripslashes($bk)));
		}
		# Делаем переменные безопасными для использования
        $login = trim(htmlspecialchars(stripslashes($login), ENT_QUOTES));
		# Создаем пустой массив ошибок
		$err = array();
		# Все ли данные введены
        if (empty($login)) 
        {
            echo $eng->msg("2", "Вы ввели не всю информацию", "2"); 
			$tpl->content .= '<meta http-equiv="refresh" content="3;URL=http://'.$_SERVER['SERVER_NAME'].'/settings">';
	        require_once TPL."footer.php";
	        exit();
        }
     	
		$sql = DB::query("SELECT * FROM users WHERE login = '{$login}'") or die(mysql_error());
		if ($sql->fetchColumn() > 0 AND $row['login'] != $login) {
            $err[] = 'Введённый вами логин уже зарегистрирован';
        }
        # Есть ли пользователь с введенным почтовым ящиком
		$user_mail = $row['email'];
		$sql = DB::query("SELECT * FROM `users` WHERE `email` = '{$email}'");
        if ($sql->fetchColumn() > 0 AND $user_mail != $email) {
            $err[] = 'Введённый вами почтовый ящик уже зарегистрирован';
        }
		# Валиден ли логин
        if (strlen($login) < 3 OR strlen($login) > 15) {
            $err[] = 'Логин не должен содержать запрещенные символы и его длина должна быть от 3 до 15 символов';
        } 
		# Валиден ли почтовый ящик
		if(!preg_match("/^[A-Z0-9._-]+@[A-Z0-9.-]{1,61}\.[A-Z]{2,6}$/i", $email))//if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{		
            $err[] = 'Формат почтового ящика не корректен';
        } 
		# Валидна ли ссылка на профиль вконтакте
        if(!empty($vk) AND !preg_match("/vk\.com\/[a-zA-Z0-9_.]{1,40}$/", $vk)){ 
            $err[] = 'Формат ссылки на профиль ВКонтакте не корректен';
            
        }	
		# Если ошибок нет
		if(count($err) == 0) {
			$sql = DB::query("UPDATE `users` SET  `login` =  '{$login}', `email` =  '{$email}', `name` =  '{$name}', `vk` =  '{$vk}', `bk` =  '{$bk}' WHERE id = '{$userinfo['id']}'");
			//Добавления в лог действий
		$eng->bd_log("[Настройки] Пользователь {$userinfo['login']} изменил свои настройки",$userinfo['id'],time(),"fa-wrench");
			if ($sql)
			{
				$tpl->content .= $eng->msg("1", "Ваши данные успешно обновлены", "1");
				echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/settings">';
			} else {
				$tpl->content .= $eng->msg("2", "Данные не были обновлены", "2");
			}
		# Если ошибки есть
		} else {
			$errormsg = '';
			foreach($err AS $error)
			{
				$errormsg .= $error."<br>";
			} 
			$tpl->content .= $eng->msg("2", $errormsg, "2");
		}
		//echo  '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/settings">';
		//exit();
    } 
	else if (isset($_POST['password']) AND isset($_POST['password1']) AND isset($_POST['password2'])) {
		# Присваиваем переменным значение
	    $password = $_POST['password'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
		# Хешируем пароли + делаем их безопасными (коряво, но как есть) 
		$mdPassword = trim(htmlspecialchars(stripslashes($password)));
		$mdPassword1 = trim(htmlspecialchars(stripslashes($password1)));
		$mdPassword2 = trim(htmlspecialchars(stripslashes($password2)));
		
		$NewPassword = $eng->GeneratePassword($mdPassword1);
		# Создаем пустой массив ошибок
		$err = array();
		
		$sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$userinfo['id']}'");
		$row = $sql->fetch();
		$unpass = $eng->UnGeneratePassword($mdPassword, $row['password']);
		//$user_pass = $row1['password'];
		if ($unpass != true)
        {
            $err[] = 'Текущий пароль неверный';
        }
		# пароли не совпадают
        if ($mdPassword1 != $mdPassword2)
        {
            $err[] = 'Пароли не совпадают';
        }
		# пароли должны отличаться
        if ($mdPassword == $mdPassword1)
        {
            $err[] = 'Новый пароль должен отличаться от старого.';
        }
		# проверка на длину пароля
        if(strlen($password1) < 6 OR strlen($password1) > 30)
        {
            $err[] = 'Длина нового пароля должна быть не менее 6 и не более 30 символов';
        }
		# Если ошибок нет
		if(count($err) == 0) 
		{
			$sql = DB::query("UPDATE `users` SET  `password` =  '{$NewPassword}' WHERE `id` = '{$userinfo['id']}' ");
			if ($sql)
			{ 
			require_once "include/header.php";
				echo $eng->msg("1", "Вы успешно сменили пароль. Через 5 секунд вы будете перемещены на главную, для повторной авторизации", "1");
				echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/logout">';
			require_once "include/footer.php";
			} else {
				require_once "include/header.php";
				echo $eng->msg("2", "Смена пароля не удалась", "2");
				echo '<meta http-equiv="refresh" content="3;URL=http://'.$_SERVER['SERVER_NAME'].'/settings">';
				require_once "include/footer.php";
			}
		# Если ошибки есть
		} else {
			$errormsg = '';
			foreach($err AS $error)
			{
				$errormsg .= $error."<br>";
			}
			require_once "include/header.php";
			echo $eng->msg("2", $errormsg, "2");
			echo '<meta http-equiv="refresh" content="3;URL=http://'.$_SERVER['SERVER_NAME'].'/settings">';
			require_once "include/footer.php";
		}
		exit();
    }
	
	else if(!empty($_FILES['avatar'])){
		# Считаем количество ошибок
		$f_err     = 0; 
		# Разрешенные форматы изображения
		$types     = array('.jpg', '.JPG', '.jpeg', '.PNG', '.png', '.gif', '.GIF');
		# Максимальный размер загружаемой картинки
		$max_size  = 5020500; 
		# Директория загрузки аватара
		$path      = 'main/avatar/';
		# Название файла
		$fname     = $_FILES['avatar']['name'];
		# Тип загружаемого файла
		$ext       = substr($fname, strpos($fname, '.'), strlen($fname) - 1);
		# Валидно ли название картинки
        if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ0-9._ ]+$/i', $fname)) {
			$f_err++;
			$mess = 'Некорректное название картинки';
        } 		
		# Проверка формата
		if (!in_array($ext, $types)) {
			$f_err++;
			$mess = 'Загружаемый файл не является картинкой';
		}
		# Проверка размера файла
		if (filesize($_FILES['avatar']['tmp_name']) > $max_size) {
			$f_err++;
			$mess = 'Размер загружаемой картинки превышает 5 Mb';
		}

		# Если файл успешно прошел проверку перемещаем его в заданную директорию из временной
		if ($f_err == 0) {
			# Путь к загруженному файлу
			$source_src = $_FILES['avatar']['tmp_name'];
			# Получаем параметры загруженного файла
			$params = getimagesize($source_src);
			switch ($params[2]) {
				case 1:
					$source = imagecreatefromgif($source_src);
					break;
				case 2:
					$source = imagecreatefromjpeg($source_src);
					break;
				case 3:
					$source = imagecreatefrompng($source_src);
					break;
			}
			# Миниатюра загруженного изображения
			$resource = imagecreatetruecolor(350, 350);
			imagecopyresampled($resource, $source, 0, 0, 0, 0, 350, 350, $params[0], $params[1]);
			imagejpeg($resource, $path . $userinfo['id'].".jpg", 100);
			# Права доступа
			chmod("$source_src", 0644);
			require_once "include/header.php";
			echo $eng->msg("1", 'Изображение загружено', "1");
			echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/settings">';
			require_once "include/footer.php";
		} else {
			require_once "include/header.php";
			echo $eng->msg("2", $mess, "2");
			echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/settings">';
			require_once "include/footer.php";
		}
		exit();
	}
	
	else
	{
	$sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$userinfo['id']}' ");
	$row = $sql->fetch();
$tpl->content .=  '
<div class="row">
		<div class="col-md-6">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title">Изменение данных профиля</h3>						
			</div>
			<div class="box-body table-responsive">
		<form action="" method="post" autocomplete="off">
		<div class="form-group">
			<label >Номер вашего профиля </label>
			<div class="controls">
				<input class="form-control" type="text" size="15" maxlength="15"  value="'.$row['id'].'" disabled>
			</div>
		</div>	
		<div class="form-group">
			<label for="login">Логин </label>			
				<input class="form-control" name="login" id="login" pattern="[A-Za-z0-9_+-\s]{3,}" type="text" size="15" maxlength="15" value="'.$row['login'].'" placeholder="Введите ваш логин">
		</div>		
		<div class="form-group">
			<label for="email">Почтовый ящик</label>
				<input class="form-control" name="email" id="email" type="email" pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" size="15" value="'.$row['email'].'" placeholder="Введите ваш email"> 
		</div>
		<div class="form-group">
			<label for="name">Полное имя</label>
				<input class="form-control" name="name" id="name" type="text" size="15" maxlength="15" value="'.$row['name'].'" placeholder="Введите ваше имя">
		</div>
		<div class="form-group">
			<label for="vk">Профиль Вконтакте: </label>
				<input class="form-control" name="vk" id="vk" type="text" size="15" maxlength="60" type="text" value="'.$row['vk'].'" placeholder="Введите ссылку на профиль">
		</div>
		
		<div class="form-group">
			<label for="bk">Любимая БК: </label>
				<input class="form-control" name="bk" id="bk" type="text"  size="15" maxlength="30" type="text" value="'.$row['bk'].'" placeholder="Введите вашу любимую БК">
		</div>
		</div>
		<div class="box-footer">
		<input type="submit" class="btn btn-success" name="submit" value="Изменить">
		<a href="/logout" class="btn btn-danger"><i class="fa fa-sign-out"></i> <span>Выйти из профиля</span></a>
	</div>
		
		</form>
		
		</div>
		</div>
		<div class="col-md-6">
		<div class="box box-solid">
	<div class="box-header">
		<h3 class="box-title">Ваша реферальная ссылка</h3>
	</div>
	<div class="box-body clearfix">	
	<div id="findinput">
			<div class="form-group">			
				<input class="form-control" style="cursor:pointer;" type="text" value="http://'.$_SERVER['SERVER_NAME'].'/?ref='.$userinfo['id'].'" readonly="" onclick="this.select()" placeholder="Ваша реферальная ссылка:">
			</div>
		</div>
	</div>
</div>
</div>
		<div class="col-md-6">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title">Изменение пароля</h3>						
			</div>
			<div class="box-body table-responsive">
		<form action="" method="post" autocomplete="off">
		<div class="form-group">
			<label for="password">Текущий пароль: </label>
				<input class="form-control" id="password" name="password" type="password" size="15" maxlength="30" placeholder="Введите текущий пароль" required>
		</div>

		<div class="form-group">
			<label for="password1">Новый пароль </label>
				<input class="form-control" id="password1" name="password1" type="password" size="15" maxlength="30" placeholder="Введите пароль" required>
		</div>
		<div class="form-group">
			<label for="password2">Повторить пароль</label>
				<input class="form-control" id="password2" name="password2" type="password" size="15" maxlength="30" placeholder="Введите ещё раз пароль"  required>
		</div></div>
		<div class="box-footer">
		<input type="submit" class="btn btn-success" name="submit" value="Изменить">
	</div>
		
		</form>
		
		</div>
		</div>
		
		
		<div class="col-md-6">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title">Изменение аватара</h3>						
			</div>
			<div class="box-body table-responsive">
			<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group" style="overflow:hidden;">
			<div class="pull-left" style="margin-right:20px;"><img height="50px" class="img-circle" width="50px" src="'.$us->avatar($userinfo['id']).'"></div>
			<div class="pull-left">
				<label for="fieldavatar">Новый аватар</label>
				<input type="file" name="avatar" style="margin-left:10px;">
			</div>
		</div>
		<!-- 	
		<form action="" method="post"><input type="submit" class="btn btn-info" name="deleteavatar" value="Удалить"></form>
		--></div>
		<div class="box-footer">
		<input type="submit" class="btn btn-success" value="Изменить">
	</div></form>
		</div></div>
		
		
		
		</div>
		
		';
	}
}
else
{
$tpl->content .= $eng->msg(3,'Вы не авторизованы', 3);
}
          ?>