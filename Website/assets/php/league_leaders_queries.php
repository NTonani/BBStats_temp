
<?php

	//NEEDS TO BE CHANGED
	//executing queries on page load
	//player based leaders

	$db = new PDO('sqlite:assets/db/ewuscbb.db');

	//team based leaders
	$tppg = $db->query('select Team, round(Points/Games_Played, 1) as PPG from Team_Stats order by PPG desc limit 5');
	$tapg = $db->query('select Team, round(Assists/Games_Played, 1) as APG from Team_Stats order by APG desc limit 5');
	$trpg = $db->query('select Team, round(Rebounds/Games_Played, 1) as RPG from Team_Stats order by RPG desc limit 5');
	$tspg = $db->query('select Team, round(Steals/Games_Played, 1) as SPG from Team_Stats order by SPG desc limit 5');
	$tbpg = $db->query('select Team, round(Blocks/Games_Played,1) as BPG from Team_Stats order by BPG desc limit 5');
	//team % leaders
	$ttpp = $db->query('select Team, (100*(round(TPM/TPA,1))) as TPP from Team_Stats order by TPP desc limit 5');
	$tftp = $db->query('select Team, (100*(round(FTM/FTA,1))) as FTP from Team_Stats order by FTP desc limit 5');
	$tfgp = $db->query('select Team, (100*(round(FGM/FGA,1))) as FGP from Team_Stats order by FGP desc limit 5');

	//top ten player based leaders
	$ppg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Points/Games_Played, 1) as PPG
			from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
			order by PPG desc
			limit 10');
	$apg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Assists/Games_Played, 1) as APG
			from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
			order by APG desc
			limit 10');
	$rpg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Rebounds/Games_Played, 1) as RPG
			from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
			order by RPG desc
			limit 10');
	$spg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Steals/Games_Played, 1) as SPG
			from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
			order by SPG desc
			limit 10');
	$bpg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Blocks/Games_Played, 1) as BPG
			from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
			order by BPG desc
			limit 10');
	$tpp10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, (100*(round(TPM/TPA, 1))) as TPP
			from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
			order by TPP desc
			limit 10');
	$ftp10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, (100*(round(FTM/FTA, 1))) as FTP
			from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
			order by FTP desc
			limit 10');
	$fgp10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, (100*(round(FGM/FGA, 1))) as FGP
			from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
			order by FGP desc
			limit 10');

	//player based game highs
	$ghpt = $db->query('select Player_ID, First_Name, Last_Name, Points from Player_Game_Stats natural join Player_Info order by Points desc limit 3');
	$ghrb = $db->query('select Player_ID, First_Name, Last_Name, Rebounds from Player_Game_Stats natural join Player_Info order by Rebounds desc limit 3');
	$ghast = $db->query('select Player_ID, First_Name, Last_Name, Assists from Player_Game_Stats natural join Player_Info order by Assists desc limit 3');
	$ghstl = $db->query('select Player_ID, First_Name, Last_Name, Steals from Player_Game_Stats natural join Player_Info order by Steals desc limit 3');
	$ghblk = $db->query('select Player_ID, First_Name, Last_Name, Blocks from Player_Game_Stats natural join Player_Info order by Blocks desc limit 3');

	//team based game highs
	$ghtpt = $db->query('select Team, PointsFor from Team_Game_Stats order by PointsFor desc limit 3');
	$ghtrb = $db->query('select Team, Rebounds from Team_Game_Stats order by Rebounds desc limit 3');
	$ghtast = $db->query('select Team, Assists from Team_Game_Stats order by Assists desc limit 3');
	$ghtstl = $db->query('select Team, Steals from Team_Game_Stats order by Steals desc limit 3');
	$ghtblk = $db->query('select Team, Blocks from Team_Game_Stats order by Blocks desc limit 3');
	//closing db
	$db = NULL;

	

	//load player ppg leaders top 10 for League Leader page
	function getPPG10(){
		  try
		  {
		    global $ppg10;
		  	//outputing data
			$i = 1;
		    foreach($ppg10 as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>Team ".$row['Team']."</td>";
		      print "<td><b>".$row['PPG']."</b></td></tr>";
		      $i++;
		    }


		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	
	//load player apg leaders top 10 for League Leader page
	function getAPG10(){
		try
		  {
		  	global $apg10;
		  	//outputing data
			$i = 1;
		    foreach($apg10 as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>Team ".$row['Team']."</td>";
		      print "<td><b>".$row['APG']."</b></td>";
		      $i++;
		    }

		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }

	}
	
	//load player rpg leaders top 10 for League Leader page
	function getRPG10(){
		try
		  {
		  	global $rpg10;
			//outputing data
			$i = 1;
		    foreach($rpg10 as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>Team ".$row['Team']."</td>";
		      print "<td><b>".$row['RPG']."</b></td></tr>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	
	//load player spg leaders top 10 for League Leader page
	function getSPG10(){
		try
		  {
		  	global $spg10;
			//outputing data
			$i = 1;
		    foreach($spg10 as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>Team ".$row['Team']."</td>";
		      print "<td><b>".$row['SPG']."</b></td>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load player bpg leaders top 10 for League Leader page
	function getBPG10(){
		  try
		  {
		    global $bpg10;
		  	//outputing data
			$i = 1;
		    foreach($bpg10 as $row)
		    {
		      print "<tr><td>".$i."</td>";

		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>Team ".$row['Team']."</td>";
		      print "<td><b>".$row['BPG']."</b></td></tr>";
		      $i++;
		    }


		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load player tp% leaders top 10 for League Leader page
	function getTPP10(){
		  try
		  {
		    global $tpp10;
		  	//outputing data
			$i = 1;
		    foreach($tpp10 as $row)
		    {
		      print "<tr><td>".$i."</td>";

		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>Team ".$row['Team']."</td>";
		      print "<td><b>".$row['TPP']."%</b></td></tr>";
		      $i++;
		    }


		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}
	//load player ftp% leaders top 10 for League Leader page
	function getFTP10(){
		  try
		  {
		    global $ftp10;
		  	//outputing data
			$i = 1;
		    foreach($ftp10 as $row)
		    {
		      print "<tr><td>".$i."</td>";

		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>Team ".$row['Team']."</td>";
		      print "<td><b>".$row['FTP']."%</b></td></tr>";
		      $i++;
		    }


		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load player fgp% leaders top 10 for League Leader page
	function getFGP10(){
		  try
		  {
		    global $fgp10;
		  	//outputing data
			$i = 1;
		    foreach($fgp10 as $row)
		    {
		      print "<tr><td>".$i."</td>";

		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td>Team ".$row['Team']."</td>";
		      print "<td><b>".$row['FGP']."%</b></td></tr>";
		      $i++;
		    }


		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load team ppg leaders
	function teamPPG(){
		try
		  {
		  	global $tppg;
			//outputing data
			$i = 1;
		    foreach($tppg as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['PPG']."</b></td></tr>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load team apg leaders
	function teamAPG(){
		try
		  {
		  	global $tapg;
			//outputing data
			$i = 1;
		    foreach($tapg as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['APG']."</b></td>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load team rpg leaders
	function teamRPG(){
		try
		  {
		  	global $trpg;
			//outputing data
			$i = 1;
		    foreach($trpg as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['RPG']."</b></td></tr>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load team spg leaders
	function teamSPG(){
		try
		  {
		  	global $tspg;
			//outputing data
			$i = 1;
		    foreach($tspg as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['SPG']."</b></td>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load team bpg leaders
	function teamBPG(){
		try
		  {
		  	global $tbpg;
			//outputing data
			$i = 1;
		    foreach($tbpg as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['BPG']."</b></td>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}
	//load team ftp leaders
	function teamFTP(){
		try
		  {
		  	global $tftp;
			//outputing data
			$i = 1;
		    foreach($tftp as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['FTP']."%</b></td>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}
	//load team tpp leaders
	function teamTPP(){
		try
		  {
		  	global $ttpp;
			//outputing data
			$i = 1;
		    foreach($ttpp as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['TPP']."%</b></td>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//load team fgp leaders
	function teamFGP(){
		try
		  {
		  	global $tfgp;
			//outputing data
			$i = 1;
		    foreach($tfgp as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['FGP']."%</b></td>";
		      $i++;
		    }
		  }
		  catch(PDOException $e)
		  {
		    print 'Exception : '.$e->getMessage();
		  }
	}

	//game highs pts
	function getGHPT(){
	  try
	  {
	    global $ghpt;
	  	//outputing data
		$i = 1;
	    foreach($ghpt as $row)
	    {
	      print "<tr><td>".$i."</td>";
	      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
	      print "<td><b>".$row['Points']."</b></td></tr>";
	      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}

	//game highs rebs
	function getGHRB(){
	  try
	  {
	    global $ghrb;
	  	//outputing data
		$i = 1;
	    foreach($ghrb as $row)
	    {
	      print "<tr><td>".$i."</td>";
	      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
	      print "<td><b>".$row['Rebounds']."</b></td></tr>";
	      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}
	//game highs assists
	function getGHAST(){
	  try
	  {
	    global $ghast;
	  	//outputing data
		$i = 1;
	    foreach($ghast as $row)
	    {
	      print "<tr><td>".$i."</td>";
	      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
	      print "<td><b>".$row['Assists']."</b></td></tr>";
	      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}
	//game highs steals
	function getGHSTL(){
	  try
	  {
	    global $ghstl;
	  	//outputing data
		$i = 1;
	    foreach($ghstl as $row)
	    {
	      print "<tr><td>".$i."</td>";
	      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
	      print "<td><b>".$row['Steals']."</b></td></tr>";
	      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}

	//game highs blocks
	function getGHBLK(){
	  try
	  {
	    global $ghblk;
	  	//outputing data
		$i = 1;
	    foreach($ghblk as $row)
	    {
	      print "<tr><td>".$i."</td>";
	      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
	      print "<td><b>".$row['Blocks']."</b></td></tr>";
	      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}


	/////////////////

	//team game highs points
	function getGHTPT(){
	  try
	  {
	    global $ghtpt;
	  	//outputing data
		$i = 1;
	    foreach($ghtpt as $row)
	    {
	       	  $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['PointsFor']."</b></td></tr>";
		      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}
	//team game highs rebounds
	function getGHTRB(){
	  try
	  {
	    global $ghtrb;
	  	//outputing data
		$i = 1;
	    foreach($ghtrb as $row)
	    {
	       	  $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Rebounds']."</b></td></tr>";
		      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}
	//team game highs assists
	function getGHTAST(){
	  try
	  {
	    global $ghtast;
	  	//outputing data
		$i = 1;
	    foreach($ghtast as $row)
	    {
	       	  $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Assists']."</b></td></tr>";
		      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}
	//team game highs steals
	function getGHTSTL(){
	  try
	  {
	    global $ghtstl;
	  	//outputing data
		$i = 1;
	    foreach($ghtstl as $row)
	    {
	       	  $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Steals']."</b></td></tr>";
		      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}

	//team game highs blocks
	function getGHTBLK(){
	  try
	  {
	    global $ghtblk;
	  	//outputing data
		$i = 1;
	    foreach($ghtblk as $row)
	    {
	       	  $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Blocks']."</b></td></tr>";
		      $i++;
	    }


	  }
	  catch(PDOException $e)
	  {
	    print 'Exception : '.$e->getMessage();
	  }
	}



?>
