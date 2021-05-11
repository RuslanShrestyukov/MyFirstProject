function formbalance() 
{
	var set = function () {
		$("#addMoney").modal('show')
	};
	$("#addMoney").length ? set() : $.get("/pay/formbalance/form.php", function (response) {
		$("#ajax-content").prepend(response);
		set();
	});
}