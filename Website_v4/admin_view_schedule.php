<?php   

	if(isset($_COOKIE["loggedin"]) && $_COOKIE["loggedin"]== 0) {
			//If you're logged in then redirect you to the landing page.
			header( 'Location: index.php' );
	}		
    require_once 'header.php';
    require_once 'assets/php/admin_queries.php';
?>

<html lang="en">
	<head>
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700|Oswald:400,700|Open+Sans' rel='stylesheet' type='text/css'>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Spokane Club Basketball Stats Administrator Management Page">
		<meta name="author" content="Nathan Tonani">

		<title>Spokane Club</title>

		<!-- page spec css -->
		<link href="assets/css/individualstats.css" rel="stylesheet">


	</head>

	<body id="body">

		<nav class="navbar navbar-inverse bodynav">
			<div class="container-fluid" id="content">
				<div class="row">
					<div class="navbar-header">
						<a class="navbar-brand brandtitle">Games</a>
					</div>
					<ul class="nav navbar-nav navbar-right">
					</ul>
				</div>
			</div>
		</nav>

		<div class="container" >
		    <div class="row">
		     	<?php require_once 'admin_nav.php'; ?>
		        <div class="col-md-10">
		            <div class="container-fluid" id ="games_container" style="display:show">
						<table class="table table-condensed table-hover" id="games_head">
							<thead>
								<tr class = "table_headers">
									<th>Game</th>
									<th>Home</th>												
									<th>Away</th>
									<th>Date</th>
									<th>Time</th>
								</tr>
							</thead>
							<tbody id="games_body">
								<?php getSchedule() ?>
						  	</tbody>						
			  			</table>
					</div>
		        </div>
		    </div>
	    </div>

		<div style="margin-top:20px;margin-bottom:50px">
			<a class="btn pull-right btn-default" id="addGame">
			Add game
			</a>
		</div>
		<div style="padding:10"></div>

		<div style="margin-top:20px;margin-bottom:100px">
			<a class="btn pull-right btn-danger" id="cancel">
			Cancel 
			</a>
			<a class="btn pull-right btn-success" id="submission">
			Submit Schedule
			</a>
		</div>


		<script type="text/javascript">
			$('#submission').on('click',function(e){
				var schedule = new Array();
				var seasonID = getSeason()["sid"];
				if(seasonID==undefined){
					seasonID = "main";
				}

				schedule = JSON.stringify(storeSeason());
				$.ajax({
					type:"POST",
					url:"assets/php/processJSONschedule.php",
					data:"schedule="+schedule+"&seasonID="+seasonID,
					success: function(msg){
						alert(msg);
						window.location.href="admin_home.php?";
					}
				});
			});
			$('#cancel').on('click',function(e){
				window.location.href="admin_home.php";
			});
			$('#addGame').on('click',function(e){
				
				var next = $('#games_body').find('tr:last').find('td:eq(0)').text();
				next = parseInt(next) + 1;
				
			    var new_row = $('<tr><td>'+next+'</td>\
			                         <td contentEditable="true"></td>\
			                         <td contentEditable="true"></td>\
			                         <td contentEditable="true"></td>\
			                         <td contentEditable="true"></td>\
			                      </tr>');
			    new_row.appendTo($('#games_body'));
			});

			function getSeason(){
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

			function storeSeason(){
				try{
					
					var tableData = new Array();
					
					$('#games_body tr').each(function(row,tr){
						tableData[row]={
							"Game_ID" : $(tr).find('td:eq(0)').text(),
							"Home" : $(tr).find('td:eq(1)').text(),
							"Away" : $(tr).find('td:eq(2)').text(),
							"Date" : $(tr).find('td:eq(3)').text(),
							"Time" : $(tr).find('td:eq(4)').text(),

						}
					});
					
					
					return tableData;
				}catch(err){
					alert("In storeTblValues: " +err.message);
				}
			}

		</script>
		
		<!--js-->
	    

	</body>
</html>

<?php require_once 'footer.php';?>
