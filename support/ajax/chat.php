<?php
ob_start();
session_start();
include("../inc/config.php");
$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
include("../inc/functions.php");

$session_id = protect($_GET['session_id']);
?>
<div id="messages" class="conversation">
	
</div>
<br>
<div id="ls_form_content">
<div class="input-group">
      <input type="text" class="form-control" id="ls_chat_message">
      <span class="input-group-btn">
        <button class="btn btn-primary" type="button" onclick="ls_chat_send('<?php echo $web['url']; ?>','<?php echo $_SESSION['chat_session_id']; ?>','<?php echo $_SESSION['chat_visitor_name']; ?>');">Send</button>
      </span>
</div><!-- /input-group -->
</div>