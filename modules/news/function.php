<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

function listnews() 
{
	global  $eng, $us, $tpl;
	
	$news_num = DB::query("SELECT COUNT(*) FROM `news`");

	if ($news_num->fetchColumn() > 0) 
	{
		$sql = DB::query("SELECT * FROM `news` order by id desc");
		
		while ($row = $sql->fetch())
		{
			$text = substr( $row['text'], 0, 350 ) . " ...";	
			$id = $row['id'];
			$news_com1 = DB::query("SELECT COUNT(*) FROM `news_com` WHERE `news_id` = '{$id}'");
			$count_news = $news_com1->fetchColumn();
$tpl->content .= ' 

<div class="post" id="post-'.$row['id'].'">
		<div class="topwrap">
			<div class="topinfoblock">
				<div class="lefttop pull-left">
					<a class="linkuser" href="/profile_'.$row['user_id'].'"><i class="fa fa-fw fa-user"></i> <span class="pointer""><span class="text-light-blue">'.$us->name_user($row['user_id'], 1).'</span></span></a>
				</div>
				<div class="righttop pull-left">
					<i class="fa fa-clock-o"></i> '.$eng->showtime($row['date'], 1).'					
				</div>
				
			</div>
			
			<div class="clearfix"></div>
		</div>    
		<div class="msgbody">
			<div class="userinfo">
				<img src="/main/img/news/'.$row['img_name'].'" class="img-rounded foravatar" width="100px" height="100px">

			</div>
			<div class="posttext textcontent" id="post-main-'.$row['id'].'">
				<b>'.$row['name'].'</b>
			<br><br>
				'.$text.'
					
				
			</div>	
			<div class="clearfix"></div>		
		</div> 
		<div class="postinfobot">
			<div class="leftblock pull-left"></div>
			<div class="allbuttons pull-right">                                        
				<a href="/news_'.$row['id'].'"><button class="btn btn-default btn-sm btn-flat">Подробнее</button></a>
			</div>
			<div class="clearfix"></div>
	<div class="thanks pull-left thanks_ ">
				<div class="thank-word">Просмотров: '.$row['count'].' </div>
				<div class="leftblock pull-left"></div>
			<div class="thank-word pull-right">                                        
				Комментарии: '.$count_news.'
			</div>
				</div>
		
	</div>
	
	</div>

';
		}
	}
	else
	{
		$tpl->content .= $eng->msg(1,'Новости еще не созданы', 1);
	}

	
}

function viewnews($newsid)
{
	global $eng, $us, $userinfo, $tpl;
	$newsid = intval($newsid);
	$news_num = DB::query("SELECT COUNT(*) FROM `news` WHERE `id` = '{$newsid}'");

	if ($news_num->fetchColumn() > 0) 
	{
		$news_com1 = DB::query("SELECT COUNT(*) FROM `news_com` WHERE `news_id` = '{$newsid}'");
			$count_news = $news_com1->fetchColumn();
	$us->news_count($newsid);
	$sql = DB::query("SELECT * FROM `news` WHERE `id` = '{$newsid}'");
	$row = $sql->fetch();
	// Заголовок новости
	$tpl->content .= '
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">'.$row['name'].'</h3>
			<div class="pull-right box-tools">
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm btn-flat hide" id="preloader" disabled=""></button>
					
				</div>			
					<a href="/news"><button  class="btn btn-primary btn-sm btn-flat">Назад</button></a>
			</div>				
		</div>
	</div>
	';
	// тело новости
	$tpl->content .= '
	
	
<div class="post" id="post-'.$row['id'].'">
		<div class="topwrap">
			<div class="topinfoblock">
				<div class="lefttop pull-left">
					<a class="linkuser" href="/profile_'.$row['user_id'].'"><i class="fa fa-fw fa-user"></i> <span class="pointer""><span class="text-light-blue">'.$us->name_user($row['user_id'], 1).'</span></span></a>
				</div>
				<div class="righttop pull-left">
					<i class="fa fa-clock-o"></i> '.$eng->showtime($row['date'], 1).'					
				</div>
				
			</div>
			
			<div class="clearfix"></div>
		</div>    
		<div class="msgbody">
			<div class="posttext textcontent" id="post-main-'.$row['id'].'">
				'.$eng->replaceBBCode($row['text']).'				
			</div>	
			
			<div class="clearfix"></div>		
		</div> 
		<div class="postinfobot">
			
				<div class="thanks pull-left thanks_ ">
					<div class="thank-word">Просмотров: '.$row['count'].' </div>
					<div class="leftblock pull-left"></div>
						<div class="thank-word pull-right">                                        
							Комментарии: '.$count_news.'
						</div>
				</div>
		
		</div>
	</div>
	';
	//вывод комментариев с проверкой авторизации
	if($userinfo['group']>1)
	{
		$news_com = DB::query("SELECT COUNT(*) FROM `news_com` WHERE `news_id` = '{$newsid}'");
		
		if ($news_com->fetchColumn() > 0) 
		{

	$sql1 = DB::query("SELECT * FROM `news_com` WHERE `news_id` = '{$newsid}'");
		$tpl->content .= '
		<div class="box box-solid">
	<div class="box-header">
		<i class="fa fa-comment-o"></i>
		<h3 class="box-title">Комментарии ('.$count_news.')</h3>
	</div>
	<div class="box-body clearfix">
		<div class="discussions">
			<ul class="discussions" id="combody">
			';
	while ($value = $sql1->fetch())
		{
	$tpl->content .= '
				
				<li id="unb2761">
					<div class="author">
						<img src="'.$us->avatar($value['user_id']).'" class="img-circle">
					</div>
					<div class="name"><a href="/profile_'.$value['user_id'].'">'.$us->name_user($value['user_id'], 1).'</a></div>
					<div class="date">'.$eng->showtime($value['date'], 1).'</div>
					
					<div class="message">'.$value['text'].'</div>
				</li>
		';
		}
		$tpl->content .= '
		</ul> 
		</div>
		
		<form class="form" method="POST">
			<textarea class="form-control" id="input_text" name="input_text" placeholder="Введите текст комментария" rows="3"></textarea>
			<div class="postinfobot">			
					<div class="pull-right postreply">
						<div class="pull-left"><button class="btn btn-primary btn-flat">Отправить</button></div>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>		
			</div>
		</form>			
	</div>
</div>
		';
	}
	
	}
	
	}
	else
	{
		$tpl->content .= $eng->msg(2,'Новость не найдена', 2);
	}
}


          ?>