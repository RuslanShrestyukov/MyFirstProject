<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

switch($_POST){
 case !empty($_POST['id_del']):
	#Удаление комментария новости
    $del_id = intval($_POST['id_del']);
	$sql = $db->query("SELECT * FROM `news_com` WHERE `id` = '{$del_id}' ORDER BY `id` DESC");
	$row = $db->fetch_array($sql);
	if ($db->num_rows($sql) AND ($userinfo['id'] == $row['user_id'] OR $us->agsearch('newsmsgdel')))
	{
        $sql = $db->query("DELETE FROM `news_com` WHERE `id` = '{$del_id}'");
		$eng->log("[Новости] В " . date('d.m.Y H:i:s') . " удален комментарий пользователем № ".$userinfo['id']."\n", "logs");	
	}
	break;
 case !empty($_POST['input_text']):
 	if ($userinfo['group'] > 1)
	{
		#Добавление комментария
		$text = $eng->input($_POST['input_text']);
		$sql = DB::query("SELECT * FROM `news` WHERE `id` = '{$newsid}'");		
		if ($sql->fetchColumn() > 0) 
		{
			$sql = "INSERT INTO `news_com` (`id`,`news_id`,`user_id`,`text`,`date`) VALUES(NULL , :news_id, :user_id ,:text , :time )";
				$q = DB::prepare($sql);
				$q->execute(array(':news_id'=>$newsid,
									':user_id'=>$userinfo['id'],
									':text'=>$text,
									':time'=>time()));
		}
	}
	break;
 case (!empty($_POST['edit_text']) AND !empty($_POST['postid'])):
	#Редактирование комментария
	$postid = intval($_POST['postid']);
	$text = $eng->input($_POST['edit_text']);
	$sql = $db->query("SELECT * FROM `news` WHERE `id` = '{$newsid}'");
	if ($db->num_rows($sql) > 0)
		$sql = $db->query("UPDATE `news_com` SET `text` = '{$text}' WHERE `id` = '{$postid}'");
	header("Refresh:2; url=".SITEDIR."".BASEDIR."/news_".$newsid."#form_msg");
	$nav[] = array('name' => 'Действие');
	$tpl->content .= $eng->msg("1", "Комментарий успешно изменен", "1");	
	break;
}