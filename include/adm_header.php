<?php if (!defined('NEWGUARD'))			exit('Нет доступа'); ?>
<!DOCTYPE html>
<html lang="ru">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title><? echo $title; ?> | <? echo $sitename; ?></title>
	<meta name="keywords" content="<? echo $defkey; ?>">
    <meta name="description" content="<?echo $defdesc;?>">
	<meta name="generator" content="<?echo $version ;?>" />
	<meta name="author" content="<?echo $author;?>" />
	<link href="<?php echo CSS; ?>bootstrap.css?v=1.5" rel="stylesheet" type="text/css">
	<link href="<?php echo CSS; ?>chat.css?v=0.3" rel="stylesheet">
    <!-- Стили -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo CSS; ?>morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo CSS; ?>jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php echo CSS; ?>datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo CSS; ?>daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo CSS; ?>bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo CSS; ?>AdminLTE.css?v=2.3" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo CSS; ?>wbbtheme.css" />

	     
        
	
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
    <!-- Подключение JS Bootstrap -->
	 <script src="<?php echo JS; ?>jquery.js"></script>
    <script src="<?php echo JS; ?>jquery.cookie.js"></script>
    <script src="<?php echo JS; ?>favicon.ico.js"></script>
    
    <script src="<?php echo JS; ?>mirror.js?v=10.3"></script>
    <?php
	if (isset($javascript) AND count($javascript) > 0) 
	{
		for($i=0;$i<count($javascript);$i++)
			echo '<script src="'.JS.$javascript[$i].'"></script>'."\n";
	}
    ?>
	<!--Позже убрать-->
	<script src="<?php echo JS; ?>autoresize.jquery.js"></script>
    <script src="<?php echo JS; ?>jquery.mousewheel-3.0.4.pack.js"></script>
    <script src="<?php echo JS; ?>jquery.fancybox-1.3.4.pack.js"></script>
	<script src="<?php echo JS; ?>jquery.easing-1.3.pack.js"></script>
	<script src="<?php echo JS; ?>tv.js"></script>
	<script src="<?php echo JS; ?>jquery.jgrowl.js"></script>
    
    <script src="<?php echo JS; ?>jquery.wysibb.min.js"></script>

    
	
       
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo JS; ?>app.js" type="text/javascript"></script>
		<script src="<?php echo JS; ?>users_my.js?v=10.3" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
      <script>
$(function() {
$("#editor").wysibb();
})

</script>

</head>

</head>
<?php
echo '<body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
		<a href="/" class="logo">Админ Центр</a>
		<nav class="navbar navbar-static-top" role="navigation">
			
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>';
			if($userinfo['group'] > 0)
						{
							$sql1 = DB::query("SELECT * FROM `users` WHERE `id` = '{$userinfo['id']}'");
							$value = $sql1->fetch();
							echo '
			<div class="navbar-right">
				<ul class="nav navbar-nav">				
					
					<li>
						<a href="/balance" class="balanceview">'.$value['user_money'].' РУБ</a> 
					</li>						
					
				</ul>
			</div>';
						}
		echo '</nav>
	</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->';
				#Подключаем файл меню
				require_once "include/adm_menu.php";
               
                echo '<!-- /.sidebar -->
            </aside>
			 <aside class="right-side">
                <!-- Content Header (Page header) -->

                <!-- Main content -->
                <section class="content">';