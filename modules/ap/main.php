<?php  if (!defined('NEWGUARD'))			exit('Нет доступа');

require_once "core/maincore.php";


#require_once TPL."header.php";



global $db,$eng,$msg,$nav;
    
echo '
   
<div class="row">
<div class="col-md-8">
                            <!-- Primary box -->
                            <div class="box box-primary">
                                <div class="box-header" data-toggle="tooltip" title="" data-original-title="Последние действия">
                                    <h3 class="box-title">Последние 10 действий</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" style="display: block;">
                                <div id="ap_code">
                                <table class="table table-bordered">
                                <tr>
                                <th>Название</th>
                                <th>Пользователь</th>
                                <th>Время</th>
                                </tr>';
								$stats = DB::query("SELECT * FROM ap_logs order by id desc LIMIT 10");
                       while ($row = $stats->fetch())
                    {       
                        
                                echo'
                                <tr>
                                <td><i class="fa '.$row['icons'].'"></i> '.$row['text'].'</td>
                                <td>№'.$row['user_id'].'</td>
                                <td>'.date("d.m.Y H:i:s", $row['time']).'
                                </td>
                                </tr>';
                    }

                               echo ' </table>
                                </div>
                                </div><!-- /.box-body -->
                               
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                            ';
 if(!empty($_POST['text'])) {
           $code_text = $_POST['text'];
        $sql = DB::query("UPDATE `ap_code` SET `code_text` = '{$code_text}' WHERE `id` = '1'");
        } 
        $sql = DB::query("SELECT COUNT(*) FROM `ap_code`");
		$sql1 = DB::query("SELECT * FROM `ap_code`");
        $row = $sql1->fetch();
        if ($sql->fetchColumn() > 0)
            $text = $row['code_text'];
        else $text = '';
echo '
<div class="col-md-4">
                            <!-- Primary box -->
                            <div class="box box-primary">
                                <div class="box-header" data-toggle="tooltip" title="" data-original-title="Заметки">
                                    <h3 class="box-title">Заметки</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" style="display: block;">
                                    <form method="post" action="" >
                                    <div id="ap_code">
                                <div class="form-group">
                                            <textarea class="form-control" rows="3" id="text" name="text" style="margin-top: 0px; margin-bottom: 0px; height: 260px;">'.$text.'</textarea>
                                </div>
                                </div>
                                </div><!-- /.box-body -->
                               <div class="box-footer unbanbot">
                              <div class="pull-right">
                              <a href="#openModal">
                                <input type="submit" class="btn btn-primary" value="Сохранить">
                                </a>
                                <div class="clearfix"></div>
                                </div>
                                </form>
                                 <div class="clearfix"></div>
                            </div>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
</div>';
 if(!empty($_POST['comment'])) {
           $comments = $_POST['comment'];
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($comments));
        } 
echo'
<div class="row">
<div class="col-md-4">
   <!-- Primary box -->
                            <div class="box box-primary">
                                <div class="box-header" data-toggle="tooltip" title="" data-original-title="Заметки">
                                    <h3 class="box-title">Сообщение в Telegram</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body" style="display: block;">
                                    <form method="post" action="" >
                                    <div id="tg">
                                <div class="form-group">
                                            <textarea type="text" name="comment" class="form-control"placeholder="Текст...."></textarea>
                                </div>
                                </div>
                                </div><!-- /.box-body -->
                               <div class="box-footer unbanbot">
                              <div class="pull-right">
                              <a href="#openModal">
                                <input type="submit" class="btn btn-primary" value="Отправить">
                                </a>
                                <div class="clearfix"></div>
                                </div>
                                </form>
                                 <div class="clearfix"></div>
                            </div>
                            </div><!-- /.box -->
</div>
</div>
            
';
#require_once TPL."footer.php";

?>