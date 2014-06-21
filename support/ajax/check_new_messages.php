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
	echo true;
} else {
	echo false;
}
mysql_close();
?>