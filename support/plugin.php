<?php
ob_start();
session_start();
include("inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));

if($web['status'] == 1) {
	?>
	<form id="is_form_online" action="" method="POST">
		<p>Please enter your name and email to start chat with operator.</p>
		<div class="form-group">
			<label>Your name</label>
			<input type="text" class="form-control" id="your_name" name="your_name">
		</div>
		<div class="form-group">
			<label>Your email</label>
			<input type="text" class="form-control" id="your_email" name="your_email">
		</div>
		<br />
		<button type="button" class="btn btn-primary" onclick="ls_start_chat();">Start chat</button>
	</form>
	<?php
} else {
	?>
	<form id="ls_form_offline" action="" method="POST">
		<p>Currently we are not online please leave us a message and we will reply to your email address.</p>
		<div class="form-group">
			<label>Your name</label>
			<input type="text" class="form-control" id="your_name" name="your_name">
		</div>
		<div class="form-group">
			<label>Your email</label>
			<input type="text" class="form-control" id="your_email" name="your_email">
		</div>
		<div class="form-group">
			<label>Your message</label>
			<textarea class="form-control" rows="3" id="your_message" name="your_message"></textarea>
		</div>
	<br />
		<button type="button" class="btn btn-primary" onclick="ls_send_message();">Send</button>
	</form>
	<?php
}
?>