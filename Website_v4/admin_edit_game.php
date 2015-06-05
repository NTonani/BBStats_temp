<?php   

	if(isset($_COOKIE["loggedin"]) && $_COOKIE["loggedin"]== 0) {
			//If you're logged in then redirect you to the landing page.
			header( 'Location: index.php' );
	}		
    require_once 'header.php';
    require_once 'assets/php/admin_queries.php';

	if((int)$_GET["id"]==0){
		print "<div class = 'container'>
				<div class = 'text-center'>
					<h1>Not a valid game</h1>
				</div>
			   </div>";
		
	}
	
	include 'assets/php/get_game_stats.php';
?>

<html lang="en">
	<head>
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700|Oswald:400,700|Open+Sans' rel='stylesheet' type='text/css'>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Spokane Club Basketball Stats Administrator Management Page">
		<meta name="author" content="Leland Burlingame">

		<title>Spokane Club</title>

		<!-- page spec css -->
		<link href="assets/css/individualstats.css" rel="stylesheet">
		<!-- page spec javascript -->
		<script src="assets/js/mindmup-editabletable.js"></script>
	

	</head>
	
	<body id="body">
		<h2>Game <?php print $_GET["id"]; ?></h2>
		<div>
		<h5 id="newGame">
		<?php isNewGame() ?>
		</h5>
		</div>

		<div class="container-fluid" id ="home_container" style="display:show">
			<?php getHomeTeam() ?>
			<table class="table table-condensed table-hover" id="home_table">
				<thead>
					<tr class = "table_headers">
						<th style="display:none">ID</th>
						<th>Player</th>
						<th>Points</th>
						<th>FGM</th>
						<th>FGA</th>
						<th>TPM</th>
						<th>TPA</th>
						<th>FTM</th>
						<th>FTA</th>
						<th>Assists</th>
						<th>Steals</th>
						<th>Rebounds</th>
						<th>Blocks</th>
					</tr>
				</thead>
				<tbody id="home_body">
				<?php getHomeGameStats() ?>
				<!--
				<tr class="totalColumn">
					<td style="display:none" class="totalCol">-1</td>
			        <td class="totalCol"><b>TOTAL</b></td>
			        <td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			        
   				 </tr>-->
			  	</tbody>						
  			</table>
		</div>

		<div class="container-fluid" id ="away_container" style="display:show">
		<?php getAwayTeam() ?>
			<table class="table table-condensed table-hover" id="away_table">
				<thead>
					<tr class = "table_headers">
						<th>Player</th>
						<th>Points</th>
						<th>FGM</th>
						<th>FGA</th>
						<th>TPM</th>
						<th>TPA</th>
						<th>FTM</th>
						<th>FTA</th>
						<th>Assists</th>
						<th>Steals</th>
						<th>Rebounds</th>
						<th>Blocks</th>
					</tr>
				</thead>
				<tbody id="away_body">
				<?php getAwayGameStats() ?>
				<!--
				<tr class="totalColumn">
					<td style="display:none" class="totalCol">-1</td>
			        <td class="totalCol"><b>TOTAL</b></td>
			        <td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
			       	<td class="totalCol"><b>0</b></td>
   				 </tr>-->
			  	</tbody>		
			  				
  			</table>
		</div>
		<div style="margin-top:20px;margin-bottom:100px">
			<a class="btn pull-right btn-danger" id="cancel">
			Cancel 
			</a>
			<a class="btn pull-right btn-success" id="submission">
			Submit Game
			</a>
		</div>
		

		<script type="text/javascript">
		
			
			$('#submission').on('click',function(e){
				storeValues();
			});

			$('#cancel').on('click',function(e){
				window.location.href="admin_home.php";
			});

			function storeValues(){
				try{
					var homeData = new Array();
					var awayData = new Array();
					var gameID = getGame()["id"];
					var seasonID = getGame()["sid"];
					if(seasonID == undefined){
						seasonID = "main";
					}

					var newGame = document.getElementById("newGame").innerHTML.search("New game") == 3;
					homeData = JSON.stringify(storeHomeValues());
					awayData = JSON.stringify(storeAwayValues());
					$.ajax({
						type:"POST",
						url: "assets/php/processJSONarray.php",
						data: "pHomeData=" + homeData + "&pAwayData=" + awayData +"&gameID="+gameID + "&newGame=" + newGame + "&seasonID=" + seasonID,
						success: function(msg){
							alert(msg);
							window.location.href = "admin_home.php";
						}
					});
				}catch(err){
					alert("In storeValues: " +err.message);
				}
			}
			function getGame(){
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
			function storeHomeValues(){
				try{
					var tableData = new Array();
					$('#home_table tr').each(function(row,tr){
						tableData[row]={
							"ID" : $(tr).find('td:eq(0)').text(),
							"Player" : $(tr).find('td:eq(1)').text(),
							"Points" : $(tr).find('td:eq(2)').text(),
							"FGM" : $(tr).find('td:eq(3)').text(),
							"FGA" : $(tr).find('td:eq(4)').text(),
							"TPM" : $(tr).find('td:eq(5)').text(),
							"TPA" : $(tr).find('td:eq(6)').text(),
							"FTM" : $(tr).find('td:eq(7)').text(),
							"FTA" : $(tr).find('td:eq(8)').text(),
							"Assists" : $(tr).find('td:eq(9)').text(),
							"Steals" : $(tr).find('td:eq(10)').text(),
							"Rebounds" : $(tr).find('td:eq(11)').text(),
							"Blocks" : $(tr).find('td:eq(12)').text(),

						}
					});
					tableData.shift();
					return tableData;
				}catch(err){
					alert("In storeTblValues: " +err.message);
				}
			}

			function storeAwayValues(){
				try{
					var tableData = new Array();
					$('#away_table tr').each(function(row,tr){
						
						tableData[row]={
								"ID" : $(tr).find('td:eq(0)').text(),
								"Player" : $(tr).find('td:eq(1)').text(),
								"Points" : $(tr).find('td:eq(2)').text(),
								"FGM" : $(tr).find('td:eq(3)').text(),
								"FGA" : $(tr).find('td:eq(4)').text(),
								"TPM" : $(tr).find('td:eq(5)').text(),
								"TPA" : $(tr).find('td:eq(6)').text(),
								"FTM" : $(tr).find('td:eq(7)').text(),
								"FTA" : $(tr).find('td:eq(8)').text(),
								"Assists" : $(tr).find('td:eq(9)').text(),
								"Steals" : $(tr).find('td:eq(10)').text(),
								"Rebounds" : $(tr).find('td:eq(11)').text(),
								"Blocks" : $(tr).find('td:eq(12)').text(),
							}

						
					});
					tableData.shift();
					return tableData;
				}catch(err){
					alert("In storeTblValues: " +err.message);
				}
			}

			
		</script>

		<ul></ul>

		
		<!-- javascript -->
	   
	    
		<script src="admin_edit_game.js"></script>

	</body>
</html>

<?php require_once 'footer.php';?>

