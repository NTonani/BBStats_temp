<!-- Team info page compiles team related information - including - roster, season stats, schedule -->
<?php
		require_once 'header.php';
?>

<html lang="en">
	<head>
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700|Oswald:400,700|Open+Sans' rel='stylesheet' type='text/css'>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Spokane Club recreational basketball league individual player statistics">
		<meta name="author" content="Nathan Tonani">

		<title>Spokane Club</title>

		<!-- page spec css -->
		<link href="assets/css/individualstats.css" rel="stylesheet">
		<link href="assets/css/boxscore.css" rel="stylesheet">
		<!-- boxscore js -->
		<script src="assets/js/boxscore.js"></script>
		<!-- team info js -->
		<script src="assets/js/teamshow.js"></script>


	</head>
    <body>
			<!-- Team info navbar - hide/show team info -->
      <nav class="navbar navbar-inverse bodynav">
        <div class="container-fluid">
          <div class="row">
            <div class="navbar-header">
              <a class="navbar-brand brandtitle" href="#">Team Info</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <li class="space active" id="hide_"><a onClick="showTeam('hide_')">Hide All</a></li>
              <li class="space" id="show_"><a onClick="showTeam('show_')">Show All</a></li>
            </ul>
          </div>
        </div>
      </nav>

		<!-- all HTML is dynamically generated because the number of teams is not known -->
    <?php require_once 'assets/php/team_info_queries.php';
			if(isset($_GET['tid'])){
				$team = $_GET['tid'];
				print "<script type='text/javascript' src='assets/js/teamshow.js'> showTeam('".$team."'); </script>";
			}?>

<!-- REMAINDER IS BOXSCORE MODAL -->
		<script type="text/javascript"> 
		function boxscore(input){
			$('.modal-body').empty();
			var sid = getSID()["sid"];
			if(sid==undefined)
				sid="main";
			$.ajax({
				url: 'assets/php/boxscore_queries.php',
				data: {'game': input, 'sid' : sid},
				type: "POST",
				success: function(data){
					$('.modal-body').append(data);
				}


			});

			function getSID(){
				var vars = [], hash;
			    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			    for(var i = 0; i < hashes.length; i++)
			    {
			        hash = hashes[i].split('=');
			        vars.push(hash[0]);
			        vars[hash[0]] = hash[1];
			    }
			    return vars
			}
			$('#boxscore_modal').modal('show');
		} </script>
	    <!-- Modal HTML -->
    <div id="boxscore_modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Boxscore</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
		<div class="footermargin"></div>

    </body>
  </html>
  <?php require_once 'footer.php';?>
