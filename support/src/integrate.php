<div class="col-md-9 col-sm-8">
	<div class="row">
		<div class="col-md-12">
		<br>
		<?php
		if(idinfo($_SESSION['operator'],"sysadmin") == 1) {
			
			if(isset($_POST['do_generate'])) {
				$bootstrap = protect($_POST['bootstrap']);
				$jquery = protect($_POST['jquery']);
				$friendly_urls = protect($_POST['friendly_urls']);
				$emoticons = protect($_POST['emoticons']);
				
				if(empty($bootstrap) or empty($jquery) or empty($friendly_urls)) { echo error("Please complete form."); }
				else {
					$success = 1;
				}
			}
			
			if($success == 1) {
			?>
				<?php echo success("Code was generated successfully. Please copy this code of the bottom in your website."); ?>
				<div class="form-group">	
					<textarea class="form-control" rows="15">
<?php if($bootstrap == "2") { ?><link href="<?php if($friendly_urls == 1) { echo $web['url']; } else { echo $web['ls_dir']."/"; } ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" /><?php } ?>

<link href="<?php if($friendly_urls == 1) { echo $web['url']; } else { echo $web['ls_dir']."/"; } ?>css/ls_main.css" rel="stylesheet" type="text/css" />
<?php if($jquery == "2") { ?><script type="text/javascript" src="<?php if($friendly_urls == 1) { echo $web['url']; } else { echo $web['ls_dir']."/"; } ?>js/jquery.js"></script><?php } ?>
<?php if($emoticons == "1") { ?>
<link href="<?php if($friendly_urls == 1) { echo $web['url']; } else { echo $web['ls_dir']."/"; } ?>css/jquery.cssemoticons.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php if($friendly_urls == 1) { echo $web['url']; } else { echo $web['ls_dir']."/"; } ?>js/jquery.cssemoticons.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php if($friendly_urls == 1) { echo $web['url']; } else { echo $web['ls_dir']."/"; } ?>ls_main.js.php"></script>
					</textarea>
				</div>
			<?php
			} else {
			?>
			<form action="" method="POST" role="form">
				<p>Please complete this form to help the system to generate the code for you that is compatible with your web site.</p>
				<br>
				<div class="form-group">
					<label>Does your website use Twitter Bootstrap version 3?</label>
					<select name="bootstrap" class="form-control">
						<option value=""></option>
						<option value="1">Yes</option>
						<option value="2">No</option>
					</select>
				</div>
				<div class="form-group">
					<label>Does your website use jQuery plugin?</label>
					<select name="jquery" class="form-control">
						<option value=""></option>
						<option value="1">Yes</option>
						<option value="2">No</option>
					</select>
				</div>
				<div class="form-group">
					<label>Does your website use friendly urls? <small>For example http://eliteworks.info/category/World-news/page/1</label>
					<select name="friendly_urls" class="form-control">
						<option value=""></option>
						<option value="1">Yes</option>
						<option value="2">No</option>
					</select>
				</div>
				<div class="form-group">
					<label>Note that the script must be located in the directory of the web site! May be located in a sub directory of the website to allow it to operate properly.</label>
				</div>
				<button type="submit" class="btn btn-primary" name="do_generate">Generate</button>
			</form>
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