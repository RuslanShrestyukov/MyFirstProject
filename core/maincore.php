<?php
if (!defined('NEWGUARD'))			exit('Нет доступа');

error_reporting(E_ALL);
ini_set('display_errors', '1');

# Калькулятор вывода генерации страницы
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

# Часовой пояс
date_default_timezone_set('Europe/Moscow');

# Константы
if (!defined("BASEDIR")) define("BASEDIR", "");
if (!defined("SITEDIR")) define("SITEDIR", "http://");
if (!defined("CLASSDIR")) define("CLASSDIR", "");
define("SITENAME", "LiteCMS v 0.1");
define("DEFKEY", "Создание легкого CMS для серверов CS 1.6 бесплатно");
define("DEFDESC", "Создание легкого CMS для серверов CS 1.6 бесплатно");
define("JS", SITEDIR."/main/js/");
define("CSS", SITEDIR."/main/css/");
define("IMG", SITEDIR."/main/img/");
define("USER_IP", $_SERVER['REMOTE_ADDR']);


# Переменные
$sitename = 'LiteCMS v 0.1';
$defkey = 'Создание легкого CMS для серверов CS 1.6 бесплатно';
$defdesc = 'Создание легкого CMS для серверов CS 1.6 бесплатно';
$version = 'LiteCMS v 0.1';
$author = 'Ruslan_Sherstyukov';
$min_pay = '50';
$cost1 = '990'; // Эконом 1 день
$cost2 = '4999'; // Стандарт 7 дней
$cost3 = '14999'; // Премиум 30 дней
$cost2_2 = 7*$cost1 - $cost2;
$cost3_3 = 30*$cost1 - $cost3;
$ref_procent = '20';
 
# Подключаемые файлы
require_once CLASSDIR."core/classes/db.class.php";
require_once CLASSDIR."core/classes/engine.class.php";
require_once CLASSDIR."core/classes/users.class.php";
require_once CLASSDIR."core/classes/tpl.class.php";

DB::init();
$eng = new Engine();
$tpl = new Tpl();
$us = new Users();

# Авторизация
$userinfo = $us->chauth();

#Платежи
//WebMoney
$wmr = '';
//Robokassa
$mrh_login = ""; // Логин от робокассы
$mrh_pass1 = "";  // регистрационная информация (пароль #1)
$mrh_pass2 = "";  // регистрационная информация (пароль #2)
$inv_desc = "Пополнение баланса на сайте NewCsdm.ru"; // описание заказа

#Telegram
$token = ""; //наш токен от telegram bot -а
$chatid = ""; //ИД чата telegrm
?>