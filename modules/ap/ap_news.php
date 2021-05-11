<?php if (!defined('NEWGUARD'))			exit('Нет доступа');

require_once "core/maincore.php";


#require_once TPL."header.php";


global $db,$eng,$msg,$nav;
	
 # Редактирование новости
	    if (!empty($_GET['id'])) {
		    $id_edit = intval($_GET['id']);
			$sql = DB::query("SELECT COUNT(*) FROM `news` WHERE `id` = '{$id_edit}'");
			$sql1 = DB::query("SELECT * FROM `news` WHERE `id` = '{$id_edit}'");
			if($sql->fetchColumn() > 0) {
			    # Отправили данные на изменение новости
			    if(isset($_POST['text_edit_news']) and isset($_POST['name_edit_news'])) {
    								$text = $eng->input($_POST['text_edit_news']);
									$name = $eng->input($_POST['name_edit_news']);	
    				if(!empty($name) AND !empty($text)) {
    			   	    $edit_new = DB::query("UPDATE `news` SET `name` = '{$name}', `text` = '{$text}' WHERE `news`.`id` = {$id_edit};");
    				    echo $eng->msg("1", "Новость успешно изменена", "1"); 
						echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/ap?act=news">';
    				} else { 
						echo $eng->msg("4", "Не все поля были заполнены", "4"); 
						echo '<meta http-equiv="refresh" content="2;URL=http://'.$_SERVER['SERVER_NAME'].'/ap?act=news&id='.$id_edit.'">';
					}
    		    } else {
					$row = $sql1->fetch();
					$text = str_replace("<br />", "\r\n", $row['text']);
			    	echo '
			    	<div class="box box-solid">
		<div class="box box-solid">
			<div class="box-header">
			<i class="fa fa fa-list"></i>
				<h3 class="box-title">Редактирование новости</h3>	
				<div class="pull-right box-tools">
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm btn-flat hide" id="preloader" disabled=""></button>
				</div><button onclick="location.href=\'http://'.$_SERVER['SERVER_NAME'].'/ap?act=news\'" class="btn btn-primary btn-sm btn-flat">Назад</button>
					</div>					
			</div>
			<div class="box-body table-responsive">
			<form method="POST" action=""><fieldset>
    		    	 <label>Название</label>
			<div class="form-group">			
				<input type="text" name="name_edit_news" id="name" value="'.$row['name'].'" class="form-control" placeholder="Введите название новости">
			</div>
			<label>Текст</label>
			<div class="form-group">
				<textarea id="editor" name="text_edit_news">'.$text.'</textarea>			
			</div>	
    			    		<div class="form-actions"><input type="submit" value="Редактировать новость" class="btn btn-info"></div>
    	    	          </fieldset></form>
    	    	          </div></div></div>
    	    	          ';
			    }
			} else { 
				echo $eng->msg("2", "Новость не найдена", "2"); 
			}
		} else {
    		# Удаление новости
            if(!empty($_POST['id_del'])) {
    			$del_news = intval($_POST['id_del']);
    	   	    $sql = DB::query("DELETE FROM `news` WHERE `id` = {$del_news}");
				echo $eng->msg("1", "Новость успешно удалена", "1"); 
            }    
    		# Добавление новости
    		else if(isset($_POST['text_add_news']) and isset($_POST['name_add_news'])) {
				$text = $eng->input($_POST['text_add_news']);
				$name = $eng->input($_POST['name_add_news']);
				$img_name = "no_image.jpg";
    			if(!empty($name) AND !empty($text)) {
					$eng->bd_log("[NEWS] Добавление новости на сайте",$userinfo['id'],time(),"fa-bullhorn");					
				$sql = "INSERT INTO `news` (name,date,text,user_id,img_name) VALUES(:name, :date, :text , :user_id , :img_name )";
				$q = DB::prepare($sql);
				$q->execute(array(':name'=>$name,
									':date'=>time(),
									':text'=>$text,
									':user_id'=>$userinfo['id'],
									':img_name'=>$img_name));
				echo $eng->msg("1", "Новость успешно добавлена", "1"); 
					
    			} else
    			    echo $eng->msg("4", "Не все поля были заполнены", "4"); 
    		}
    	    $sql = DB::query("SELECT * FROM `news` ORDER BY `id` ASC");
    		echo '
<div id = "add_news" style = "display: none;"><fieldset>
		<div class="box box-solid">
	<div class="box-header">
		<h3 class="box-title">Добавление новости</h3>
		<div class="pull-right box-tools">
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm btn-flat hide" id="preloader" disabled=""></button>
					
				</div><button onClick="Toggle(add_news)" class="btn btn-primary btn-sm btn-flat">Скрыть</button>
					 
					</div>	
	</div>
	<div class="box-body clearfix">	
	<form method="post" action="" >
    		       
			<label>Название</label>
			<div class="form-group">			
				<input type="text" name="name_add_news" id="name" class="form-control" placeholder="Введите название новости">
			</div>
			<label>Текст</label>
			<div class="form-group">
			<textarea id="editor" name="text_add_news"></textarea>			
			</div>	
	</div>
	<div class="box-footer unbanbot">
		<div class="pull-left">
			<input type="submit" class="btn btn-primary" value="Создать">
			<div class="clearfix"></div>
		</div>
		</form>
		<div class="clearfix"></div>
	</div>
</div>
</fieldset></div>
    	          <div class="box box-solid">
		<div class="box box-solid">
			<div class="box-header">
			<i class="fa fa fa-list"></i>
				<h3 class="box-title">Список новостей</h3>	
				<div class="pull-right box-tools">
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm btn-flat hide" id="preloader" disabled=""></button>
				</div><button onClick="Toggle(add_news)" class="btn btn-primary btn-sm btn-flat">Добавить новость</button>
					</div>					
			</div>
			<div class="box-body table-responsive">
    		      
    			  <table class="table table-bordered"><thead><th>Название</th><th>Дата добавления</th><th>Автор</th><th>Функции</th></thead><tbody>';
			 
			 if (isset($_GET['page'])) $page_sel=(intval($_GET['page'])-1); else $page_sel=0;
			 $num_post = 20; // количество записей на странице
			  $start=abs($page_sel* $num_post);
			  $sql = DB::query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT $start, $num_post");
			  while($cur = $sql->fetch()) { echo '<tr><td><a href="http://'.$_SERVER['SERVER_NAME'].'/ap?act=news&id='.$cur['id'].'">'.$cur['name'].'</a></td> <td>'.date("d.m.Y", $cur['date']).'</td><td>'.$us->name_user($cur['user_id'], 1).'</td> <td><form method="POST" action=""><input type="hidden" name="id_del" value="'.$cur['id'].'"><input type="submit" onclick="return confirmDelete();" value="Удалить"></form></td></tr>'; }        
			  echo '</tbody></table></div></div></div>';
			  $sql=DB::query("SELECT count(*) FROM `news`");
			  $row=$sql->fetch();
			  $total_rows=$row[0];
			echo $eng->pagination($total_rows,$num_post,$page_sel,"/ap?act=news&page=");
		}


#require_once TPL."footer.php";

?>