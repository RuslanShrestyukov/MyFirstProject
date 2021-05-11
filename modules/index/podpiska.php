<?php if (!defined('NEWGUARD'))			exit('Нет доступа');
$title = 'Главная';
$tpl->content .= '
<div class="col-md-12">
<div class="row">

 <div class="col-md-4">
 <div class="pricingTable">
 <h4 class="title">Стандарт</h4>
 <span class="amount"><b>1</b></span>
 <span class="month"><b>день</b></span>
 <div class="icon"><i class="fa fa-money"></i></div>
 <ul class="pricing-content">
 <li><span style="font-size:30px">Цена: <span style="font-size:45px">'.$cost1.'</span> рублей</span></li>
 <li><span style="font-size:20px">Доступно и просто!</span></li>
 </ul>
 <a class="pricingTable-signup" href="/pay_1">Купить подписку</a>
 </div>
 </div>

 <div class="col-md-4">
 <div class="pricingTable middle">
 <h4 class="title">Популярный</h4>
 <span class="amount"><b>7</b></span>
 <span class="month"><b>дней</b></span>
 <div class="icon"><i class="fa fa-money"></i></div>
 <ul class="pricing-content">
<li><span style="font-size:30px">Цена: <span style="font-size:45px">'.$cost2.'</span> рублей</span></li>
<li><span style="font-size:20px">Вы экономите: <span style="font-size:30px">'.$cost2_2.'</span> рубля</span></li>
 </ul>
  <a class="pricingTable-signup" href="/pay_2">Купить подписку</a>
 </div>
 </div>

 <div class="col-md-4">
 <div class="pricingTable">
 <h4 class="title">Премиум</h4>
 <span class="amount"><b>30</b></span>
 <span class="month"><b>дней</b></span>
 <div class="icon"><i class="fa fa-money"></i></div>
 <ul class="pricing-content">
<li><span style="font-size:30px">Цена: <span style="font-size:45px">'.$cost3.'</span> рублей</span></li>
<li><span style="font-size:20px">Вы экономите: <span style="font-size:30px">'.$cost3_3.'</span> рубль</span></li>
 </ul>
  <a class="pricingTable-signup" href="/pay_3">Купить подписку</a>
 </div>
 </div>

</div><!-- ./row -->
</div><!-- ./container -->
<br><br>©
';
          ?>