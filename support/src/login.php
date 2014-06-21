<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>LiveSupport System | Login</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">LiveSupport System</div>
            <form action="" method="POST">
                <div class="body bg-gray">
					<?php
					if(isset($_POST['do_login'])) {
						$usern = protect($_POST['usern']);
						$passwd = md5(protect($_POST['passwd']));
						$check = mysql_query("SELECT * FROM ls_operators WHERE usern='$usern' and passwd='$passwd'");
						if(mysql_num_rows($check)>0) {
							$_SESSION['operator'] = $usern;
							header("Location: ./");
						} else {
							echo error("Wrong username or password.");
						}
					}
					?>
			
                    <div class="form-group">
                        <input type="text" name="usern" class="form-control" placeholder="Operator"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="passwd" class="form-control" placeholder="Password"/>
                    </div>          
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block" name="do_login">Login</button>  
                </div>
            </form>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>