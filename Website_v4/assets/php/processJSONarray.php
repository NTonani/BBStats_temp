
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
		global $db_main;
		global $homeData;
		global $awayData;
		global $gameID;
		global $newGame;
		global $homeTeam;
		global $awayTeam;
		global $date;

		try{
			
			if($newGame!="true"){
				$playerdata = $db->query('select * from Player_Game_Stats where Game_ID='.$gameID);
				foreach($playerdata as $row){
					removeFromPlayerStats($db,array($row['Points'] , $row['FGM'] , $row['FGA'] , $row['TPM'], $row['TPA'], $row['FTM'], $row['FTA'], $row['Assists'], $row['Steals'] , $row['Rebounds'] , $row['Blocks']),$row['Player_ID']);
					removeFromPlayerStats($db_main,array($row['Points'] , $row['FGM'] , $row['FGA'] , $row['TPM'], $row['TPA'], $row['FTM'], $row['FTA'], $row['Assists'], $row['Steals'] , $row['Rebounds'] , $row['Blocks']),$row['Player_ID']);

					removeGameHighsMain($db_main,"Points",$row['Player_ID'],$row['Points']);
					removeGameHighsMain($db_main,"Rebounds",$row['Player_ID'],$row['Rebounds']);
					removeGameHighsMain($db_main,"Assists",$row['Player_ID'],$row['Assists']);
					removeGameHighsMain($db_main,"Steals",$row['Player_ID'],$row['Steals']);
					removeGameHighsMain($db_main,"Blocks",$row['Player_ID'],$row['Blocks']);
				}
				$removeplayerdata = $db->exec('delete from Player_Game_Stats where Game_ID='.$gameID);

				$teamdata = $db->query('select * from Team_Game_Stats where Game_ID='.$gameID);
				foreach($teamdata as $row){
					if($row['PointsFor']>$row['PointsAgst'])
						removeFromGameStats($db,array(1,$row['PointsFor'],0, $row['FGM'],$row['FGA'],$row['3PM'],$row['3PA'],$row['FTM'],$row['FTA'],$row['Assists'],$row['Steals'],$row['Rebounds'],$row['Blocks']),$row['Team']);
					else 
						removeFromGameStats($db,array(0,$row['PointsFor'],1, $row['FGM'],$row['FGA'],$row['3PM'],$row['3PA'],$row['FTM'],$row['FTA'],$row['Assists'],$row['Steals'],$row['Rebounds'],$row['Blocks']),$row['Team']);
				}
				$removeteamdata = $db->exec('delete from Team_Game_Stats where Game_ID='.$gameID);
			}

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

			//if($newGame=="true"){

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
						addToPlayerStats($db_main,array($row['Points'] , $row['FGM'] , $row['FGA'] , $row['TPM'], $row['TPA'], $row['FTM'], $row['FTA'], $row['Assists'], $row['Steals'] , $row['Rebounds'] , $row['Blocks']),$row['ID']);

						updateGameHighsMain($db_main,"Points",$row['ID'],$row['Points']);
						updateGameHighsMain($db_main,"Rebounds",$row['ID'],$row['Rebounds']);
						updateGameHighsMain($db_main,"Assists",$row['ID'],$row['Assists']);
						updateGameHighsMain($db_main,"Steals",$row['ID'],$row['Steals']);
						updateGameHighsMain($db_main,"Blocks",$row['ID'],$row['Blocks']);
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

						updateGameHighsMain($db_main,"Points",$row['ID'],$row['Points']);
						updateGameHighsMain($db_main,"Rebounds",$row['ID'],$row['Rebounds']);
						updateGameHighsMain($db_main,"Assists",$row['ID'],$row['Assists']);
						updateGameHighsMain($db_main,"Steals",$row['ID'],$row['Steals']);
						updateGameHighsMain($db_main,"Blocks",$row['ID'],$row['Blocks']);
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

			//}else{


			//}
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}

	function updateGameHighsMain($db,$stat,$player_id,$value){
		$stat_query = $db->query('Select * from GH'.$stat.' where '.$stat.'=(select MIN('.$stat.') from GH'.$stat.')');
		$stat_value = $stat_query->fetch(PDO:: FETCH_BOTH);
		if($stat_value[1]< $value){

			$update = $db->prepare('Update GH'.$stat.' set Player_ID= ?, '.$stat.'= ? where ROWID = (select ROWID from GH'.$stat.' where Player_ID='.$stat_value[0].' and '.$stat.' = '.$stat_value[1].' limit 1)');
			$update->execute(array($player_id,$value));
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

	function removeFromPlayerStats($db,$array,$id){
		$addPlayerStats = $db->prepare('Update Player_Stats set Games_Played = Games_Played - 1, Points = Points - ?, FGM = FGM - ?, FGA = FGA - ?, TPM = TPM - ?, TPA = TPA - ?, FTM = FTM - ?, FTA = FTA - ?, Assists = Assists - ?, Steals = Steals - ?, Rebounds = Rebounds - ?, Blocks = Blocks - ? where Player_ID ='.$id);
		$addPlayerStats->execute($array);
	}
	function removeGameHighsMain($db,$stat,$player_id,$value){
		$update = $db->prepare('Update GH'.$stat.' set Player_ID= ?, '.$stat.'= ? where ROWID = (select ROWID from GH'.$stat.' where Player_ID='.$player_id.' and '.$stat.'='.$value.' limit 1)');
		$update->execute(array(0,0));
	}
	
	function removeFromGameStats($db,$array,$team){
		$teamStats = $db->prepare('Update Team_Stats set Games_Played=Games_Played-1, Wins = Wins - ?, Points = Points - ?, Losses = Losses - ?, FGM = FGM - ? , FGA = FGA - ?, TPM = TPM - ?, TPA = TPA - ?, FTM = FTM - ?, FTA = FTA - ?, Assists = Assists - ?, Steals = Steals - ?, Rebounds = Rebounds - ?, Blocks = Blocks - ? where Team='.$team);
		$teamStats->execute($array);
	}

?>