<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>LiveSupport System</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck for checkboxes and radio inputs -->
        <link href="css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="./" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                LiveSupport System
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo idinfo($_SESSION['operator'],"display_name"); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/avatar6.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo idinfo($_SESSION['operator'],"display_name"); ?>
                                        <small>@<?php echo $_SESSION['operator']; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="./?m=change_password" class="btn btn-default btn-flat">Change password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="./?m=logout" class="btn btn-default btn-flat">Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">


                <!-- Main content -->
                <section class="content">
                    <!-- MAILBOX BEGIN -->
                    <div class="mailbox row">
                        <div class="col-xs-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4">
                                            <!-- BOXES are complex enough to move the .box-header around.
                                                 This is an example of having the box header within the box body -->
                                            <div class="box-header">
												<?php
												if(empty($m)) {
													?>
													<i class="fa fa-dashboard"></i>
													<h3 class="box-title">Dashboard</h3>
													<?php
												} elseif($m == "history") {
													?>
													<i class="fa fa-retweet"></i>
													<h3 class="box-title">History</h3>
													<?php
												} elseif($m == "messages") {
													?>
													<i class="fa fa-edit"></i>
													<h3 class="box-title">Fast messages</h3>
													<?php
												} elseif($m == "operators") {
													?>
													<i class="fa fa-users"></i>
													<h3 class="box-title">Operators</h3>
													<?php
												} elseif($m == "integrate") {
													?>
													<i class="fa fa-code"></i>
													<h3 class="box-title">Integrate Plugin</h3>
													<?php
												} elseif($m == "config") {
													?>
													<i class="fa fa-cog"></i>
													<h3 class="box-title">Configurate Plugin</h3>
													<?php
												} elseif($m == "change_password") {
													?>
													<i class="fa fa-key"></i>
													<h3 class="box-title">Change password</h3>
													<?php
												} else {
													?>
													<i class="fa fa-dashboard"></i>
													<h3 class="box-title">Dashboard</h3>
													<?php
												}
                                                ?>
                                            </div>
                                           
                                            <!-- Navigation - folders-->
                                            <div style="margin-top: 15px;">
                                                <ul class="nav nav-pills nav-stacked">
                                                    <li class="header">Menu</li>
                                                    <li><a href="./"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                                                    <li><a href="./?m=history"><i class="fa fa-retweet"></i> History</a></li>
													<li><a href="./?m=messages"><i class="fa fa-edit"></i> Fast messages</a></li>
                                                    <li><a href="./?m=operators"><i class="fa fa-users"></i> Operators</a></li>
                                                    <li><a href="./?m=integrate"><i class="fa fa-code"></i> Integrate Plugin</a></li>
                                                    <li><a href="./?m=config"><i class="fa fa-cog"></i> Configurate Plugin</a></li>
                                                </ul>
                                            </div>
                                        </div><!-- /.col (LEFT) -->