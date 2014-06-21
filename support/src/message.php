<?php
$session_id = protect($_GET['session_id']);
$check = mysql_query("SELECT * FROM ls_sessions WHERE id='$session_id'");
if(mysql_num_rows($check)==0) { header("Location: ./"); }
$row = mysql_fetch_array($check);
?>
<div class="col-md-9 col-sm-8">
	<div class="row">
		<div class="col-md-10 text-left">
			<h3>Message from <?php echo $row['visitor_name']; ?> <small>viewing <a href="<?php echo $row['visitor_curl']; ?>" target="_blank"><?php echo $row['visitor_curl']; ?></a></small></h3>
		</div>
		<div class="col-md-2 text-right">
			<a href="./?m=close&session_id=<?php echo $row['id']; ?>"><i class="fa fa-times"></i> Close message</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			Sent <?php echo timeago($row['visitor_activity']); ?> (<?php echo date("d/m/Y H:i",$row['visitor_activity']); ?>)
		</div>
		<div class="col-md-12" style="margin-top:10px;">
			<div class=" well well-sm">
			<?php echo nl2br(check_urls($row['last_message'])); ?>
			</div>
		</div>
		<div class="col-md-12">
			<h4>Fast reply</h4>
			<?php
			if(isset($_POST['do_send'])) {
				$your_name = protect($_POST['your_name']);
				$your_email = protect($_POST['your_email']);
				$your_message = protect($_POST['your_message']);
				if(empty($your_name) or empty($your_email) or empty($your_message)) { echo error("All fields are required."); }
				elseif(!isValidEmail($your_email)) { echo error("Please enter valid email address."); }
				else {
					mail($row['visitor_email'], "[LiveSupport System] Reply for your message", $your_message,  "FROM: $your_name <$your_email>");
					echo success("Your reply was sent successfully.");
				}
			}
			?>
			<form action="" method="POST" role="form">
				<div class="form-group">
					<label>Your name</label>
					<input type="text" class="form-control" name="your_name" value="<?php echo idinfo($_SESSION['operator'],"display_name"); ?>">
				</div>
				<div class="form-group">
					<label>Your email</label>
					<input type="text" class="form-control" name="your_email" value="<?php echo idinfo($_SESSION['operator'],"email"); ?>">
				</div>
				<div class="form-group">
					<label>Your message</label>
					<textarea class="form-control" name="your_message" rows="7"></textarea>
				</div>
				<button type="submit" class="btn btn-primary" name="do_send">Send</button>
			</form>
		</div>
	</div>
</div>