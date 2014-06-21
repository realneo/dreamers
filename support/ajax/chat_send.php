<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$session_id = protect($_POST['session_id']);
$visitor = protect($_POST['visitor']);
$message = protect($_POST['message']);
$time = time();
$get = mysql_fetch_array(mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id' and visitor_name='$visitor'"));
$from = $get['visitor_name'];
$to = $get['operator'];
$update = mysql_query("UPDATE ls_sessions SET visitor_activity='$time',last_message='$message' WHERE id='$session_id'");
$insert = mysql_query("INSERT ls_messages (chat_session,from_u,to_u,message,sent,readed) VALUES ('$session_id','$from','$to','$message','$time','0')") or die(mysql_error());
?>