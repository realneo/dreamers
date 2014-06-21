<?php
ob_start();
session_start(); 
if(file_exists("./install.php")) {
	header("Location: ./install.php");
} 
include("inc/config.php");
// get web settings 
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
$url = $web['url'];
include("inc/functions.php");
$source_dir = 'src/';

if($_SESSION['operator']) {
$m = protect($_GET['m']);
	include($source_dir."header.php");
	switch($m) {
		case "home": include($source_dir."home.php"); break;
		case "history": include($source_dir."history.php"); break;
		case "messages": include($source_dir."messages.php"); break;
		case "operators": include($source_dir."operators.php"); break;
		case "integrate": include($source_dir."integrate.php"); break;
		case "config": include($source_dir."config.php"); break;
		case "change_password": include($source_dir."change_password.php"); break;
		case "accept": include($source_dir."accept.php"); break;
		case "chat": include($source_dir."chat.php"); break;
		case "message": include($source_dir."message.php"); break;
		case "discad": include($source_dir."discad.php"); break;
		case "close": include($source_dir."close.php"); break;
		case "logout": 
				unset($_SESSION['operator']);
				session_unset();
				session_destroy();
				header("Location: ./");
				break;
		default: include($source_dir."home.php");
	}
	include($source_dir."footer.php");
} else {
	include($source_dir."login.php");
}
?>