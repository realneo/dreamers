<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$type = protect($_GET['type']);

if($type == "send_message") {
	$session_id = protect($_POST['session_id']);
	$message = protect($_POST['message']);
	$from = $_SESSION['operator'];
	$get = mysql_fetch_array(mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'"));
	$time = time();
	$to = $get['visitor_name'];
	$insert = mysql_query("INSERT ls_messages (chat_session,from_u,to_u,message,sent,readed) VALUES ('$session_id','$from','$to','$message','$time','0')") or die(mysql_error());
	echo '<div class="media media-left">
			              <a class="pull-left" href="#">
			                <img class="media-object" src="img/customer.jpg" width="40px">
			              </a>
				            <div class="media-body">
				                <h5 class="media-heading">'.idinfo($get[operator],"display_name").' <span class="badge">operator</span></h5>
				                <div class="timestamp">
									Sent on <span>'.date("l, d F Y H:i",time()).'</span>
								</div>
				                <div class="message message-right">
				                	<p>'.check_urls($message).'</p>
				            	</div>
				            </div>
			            </div>';
} elseif($type == "send_question") {
	$session_id = protect($_POST['session_id']);
	$mid = protect($_POST['message']);
	$from = $_SESSION['operator'];
	$row = mysql_fetch_array(mysql_query("SELECT * FROM ls_fast_messages WHERE Id='$mid'"));
	$message = $row['message'];
	$get = mysql_fetch_array(mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'"));
	$time = time();
	$to = $get['visitor_name'];
	$insert = mysql_query("INSERT ls_messages (chat_session,from_u,to_u,message,sent,readed) VALUES ('$session_id','$from','$to','$message','$time','0')") or die(mysql_error());
	echo '<div class="media media-left">
			              <a class="pull-left" href="#">
			                <img class="media-object" src="img/customer.jpg" width="40px">
			              </a>
				            <div class="media-body">
				                <h5 class="media-heading">'.idinfo($get[operator],"display_name").' <span class="badge">operator</span></h5>
				                <div class="timestamp">
									Sent on <span>'.date("l, d F Y H:i",time()).'</span>
								</div>
				                <div class="message message-right">
				                	<p>'.check_urls($message).'</p>
				            	</div>
				            </div>
			            </div>';
} elseif($type == "check_new_messages") {
	$session_id = protect($_GET['session_id']);
	$session_user = $_SESSION['operator'];

	$check = mysql_query("SELECT * FROM ls_messages WHERE chat_session='$session_id' and to_u='$session_user' and readed='0' ORDER BY id LIMIT 1") or die(mysql_error());
	if(mysql_num_rows($check)>0) {
		echo true;
	} else {
		echo false;
	}
mysql_close();
} elseif($type == "add_new_message") {
	$session_id = protect($_GET['session_id']);
	$session_user = $_SESSION['operator'];

	$check = mysql_query("SELECT * FROM ls_messages WHERE chat_session='$session_id' and to_u='$session_user' and readed='0' ORDER BY id LIMIT 1") or die(mysql_error());
	if(mysql_num_rows($check)>0) {
		$row = mysql_fetch_array($check);
		$get = mysql_fetch_array(mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'"));
		echo '<div class="media media-right">
			              <a class="pull-right" href="#">
			                <img class="media-object" src="img/client.png" width="40px">
			              </a>
			              <div class="media-body">
			                <h5 class="media-heading">'.$get[visitor_name].' <span class="badge">client</span></h5>
			                <div class="timestamp">
									Sent on <span>'.date("l, d F Y H:i",$row[sent]).'</span>
								</div>
			                <div class="message message-left">
			                	<p>'.check_urls($row['message']).'</p>
			            	</div>
			              </div>
			            </div>';
		$update = mysql_query("UPDATE ls_messages SET readed='1' WHERE id='$row[id]'");
	}
mysql_close();
} else {
	echo 'Unknown function.';
}
?>