<?php session_start();
define ('NEWGUARD', true);
require_once "core/maincore.php";
$title = ' тест';

require_once "include/header.php";
//Находим пользователя с реф id 
$ref_sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$userinfo['id']}' LIMIT 1");
$row = $ref_sql->fetch();
$refer_id = DB::query("SELECT COUNT(*) FROM `users` WHERE `id` = '{$row['ref_id']}' LIMIT 1");
if ($refer_id->fetchColumn() > 0) {
	$refer_id_1 = DB::query("SELECT * FROM `users` WHERE `id` = '{$row['ref_id']}' LIMIT 1");
	$rows = $refer_id_1->fetch();
	$new_money = $rows['user_money'] +500/100 * $ref_procent;
	$sql = DB::query("UPDATE `users` SET  `user_money` =  '{$new_money}' WHERE id = '{$row['ref_id']}'");
	// обновляем доход от пользователя
	$refer_id_2 = DB::query("SELECT * FROM `users_res` WHERE `login` = '{$row['login']}' LIMIT 1");
	$rows1 = $refer_id_2->fetch();
	$new_money = $rows1['money'] +500/100 * $ref_procent;
	$sql = DB::query("UPDATE `users_res` SET  `money` =  '{$new_money}' WHERE `login` = '{$row['login']}'");
	
}
echo '

<div class="module">
                            <div class="module-head">
                                <h3>
                                    Заголовок</h3>
                            </div>
                            <div class="module-body">
                                123
                        </div>

';
require_once "include/footer.php";
          ?>