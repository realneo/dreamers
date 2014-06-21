<?php
								$sql["host"] = "localhost:8888";
								$sql["user"] = "root";
								$sql["pass"] = "root";
								$sql["base"] = "dreamers_livesupport";
								$connection = mysql_connect($sql["host"],$sql["user"],$sql["pass"]);
								$select_database = mysql_select_db($sql["base"], $connection);
								mysql_query("SET NAMES utf8");
								?>
								