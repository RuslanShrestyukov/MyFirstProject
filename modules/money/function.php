<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
function showmoney ()
{
	global  $eng, $us,$userinfo, $tpl;
	$sql = DB::query("SELECT * FROM `users` WHERE `id` = '{$userinfo['id']}'");
	$row = $sql->fetch();
	$money = $row['user_money'];
$tpl->content .= '
	<div class="row">
	<div class="col-md-6">
	<div class="box box-solid">
	<div class="box-header">
		<h3 class="box-title">Пополнение баланса</h3>
	</div>
	<form action="" method="post" autocomplete="off">
	
	<div class="box-body">
	
	<div class="form-group">
                  <label>Способ пополнения</label>
                  <select class="form-control" name="type">
                    <option value="WebMoney">WebMoney</option>
                    <option value="Robokassa">Robokassa</option>
                  </select>
                </div>
				 
		<label for="fieldruble">Сумма в рублях</label>
		<div class="input-group">
			
			<input name="summa" id="LMI_PAYMENT_AMOUNT" type="text" class="form-control"  type="text"  placeholder="Введите сумму не менее 10 рублей">
			<span class="input-group-addon"><i class="fa fa-rub"></i></span>
		</div>		
	</div>
	<div class="box-footer">
	<input type="submit" class="btn btn-success" value="пополнить">
		
	</div>
	</form>
	</div>
</div>
	<div class="col-md-6">
	<div class="box box-solid">
		<div class="box-header">
			<h3 class="box-title">Состояние счета</h3>
		</div>
	<div class="box-body">
		<label>Текущий баланс</label>
		<input type="text" class="form-control" value="'.$money.' руб." disabled="">
	</div>
</div>
</div>
</div>
';
}
          ?>