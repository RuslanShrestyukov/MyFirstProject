<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
$title = 'Вопросы-Ответы';

$tpl->content .= '
<div class="row">
	<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title"><i class="fa fa-file"></i> Вопросы-Ответы</h3>						
			</div>
			<div class="box-body table-responsive">	
			';
						$stats = DB::query("SELECT * FROM buy_order");
						while ($row = $stats->fetch())
				{
						$tpl->content .= '
							<div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne'.$row['id'].'" aria-expanded="false" class="collapsed">
                        <i class="fa  fa-check-square"></i> '.$row['name'].'
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne'.$row['id'].'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                     <p class="lead">'.$row['text'].'</p>
                    </div>
                  </div>
                </div>
						';
				}
					
					
									
					$tpl->content .= '
		
			
				</div>
		</div>
	</div>
</div>
';
          ?>