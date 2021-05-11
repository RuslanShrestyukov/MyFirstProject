$(document).ready(function(){
	$('#formbuy input[type=radio]').change(function(){
		onchangepay()
	});
});

function url_redirect(options){
	 var $form = $("<form />");
	 
	 $form.attr("action",options.url);
	 $form.attr("method",options.method);
	 
	 for (var data in options.data)
	 $form.append('<input type="hidden" name="'+data+'" value="'+options.data[data]+'" />');
	  
	 $("body").append($form);
	 $form.submit();
}
			
function onchangepay()
{
	$("#loading").show();
	$.post('/modules/ajax/pay/action.php', $('#formbuy').serialize(), function(data){
		$("#loading").hide();
		$('#buycontent').html(data);
	});
}

function checkbuy()
{
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/pay/create_order.php",
        data: $('#formbuy').serialize(),
        dataType: "json",
        success: function(data)
		{
			switch(data.status) {
				case 'error':			 
					showError(data.text, "#buyerror")
					break;
				case 'success':
					url_redirect({url: "https://merchant.webmoney.ru/lmi/payment.asp",
						method: "POST",
						data: { LMI_PREREQUEST: 1, LMI_PAYEE_PURSE: data.purse, LMI_PAYMENT_AMOUNT: data.cost, LMI_PAYMENT_DESC_BASE64: data.desc, LMI_PAYMENT_NO: data.order, id: data.id }
					});									
					break;
			}		
		}
    });
	return false;
}