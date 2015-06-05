<?php

	$seasonID = stripcslashes($_POST['seasonID']);
	$schedule = stripcslashes($_POST['schedule']);

	$schedule = json_decode($schedule,TRUE);

	if($seasonID == "main"){
		$db = new PDO('sqlite:../db/scbb'.$seasonID.'.db');
		$current_season = $db->query('select MAX(season) from Seasons');
		$row = $current_season->fetch(PDO::FETCH_BOTH);
		$seasonID = $row[0];
	}

	$db = new PDO('sqlite:../db/scbb'.$seasonID.'.db');

	removeFromSchedule();
	echo writeToSchedule();


	function removeFromSchedule(){
		global $db;
		$remove = $db->exec('delete from Schedule');
	}

	function writeToSchedule(){
		try{
			global $db;
			global $schedule;
			foreach((array)$schedule as $row){
				$addGame = $db->prepare('Insert into Schedule VALUES (?,?,?,?,?)');
				$addGame->execute(array($row['Game_ID'],$row['Home'],$row['Away'],$row['Date'],$row['Time']));
			}

			return "Success";
		}catch(PDOException $e){
			return $e->getMessage();
		}
	}



?>