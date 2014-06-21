<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$session_id = $_SESSION['chat_session_id'];
$session_user = $_SESSION['chat_visitor_name'];

$check = mysql_query("SELECT * FROM ls_messages WHERE chat_session='$session_id' and to_u='$session_user' and readed='0' ORDER BY id LIMIT 1") or die(mysql_error());
if(mysql_num_rows($check)>0) {
	$row = mysql_fetch_array($check);
	$get = mysql_fetch_array(mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'"));
	echo '<div class="media media-left">
			              <a class="pull-left" href="#">
			                <img class="media-object" src="'.$web[url].'img/customer.jpg">
			              </a>
				            <div class="media-body">
				                <h5 class="media-heading">'.idinfo($get[operator],"display_name").' <span class="badge">operator</span></h5>
				                <div class="timestamp">
									<small>Sent on <span>'.date("l, d F Y H:i",time()).'</span></small>
								</div>
				                <div class="message message-right">
				                	<p>'.check_urls($row[message]).'</p>
				            	</div>
				            </div>
			            </div>';
	$update = mysql_query("UPDATE ls_messages SET readed='1' WHERE id='$row[id]'");
}
mysql_close();
?>