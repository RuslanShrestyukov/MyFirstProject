<?php
session_start();
define ('NEWGUARD', true);
define("CLASSDIR", "../");

require_once CLASSDIR."core/maincore.php";

if(empty($_GET['cron']) OR (!empty($_GET['cron']) AND $_GET['cron'] != 'rR1701')) 
	exit('Нет доступа');

$time = time();
$podpiska = DB::query("SELECT COUNT(*) FROM `accounts` WHERE `date_end` <= '{$time}'");
	if ($podpiska->fetchColumn() > 0) 
	{
		$podpiska = DB::query("DELETE FROM `accounts` WHERE `date_end` <= '{$time}'");
		echo "yes";
	}
