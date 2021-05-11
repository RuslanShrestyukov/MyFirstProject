<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
		if($userinfo['group'] > 0)
						{
		$sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$userinfo['id']}'");
		$row = $sql->fetch();
							echo '
							<section class="sidebar">
				<div class="user-panel">	
					<div class="imageLeft">
						<div>
							<a href="/profile_'.$userinfo['id'].'">
								
								<img src="'.$us->avatar($userinfo['id']).'" class="us-online">
							</a>
						</div>
						<div class="imageRight">
							<div id="infoLogin">
								<a href="/profile_'.$userinfo['id'].'">'.$userinfo['login'].'</a>
							</div>
	 						<div id="infoGroup">'.$us->groupname($row['group_id'], 1).'</div>
						</div>
						<div id="infoLogout">
							<a href="/settings"><i class="fa fa-cog"></i></a>
						</div>
					</div>		
				</div>
				<ul class="sidebar-menu">
						<li>
                            <a href="/ap">
                                <i class="fa fa-bullhorn"></i> <span>Главные настройки</span>
                            </a>
                        </li>
                        <li>
                            <a href="/ap?act=news">
                                <i class="fa fa-bullhorn"></i> <span>Управление новостями</span>
                            </a>
                        </li>
						 <li>
                            <a href="/ap?act=users">
                                <i class="fa fa-users"></i> <span>Пользователи </span>
                            </a>
                        </li>
						<li>
                            <a href="/ap?act=forecasts">
                                <i class="fa fa-check-square"></i> <span>Управление прогнозами </span>
                            </a>
                        </li>
                        <li>
                            <a href="/ap?act=forecasts">
                                <i class="fa fa-check-square"></i> <span>Логи </span><small class="badge pull-right bg-yellow">В разработке</small>
                            </a>
                        </li>
					
						
                    </ul>
                </section>
';
						} 
						else 
						{
							echo '
							 <section class="sidebar">
				
				<ul class="sidebar-menu">

						<li>
                            <a href="/stats">
                                <i class="fa fa-list"></i> <span>Статистика</span>
                            </a>
                        </li>
						<li>
                            <a href="/faq">
                                <i class="fa  fa-file"></i> <span>FAQ</span>
                            </a>
                        </li>
						<li>
                            <a href="/doc">
                                <i class="fa fa-book"></i> <span>Договор оферты</span>
                            </a>
                        </li>
						<li>
                            <a href="/partner">
                                <i class="fa fa-users"></i> <span>Партнерская программа</span>
                            </a>
                        </li>
						<li class="treeview active">
                            <a href="#">
                                <i class="fa fa-unlock"></i> <span>Авторизация</span>
                                <i class="fa pull-right fa-angle-down"></i>
                            </a>
                            <ul class="treeview-menu" style="display: block;">
								 <form action="auth" method="post" class="authregrecform">
								
									<div class="form-group">
										<input type="text" name="login" class="form-control" placeholder="Логин">
										
									</div>
									<div class="form-group">
										<input type="password" name="password" class="form-control" placeholder="Пароль">
									</div>
																		
									<button type="submit" class="btn btn-success btn-flat btn-block">Войти</button>  
								</form>   
							</ul>
                        </li>
						<li>
                            <a href="/reg">
                                <i class="fa fa-group"></i> <span>Регистрация</span>
                            </a>
                        </li>
                       <!--- <li>
						<a href="javascript:showtv()">
						<i class="fa fa-youtube-play"></i> Телевизор
						</a>
						</li>	--->
					
						
                    </ul>
                </section>
				';
						}
					
          ?>