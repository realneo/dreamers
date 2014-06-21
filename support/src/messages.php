<div class="col-md-9 col-sm-8">
	<div class="row">
		<div class="col-md-12">
		<br>
		<?php
		$type = protect($_GET['type']);
		$id = protect($_GET['mID']);
		
		if($type == "add") {
		?>
			<h3>Add new</h3>
			<br>
			<?php
			if(isset($_POST['do_add'])) {
				$title = protect($_POST['title']);
				$message = protect($_POST['message']);
				
				if(empty($title) or empty($message)) { echo error("All fields are required."); }
				else {
					$insert = mysql_query("INSERT ls_fast_messages (title,message,added_by) VALUES ('$title','$message','$_SESSION[operator]')");
					echo success("Message ($title) was added successfully.");
				}
			}
			?>
			<form action="" method="POST" role="form">
				<div class="form-group">
					<label>Title</label>
					<input type="text" class="form-control" name="title">
				</div>
				<div class="form-group">
					<label>Message</label>
					<textarea class="form-control" name="message" rows="5"></textarea>
				</div>
				<button type="submit" class="btn btn-primary" name="do_add">Add</button>
			</form>
		<?php
		} elseif($type == "edit") {
			$sql = mysql_query("SELECT * FROM ls_fast_messages WHERE id='$id'");
			if(mysql_num_rows($sql)==0) { header("Location: ./?m=messages"); }
			$row = mysql_fetch_array($sql);
			?>
			<h3>Edit</h3>
			<br>
			<?php
			if(isset($_POST['do_save'])) {
				$title = protect($_POST['title']);
				$message = protect($_POST['message']);
				
				if(empty($title) or empty($message)) { echo error("All fields are required."); }
				else {
					$update = mysql_query("UPDATE ls_fast_messages SET title='$title',message='$message' WHERE id='$id'");
					$row = mysql_fetch_array(mysql_query("SELECT * FROM ls_fast_messages WHERE id='$id'"));
					echo success("Your changes was saved successfully.");
				}
			}
			?>
			<form action="" method="POST" role="form">
				<div class="form-group">
					<label>Title</label>
					<input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>">
				</div>
				<div class="form-group">
					<label>Message</label>
					<textarea class="form-control" name="message" rows="5"><?php echo $row['message']; ?></textarea>
				</div>
				<button type="submit" class="btn btn-primary" name="do_save">Save changes</button>
			</form>
			<?php
		} elseif($type == "delete") {
			$sql = mysql_query("SELECT * FROM ls_fast_messages WHERE id='$id'");
			if(mysql_num_rows($sql)==0) { header("Location: ./?m=messages"); }
			$row = mysql_fetch_array($sql);
			if(isset($_GET['confirm'])) {
				echo '<h3>Success</h3><br>';
				echo success("Message ($row[title]) was deleted successfully.");
				$delete = mysql_query("DELETE FROM ls_fast_messages WHERE id='$id'");
			} else {
				echo '<h3>Delete</h3><br>';
				echo info("Are you sure you want to delete ($row[title])?");
				echo '<a href="./?m=messages&type=delete&mID='.$row[id].'&confirm=y" class="btn btn-success">Yes</a>&nbsp;&nbsp;<a href="./?m=messages" class="btn btn-danger">No</a>';
			}
		} else {
		?>
			<a href="./?m=messages&type=add" class="btn btn-primary">Add new</a>
			<br><br>
			<table class="table table-hover">
			  <thead>
				<tr>
					<td>#</td>
					<td width="70%">Title</td>
					<td width="20%">Added by</td>
					<td></td>
				</tr>
			  </thead>
			  <tbody>
				<?php
				$i=1;
				$sql = mysql_query("SELECT * FROM ls_fast_messages ORDER BY id");
				if(mysql_num_rows($sql)>0) {
					while($row = mysql_fetch_array($sql)) {
						echo '<tr>
								<td>'.$i.'</td>
								<td>'.$row[title].'</td>
								<td>'.idinfo($row[added_by],"display_name").'</td>
								<td><a href="./?m=messages&type=edit&mID='.$row[id].'" title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;<a href="./?m=messages&type=delete&mID='.$row[id].'" title="Delete"><i class="fa fa-times"></i></a></td>
							</tr>';
						$i++;
					}
				} else {
					echo '<tr><td colspan="4">No have fast messages in database.</td></tr>';
				}
				?>
			  </tbody>
			</table>
		<?php
		}
		?>
		</div>
	</div>
</div>