<div class="col-md-9 col-sm-8">
	<div class="row">
		<div class="col-md-12">
		<br>
		<?php
		if(idinfo($_SESSION['operator'],"sysadmin") == 1) {
			?>
			<?php
			if(isset($_POST['do_save'])) {
				$ls_dir = protect($_POST['ls_dir']);
				$url = protect($_POST['url']);
				$online_message = protect($_POST['online_message']);
				$offline_message = protect($_POST['offline_message']);
				
				if(empty($ls_dir) or empty($url) or empty($online_message) or empty($offline_message)) { echo error("All fields are required."); }
				else {
					$update = mysql_query("UPDATE ls_settings SET ls_dir='$ls_dir',url='$url',online_message='$online_message',offline_message='$offline_message'");
					$web = mysql_fetch_array(mysql_query("SELECT * FROM ls_settings ORDER BY id DESC LIMIT 1"));
					echo success("Your changes was saved successfully.");
				}
			}
			?>
			<form action="" method="POST" role="form">
				<div class="form-group">
					<label>LiveSupport System directory</label>
					<input type="text" class="form-control" name="ls_dir" value="<?php echo $web['ls_dir']; ?>">
				</div>
				<div class="form-group">
					<label>LiveSupport System url address</label>
					<input type="text" class="form-control" name="url" value="<?php echo $web['url']; ?>">
				</div>
				<div class="form-group">
					<label>Online message on header box</label>
					<input type="text" class="form-control" name="online_message" value="<?php echo $web['online_message']; ?>">
				</div>
				<div class="form-group">
					<label>Offline message on header box</label>
					<input type="text" class="form-control" name="offline_message" value="<?php echo $web['offline_message']; ?>">
				</div>
				<button type="submit" class="btn btn-primary" name="do_save">Save changes</button>
			</form>
			<?php
		} else {
		?>
		<div class="error-page">
                        <h2 class="headline">500</h2>
                        <div class="error-content">
                            <h3><i class="fa fa-warning text-yellow"></i> Oops! Something went wrong.</h3>
                            <p>
                                You do not have access to this page for prohibition by the operator with greater rank than your.
                            </p>
							<a href="./">Click here</a> to back to dashboard.
                        </div>
                    </div><!-- /.error-page -->
		<?php
		}
		?>
		</div>
	</div>
</div>