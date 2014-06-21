<?php
$session_id = protect($_GET['session_id']);
$check = mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'");
if(mysql_num_rows($check)>0) {
	$row = mysql_fetch_array($check);
	$time = time();
	$update = mysql_query("UPDATE ls_sessions SET finished='$time',operator='$_SESSION[operator]',closed='1' WHERE id='$session_id'");
	header("Location: ./");
} else {
	header("Location: ./");
}
?>