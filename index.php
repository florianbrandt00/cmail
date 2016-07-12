<?php
session_start();
include_once("data//configurations/conf.maia.php");
	try {
		$conn = 'mysql:host=' . $maia_database_host . ';dbname=' . $maia_database_name . ';charset=utf8';
    	$db = new PDO($conn, $maia_database_username, $maia_database_password);

        $success = "true";
	} catch (Exception $e) {
	    echo("Can't open the database.");
		$success = "false";
	}

$starting_page = 1;

if(isset($_GET['page'])) {
	$starting_page = $_GET['page'];
} else {
	$starting_page = 1;
}
$stmt = 'SELECT * FROM `templates` WHERE `id` = :id';


		$sth = $db->prepare($stmt);
		$sth->execute(array("id" => $starting_page));
 		$result = $sth->fetch(PDO::FETCH_BOTH);
		$site_title =	$result[1];
		$site_content = $result[2];
		$none = "false";
		if(empty($result)) {
			$none = "true";
			ob_end_clean();
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
		}



?>
<!DOCTYPE HTML>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Maia CMS</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
				<script src="scripts/jquery/login.js"></script>
		<link rel="stylesheet" type="text/css" href="stylesheets/css/main.css">
	</head>

	<body>
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" align="center">
					<img class="img-circle" id="img_logo" src="images/jpg/logo.jpg">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				</div>
                
                <!-- Begin # DIV Form -->
                <div id="div-forms">
                
                    <!-- Begin # Login Form -->
                    <form id="login-form">
		                <div class="modal-body">
				    		<div id="div-login-msg">
                                <div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-login-msg">Type your username and password.</span>
                            </div>
				    		<input id="login_username" class="form-control" type="text" placeholder="Username (type ERROR for error effect)" required>
				    		<input id="login_password" class="form-control" type="password" placeholder="Password" required>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Remember me
                                </label>
                            </div>
        		    	</div>
				        <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                            </div>
				    	    <div>
                                <button id="login_lost_btn" type="button" class="btn btn-link">Lost Password?</button>
                                <button id="login_register_btn" type="button" class="btn btn-link">Register</button>
                            </div>
				        </div>
                    </form>
                    <!-- End # Login Form -->
                    
                    <!-- Begin | Lost Password Form -->
                    <form id="lost-form" style="display:none;">
    	    		    <div class="modal-body">
		    				<div id="div-lost-msg">
                                <div id="icon-lost-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-lost-msg">Type your e-mail.</span>
                            </div>
		    				<input id="lost_email" class="form-control" type="text" placeholder="E-Mail (type ERROR for error effect)" required>
            			</div>
		    		    <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Send</button>
                            </div>
                            <div>
                                <button id="lost_login_btn" type="button" class="btn btn-link">Log In</button>
                                <button id="lost_register_btn" type="button" class="btn btn-link">Register</button>
                            </div>
		    		    </div>
                    </form>
                    <!-- End | Lost Password Form -->
                    
                    <!-- Begin | Register Form -->
                    <form id="register-form" style="display:none;">
            		    <div class="modal-body">
		    				<div id="div-register-msg">
                                <div id="icon-register-msg" class="glyphicon glyphicon-chevron-right"></div>
                                <span id="text-register-msg">Register an account.</span>
                            </div>
		    				<input id="register_username" class="form-control" type="text" placeholder="Username (type ERROR for error effect)" required>
                            <input id="register_email" class="form-control" type="text" placeholder="E-Mail" required>
                            <input id="register_password" class="form-control" type="password" placeholder="Password" required>
            			</div>
		    		    <div class="modal-footer">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                            </div>
                            <div>
                                <button id="register_login_btn" type="button" class="btn btn-link">Log In</button>
                                <button id="register_lost_btn" type="button" class="btn btn-link">Lost Password?</button>
                            </div>
		    		    </div>
                    </form>
                    <!-- End | Register Form -->
                    
                </div>
                <!-- End # DIV Form -->
                
			</div>
		</div>
	</div>


		<nav class="navbar navbar-default">
		  <div class="container">
		    <div class="navbar-header">
		    	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        	<span class="sr-only">Toggle navigation</span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		    	</button>
		      	<a class="navbar-brand" href="#">MaiaCMS</a>
		    </div>
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			    <ul class="nav navbar-nav navbar-right">
			    	<li class="dropdown">
	                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Alle Seiten <span class="caret"></span></a>
	                <ul class="dropdown-menu">
	                	<?php

	                		$stmt = $db->query('SELECT * FROM `templates`');
 
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$site_author = "maia";
							    ?>
							    	<li><a href="index.php?page=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></li>

							    <?php
							}
	                	?>

	                </ul>
	              </li>
		        	<li><a href="#" data-toggle="modal" data-target="#login-modal">Login</a></li>
		        </ul>
	        </div>

		  </div>
		</nav>
		<div class="container">
			<div class="table-responsive" style="background-color: #f5f5f5; border: 0;">
				<ol class="breadcrumb" style="padding: 0; padding-top: 10px;padding-left: 15px; margin-bottom:0;">
				  <li><a href="#">MaiaCMS</a></li>
				  <li><a href="#">Home</a></li>
				  <li class="active"><a href="#"><?php echo $site_title; ?></a></li>
				  <li><a href="#">Author: <?php echo $site_author; ?></a></li>
				</ol>
			</div>
		
		<?php echo $site_content; ?>
		<?php
			if($none == "true") {
				?>
					<div class="row">
    <div class="jumbotron">
  <h3 style="font-size: 22px; color: red;">Error 404</h3>
  <p style="font-size: 18px;">The Site you have requested could not be found! Please use your Browsers back button or click this simple Button:</p>
  <p><a class="btn btn-default" href="index.php" role="button">Take me Home</a></p>
</div>
				<?php


			}
		?>
</div>



	</body>
</html>