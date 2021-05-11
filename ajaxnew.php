<?php
session_start();
define ('NEWGUARD', true);
require_once "core/maincore.php";
$page = 'ajaxnew';

Header("Cache-Control: no-cache, must-revalidate");
Header("Pragma: no-cache");
Header("Content-Type: text/javascript; charset=utf-8");

if(isset($_POST['act'])) 
{
	switch ($_POST['act'])
	{
		case "auth" :
			auth();
			break;
		default :
			exit();
	}
} else
	echo 'Что вы тут забыли?';

function auth() 
{
	$login = $_POST['login'];
	$password = md5($_POST['password']);
	$sql = DB::query("SELECT * FROM `users` WHERE `login` = '{$login}' OR `email` = '{$login}'");
	$row = $sql->fetch();
	if($row['login'] == $login )
	{
		
		echo json_encode($s = array(
		'success' => true,
		'status' => 'Yes',
		'text' => '<i class="fa fa-check"></i>Вы успешно вошли!',
		));
	}
	else 
	{
		echo json_encode($s = array(
		'success' => true,
		'status' => 'No',
		'text' => '<i class="fa fa-ban"></i>Вы не вошли!',
		));
	}

}

