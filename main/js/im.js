$(document).ready(function () {
	$("#imgLoad").hide();
	$("#form_msg").submit(send_im);
	$("#input_text").focus();
	newLoad_im();
	setInterval("newLoad_im();", 5000);
	//setInterval("messages_check();", 5000);
}); 

var load_in_process = false;

function send_im() 
{
	$.ajax({
		url: '/modules/ajax/im/send.php',
		dataType: "html",
		type: "POST",
		data: { 
			act: "im_post",
			dialog: dialog,
			text: $("#input_text").val()
		},
		success: function(data) {
			newLoad_im();		
		},
		beforeSend: function(xhr, opts){
			$("#input_textf").html("");
			var a = trim($("#input_text").val());
			if (a==0)
			{
				$("#input_textf").html("&nbsp;&nbsp;<sup>* запрещена отправка пустых сообщений</sup>");
				$("#input_text").val("");
				$("#input_text").focus();
				xhr.abort();
			}
		},
		complete: function() {
			$("#input_text").val("");
			$("#input_text").focus();
		}
	});
	
	return false;
}

function oldLoad_im() 
{
	if(!load_in_process)
	{
		load_in_process = true;
		$.ajax({
			url: '/modules/ajax/im/load.php',
			dataType: "html",
			type: "POST",
			data: { 
				act: "old_posts",
				dialog: dialog,
				last: $(".messages:last").attr("id")
			},
			success: function(data) {
				if(!data)
					$("#load").hide();
				$("#allmessages").append(data);
			},
			beforeSend: function(){
				$("#imgLoad").show();
			},
			complete: function() {
				$("#imgLoad").hide();
				load_in_process = false;
			}
		});
	}
}

function newLoad_im() 
{
	if(!load_in_process)
	{
		load_in_process = true;
		$.ajax({
			url: '/modules/ajax/im/load.php',
			dataType: "html",
			type: "POST",
			data: { 
				act: "new_posts",
				dialog: dialog,
				first: $(".messages:first").attr("id")
			},
			success: function(data) {
				$("#allmessages").prepend(data);
			},
			complete: function() {
				load_in_process = false;
			}
		});
	}
}

function delete_pm(num) 
{
	$.ajax({
		url: '/modules/ajax/im/del.php',
		dataType: "html",
		type: "POST",
		data: { 
			act: "delpost",
			postid: num
		},
		success: function(data) {
			if(data.status == 'error')
				$("#" + num).show();
			else
				$("#" + num).remove();
		},
		beforeSend: function(){
			$("#" + num).hide();
		},
		error: function(){
			$("#" + num).show();
		}
	});
}

/*function messages_check() {
	$.post("ajaxnew.php", 
	{
		act: "messages_im_check",
		dialog: dialog
	},
	function(result) { 
		if(result.length > 0){ 
			$(".my_msg").animate({backgroundColor: 'rgba(242, 247, 249, 255)'}); 
		} 
	}
	);
}*/