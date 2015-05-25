<?php
	function getDB(){
		if(isset($_GET['sid'])){
			return 'scbb'.$_GET['sid'].'.db';
		}else{
			if(basename($_SERVER['SCRIPT_FILENAME']) == "boxscore_queries.php"){
				$db_temp = new PDO('sqlite:../db/scbbmain.db');
			}else{
				$db_temp = new PDO('sqlite:assets/db/scbbmain.db');
			}
			$current_season = $db_temp->query('select MAX(season) from Seasons');
			$row = $current_season->fetch(PDO::FETCH_BOTH);
			return 'scbb'.$row[0].'.db';
		}
	}

	function getAllDBs($input){

		$array = array();
		$db_temp = new PDO('sqlite:assets/db/scbbmain.db');
		$current_season = $db_temp->query('select MAX(season) from Seasons');
		$row = $current_season->fetch(PDO::FETCH_BOTH);
		$max = $row[0];
		for($i =1;$i<=$max;$i++){
			$db_check = new PDO('sqlite:assets/db/scbb'.$i.'.db');
			$check_id = $db_check->query('select COUNT(*) from Player_Info where Player_ID = '.$input);
			$row1 = $check_id->fetch(PDO::FETCH_BOTH);
			if($row1[0]>0){
				array_push($array,$i);
			}
		}

		return $array;
	}

?>