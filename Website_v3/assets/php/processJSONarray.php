
<?php
//NEED TO CHANGE FOR UPDATING GAMES
	$homeData = stripcslashes($_POST['pHomeData']);
	$awayData = stripcslashes($_POST['pAwayData']);
	$gameID = stripcslashes($_POST['gameID']);
	$newGame = stripcslashes($_POST['newGame']);
	$seasonID = stripcslashes($_POST['seasonID']);

	$homeData = json_decode($homeData,TRUE);
	$awayData = json_decode($awayData,TRUE);

	if($seasonID == "main"){
		$db = new PDO('sqlite:../db/scbb'.$seasonID.'.db');
		$current_season = $db->query('select MAX(season) from Seasons');
		$row = $current_season->fetch(PDO::FETCH_BOTH);
		$seasonID = $row[0];
	}

	$db = new PDO('sqlite:../db/scbb'.$seasonID.'.db');
	$db_main = new PDO('sqlite:../db/scbbmain.db');

	$schedule = $db->query('select Home, Away, Date from Schedule where Game_ID='.$gameID);
	$schedule_row = $schedule->fetch(PDO::FETCH_BOTH);

	$homeTeam = $schedule_row[0];
	$awayTeam = $schedule_row[1];
	$date = $schedule_row[2];

	echo storeData();


	function storeData(){

		global $db;
		global $homeData;
		global $awayData;
		global $gameID;
		global $newGame;
		global $homeTeam;
		global $awayTeam;
		global $date;

		try{
			$homeStats = array(
				"Game_ID" => $gameID,
				"Team" => $homeTeam,
				"Date" => $date,
				"Home/Away" => "Home",
				"Opponent" => $awayTeam,
				"PointsFor" => 0,
				"PointsAgst" => 0,
				"FGM" => 0,
				"FGA" => 0,
				"TPM" => 0,
				"TPA" => 0,
				"FTM" => 0,
				"FTA" => 0,
				"Assists" => 0,
				"Steals" => 0,
				"Rebounds" => 0,
				"Blocks" => 0

			);
			
			$awayStats = array(
				"Game_ID" => $gameID,
				"Team" => $awayTeam,
				"Date" => $date,
				"Home/Away" => "Away",
				"Opponent" => $homeTeam,
				"PointsFor" => 0,
				"PointsAgst" => 0,
				"FGM" => 0,
				"FGA" => 0,
				"TPM" => 0,
				"TPA" => 0,
				"FTM" => 0,
				"FTA" => 0,
				"Assists" => 0,
				"Steals" => 0,
				"Rebounds" => 0,
				"Blocks" => 0

			);

			if($newGame){
				foreach($homeData as $row){

					if($row['Points']!="DNP"){
						$homeStats['PointsFor'] += $row['Points'];
						$homeStats['FGM'] += $row['FGM'];
						$homeStats['FGA'] += $row['FGA'];
						$homeStats['TPM'] += $row['TPM'];
						$homeStats['TPA'] += $row['TPA'];
						$homeStats['FTM'] += $row['FTM'];
						$homeStats['FTA'] += $row['FTA'];
						$homeStats['Assists'] += $row['Assists'];
						$homeStats['Steals'] += $row['Steals'];
						$homeStats['Rebounds'] += $row['Rebounds'];
						$homeStats['Blocks'] += $row['Blocks'];

						newPlayerGameStat($db,array($row['ID'] , $gameID , $row['Points'] , $row['FGM'] , $row['FGA'] , $row['TPM'], $row['TPA'], $row['FTM'], $row['FTA'], $row['Assists'], $row['Steals'] , $row['Rebounds'],$row['Blocks']));

						addToPlayerStats($db,array($row['Points'] , $row['FGM'] , $row['FGA'] , $row['TPM'], $row['TPA'], $row['FTM'], $row['FTA'], $row['Assists'], $row['Steals'] , $row['Rebounds'] , $row['Blocks']),$row['ID']);
					}

				}

				foreach($awayData as $row){

					if($row['Points']!="DNP"){
						$awayStats['PointsFor'] += $row['Points'];
						$awayStats['FGM'] += $row['FGM'];
						$awayStats['FGA'] += $row['FGA'];
						$awayStats['TPM'] += $row['TPM'];
						$awayStats['TPA'] += $row['TPA'];
						$awayStats['FTM'] += $row['FTM'];
						$awayStats['FTA'] += $row['FTA'];
						$awayStats['Assists'] += $row['Assists'];
						$awayStats['Steals'] += $row['Steals'];
						$awayStats['Rebounds'] += $row['Rebounds'];
						$awayStats['Blocks'] += $row['Blocks'];


						newPlayerGameStat($db,array($row['ID'] , $gameID , $row['Points'] , $row['FGM'] , $row['FGA'] , $row['TPM'], $row['TPA'], $row['FTM'], $row['FTA'], $row['Assists'], $row['Steals'] , $row['Rebounds'],$row['Blocks']));

						addToPlayerStats($db,array($row['Points'] , $row['FGM'] , $row['FGA'] , $row['TPM'], $row['TPA'], $row['FTM'], $row['FTA'], $row['Assists'], $row['Steals'] , $row['Rebounds'] , $row['Blocks']),$row['ID']);
					}
				}


				$homeStats['PointsAgst'] = $awayStats['PointsFor'];
				$awayStats['PointsAgst'] = $homeStats['PointsFor'];

				newTeamGameStat($db,array($homeStats['Game_ID'],$homeStats['Team'],$homeStats['Date'],$homeStats['Home/Away'], $homeStats['Opponent'], $homeStats['PointsFor'], $homeStats['PointsAgst'],$homeStats['FGM'],$homeStats['FGA'],$homeStats['TPM'],$homeStats['TPA'],$homeStats['FTM'],$homeStats['FTA'],$homeStats['Assists'],$homeStats['Steals'],$homeStats['Rebounds'],$homeStats['Blocks']));
				newTeamGameStat($db,array($awayStats['Game_ID'],$awayStats['Team'],$awayStats['Date'],$awayStats['Home/Away'], $awayStats['Opponent'], $awayStats['PointsFor'], $awayStats['PointsAgst'],$awayStats['FGM'],$awayStats['FGA'],$awayStats['TPM'],$awayStats['TPA'],$awayStats['FTM'],$awayStats['FTA'],$awayStats['Assists'],$awayStats['Steals'],$awayStats['Rebounds'],$awayStats['Blocks']));

				if($homeStats['PointsFor']>$awayStats['PointsFor']){
					addToGameStats($db,array(1,$homeStats['PointsFor'],0,$homeStats['FGM'],$homeStats['FGA'],$homeStats['TPM'],$homeStats['TPA'],$homeStats['FTM'],$homeStats['FTA'],$homeStats['Assists'],$homeStats['Steals'],$homeStats['Rebounds'],$homeStats['Blocks']),$homeStats['Team']);
					addToGameStats($db,array(0,$awayStats['PointsFor'],1, $awayStats['FGM'],$awayStats['FGA'],$awayStats['TPM'],$awayStats['TPA'],$awayStats['FTM'],$awayStats['FTA'],$awayStats['Assists'],$awayStats['Steals'],$awayStats['Rebounds'],$awayStats['Blocks']),$awayStats['Team']);
				}else{
					addToGameStats($db,array(0,$homeStats['PointsFor'],1,$homeStats['FGM'],$homeStats['FGA'],$homeStats['TPM'],$homeStats['TPA'],$homeStats['FTM'],$homeStats['FTA'],$homeStats['Assists'],$homeStats['Steals'],$homeStats['Rebounds'],$homeStats['Blocks']),$homeStats['Team']);
					addToGameStats($db,array(1,$awayStats['PointsFor'],0, $awayStats['FGM'],$awayStats['FGA'],$awayStats['TPM'],$awayStats['TPA'],$awayStats['FTM'],$awayStats['FTA'],$awayStats['Assists'],$awayStats['Steals'],$awayStats['Rebounds'],$awayStats['Blocks']),$awayStats['Team']);
				}				
				return "Success!";

			}else{

			}
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}

	function newPlayerGameStat($db,$array){
		 $newPlayerStat = $db->prepare('insert into Player_Game_Stats VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)');
		 $newPlayerStat->execute($array);
	}

	function addToPlayerStats($db,$array,$id){
		$addPlayerStats = $db->prepare('Update Player_Stats set Games_Played = Games_Played + 1, Points = Points + ?, FGM = FGM + ?, FGA = FGA + ?, TPM = TPM + ?, TPA = TPA + ?, FTM = FTM + ?, FTA = FTA + ?, Assists = Assists + ?, Steals = Steals + ?, Rebounds = Rebounds + ?, Blocks = Blocks + ? where Player_ID ='.$id);
		$addPlayerStats->execute($array);
	}

	function newTeamGameStat($db,$array){
		$teamGame = $db->prepare('insert into Team_Game_Stats VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
		$teamGame->execute($array);
	}

	function addToGameStats($db,$array,$team){
		$teamStats = $db->prepare('Update Team_Stats set Games_Played=Games_Played+1, Wins = Wins + ?, Points = Points + ?, Losses = Losses + ?, FGM = FGM + ? , FGA = FGA + ?, TPM = TPM + ?, TPA = TPA + ?, FTM = FTM + ?, FTA = FTA + ?, Assists = Assists + ?, Steals = Steals + ?, Rebounds = Rebounds + ?, Blocks = Blocks + ? where Team='.$team);
		$teamStats->execute($array);
	}

?>