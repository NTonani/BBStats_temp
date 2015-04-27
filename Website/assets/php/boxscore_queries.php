<?php  
	//game id check
	if(isset($_POST['game'])){
		$game = $_POST['game'];
		$db = new PDO('sqlite:../db/ewuscbb.db');
		$game_query = $db->query("select Team, Date, \"Home/Away\" as ha, Opponent, PointsFor, PointsAgst from Team_Game_Stats where Game_ID =".$game." limit 1");
		$output = "<div class = 'container-fluid lg-font'>
						<div class = 'row text-center'>";
		$home;$away;$homepts;$awaypts;$date;
		foreach($game_query as $row){
			$date = $row['Date'];
			$output = $output." ".$date."
						</div>
						<div class ='row bar'></div>
						<div class = 'row text-center score-font'>
							<div class = 'col-sm-6 score-font'>";
			if($row['ha'] == "Home"){
				$home = $row['Team'];
				$away = $row['Opponent'];
			}else{
				$home = $row['Opponent'];
				$away = $row['Team'];
			}
			$homepts = $row['PointsFor'];
			$awaypts = $row['PointsAgst'];

			//naive way of indicating winning team....
			if($homepts < $awaypts){
				$output = $output."".$homepts."</div><div class = 'col-sm-6'><b>".$awaypts."</b></div></div>";
			}else{
				$output = $output."<b>".$homepts."</b></div><div class = 'col-sm-6'>".$awaypts."</div></div>";
			}

			$output = $output."<div class ='row text-center team-font'> vs </div> <div class = 'row text-center team-font'>
										<div class = 'col-sm-6'>
											Team ".$home."</div>
										<div class = 'col-sm-6'>Team ".$away."</div></div>
										<div class ='row roster-bar'>Team ".$home."</div>";

			//collecting players
			$away_players = $db->query('select First_Name, Last_Name, Points, FGM, FGA, TPM, TPA, FTM, FTA, Assists, Steals, Rebounds, Blocks from Player_Game_Stats natural join Player_Info where Game_ID ='.$game.' and Team ='.$away);
			$home_players = $db->query('select First_Name, Last_Name, Points, FGM, FGA, TPM, TPA, FTM, FTA, Assists, Steals, Rebounds, Blocks from Player_Game_Stats natural join Player_Info where Game_ID ='.$game.' and Team ='.$home);
			
			$home_roster_html = "<div class = 'container-fluid'>
									<div class = 'table-responsive text-center'>
										<div class='col'>
											<table class='table table-condensed'>
												<thead>
													<tr class = 'table_headers'>
														<th>Player</th>
														<th>FGM</th>
														<th>FGA</th>
														<th>TPM</th>
														<th>TPA</th>
														<th>FTM</th>
														<th>FTA</th>
														<th>PTS</th>
														<th>AST</th>
														<th>REB</th>
														<th>STL</th>
														<th>BLK</th>
													</tr>
												</thead>
											<tbody>";
			foreach($home_players as $row){
				$player = "<tr><td>".$row['First_Name']." ".$row['Last_Name']."</td>";
				$player = $player."<td>".$row['FGM']."</td>";
				$player = $player."<td>".$row['FGA']."</td>";
				$player = $player."<td>".$row['TPM']."</td>";
				$player = $player."<td>".$row['TPA']."</td>";
				$player = $player."<td>".$row['FTM']."</td>";
				$player = $player."<td>".$row['FTA']."</td>";
				$player = $player."<td>".$row['Points']."</td>";
				$player = $player."<td>".$row['Assists']."</td>";
				$player = $player."<td>".$row['Rebounds']."</td>";
				$player = $player."<td>".$row['Steals']."</td>";
				$player = $player."<td>".$row['Blocks']."</td></tr>";
				$home_roster_html = $home_roster_html.$player;
			}
			$home_roster_html = $home_roster_html."	</tbody>
						  			</table>
						  		</div>
					  		</div>
						</div>";
			$output = $output." ".$home_roster_html."<div class ='row roster-bar'>Team ".$away."</div>";

			
			$away_roster_html = "<div class = 'container-fluid'>
									<div class = 'table-responsive text-center'>
										<div class='col'>
											<table class='table table-condensed'>
												<thead>
													<tr class = 'table_headers'>
														<th>Player</th>
														<th>FGM</th>
														<th>FGA</th>
														<th>TPM</th>
														<th>TPA</th>
														<th>FTM</th>
														<th>FTA</th>
														<th>PTS</th>
														<th>AST</th>
														<th>REB</th>
														<th>STL</th>
														<th>BLK</th>
													</tr>
												</thead>
											<tbody>";
			foreach($away_players as $row){
				$player = "<tr><td>".$row['First_Name']." ".$row['Last_Name']."<td>";
				$player = $player."<td>".$row['FGM']."</td>";
				$player = $player."<td>".$row['FGA']."</td>";
				$player = $player."<td>".$row['TPM']."</td>";
				$player = $player."<td>".$row['TPA']."</td>";
				$player = $player."<td>".$row['FTM']."</td>";
				$player = $player."<td>".$row['FTA']."</td>";
				$player = $player."<td>".$row['Points']."</td>";
				$player = $player."<td>".$row['Assists']."</td>";
				$player = $player."<td>".$row['Rebounds']."</td>";
				$player = $player."<td>".$row['Steals']."</td>";
				$player = $player."<td>".$row['Blocks']."</td></tr>";
				$away_roster_html = $away_roster_html.$player;
			}


			$away_roster_html = $away_roster_html."	</tbody>
						  			</table>
						  		</div>
					  		</div>
						</div>";

			
			$output = $output." ".$away_roster_html;



		}
		//$output = $output."</div>";
		print $output;
	}else{
		print "No game was found";
	}

	$db = NULL;
	
?>
