<?php


	$id  = (int)$_GET["id"];
	  $dbString = getDB();
	  $db = new PDO('sqlite:assets/db/'.$dbString);
	$home = $db->query("SELECT Player_Info.Player_ID, First_Name, Last_Name, Points, FGM, FGA, TPM, TPA, FTM, FTA, Assists, Steals, Rebounds, Blocks FROM Player_Info join Schedule ON Team = Schedule.Home left outer join Player_Game_Stats on Schedule.Game_ID = Player_Game_Stats.Game_ID and Player_Game_Stats.Player_ID = Player_Info.Player_ID WHERE Schedule.Game_ID = " .$id);
	$away = $db->query("SELECT Player_Info.Player_ID, First_Name, Last_Name, Points, FGM, FGA, TPM, TPA, FTM, FTA, Assists, Steals, Rebounds, Blocks FROM Player_Info join Schedule ON Team = Schedule.Away left outer join Player_Game_Stats on Schedule.Game_ID = Player_Game_Stats.Game_ID and Player_Game_Stats.Player_ID = Player_Info.Player_ID WHERE Schedule.Game_ID = " .$id);
	$teams_query = $db->query("Select Home, Away from Schedule where Game_ID = ".$id);
	$new_game = $db->query("Select Game_ID from Team_Game_Stats where Game_ID =".$id);

	$db = NULL;

	$teams = $teams_query->fetch(PDO::FETCH_BOTH);
	$home_team = $teams['Home'];
	$away_team = $teams['Away'];

	function isNewGame(){
		
		global $new_game;
		$row = $new_game->fetch(PDO::FETCH_ASSOC);
		if(!$row)
			print "New game";
		else
			print "Edit game";

	}
	
	function getHomeTeam(){
		global $home_team;
		print("<div style = 'font-weight:bold'><u>Home - Team ".$home_team."</u></div>");
	}

	function getAwayTeam(){
		global $away_team;
		print("<div style = 'font-weight:bold'><u>Away - Team ".$away_team."</u></div>");
	}

	function getHomeGameStats(){
		global $home;
		foreach($home as $row){
			  print "<tr><td style='display:none'>".$row['Player_ID']."</td>";
		      print "<td>".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td contenteditable=true>".(int)$row['Points']."</td>";
		      print "<td contenteditable=true>".(int)$row['FGM']."</td>";
		      print "<td contenteditable=true>".(int)$row['FGA']."</td>";
		      print "<td contenteditable=true>".(int)$row['TPM']."</td>";
		      print "<td contenteditable=true>".(int)$row['TPA']."</td>";
		      print "<td contenteditable=true>".(int)$row['FTM']."</td>";
		      print "<td contenteditable=true>".(int)$row['FTA']."</td>";
		      print "<td contenteditable=true>".(int)$row['Assists']."</td>";
		      print "<td contenteditable=true>".(int)$row['Steals']."</td>";
		      print "<td contenteditable=true>".(int)$row['Rebounds']."</td>";
		      print "<td contenteditable=true>".(int)$row['Blocks']."</td></tr>";
		}
	}

	function getAwayGameStats(){
		global $away;
		foreach($away as $row){
			  print "<tr><td style='display:none'>".$row['Player_ID']."</td>";
		      print "<td>".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td contenteditable=true>".(int)$row['Points']."</td>";
		      print "<td contenteditable=true>".(int)$row['FGM']."</td>";
		      print "<td contenteditable=true>".(int)$row['FGA']."</td>";
		      print "<td contenteditable=true>".(int)$row['TPM']."</td>";
		      print "<td contenteditable=true>".(int)$row['TPA']."</td>";
		      print "<td contenteditable=true>".(int)$row['FTM']."</td>";
		      print "<td contenteditable=true>".(int)$row['FTA']."</td>";
		      print "<td contenteditable=true>".(int)$row['Assists']."</td>";
		      print "<td contenteditable=true>".(int)$row['Steals']."</td>";
		      print "<td contenteditable=true>".(int)$row['Rebounds']."</td>";
		      print "<td contenteditable=true>".(int)$row['Blocks']."</td></tr>";
		}
	}	

?>


<!--

<script>
var obj = JSON.parse('<?php //echo json_encode($stats) ?>');

	for (var i = 0; i < obj.length; i++) {
		document.write(obj.length);
document.write(obj[i])	} 


</script>



	/* set out document type to text/javascript instead of text/html */
	header("Content-type: text/javascript");


/* our multidimentional php array to pass back to javascript via ajax */
$arr = array(
        array(
                "first_name" => "Darian",
                "last_name" => "Brown",
                "age" => "28",
                "email" => "darianbr@example.com"
        ),
        array(
                "first_name" => "John",
                "last_name" => "Doe",
                "age" => "47",
                "email" => "john_doe@example.com"
        )
);

/* encode the array as json. this will output [{"first_name":"Darian","last_name":"Brown","age":"28","email":"darianbr@example.com"},{"first_name":"John","last_name":"Doe","age":"47","email":"john_doe@example.com"}] */
echo json_encode($arr);
-->