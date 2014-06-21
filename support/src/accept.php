<?php
$session_id = protect($_GET['session_id']);
$check = mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'");
if(mysql_num_rows($check)>0) {
	$row = mysql_fetch_array($check);
	$update = mysql_query("UPDATE ls_sessions SET operator='$_SESSION[operator]',accepted='1' WHERE id='$session_id'");
	$redirect = './?m=chat&session_id='.$session_id;
	header("Location: $redirect");
} else {
	header("Location: ./");
}
?>