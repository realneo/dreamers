<div class="col-md-9 col-sm-8">
	<div class="row">
		<div class="col-md-12">
		<br>
		<?php
		if(idinfo($_SESSION['operator'],"sysadmin") == 1) {
			$type = protect($_GET['type']);
			$id = protect($_GET['oID']);
			
			if($type == "add") {
			?>
				<h3>Add new</h3>
				<br>
				<?php
				if(isset($_POST['do_add'])) {
					$display_name = protect($_POST['display_name']);
					$usern = protect($_POST['usern']);
					$passwd = protect($_POST['passwd']);
					$cpasswd = protect($_POST['cpasswd']);
					$email = protect($_POST['email']);
					$check_username = mysql_query("SELECT * FROM ls_operators WHERE usern='$usern'");
					$check_email = mysql_query("SELECT * FROM ls_operators WHERE email='$email'");
					if(empty($display_name) or empty($usern) or empty($passwd) or empty($cpasswd) or empty($email)) { echo error("All fields are required."); }
					elseif(mysql_num_rows($check_username)>0) { echo error("This username is already used. Please choose another."); }
					elseif(mysql_num_rows($check_email)>0) { echo error("This email address is already used. Please choose another."); }
					elseif(!isValidUsername($usern)) { echo error("Please enter valid username."); }
					elseif(!isValidEmail($email)) { echo error("Please enter valid email address."); }
					elseif($passwd !== $cpasswd) { echo error("Passwords does not match."); }
					else {
						$passwd = md5($passwd);
						$insert = mysql_query("INSERT ls_operators (display_name,usern,passwd,email) VALUES ('$display_name','$usern','$passwd','$email')");
						echo success("Operator ($usern) was added successfully.");
					}
				}
				?>
				<form action="" method="POST" role="form">
					<div class="form-group">
						<label>Display name</label>
						<input type="text" class="form-control" name="display_name">
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="usern">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="passwd">
					</div>
					<div class="form-group">
						<label>Confirm password</label>
						<input type="password" class="form-control" name="cpasswd">
					</div>
					<div class="form-group">
						<label>Email address</label>
						<input type="email" class="form-control" name="email">
					</div>
					<button type="submit" class="btn btn-primary" name="do_add">Add</button>
				</form>
			<?php
			} elseif($type == "edit") {
				$sql = mysql_query("SELECT * FROM ls_operators WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: ./?m=messages"); }
				$row = mysql_fetch_array($sql);
				?>
				<h3>Edit</h3>
				<br>
				<?php
				if(isset($_POST['do_save'])) {
					$display_name = protect($_POST['display_name']);
					$usern = protect($_POST['usern']);
					if(empty($_POST['passwd'])) { $passwd = $row['passwd']; } else { $passwd = md5($_POST['passwd']); }
					$email = protect($_POST['email']);
					$check_username = mysql_query("SELECT * FROM ls_operators WHERE usern='$usern'");
					$check_email = mysql_query("SELECT * FROM ls_operators WHERE email='$email'");
					if(empty($display_name) or empty($usern) or empty($email)) { echo error("All fields are required."); }
					elseif($usern !== $row['usern'] && mysql_num_rows($check_username)>0) { echo error("This username is already used. Please choose another."); }
					elseif($email !== $row['email'] && mysql_num_rows($check_email)>0) { echo error("This email address is already used. Please choose another."); }
					elseif($usern !== $row['usern'] && !isValidUsername($usern)) { echo error("Please enter valid username."); }
					elseif($email !== $row['email'] && !isValidEmail($email)) { echo error("Please enter valid email address."); }
					else {
						$update = mysql_query("UPDATE ls_operators SET display_name='$display_name',usern='$usern',passwd='$passwd',email='$email' WHERE id='$row[id]'");
						echo success("Your changes was saved successfully.");
					}
				}
				?>
				<form action="" method="POST" role="form">
					<div class="form-group">
						<label>Display name</label>
						<input type="text" class="form-control" name="display_name" value="<?php echo $row['display_name']; ?>">
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="usern" value="<?php echo $row['usern']; ?>">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="passwd" placeholder="Leave empty if you don`t want to change password.">
					</div>
					<div class="form-group">
						<label>Email address</label>
						<input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>">
					</div>
					<button type="submit" class="btn btn-primary" name="do_save">Save changes</button>
				</form>
				<?php
			} elseif($type == "delete") {
				$sql = mysql_query("SELECT * FROM ls_operators WHERE id='$id'");
				if(mysql_num_rows($sql)==0) { header("Location: ./?m=operators"); }
				$row = mysql_fetch_array($sql);
				if(isset($_GET['confirm'])) {
					echo '<h3>Success</h3><br>';
					echo success("Operator ($row[usern]) was deleted successfully.");
					$delete = mysql_query("DELETE FROM ls_fast_messages WHERE added_by='$row[usern]'");
					$delete = mysql_query("DELETE FROM ls_operators WHERE id='$row[id]'");
				} else {
					echo '<h3>Delete</h3><br>';
					echo info("Are you sure you want to delete ($row[usern])?");
					echo '<a href="./?m=operators&type=delete&oID='.$row[id].'&confirm=y" class="btn btn-success">Yes</a>&nbsp;&nbsp;<a href="./?m=operators" class="btn btn-danger">No</a>';
				}
			} else {
			?>
				<a href="./?m=operators&type=add" class="btn btn-primary">Add new</a>
				<br><br>
				<table class="table table-hover">
				  <thead>
					<tr>
						<td>#</td>
						<td width="30%">Display name</td>
						<td width="30%">Username</td>
						<td width="30%">Email address</td>
						<td></td>
					</tr>
				  </thead>
				  <tbody>
					<?php
					$i=1;
					$sql = mysql_query("SELECT * FROM ls_operators ORDER BY id");
					if(mysql_num_rows($sql)>0) {
						while($row = mysql_fetch_array($sql)) {
							echo '<tr>
									<td>'.$i.'</td>
									<td>'.$row[display_name].'</td>
									<td>'.$row[usern].'</td>
									<td>'.$row[email].'</td>
									<td><a href="./?m=operators&type=edit&oID='.$row[id].'" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="./?m=operators&type=delete&oID='.$row[id].'" title="Delete"><i class="fa fa-times"></i></a></td>
								</tr>';
							$i++;
						}
					} else {
						echo '<tr><td colspan="5">No have operators in database.</td></tr>';
					}
					?>
				  </tbody>
				</table>
			<?php
			}
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