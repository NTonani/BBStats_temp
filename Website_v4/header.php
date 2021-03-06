<?php require_once 'assets/php/collect_seasons.php'; ?>

<!-- Header for all pages - includes site navigation and potentially a scoreboard -->
<html lang="en">
	<head>
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700|Oswald:400,700|Open+Sans' rel='stylesheet' type='text/css'>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Spokane Club recreational basketball league basketball statistics">
		<meta name="author" content="Nathan Tonani">

		<title>Spokane Club</title>

		<!-- Bootstrap CSS -->
		<link href="assets/css/bootstrap.css" rel="stylesheet">
		<!-- Specific CSS -->
		<link href="assets/css/main.css" rel="stylesheet">


		<!--js-->
		
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery.js"></script>
		<script src="assets/js/jquery.query-object.js"></script>
		<script src="assets/js/navpage.js"></script>
		<script src ="assets/js/change_seasons.js"></script>
	</head>
	<body id="page-top">
		<!--Navbar-->
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="admin-login">
									<ul class="nav navbar-nav navbar-right" id="account_nav">
										<?php 
										if(isset($_COOKIE["loggedin"]) && $_COOKIE["loggedin"]==0) { ?>
																	<a href="#" id="login_link" data-toggle="modal" data-target="#login_modal">admin</a>

										<?php }else{ ?>
					<a href="admin_home.php" id="login_link">admin</a>
											<a href="admin_logout.php" id="logout_link">logout</a>
						<?php } ?>
						

					</ul>
				</div>


				<div class="row logo">
					<a class="" href="http://www.spokaneclub.org"><img class="image-responsive" style="margin-top:-7px" src="assets/img/scsmall.png"></img></a>
				</div>
				<div class="row">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle Navigation</span>
							<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
						<a class="navbar-brand" href="index.php">Basketball Stats</a>

						
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right" id="main_nav">

						</ul>

					</div>
				</div>
			</div>
		</nav>

		<!-- Scrolling scoreboard -->
		<div class="scoreboard">
			<div class="container-fluid">
				<div class="row" style="border:1px solid;border-color:#2f2f2f">
					<div class="" style="text-align:center;font-size:60px">Scoreboard</div>
				</div>
			</div>
		</div>


		<!-- seasons -->
		<div class = "season_select" style="padding-top:10px">
			<div class = "dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="seasons_btn" data-toggle="dropdown" aria-expanded="true">
   
    				<span class="caret"></span>
 				 </button>
 				 <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				 	<?php getSeasons(); ?>  
				 </ul>
				</div>
			</div>
		</div>


		<!-- Login modal, or do we want to have login be a separate page? -->

	     <div class="modal" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="login_modal" aria-hidden="true">
	      <div class="modal-dialog">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	            <h4 class="modal-title" id="modalLabel">Sign in</h4>
	          </div>
  	          <form class="form-signin" action ="admin_login.php" method ="post">
		          <div class="modal-body">
	                <input type="text"  name ="username" class = "form-control" placeholder="Username" required autofocus><br>
	                <input type="password" name = "password" class = "form-control" placeholder="Password" required><br>
		          	<div class="checkbox"><label><input type="checkbox"> Remember me</label></div>
		          </div>
		          <div class="modal-footer">
		            <button type="button" class="btn btn-default" onclick="#" data-dismiss="modal">Cancel</button>
	 				<button type="submit" class="btn btn-default">Sign in</button>
				  </div>
			  </form>
	        </div>
	      </div>
	    </div>



	    <!--load javascript-->
	

		<!-- testing javascript stuff here #TEMPORARY-->

		<!--##################END OF JAVASCRIPT##################-->
		<!--
                 -->


	</body>
</html>
