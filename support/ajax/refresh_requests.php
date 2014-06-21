<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$sql = mysql_query("SELECT * FROM ls_sessions WHERE accepted='0' and discaded='0' and closed='0' ORDER BY id DESC");
if(mysql_num_rows($sql)>0) {
?>
	<!-- THE MESSAGES -->
	<table class="table table-mailbox">
	<?php
	while($row = mysql_fetch_array($sql)) {
	?>
	<tr class="unread">
		<td class="name"><a href="./?m=accept&session_id=<?php echo $row['id']; ?>"><?php echo $row['visitor_name']; ?></a></td>
		<td class="subject"><a href="<?php echo $row['visitor_curl']; ?>" target="_blank"><?php echo $row['visitor_curl']; ?></a></td>
		<td><?php if($row['visitor_status'] == 1) { echo 'waiting...'; } else { echo 'new message'; } ?></td>
		<td class="time"><?php if($row['visitor_status'] == 1) { ?><a href="./?m=accept&session_id=<?php echo $row['id']; ?>" title="Accept"><i class="fa fa-check"></i></a>&nbsp;&nbsp;<a href="./?m=discad&session_id=<?php echo $row['id']; ?>" title="Discard"><i class="fa fa-times"></i></a><?php } else { ?><a href="./?m=message&session_id=<?php echo $row['id']; ?>"><i class="fa fa-search"></i></a>&nbsp;&nbsp;<a href="./?m=discad&session_id=<?php echo $row['id']; ?>" title="Discard"><i class="fa fa-times"></i></a><?php } ?></td>
	</tr>
	<?php 
	}
	?>
	</table>
<?php
} else {
?>
<div class="row">
	<div class="col-md-12 text-center">
		<h1 class="text-muted"><i class="fa fa-exclamation-circle"></i> No have chat requests.</h1>
		<small>Requests are updated automatically do not have to refresh your browser.</small>
	</div>
</div>
<?php
}
?>