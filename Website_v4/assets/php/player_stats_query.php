
<?php
	include 'proper_season_db.php';
	$dbString = getDB();
	$db = new PDO('sqlite:assets/db/'.$dbString);

	//player per game
	$pergame = $db->query('select Player_ID, First_Name, Last_Name, Games_Played, round(Points/Games_Played,1) as points, round(FGM*1.0/Games_Played,2) as fgm, round(FGA*1.0/Games_Played,2) as fga, round(TPM*1.0/Games_Played,2) as tpm, round(TPA*1.0/Games_Played,2) as tpa, round(FTM/Games_Played,2) as ftm, round(FTA/Games_Played,2) as fta, round(Assists/Games_Played,1) as assists, round(Steals/Games_Played,1) as steals, round(Rebounds/Games_Played,1) as rebounds, round(Blocks/Games_Played,1) as blocks from Player_Stats');
	//player season totals
	$season = $db->query('select * from Player_Stats');

	//closing db
	$db = NULL;


	//load pergame
	function getPerGame(){
		try
		  {
		  	global $pergame;
			//outputing data
			$i = 1;
		    foreach($pergame as $row)
		    {
		      $fgpct = 0.0;
		      $tppct = 0.0;
		      $ftpct = 0.0;
		      if($row['fga']!=0)
		      	$fgpct = round($row['fgm']/$row['fga'],3)*100;
		      if($row['tpa']!=0)
		      	$tppct = round($row['tpm']/$row['tpa'],3)*100;
		      if($row['fta']!=0)
		     	 $ftpct = round($row['ftm']/$row['fta'],3)*100;
		      print "<tr><td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>".(int)$row['Games_Played']."</td>";
		      print "<td>".$row['points']."</td>";
		      print "<td>".$row['fgm']."</td>";
		      print "<td>".$row['fga']."</td>";
		      print "<td>".$fgpct."</td>";
		      print "<td>".$row['tpm']."</td>";
		      print "<td>".$row['tpa']."</td>";
		      print "<td>".$tppct."</td>";
		      print "<td>".$row['ftm']."</td>";
		      print "<td>".$row['fta']."</td>";
		      print "<td>".$ftpct."</td>";
		      print "<td>".$row['assists']."</td>";
		      print "<td>".$row['steals']."</td>";
		      print "<td>".$row['rebounds']."</td>";
		      print "<td>".$row['blocks']."</td></tr>";
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load season totals
	function getSeason(){
		try
		  {
		  	global $season;
			//outputing data
			$i = 1;
		    foreach($season as $row)
		    {
		      $fgpct = 0.0;
		      $tppct = 0.0;
		      $ftpct = 0.0;
		      if($row['FGA']!=0)
		      	$fgpct = round($row['FGM']/$row['FGA'],3)*100;
		      if($row['TPA']!=0)
		      	$tppct = round($row['TPM']/$row['TPA'],3)*100;
		      if($row['FTA']!=0)
		     	 $ftpct = round($row['FTM']/$row['FTA'],3)*100;
		      print "<tr><td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>".(int)$row['Games_Played']."</td>";
		      print "<td>".(int)$row['Points']."</td>";
		      print "<td>".(int)$row['FGM']."</td>";
		      print "<td>".(int)$row['FGA']."</td>";
		      print "<td>".$fgpct."</td>";
		      print "<td>".(int)$row['TPM']."</td>";
		      print "<td>".(int)$row['TPA']."</td>";
		      print "<td>".$tppct."</td>";
		      print "<td>".(int)$row['FTM']."</td>";
		      print "<td>".(int)$row['FTA']."</td>";
		      print "<td>".$ftpct."</td>";
		      print "<td>".(int)$row['Assists']."</td>";
		      print "<td>".(int)$row['Steals']."</td>";
		      print "<td>".(int)$row['Rebounds']."</td>";
		      print "<td>".(int)$row['Blocks']."</td></tr>";
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}
  /* --PRINTS NAMES OF ALL TABLES IN DB FILE--
    $db = new SQLite3('assets/db/ewuscbb.db');
    $tablesquery = $db->query("SELECT name FROM sqlite_master WHERE type='table';");

    while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
        echo $table['name'] . '<br />';
    }*/
?>
