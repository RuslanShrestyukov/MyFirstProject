<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
require_once "core/maincore.php";
switch($_POST){
 case (!empty($_POST['type']) AND !empty($_POST['summa'])):
	#Редактирование комментария
	$out_summ = intval($_POST['summa']);
		if ($out_summ < $min_pay) {
			$tpl->content .= $eng->msg("3", "Введеная сумма должна быть больше {$min_pay} рублей", "3"); 
			$tpl->content .=  '<meta http-equiv="refresh" content="3;URL=http://'.$_SERVER['SERVER_NAME'].'/balance">';
		} else {
			$pay_num = DB::query("SELECT COUNT(*) FROM `news`");
			
			
		if($_POST['type'] == 'WebMoney') 
		{		
			$desc = 'Пополнение баланса на сайте NewCsdm.ru';
			$tpl->content .=  '
				<form name="oplata" method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
					<input type="hidden" name="LMI_PAYMENT_NO" value="'.$pay_num->fetchColumn().'" />
					<input type="hidden" name="LMI_PAYMENT_DESC_BASE64" value="'.base64_encode( $desc ).'" />
					<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.intval($_POST['summa']).'" />
					<input type="hidden" name="LMI_PAYEE_PURSE" value="'.$wmr.'" />
					<noscript><input type="submit" value="Нажмите, если не хотите ждать!" onclick="document.oplata.submit();"></noscript>
				</form>
				<script language="Javascript" type="text/javascript">
					document.oplata.submit();
				</script>';
		}
		else if($_POST['type'] == 'Robokassa') {
	// 2.
// Оплата заданной суммы с выбором валюты на сайте ROBOKASSA
// Payment of the set sum with a choice of currency on site ROBOKASSA

// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)

// номер заказа
// number of order
$inv_id = 0;

// описание заказа
// order description

// сумма заказа
// sum of order
$out_summ = intval($_POST['summa']);

// тип товара
// code of goods
$shp_item = "2";

// предлагаемая валюта платежа
// default payment e-currency
$in_curr = "руб.";

// язык
// language
$culture = "ru";

// формирование подписи
// generate signature
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");

// форма оплаты товара
// payment form
print "".
      "<form name='oplata' action='https://merchant.roboxchange.com/Index.aspx' method=POST>".
      "<input type=hidden name=MrchLogin value=$mrh_login>".
      "<input type=hidden name=OutSum value=$out_summ>".
      "<input type=hidden name=InvId value=$inv_id>".
      "<input type=hidden name=Desc value='$inv_desc'>".
      "<input type=hidden name=SignatureValue value=$crc>".
      "<input type=hidden name=Shp_item value='$shp_item'>".
      "<input type=hidden name=IncCurrLabel value=$in_curr>".
      "<input type=hidden name=Culture value=$culture>".
      "<noscript><input type='submit' value='Нажмите, если не хотите ждать!' onclick='document.oplata.submit();'></noscript>".
		 "</form>".
		"<script language='Javascript' type='text/javascript'>document.oplata.submit();</script>"
     ;
	}
		}	
	break;
}
          ?>