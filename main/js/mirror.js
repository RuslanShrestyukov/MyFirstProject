var ie=document.all?1:0;
var ns=document.getElementById&&!document.all?1:0;
var msg=0;
var newTitle = document.title;
var firstmsg = true;


$(document).ready(function(){
  $("#test").click(function(){
    $("#myModalonJS").modal('show');
  });
});


function usonline(){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/other/online.php",
        data: "act=online",
        dataType: "html",
        success: function(data){
			if($('.usonline').length)
				$('.usonline').html(data);
		}
    });  
    return false;
}

function checkservers(){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/other/servers.php",
		data: "act=servers",
        dataType: "json",
        success: function(data){
			for (a in data) 
			{
				$('#server' + a + ' #hostname').html(data[a].hostname)
				$('#server' + a + ' #map').html(data[a].map)
				$('#server' + a + ' #playerslist').html(data[a].players)
			}
		}
    });  
    return false;
}

function checkthreads(){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/other/threadslast.php",
		data: "act=threadslast",
        dataType: "json",
        success: function(data){
			for (a in data) 
			{
				$('#thread' + a + ' #title').html(data[a].title)
				$('#thread' + a + ' #otv').html(data[a].otv)
				$('#thread' + a + ' #lastmsg').html(data[a].lastmsg)
			}
		}
    });  
    return false;
}


function blockfriend(id){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/friends/blockfriend.php",
        data: "user_id=" + id,
        dataType: "json",
        success: function(data){
			switch(data.status) {
				case 'error':
					 showToast("Не удалось заблокировать пользователя", "error", false);					
					break;
				case 'success':
					 location.reload()
					break;
			}
		}
    });  
    return false;
}

function unblockfriend(id){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/friends/unblockfriend.php",
        data: "user_id=" + id,
        dataType: "json",
        success: function(data){
			switch(data.status) {
				case 'error':
					 showToast("Не удалось разблокировать пользователя", "error", false);					
					break;
				case 'success':
					 location.reload()
					break;
			}
		}
    });  
    return false;
}

function addfriend(id){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/friends/addfriend.php",
        data: "user_id=" + id,
        dataType: "json",
        success: function(data){
			switch(data.status) {
				case 'error':
					 showToast("Не удалось добавить друга", "error", false);					
					break;
				case 'success':
					 showToast("Заявка в друзья успешно создана", "success", false);
					break;
			}
		}
    });  
    return false;
}

function delfriend(id){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/friends/delfriend.php",
        data: "user_id=" + id,
        dataType: "json",
        success: function(data){
			switch(data.status) {
				case 'error':
					 showToast("Не удалось удалить друга", "error", false);					
					break;
				case 'success':
					 location.reload()
					break;
			}
		}
    });  
    return false;
}

function validatefriend(id){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/friends/validatefriend.php",
        data: "user_id=" + id,
        dataType: "json",
        success: function(data){
			switch(data.status) {
				case 'error':
					 showToast("Не удалось добавить друга", "error", false);					
					break;
				case 'success':
					 location.reload()
					break;
			}
		}
    });  
    return false;
}

function delinvite(id){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/friends/delinvite.php",
        data: "user_id=" + id,
        dataType: "json",
        success: function(data){
			switch(data.status) {
				case 'error':
					 showToast("Не удалось отозвать заявку", "error", false);					
					break;
				case 'success':
					 location.reload()
					break;
			}
		}
    });  
    return false;
}

function Toggle(el) {	
    el.style.display = (el.style.display == 'none') ? '' : 'none' 
}

function reply_post() {
	$('html, body').animate({scrollTop: $('textarea').offset().top}, 500);
	$('textarea').focus();
}

function LikeAction(postid) {
	$('#thanks' + postid).hide();
	$.post("ajaxnew.php", 
	{
		act: "like_post",
		postid: postid
	}, function(result) {
		$('#bpost' + postid).show();
	}
	);
}
function ToggleBar(check) {	
    if(check == "0") {
		if($.cookie("full_width") == "on") {
			$.cookie("full_width", "off");
			$("#templatemo_content_full").attr("id", "templatemo_content");
			$('#sidebar').show();
			$('.brand').show();
			$('ul').find('a#fullwidth').remove();
		} else {
			$.cookie("full_width", "on");
			$("#templatemo_content").attr("id", "templatemo_content_full");
			$('#sidebar').hide();
			$('.brand').hide();
			if($("#authorized").length) {
				$("ul[class='nav']").append("<li><a id='fullwidth' href='/profile'>Профиль</a></li><li><a id='fullwidth' href='/im'>Cообщения <span id='num_msg'></span></a></li><li><a id='fullwidth' href='/gounban'>Заявки на разбан</a></li><li><a id='fullwidth' href='/settings'>Настройки</a></li>");
				$('a[href="' + location.pathname + '"]').parent("li").addClass('active');
			}
		}
	} else if(check == "1") {
		if($.cookie("full_width") == "on") {
			$("#templatemo_content").attr("id", "templatemo_content_full");
			$('#sidebar').hide();
			$('.brand').hide();
			if($("#authorized").length) {
				$("ul[class='nav']").append("<li><a id='fullwidth' href='/profile'>Профиль</a></li><li><a id='fullwidth' href='/im'>Cообщения <span id='num_msg'></span></a></li><li><a id='fullwidth' href='/gounban'>Заявки на разбан</a></li><li><a id='fullwidth' href='/settings'>Настройки</a></li>");
				$('a[href="' + location.pathname + '"]').parent("li").addClass('active');
			}
		}
	}
}

function prava_admina (accnum)
{
	$("#account_edit_num").val(accnum)
	$('#edit_account').submit();
}

function validate_un(){
        //Очищаем значение полей
        document.getElementById('nickf').innerHTML='';
        document.getElementById('prichinaf').innerHTML='';
        document.getElementById('docsf').innerHTML='';
        //Считаем значения из полей
        var x=0;
        var a=document.forms['form']['nick'].value;
		a = trim(a);
        var b=document.forms['form']['prichina'].value;
		b = trim(b);
        var c=document.forms['form']['docs'].value;
		b = trim(b);
        //Если поле name пустое выведем сообщение и предотвратим отправку формы
        if (a.length==0){
            document.getElementById('nickf').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
	        x++;
        }
        if (b.length==0){
            document.getElementById('prichinaf').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
	        x++;
        }
        if (c.length==0){
            document.getElementById('docsf').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
	        x++;
        }
        if (x!=0) {
            return false;
        }
}
		
function validate_p(){
	//Очищаем значение полей
	document.getElementById('passwordf').innerHTML='';
	document.getElementById('password1f').innerHTML='';
	//Считаем значения из полей
	var x=0;
	var a=document.forms['form']['password'].value;
	a = trim(a);
	var b=document.forms['form']['password1'].value;
	b = trim(b);
	//Если поле name пустое выведем сообщение и предотвратим отправку формы
	if (a.length==0){
		document.getElementById('passwordf').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
		x++;
	}
	if (b.length==0){
		document.getElementById('password1f').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
		x++;
	}
	if ((a!=b) && (a.length!=0) && (b.length!=0)){
		document.getElementById('password1f').innerHTML='&nbsp;&nbsp;<sup>* пароли не совпадают</sup>';
		x++;
	}
	if ((a.length<6) && (a=b) && (a.length!=0) && (b.length!=0)){
		document.getElementById('passwordf').innerHTML='&nbsp;&nbsp;<sup>* длина пароля менее 6 символов</sup>';
		x++;
	}
	if (x!=0) {
		return false;
	}
}
function validate_m(){
	//Очищаем значение полей
	document.getElementById('emailf').innerHTML='';
	//Считаем значения из полей
	var x=0;
	var a=document.forms['form']['email'].value;
	reg = /^[A-Z0-9._-]+@[A-Z0-9.-]{1,61}\.[A-Z]{2,6}$/i;
	if (!a.match(reg)){
		document.getElementById('emailf').innerHTML='&nbsp;&nbsp;<sup>* email введен не верно</sup>';
	  x++;
	}
	if (x!=0) {
		return false;
	}
}
function validate(){
	//Очищаем значение полей
	document.getElementById('loginf').innerHTML='';
	document.getElementById('namef').innerHTML='';
	document.getElementById('nickf').innerHTML='';
	document.getElementById('emailf').innerHTML='';
	document.getElementById('passwordf').innerHTML='';
	document.getElementById('password1f').innerHTML='';
	//Считаем значения из полей
	var x=0;
	var a=document.forms['form']['login'].value;
	a = trim(a);
	var b=document.forms['form']['name'].value;
	b = trim(b);
	var c=document.forms['form']['nick'].value;
	c = trim(c);
	var d=document.forms['form']['email'].value;
	d = trim(d);
	var e=document.forms['form']['password'].value;
	e = trim(e);
	var f=document.forms['form']['password1'].value;
	f = trim(f);
	//Если поле name пустое выведем сообщение и предотвратим отправку формы
	if (a.length==0){
		document.getElementById('loginf').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
		x++;
	}
	if (b.length==0){
		document.getElementById('namef').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
		x++;
	}
	if (c.length==0){
		document.getElementById('nickf').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
		x++;
	}
	if (d.length==0){
		document.getElementById('emailf').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
		x++;
	}
	if (e.length==0){
		document.getElementById('passwordf').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
		x++;
	}
	if (f.length==0){
		document.getElementById('password1f').innerHTML='&nbsp;&nbsp;<sup>* данное поле обязательно для заполнения</sup>';
		x++;
	}
	reg = /^[A-Z0-9._-]+@[A-Z0-9.-]{1,61}\.[A-Z]{2,6}$/i;
	if (!d.match(reg)){
		document.getElementById('emailf').innerHTML='&nbsp;&nbsp;<sup>* email введен не верно</sup>';
	  x++;
	}
	if ((e!=f) && (e.length!=0) && (f.length!=0)){
		document.getElementById('password1f').innerHTML='&nbsp;&nbsp;<sup>* пароли не совпадают</sup>';
		x++;
	}
	if ((e.length<6) && (e=f) && (e.length!=0) && (f.length!=0)){
		document.getElementById('passwordf').innerHTML='&nbsp;&nbsp;<sup>* длина пароля менее 6 символов</sup>';
		x++;
	}
	if (x!=0) {
		return false;
	}
}
	
//удаление сообщения на форуме
function delete_post(num, status) {
	event.preventDefault(); 
	event.stopPropagation();
	$.post("ajaxnew.php", 
	{
		act: "messages_forum_del",
		npost: num
	},
	function(result) {
		if(status == 1) {
			window.location.replace('http://'+document.location.hostname+'/forums');
		} else {
			location.reload();
		}
	}
	);
}
// Не пустое ли поле ввода сообщения
function validate_input() {
	var a= document.getElementById('input_text').value;
	a = trim(a);
	if (a.length==0){
		$("#input_textf").html("&nbsp;&nbsp;<sup>* запрещена отправка пустых сообщений</sup>");
		$("#input_text").val("");
		$("#input_text").focus();
		return false;
	}
}
//подтверждение удаления
function confirmDelete() {
	if (confirm("Вы подтверждаете удаление?")) {
		return true;
	} 
	else {
		return false;
	}
}
//добавление смайлов в форму ввода
function InsertInChat(textid)
{
    if(ie)
    {
    document.all.pm_text.focus();
    document.all.pm_text.value+=" "+textid+" ";
    }
 
    else if(ns)
    {
    document.forms['form_msg'].elements['pm_text'].focus();
    document.forms['form_msg'].elements['pm_text'].value+=" "+textid+" ";
    }
 
    else
    alert("Ваш браузер не поддерживается!");
}

function trim(str, charlist)
{
    charlist = !charlist ? " \s\r\n\t\xA0\x0B\0" :
                charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, "\$1");
    
    var re = new RegExp("^[" + charlist + "]+|[" + charlist + "]+$", "g");
    
    return str.replace(re, '');
}

//добавление смайлов в форму ввода
function InsertSmile(textid)
{
    if(ie)
    {
    document.all.input_text.focus();
    document.all.input_text.value+=" "+textid+" ";
    } else if(ns) {
    document.forms['form_msg'].elements['input_text'].focus();
    document.forms['form_msg'].elements['input_text'].value+=" "+textid+" ";
    } 
    else
    alert("Ваш браузер не поддерживается!");
}

//подтверждение очистки чата
function confirmClear() {
	if (confirm("Вы подтверждаете очистку чата?")) {
		return true;
	} 
	else {
		return false;
	}
}

//скрытие элемента
function ToToggle(el) {	
    el.style.display = 'none';
}

//открытие элемента
function UnToggle(el) {	
    el.style.display = '' ;
}

function chat_to (msg_id){
	$("#pac_text").val($('#username' + msg_id).html() + ', ');
	$("#pac_text").focus();
	return false;
}

function forum_to (msg_id){
	$("#editor").val($('#username' + msg_id).html() + ', ');
	$("#editor").focus();
	return false;
}

//считывание новых ЛС
function loadmsg(){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/im/check.php",
        data: "act=check",
        dataType: "html",
        success: function(data){  
			if (data > 0) {
				$('#num_msg').html('<small class="badge pull-right bg-yellow">' + data + '</small>');
				Tinycon.setBubble(data);
				document.title = '(' + data +') Новые сообщения';
			}
			else
			{
				$('#num_msg').html('');
				Tinycon.setBubble('0');
				document.title = newTitle;
			}
			
			if (data > msg && !firstmsg && $.cookie("msg_sound") != "off") {
				$('#misc').append('<audio style="display:none;" autoplay="autoplay"><source src="/main/sound/pick.mp3" type="audio/mpeg"><source src="/main/sound/pick.wav" type="audio/wav"></audio>');		
			}
			msg=data;
			firstmsg=false;
		}
    });  
    return false;
}

function loadms(){
    $.ajax({  
        type: "POST",  
        url: "/modules/ajax/im/check.php",
        data: "act=check",
        dataType: "html",
        success: function(data){  
			if (data > 0) {
				$('#num_msg1').html('<small class="badge pull-right bg-yellow">' + data + '</small>');
				Tinycon.setBubble(data);
				
			}
			
			
			
		}
    });  
    return false;
}

$(document).ready(function(){

	setInterval(usonline, 120000)
	
	if($("table").is(".blockservers"))
		setInterval(checkservers, 240000)

	if($("table").is(".topiclist"))
		setInterval(checkthreads, 300000)
			
	 
	 loadmsg(); 
	 ToggleBar(1);
	 $('textarea').autoResize();
	 $(".fancybox").fancybox();
	 setInterval("loadmsg();", 10000);
	 $('#bbpanel a').click(function() {
	  var button_id = attribs = $(this).attr("alt");
	  button_id = button_id.replace(/\[.*\]/, '');
	  if (/\[.*\]/.test(attribs)) { attribs = attribs.replace(/.*\[(.*)\]/, '$1'); } else attribs = '';
	  var start = '['+button_id+attribs+']';
	  var end = '[/'+button_id+']';
	  insert(start, end);
	  return false;
	 });
	 $.fn.scrollToTop = function() {
	  $(this).hide().removeAttr("href");
	  if ($(window).scrollTop() >= "250") $(this).fadeIn("slow")
	  var scrollDiv = $(this);
	  $(window).scroll(function() {
	   if ($(window).scrollTop() <= "250") $(scrollDiv).fadeOut("slow")
	   else $(scrollDiv).fadeIn("slow")
	  });
	  $(this).click(function() {
	   $("html, body").animate({scrollTop: 0}, "slow")
	  })
	 }
	  $("#Go_Top").scrollToTop();
	  $('#pm_msg tbody tr[data-href]').addClass('clickable').click( function() {
		window.location = $(this).attr('data-href');
	  });
	$('[data-toggle="modal"]').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		var title = $(this).attr('data-title');
		if (url.indexOf('#') == 0) {
			$(url).modal('open');
		} else {
			$.get(url, function(data) {
				$('<div class="modal hide fade" data-toggle="modal" tabindex="-1" role="dialog"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button><h3 id="myModalLabel">' + title +'</h3></div><div class="modal-body">' + data +'</div></div>').modal();
			});
		}
	});
	$('[data-toggle="tv"]').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		var title = $(this).attr('data-title');
		if (url.indexOf('#') == 0) {
			$(url).modal('open');
		} else {
			$.get(url, function(data) {
				$('<div class="modal hide fade" data-toggle="modal" tabindex="-1" role="dialog"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button></div><div class="modal-body">' + data +'</div></div>').modal();
			});
		}
	});
});

function insert(start, end) {
	element = document.getElementById('input_text');
	if (document.selection) {
		element.focus();
		sel = document.selection.createRange();
		sel.text = start + sel.text + end;
	} else if (element.selectionStart || element.selectionStart == '0') {
		element.focus();
		var startPos = element.selectionStart;
		var endPos = element.selectionEnd;
		element.value = element.value.substring(0, startPos) + start + element.value.substring(startPos, endPos) + end + element.value.substring(endPos, element.value.length);
	} else {
		element.value += start + end;
	}
}

function msg_status() {
    if($.cookie("msg_sound") == "off") {
	    $.cookie("msg_sound", "on");
        $('#msg_status').html('<font color=green>Звук включен</font>');
    } else {
	    $.cookie("msg_sound", "off");
        $('#msg_status').html('<font color=red>Звук выключен</font>');
	}
}

function Load() {
    if(!load_in_process)
    {
	    load_in_process = true;
    	$.post("ajaxnew.php", 
    	{
      	    act: "load_chat",
      	    last: last_message_id
    	},
   	    function (result) {
		    load_in_process = false;
    	});
    }
}

function Old_Load() 
{
	$.ajax({
		url: 'ajaxnew.php',
		dataType: "script",
		type: "POST",
		data: { 
      	    act: "load_old_chat",
      	    last: $(".chat:last").attr("id")
		},
		success: function(result) {
			 showToast("Вы успешно загрузили прошлые сообщения", "success", false);
		}
	});
}

function Send() {
    $.post("ajaxnew.php",  
	{
        act: "send_chat", 
        text: $("#pac_text").val()
    },
     Load );

    $("#pac_text").val(""); 
    $("#pac_text").focus();
    
    return false;
}

function showError(text, selector)
{
	var element = $('<div class="alert alert-error"><strong>Ошибка!</strong><br />' + text + '</div>').prependTo(selector);
	setTimeout(function() {
		element.fadeOut(500, function() {
			$(this).remove();
		});
	}, 5000);
}
function showWarning(text, selector) {
	var element = $('<div class="alert"><strong>Предупреждение!</strong><br />' + text + '</div>').prependTo(selector);
	setTimeout(function() {
		element.fadeOut(500, function() {
			$(this).remove();
		});
	}, 5000);
}
function showSuccess(text, selector) {
	var element = $('<div class="alert alert-success"><strong>Поздравляем!</strong><br />' + text + '</div>').prependTo(selector);
	setTimeout(function() {
		element.fadeOut(500, function() {
			$(this).remove();
		});
	}, 5000);
}
function showToast(text, type, sticky) {
	$().toastmessage('showToast', {
		text     : text,
		type     : type,
		sticky   : sticky
	});
}

function formbalance() 
{
	var set = function () {
		$("#addMoney").modal('show')
	};
	$("#addMoney").length ? set() : $.get("/modules/ajax/aj_balance", function (response) {
		$("#ajax-content").prepend(response);
		set();
	});
}

