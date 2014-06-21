<?php
$session_id = protect($_GET['session_id']);
$check = mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'");
if(mysql_num_rows($check)==0) { header("Location: ./"); }
$row = mysql_fetch_array($check);
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#messages").scrollTop($('#messages')[0].scrollHeight);
});

function refresh_chat() {
	var senddata = "ajax/operator.php?type=check_new_messages&session_id=<?php echo $session_id; ?>";
	 $.ajax({
        async:false,
        cache:false,
        url:senddata,
        type:"GET",
        dataType:"text",
        success:function (data) {
			if (data == true) {
				add_new_message();
			}
        }
    });
}

function add_new_message() {
	var senddata = "ajax/operator.php?type=add_new_message&session_id=<?php echo $session_id; ?>";
	 $.ajax({
        async:false,
        cache:false,
        url:senddata,
        type:"GET",
        dataType:"text",
        success:function (data) {
			$("#messages").append(data).scrollTop($('#messages')[0].scrollHeight);
			document.getElementById('new_message').play();
        }
    });
}

setInterval(refresh_chat,1000);
</script>
<div class="col-md-9 col-sm-8">
	<div class="row">
		<div class="col-md-10 text-left">
			<h3>Chat whit <?php echo $row['visitor_name']; ?> <small>viewing <a href="<?php echo $row['visitor_curl']; ?>" target="_blank"><?php echo $row['visitor_curl']; ?></a></small></h3>
		</div>
		<div class="col-md-2 text-right">
			<a href="./?m=close&session_id=<?php echo $row['id']; ?>"><i class="fa fa-times"></i> Close chat</a>
		</div>
	</div>
	<div id="messages" class="conversation">
		<?php
		$sql = mysql_query("SELECT * FROM ls_messages WHERE chat_session='$session_id' ORDER BY id");
		if(mysql_num_rows($sql)>0) {
			while($row = mysql_fetch_array($sql)) {
				$get = mysql_fetch_array(mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'"));
				if($row['from_u'] == $_SESSION['operator']) {
					echo '<div class="media media-left">
			              <a class="pull-left" href="#">
			                <img class="media-object" src="img/customer.jpg" width="40px">
			              </a>
				            <div class="media-body">
				                <h5 class="media-heading">'.idinfo($get[operator],"display_name").' <span class="badge">operator</span></h5>
				                <div class="timestamp">
									Sent on <span>'.date("l, d F Y H:i",$row[sent]).'</span>
								</div>
				                <div class="message message-right">
				                	<p>'.check_urls($row[message]).'</p>
				            	</div>
				            </div>
			            </div>';
				} else {
					echo '<div class="media media-right">
			              <a class="pull-right" href="#">
			                <img class="media-object" src="img/client.png" width="40px">
			              </a>
			              <div class="media-body">
			                <h5 class="media-heading">'.$get[visitor_name].' <span class="badge">client</span></h5>
			                <div class="timestamp">
									Sent on <span>'.date("l, d F Y H:i",$row[sent]).'</span>
								</div>
			                <div class="message message-left">
			                	<p>'.check_urls($row['message']).'</p>
			            	</div>
			              </div>
			            </div>';
				}
			}
		}
		?>
	</div>
	<br>
	<div class="input-group">
		  <input type="text" class="form-control" id="form_msg">
		  <span class="input-group-btn">
			<button class="btn btn-primary" type="button" onclick="send('<?php echo $session_id; ?>');">Send</button>
		  </span>
	</div><!-- /input-group -->
	<br>
	<div class="input-group">
		  <select id="fast_msg" class="form-control">
			<option value="">Select fast message to send.</option>
			<?php
			$get_sql = mysql_query("SELECT * FROM ls_fast_messages ORDER BY id");
			if(mysql_num_rows($get_sql)>0) {
				while($get = mysql_fetch_array($get_sql)) {
					echo '<option value="'.$get[id].'">'.$get[title].'</option>';
				}
			}
			?>
		  </select>
		  <span class="input-group-btn">
			<button class="btn btn-primary" type="button" onclick="send_q('<?php echo $session_id; ?>');">Send</button>
		  </span>
	</div><!-- /input-group -->
</div>

<audio id="new_message" src="wav/listen.wav" preload="auto"></audio>