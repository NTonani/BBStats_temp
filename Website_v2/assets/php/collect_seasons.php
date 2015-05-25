<?php
	$db = new PDO('sqlite:assets/db/scbbmain.db');
	//seasons query
	$seasons = $db->query('select Season from Seasons');
	$db = null;

	function getSeasons(){
		try{

			if(strpos($_SERVER['SCRIPT_NAME'],'league_leaders_page')==true || strpos($_SERVER['SCRIPT_NAME'],'player_stats')==true){
				print " <li role='presentation'><a role='menuitem' tabindex='-1' href='#' onClick=refreshSeason('main')>All Time</a></li>";

			}
			global $seasons;
			foreach($seasons as $row){
				$id = $row['Season'];
				print " <li role='presentation'><a role='menuitem' tabindex='-1' href='#' onClick=\"refreshSeason('".$id."')\">Season ".$id."</a></li>";
			}


		}catch(PDOException $e){
			print 'Exception : '.$e->getMessage();
		}
	}



?>