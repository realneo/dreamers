<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$turn = protect($_GET['turn']);

if($turn == "online") {
	$update = mysql_query("UPDATE ls_settings SET status='1'");
	?><a href="javascript:void(0);" onclick="turn_offline();"><span class="text-danger">Turn chat offline.</span><?php
} elseif($turn == "offline") {
	$update = mysql_query("UPDATE ls_settings SET status='0'");
	?><a href="javascript:void(0);" onclick="turn_online();"><span class="text-success">Turn chat online.</span></a><?php
} else {
	echo '<span class="text-danger">Unknown function.</span>';
}
?>