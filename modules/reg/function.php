<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

function formreg()
{
	$result = '
	
<div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Регистрация</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post">
              <div class="box-body">
                <div class="form-group">
                  <label >Логин</label>
                  <input type="text" name="login" class="form-control input-lg" placeholder="Введите логин" required>
                </div>
				<div class="form-group">
                  <label >Почта</label>
                  <input type="text" name="email" class="form-control input-lg" placeholder="Введите email" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Пароль</label>
                  <input type="password" name="password" class="form-control input-lg" id="exampleInputPassword1" placeholder="Введите пароль">
                </div> 
				<div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="rules"> Принимаю <a href="/doc">правила сайта и договор оферты</a>
                      </label>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Создать профиль</button>
              </div>
            </form>
          </div>
          <!-- /.box -->


        </div>
<div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Информация</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
               123
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                123
              </div>
          </div>
          <!-- /.box -->


        </div>
	';

	return $result;
}

function validatereg($login,$password,$email,$rules)
{
	global $eng, $us;
	$err = array();
	
	$login = trim(htmlspecialchars($login, ENT_QUOTES));
	$email = trim(htmlspecialchars($email));
	$pass = $password;
	$password = $eng->GeneratePassword($password);
	$ip = USER_IP;
	
	//Проверка на налицие пользователя в базе по логину
	$user_num = DB::query("SELECT COUNT(*) FROM `users` WHERE `login` = '{$login}'");
	if ($user_num->fetchColumn() > 0) 
		$err[] = 'Введённый логин уже зарегистрирован';

	//Проверка на налицие пользователя в базе по IP
	$sql = DB::query("SELECT * FROM `users` WHERE `ip` = '{$ip}' ORDER BY `id`");
	$row = $sql->fetch();
	$user_ip = DB::query("SELECT COUNT(*) FROM `users` WHERE `ip` = '{$ip}' ORDER BY `id`");
	if ($user_ip->fetchColumn() > 0)  
		$err[] = 'Вы уже регистрировались на нашем сайте. Ваш логин '. $row['login'].' ';
	
	if (!preg_match('/^[A-Za-z0-9_\+-\.,\[\]\)\(@!\?\$\*~\s]{3,15}$/i', $login))
		$err[] = 'Логин может состоять только из букв латинского алфавитов, пробела, спецсимволов: _+-.,[])(@!?$*~, а также его длина должна быть от 3 до 15 символов';
	
	if (strlen($pass) < 6 OR strlen($pass) > 30) 
		$err[] = 'Длина должна быть от 6 до 30 символов';	
	
	if($rules == 1)
		$err[] = 'Ошибка';	
	
	//Проверка на налицие пользователя в базе по почте
	$user_email = DB::query("SELECT COUNT(*) FROM `users` WHERE `email` = '{$email}'");
	if ($user_email->fetchColumn() > 0) 
		$err[] = 'Введённый вами почтовый ящик уже зарегистрирован';	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		$err[] = 'Неверный почтовый ящик';
	if(count($err) == 0) 
	{
		
		 $time = time();
		 $ip = USER_IP;
		 
		 //Ref system
		 $referer_id = (isset($_COOKIE["ref"]) AND intval($_COOKIE["ref"]) > 0 AND intval($_COOKIE["ref"]) < 1000000) ? intval($_COOKIE["ref"]) : 1;
			$ref_sql = DB::query("SELECT COUNT(*) FROM `users` WHERE `id` = '{$referer_id}' LIMIT 1");
			if ($ref_sql->fetchColumn() > 0) 
				{
					 $sql = "INSERT INTO `users_res` (`user_id`, `login`, `money`,`time`) VALUES(:user_id, :login,  :money ,:time)";
					 $q = DB::prepare($sql);
					 $q->execute(array(':user_id'=>$referer_id,
									':login'=>$login,
									':money'=>0,
									':time'=>$time));
				}
		 
		 
		 
		 $sql = "INSERT INTO `users` (`login`,`password`,`email`,`group_id`,`ip`, `ref_id`) VALUES(:login, :password, :email ,:group_id , :ip, :ref_id )";
				$q = DB::prepare($sql);
				$q->execute(array(':login'=>$login,
									':password'=>$password,
									':email'=>$email,
									':group_id'=>2,
									':ip'=>$ip,
									':ref_id'=>$referer_id));
		if ($sql)
		{
			$type = 1;
			$message = "Вы успешно зарегистрированы! Авторизуйтесь на сайте для дальнейших действий.";
			//Добавления в лог действий
			$eng->bd_log("[Регистрация] Зарегистрирован новый пользователь {$login}",0,time(),"fa-user");
		} else {
			$type = 2;
			$message = "Регистрация не удалась";
		}
	} else {
		$type = 2;
		$message = '';
		foreach($err AS $error)
			$message .= $error."<br>";
	}	
	return array('type' => $type, 'msg' => $message);
}