<?php
header("Content-type: application/x-javascript");
header("Content-Type: text/plain; charset=utf-8");
ob_start();
session_start();
include("inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("inc/functions.php");
?>
$(document).ready(function() {
	var ls_timer;
	var ls_timer_2;
	$("body").append("<div id='ls_chat_plugin'></div>");
	ls_load_plugin();
});

function ls_load_plugin() {
	$("#ls_chat_plugin").html("<a href='javascript:void(0);' onclick='ls_toggle_chat();'><div class='header'><?php if($web['status'] == 1) { echo $web['online_message']; } else { echo $web['offline_message']; } ?></div></a><div class='chat_content' id='chat_content'></div>");
}

function ls_toggle_chat() {
	$("#ls_chat_plugin .chat_content").toggle();
	$("#ls_chat_plugin #chat_content").load("<?php echo $web['url']."plugin.php"; ?>");
}

function ls_send_message() {
	var your_name = $("#your_name").val();
	var your_email = $("#your_email").val();
	var your_message = $("#your_message").val();
	var curl = window.location.href;
	
	if(your_name == "") { alert("Please enter your name."); }
	else if(validateEmail(your_email) == false) { alert("Please enter valid email address."); }
	else if(your_message == "") { alert("Please enter your message."); }
	else {
		$("#ls_chat_plugin #chat_content").html("<div class='text-center'><img src='<?php echo $web['url']."img/loader.gif"; ?>' width='16px'> Loading...</div>");
		var senddata = "<?php echo $web['url']."ajax/send_message.php"; ?>";
		$.ajax({
			async:false,
			cache:false,
			url:senddata,
			type:"POST",
			data: { your_name: your_name, your_email: your_email, your_message: your_message, curl: curl },
			dataType:"text",
			success:function (data) {
				$("#ls_chat_plugin #chat_content").html(data);
			}
		});
	}
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

function ls_start_chat() {
	var your_name = $("#your_name").val();
	var your_email = $("#your_email").val();
	var curl = window.location.href;
	
	if(your_name == "") { alert("Please enter your name."); }
	else if(validateEmail(your_email) == false) { alert("Please enter valid email address."); }
	else {
		$("#ls_chat_plugin #chat_content").html("<div class='text-center'><img src='<?php echo $web['url']."img/loader.gif"; ?>' width='16px'> Loading...</div>");
		var senddata = "<?php echo $web['url']."ajax/start_chat.php"; ?>";
		$.ajax({
			async:false,
			cache:false,
			url:senddata,
			type:"POST",
			data: { your_name: your_name, your_email: your_email, curl: curl },
			dataType:"text",
			success:function (data) {
				$("#ls_chat_plugin #chat_content").html(data);
				ls_check_status();
			}
		});
	}
}
	
function ls_check_status() { 
	var ref_timer;
	var session_id = $("#session_id").val();
	var senddata = "<?php echo $web['url']."ajax/check_status.php?session_id="; ?>"+session_id;
	$.ajax({
		async:false,
		cache:false,
		url:senddata,
		type:"GET",
		dataType:"text",
		success:function (data) {
			if (data == true) {
				stopTimer();
				$("#ls_chat_plugin .header").append('<input type="hidden" id="session_id" value="' + session_id + '">');
				$("#ls_chat_plugin #chat_content").load("<?php echo $web['url']."ajax/chat.php?session_id="; ?>"+session_id);
				start_check_refresh();
			} else {
				$("#ls_chat_plugin .header").append('<input type="hidden" id="session_id" value="' + session_id + '">');
				startTimer();
			}
		}
	});
}

function ls_check_discad() { 
	var ref_timer;
	var session_id = $("#session_id").val();
	var senddata = "<?php echo $web['url']."ajax/check_discad.php?session_id="; ?>"+session_id;
	$.ajax({
		async:false,
		cache:false,
		url:senddata,
		type:"GET",
		dataType:"text",
		success:function (data) {
			if (data == true) {
				$("#ls_chat_plugin #chat_content").html("<div class='text-danger' style='font-size:14px;'><center>The operator reject the chat.</center></div>");
			}
		}
	});
}

function ls_check_close() { 
	var ref_timer;
	var session_id = $("#session_id").val();
	var senddata = "<?php echo $web['url']."ajax/check_close.php?session_id="; ?>"+session_id;
	$.ajax({
		async:false,
		cache:false,
		url:senddata,
		type:"GET",
		dataType:"text",
		success:function (data) {
			if (data == true) {
				$("#ls_chat_plugin #chat_content #ls_form_content").html("<div class='text-danger' style='font-size:14px;'><center>The operator left the chat.</center></div>");
			}
		}
	});
}

function ls_check_new_messages() { 
	var session_id = $("#session_id").val();
	var session_user = $("#ls_chater").val();
	var senddata = "<?php echo $web['url']."ajax/check_new_messages.php?session_id="; ?>"+session_id+"&to="+session_user;
	$.ajax({
		async:false,
		cache:false,
		url:senddata,
		type:"GET",
		dataType:"text",
		success:function (data) {
			if (data == true) {
				ls_load_new_messages();
			}
			start_check_refresh();
			start_check_close();
		}
	});
}

function ls_load_new_messages() { 
	var session_id = $("#session_id").val();
	var session_user = $("#ls_chater").val();
	var senddata = "<?php echo $web['url']."ajax/load_new_messages.php?session_id="; ?>"+session_id+"&to="+session_user;
	$.ajax({
		async:false,
		cache:false,
		url:senddata,
		type:"GET",
		dataType:"text",
		success:function (data) {
			$("#ls_chat_plugin #chat_content #messages").append(data).scrollTop($("#ls_chat_plugin #chat_content #messages")[0].scrollHeight);
		}
	});
}

function ls_chat_send(url,session_id,visitor) {
	var message = $("#ls_chat_message").val();
	var senddata = "<?php echo $web['url']."ajax/chat_send.php"; ?>";
	if(message == "") { alert("Please enter your message."); }
	else {
		$.ajax({
			async:false,
			cache:false,
			url:senddata,
			type:"POST",
			data: { session_id: session_id, visitor: visitor, message: message },
			dataType:"text",
			success:function (data) {
				$("#ls_chat_message").val("");
				$("#ls_chat_plugin #chat_content #messages").append('<div class="media media-right"><a class="pull-right" href="#"><img class="media-object" src="<?php echo $web['url']; ?>img/client.png"></a><div class="media-body"><h5 class="media-heading">You <span class="badge">client</span></h5><div class="timestamp">Sent on <span><?php echo date("l, d F Y H:i",time()); ?></span></div><div class="message message-left"><p>' + message + '</p></div></div></div>').scrollTop($("#ls_chat_plugin #chat_content #messages")[0].scrollHeight);;
			}
		});
	}
}

function start_check_refresh() {
	window.setTimeout(ls_check_new_messages,1000);
}

function start_check_close() {
	window.setTimeout(ls_check_close,1000);
}

function startTimer() {
	ls_timer = window.setTimeout(ls_check_status,1000);
	ls_timer_2 = window.setTimeout(ls_check_discad,1000);
}

function stopTimer() {
	window.clearTimeout(ls_timer);
	window.clearTimeout(ls_timer_2);
}