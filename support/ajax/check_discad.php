<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$session_id = protect($_GET['session_id']);
$sql = mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id' and discaded='1'");
if(mysql_num_rows($sql)>0) {
	echo true;
} else {
	echo false;
}
?>