<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$your_name = protect($_POST['your_name']);
$your_email = protect($_POST['your_email']);
$your_ip = $_SERVER['REMOTE_ADDR'];
$curl = protect($_POST['curl']);

if(empty($your_name) or empty($your_email)) { echo error("All fields are required."); }
elseif(!isValidEmail($your_email)) { echo error("Please enter valid email address."); }
else {
	$time = time();
	$insert = mysql_query("INSERT ls_sessions (started,finished,accepted,discaded,closed,visitor_name,visitor_email,visitor_ip,visitor_curl,last_message,visitor_activity,visitor_status) VALUES 
	('$time','0','0','0','0','$your_name','$your_email','$your_ip','$curl','$your_message','$time','1')");
	$get = mysql_fetch_array(mysql_query("SELECT * FROM ls_sessions WHERE started='$time' and visitor_ip='$your_ip'"));
	$_SESSION['chat_session_id'] = $get['id'];
	$_SESSION['chat_visitor_name'] = $get['visitor_name'];
	?>
	<div class='text-center'><img src='<?php echo $web['url']."img/loader.gif"; ?>' width='16px'> Waiting operator...</div>
	<input type="hidden" id="session_id" value="<?php echo $get['id']; ?>">
	<?php
}
?>