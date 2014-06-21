<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$your_name = protect($_POST['your_name']);
$your_email = protect($_POST['your_email']);
$your_message = protect($_POST['your_message']);
$your_ip = $_SERVER['REMOTE_ADDR'];
$curl = protect($_POST['curl']);

if(empty($your_name) or empty($your_email) or empty($your_message)) { echo "<div class='text-danger' style='font-size:14px;'><center>All fields are required.</center></div>"; }
elseif(!isValidEmail($your_email)) { echo "<div class='text-danger' style='font-size:14px;'><center>Please enter valid email address.</center></div>"; }
else {
	$time = time();
	$insert = mysql_query("INSERT ls_sessions (started,finished,accepted,discaded,closed,visitor_name,visitor_email,visitor_ip,visitor_curl,last_message,visitor_activity,visitor_status) VALUES 
	('$time','0','0','0','0','$your_name','$your_email','$your_ip','$curl','$your_message','$time','0')");
	echo "<div class='text-success' style='font-size:14px;'><center>Your message was sent.</center></div>";
}
?>