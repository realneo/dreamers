<div class="col-md-9 col-sm-8">
	<div class="row">
		<div class="col-md-12">
		<br>
		<?php
		$type = protect($_GET['type']);
		$id = protect($_GET['sID']);
		
		if($type == "view") {
			$sql = mysql_query("SELECT * FROM ls_sessions WHERE id='$id'");
			if(mysql_num_rows($sql)==0) { header("Location: ./?m=history"); }
			$row = mysql_fetch_array($sql);
			?>
			<table class="table table-bordered">
			  <thead>
				<tr>
					<td>From: <?php echo $row['visitor_name']; ?></td>
					<td>Email address: <?php echo $row['visitor_email']; ?></td>
				</tr>
				<tr>
					<td>View: <a href="<?php echo $row['visitor_curl']; ?>" target="_blank"><?php echo $row['visitor_curl']; ?></a></td>
					<td>IP: <?php echo $row['visitor_ip']; ?></td>
				</tr>
				<tr>
					<td>Chat session start: <?php echo date("d/m?Y H:i",$row['started']); ?></td>
					<td>Chat session end: <?php echo date("d/m?Y H:i",$row['finished']); ?></td>
				</tr>
			  </thead>
			  <tbody>
				<tr>
					<td colspan="2">
					<div id="messages">
					<?php
					if($row['visitor_status'] == 1) {
						$get_sql = mysql_query("SELECT * FROM ls_messages WHERE chat_session='$row[id]' ORDER BY id");
						if(mysql_num_rows($get_sql)>0) {
							while($get = mysql_fetch_array($get_sql)) {
								if($get['from_u'] == $row['operator']) {
								  if(idinfo($row[operator],"display_name")) {
									echo '<div style="padding:2px;"><b>[Operator] '.idinfo($row[operator],"display_name").':</b> '.check_urls($get[message]).'</div>';
								  } else {
									echo '<div style="padding:2px;"><b>[Operator] '.$row[operator].':</b> '.check_urls($get[message]).'</div>';
								  }
								} else {
									echo '<div style="padding:2px;"><b>[Client] '.$row[visitor_name].':</b> '.check_urls($get[message]).'</div>';
								}
							}
						}
					} else {
						echo $row['last_message'];
					}
					?>
					</div>
					</td>
				</tr>
			  </tbody>
			</table>
			<?php
		} elseif($type == "delete") { 
			$sql = mysql_query("SELECT * FROM ls_sessions WHERE id='$id'");
			if(mysql_num_rows($sql)==0) { header("Location: ./?m=history"); }
			$row = mysql_fetch_array($sql);
			if(idinfo($_SESSION['operator'],"sysadmin") == 1) {
				if(isset($_GET['confirm'])) {
					$delete = mysql_query("DELETE FROM ls_sessions WHERE id='$row[chat_session]'");
					$delete = mysql_query("DELETE FROM ls_messages WHERE id='$row[id]'");
					echo '<h3>Success</h3><br>';
					echo success("Chat whit ($row[visitor_name]) was deleted successfully.");
				} else {
					echo '<h3>Delete</h3><br>';
					echo info("Are you sure you want to delete chat whit ($row[visitor_name])?");
					echo '<a href="./?m=history&type=delete&sID='.$row[id].'&confirm=y" class="btn btn-success">Yes</a>&nbsp;&nbsp;<a href="./?m=history" class="btn btn-danger">No</a>';
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
		} else {
		?>
			<form action="" method="POST" role="form">
				<table border="0" cellspacing="2" cellpadding="2" width="100%">
					<tr>
					 <td>
						<div class="form-group">
							<input type="text" class="form-control" name="name" placeholder="Name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; } ?>">
						</div>
					 </td>
					 <td>
						<div class="form-group">
							<input type="text" class="form-control" name="email" placeholder="Email address" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
						</div>
					 </td>
					 <td>
						<div class="form-group">
							<input type="text" class="form-control" name="ip" placeholder="IP Address" value="<?php if(isset($_POST['ip'])) { echo $_POST['ip']; } ?>">
						</div>
					 </td>
					 <td>
						<div class="form-group">
							<button type="submit" class="btn btn-primary" name="do_filter">Filter</button>
						</div>
					 </td>
					</tr>
				</table>	
			</form>
			
			<table class="table table-hover">
				 <thead>
					<tr>
					 <td width="20%">From</td>
					 <td width="20%">Email address</td>
					 <td width="15%">IP</td>
					 <td width="20%">Operator</td>
					 <td width="20%">Date</td>
					 <td></td>
					</tr>
				 </thead>
				 <tbody>
			<?php
			$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
			$limit = 20;
			$startpoint = ($page * $limit) - $limit;
			if($page == 1) {
				$i = 1;
			} else {
				$i = $page * $limit;
			}
			if(isset($_POST['do_filter'])) {
				$name = protect($_POST['name']);
				$email = protect($_POST['email']);
				$ip = protect($_POST['ip']);
				$s=1;
				if(!empty($name) and !empty($email) and !empty($ip)) { $filter = "visitor_name LIKE '%$name%' and visitor_email LIKE '%$email%' and visitor_ip LIKE '%$ip%'"; }
				elseif(!empty($name) and !empty($email)) { $filter = "visitor_name LIKE '%$name%' and visitor_email LIKE '%$email%'"; }
				elseif(!empty($name) and !empty($ip)) { $filter = "visitor_name LIKE '%$name%' and visitor_ip LIKE '%$ip%'"; }
				elseif(!empty($email) and !empty($ip)) { $filter = "visitor_email LIKE '%$email%' and visitor_ip LIKE '%$ip%'"; }
				elseif(!empty($name)) { $filter = "visitor_name LIKE '%$name%'"; }
				elseif(!empty($email)) { $filter = "visitor_email LIKE '%$email%'"; }
				elseif(!empty($ip)) { $filter = "visitor_ip LIKE '%$ip%'"; }
				else {
					$filter = "started='213123'";
				}
				$statement = "ls_sessions WHERE $filter";
				$filtering = 1;
			} else {
				$statement = "ls_sessions";
				$filtering = 0;
			}
			$sql = mysql_query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
			if(mysql_num_rows($sql)>0) {
				while($row = mysql_fetch_array($sql)) {
				?>
				<tr>
					<td><?php echo $row['visitor_name']; ?></td>
					<td><?php echo $row['visitor_email']; ?></td>
					<td><?php echo $row['visitor_ip']; ?></td>
					<td><?php if(idinfo($_SESSION['operator'],"display_name")) { echo idinfo($_SESSION['operator'],"display_name"); } else { echo $row['operator']; } ?></td>
					<td><?php echo date("d/m/Y H:i",$row['visitor_activity']); ?></td>
					<td><a href="./?m=history&type=view&sID=<?php echo $row['id']; ?>"><i class="fa fa-search"></i></a>&nbsp;&nbsp;<a href="./?m=history&type=delete&sID=<?php echo $row['id']; ?>"><i class="fa fa-times"></i></a></td>
				</tr>
				<?php
				}
			} else {
				echo '<tr><td colspan="6">No have chat sessions for display.</td></tr>';
			}
			?>
			</tbody>
		</table>
		
		<?php
		if($filtering !== 1) {
			$ver = './?m=history';
			if(pagination($statement,$ver,$limit,$page)) {
				echo '<br>';
				echo pagination($statement,$ver,$limit,$page);
			}
		}
		}
		?>
		</div>
	</div>
</div>