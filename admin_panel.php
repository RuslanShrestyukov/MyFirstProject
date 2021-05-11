<?php
session_start();
define ('NEWGUARD', true);
require_once "core/maincore.php";

$title = 'Панель администратора';


require_once "include/adm_header.php"; 

if ($userinfo['group'] == 4) {

    # Управление новостями
    if (!empty($_GET['act']) AND $_GET['act'] == 'news') {
	require_once "modules/ap/ap_news.php";   
	} else if (!empty($_GET['act']) AND $_GET['act'] == 'users') {
	require_once "modules/ap/ap_users.php";   
	} else if (!empty($_GET['act']) AND $_GET['act'] == 'forecast') {
	require_once "modules/ap/ap_forecast.php";   
	} else if (!empty($_GET['act']) AND $_GET['act'] == 'forecasts') {
	require_once "modules/ap/ap_forecasts.php";   
	}
	#Тест работы с чатом 
	 else if (!empty($_GET['act']) AND $_GET['act'] == 'chat_log') {
	echo '
<div class="box box-solid">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title">Просмотр действий на сайте</h3>						
			</div>
			<div class="box-body table-bordered">
	<table class="table table-bordered">';
	$a=file('main/logs/logs.txt'); 
if(preg_match('{\Z.+\z}s', $a[count($a)-1]))  
    echo "<tr><td>" . $a[count($a)-1] . "</td></tr>" ; 
  else 
    echo $a[count($a)-1] ;     
for($i=count($a)-2; 0<=$i; $i--) { 
    echo "<tr><td>" .$a[$i] . "</td></tr>" ; 
} 
echo '</table></div></div></div>';
	 }
	# Управление чатом
    else if (!empty($_GET['act']) AND $_GET['act'] == 'chat') {
    	# Удаление сообщения
        if(!empty($_POST['id_del'])) {
    		#$del_chat = intval($_POST['id_del']);
    	   	#$sql = mysql_query("DELETE FROM `messages` WHERE `id` = {$del_chat}");
    	  
    	   foreach ($_POST['msg'] as $v) {
    	   	$sql = mysql_query("DELETE FROM `messages` WHERE `id` = {intval($v)}");
    	    }

            echo $eng->msg("1", "Сообщения удалены", "1"); 
        }    
    	# Очистка чата
        if(!empty($_POST['chat_clear']) AND $_POST['chat_clear'] == 1) {
    	   	$sql = mysql_query("TRUNCATE TABLE `messages`");
            echo $eng->msg("1", "Чат успешно очищен", "1"); 
			echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/ap?act=chat">';

        }  
	    else
		{
	        echo '
	        <div class="box box-solid">
		<div class="box box-solid">
		<div class="box-header">
			<i class="fa fa fa-list"></i>
				<h3 class="box-title">Управление чатом</h3>	
				<div class="pull-right box-tools">
				<div class="btn-group">
				
					<button type="button" class="btn btn-default btn-sm btn-flat hide" id="preloader" disabled=""></button>
					
				</div>
				<form method="POST" action=""><input type="hidden" name="chat_clear" value="1"><input type="submit" onclick="return confirmClear();"  class="btn btn-primary btn-sm btn-flat"value="Очистить чат"></form>
				<form method="POST" action="">	 <input class="btn btn-primary btn-sm btn-flat" type="submit" value="Удалить выделеные">
					</div>					
			</div>
			<div class="box-body table-responsive">
			<table class="table table-responsive" >
	        ';
	       # echo '<pre class="pagination-centered"><form method="POST" action=""><input type="hidden" name="chat_clear" value="1"><input type="submit" onclick="return confirmClear();" value="Очистить чат"></form></pre>';
	    	$sql = mysql_query("SELECT * FROM `messages` ORDER BY `id` DESC LIMIT 30");
	    	if (mysql_num_rows($sql) > 0) {
                echo '<table class="table table-bordered">';
                while($row=mysql_fetch_array($sql)) {
			       
		            echo '<tr><td width="2px"><input type="hidden" name="id_del" value="'.$row['id'].'"><input type="checkbox" name="msg[]" value="'.$row['id'].'"></td><th>'.$us->username($row['user_id'], 0).'</th> <td>'.$row['text'].' </td></tr>';
	            }
				echo '</table></form>';
				if(mysql_num_rows($sql) == 30) 
			{
				echo  '<center><div id="load">
				<span onclick="oldLoad_im()" class="btn btn-primary">Загрузить еще</span><br>
					<img src="'.IMG.'loading.gif" id="imgLoad">
				</div></center> ';
			}  else
			echo '<div id="0" class="messages"></div>
			</div>';
		    } else { 
				echo $eng->msg("3", "Сообщений нет", "3");
			}
		}
	}
	
	#Логи сайта
    else if (!empty($_GET['act']) AND $_GET['act'] == 'logs') {
	        echo '<legend>Действия на сайте</legend>';
			echo '<table class="table table-bordered">';
	$a=file('main/logs/logs.txt'); 
if(preg_match('{\Z.+\z}s', $a[count($a)-1]))  
    echo "<tr><td>" . $a[count($a)-1] . "</td></tr>" ; 
  else 
    echo $a[count($a)-1] ;     
for($i=count($a)-2; 0<=$i; $i--) { 
    echo "<tr><td>" .$a[$i] . "</td></tr>" ; 
} 
echo '</table>';
	    	
	}
	#Управление сервером через API
	else if (!empty($_GET['act']) AND $_GET['act'] == 'api') {
		require_once "modules/ap/myarena_api.php";
	
	}
	# Управление логами ЛС
    else if (!empty($_GET['act']) AND $_GET['act'] == 'dialogs') {
	 require_once "modules/ap/dialogs.php";
	}
    else if ($userinfo['group'] == 4) {
    require_once "modules/ap/main.php";
	}
} else {
	echo $eng->msg("2", "У вас нет прав доступа", "2"); 
}
require_once "include/adm_footer.php";