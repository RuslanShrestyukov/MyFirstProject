<?php
session_start();
define ('NEWGUARD', true);

require_once "core/maincore.php"; 

$load = (isset($_GET['page']) ? $_GET['page'] : "");
$title = '';
switch ($load) 
{
	case 'error':
        require_once('modules/pages/error.php');
        break;
    case 'news':
        require_once('modules/news/main.php');
        break;
	case 'stats':
        require_once('modules/stats/main.php');
        break;
	case 'auth':
        require_once('modules/auth/main.php');
        break;
	case 'reg':
        require_once('modules/reg/main.php');
        break;
	case 'settings':
        require_once('modules/settings/main.php');
        break;
	case 'profile':
        require_once('modules/profile/main.php');
        break; 
	case 'balance':
        require_once('modules/money/balance.php');
        break;
	case 'doc':
        require_once('modules/pages/doc.php');
        break;
	case 'faq':
        require_once('modules/pages/faq.php');
        break;
	case 'partner':
        require_once('modules/pages/partner.php');
        break;	
	case 'forecast':
        require_once('modules/forecast/main.php');
        break;
	case 'pay':
        require_once('modules/pay/main.php');
        break;
		
 default:
        require_once('modules/index/main.php');
}

# Шапка сайта
require_once "include/header.php"; 

# Основной контент
echo $tpl->content;
#require_once "modules/index/main.php"; 

# Footer
require_once "include/footer.php"; 

?>