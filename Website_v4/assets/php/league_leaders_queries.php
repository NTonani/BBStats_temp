
<?php

	//NEEDS TO BE CHANGED
	//executing queries on page load
	//player based leaders

	include 'proper_season_db.php';
	$dbString = getDB();
	$db = new PDO('sqlite:assets/db/'.$dbString);
	$main = false;
	if(isset($_GET['sid'])){
		if($_GET['sid']=='main'){
			$main = true;
		}
	}

	
	//top ten player based leaders
	if(!$main){
		$ppg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Points/Games_Played, 1) as PPG
				from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
				order by PPG desc
				limit 5');
		$apg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Assists/Games_Played, 1) as APG
				from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
				order by APG desc
				limit 5');
		

		$rpg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Rebounds/Games_Played, 1) as RPG
				from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
				order by RPG desc
				limit 5');
		$spg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Steals/Games_Played, 1) as SPG
				from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
				order by SPG desc
				limit 5');
		$bpg10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, round(Blocks/Games_Played, 1) as BPG
				from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
				order by BPG desc
				limit 5');
		$tpp10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, (100*(round(TPM/TPA, 1))) as TPP
				from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
				order by TPP desc
				limit 5');
		$ftp10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, (100*(round(FTM/FTA, 1))) as FTP
				from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
				order by FTP desc
				limit 5');
		$fgp10 = $db->query('select pi.Player_ID, ps.First_Name, ps.Last_Name, Team, (100*(round(FGM/FGA, 1))) as FGP
				from Player_Stats as ps left outer join Player_Info as pi on ps.First_Name = 	pi.First_Name and ps.Last_Name = pi.Last_Name
				order by FGP desc
				limit 5');
		//player based game highs
		$ghpt = $db->query('select Player_ID, First_Name, Last_Name, Team, Points from Player_Game_Stats natural join Player_Info order by Points desc limit 5');
		$ghrb = $db->query('select Player_ID, First_Name, Last_Name, Team, Rebounds from Player_Game_Stats natural join Player_Info order by Rebounds desc limit 5');
		$ghast = $db->query('select Player_ID, First_Name, Last_Name, Team, Assists from Player_Game_Stats natural join Player_Info order by Assists desc limit 5');
		$ghstl = $db->query('select Player_ID, First_Name, Last_Name, Team, Steals from Player_Game_Stats natural join Player_Info order by Steals desc limit 5');
		$ghblk = $db->query('select Player_ID, First_Name, Last_Name, Team, Blocks from Player_Game_Stats natural join Player_Info order by Blocks desc limit 5');

		//team based game highs
		$ghtpt = $db->query('select Team, PointsFor from Team_Game_Stats order by PointsFor desc limit 5');
		$ghtrb = $db->query('select Team, Rebounds from Team_Game_Stats order by Rebounds desc limit 5');
		$ghtast = $db->query('select Team, Assists from Team_Game_Stats order by Assists desc limit 5');
		$ghtstl = $db->query('select Team, Steals from Team_Game_Stats order by Steals desc limit 5');
		$ghtblk = $db->query('select Team, Blocks from Team_Game_Stats order by Blocks desc limit 5');

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


	}else{
		print ' NOTE: All-time team stats are not available.';

		$ppgALL = $db->query('select Player_ID, First_Name, Last_Name, round(Points/Games_Played, 1) as PPG
				from Player_Stats order by PPG desc limit 5');
		$apgALL = $db->query('select Player_ID, First_Name, Last_Name, round(Assists/Games_Played, 1) as APG
				from Player_Stats order by APG desc limit 5');
		$rpgALL = $db->query('select Player_ID, First_Name, Last_Name, round(Rebounds/Games_Played, 1) as RPG
				from Player_Stats order by RPG desc limit 5');
		$spgALL = $db->query('select Player_ID, First_Name, Last_Name, round(Steals/Games_Played, 1) as SPG
				from Player_Stats order by SPG desc limit 5');
		$bpgALL = $db->query('select Player_ID, First_Name, Last_Name, round(Blocks/Games_Played, 1) as BPG
				from Player_Stats order by BPG desc limit 5');
		$tppALL = $db->query('select Player_ID, First_Name, Last_Name, (100*(round(TPM/TPA, 1))) as TPP
				from Player_Stats order by TPP desc limit 5');
		$ftpALL = $db->query('select Player_ID, First_Name, Last_Name, (100*(round(FTM/FTA, 1))) as FTP
				from Player_Stats order by FTP desc limit 5');
		$fgpALL = $db->query('select Player_ID, First_Name, Last_Name, (100*(round(FGM/FGA, 1))) as FGP
				from Player_Stats order by FGP desc limit 5');
		$ghptALL = $db->query('select Player_ID, First_Name, Last_Name, gh.Points from GHPoints as gh natural join Player_Stats as ps order by gh.Points limit 5');
		$ghastALL = $db->query('select Player_ID, First_Name, Last_Name, gh.Assists from GHAssists as gh natural join Player_Stats as ps order by gh.Assists limit 5');
		$ghrebALL = $db->query('select Player_ID, First_Name, Last_Name, gh.Rebounds from GHRebounds as gh natural join Player_Stats as ps order by gh.Rebounds limit 5');
		$ghstlALL = $db->query('select Player_ID, First_Name, Last_Name, gh.Steals from GHSteals as gh natural join Player_Stats as ps order by gh.Steals limit 5');
		$ghblkALL = $db->query('select Player_ID, First_Name, Last_Name, gh.Blocks from GHBlocks as gh natural join Player_Stats as ps order by gh.Blocks limit 5');


	}

	
	//closing db
	$db = NULL;

	

	//load player ppg leaders top 10 for League Leader page
	function getPPG10(){
		  try
		  {
		  	global $main;
		  	if(!$main){
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
			}else{
				global $ppgALL;
				$i = 1;
			    foreach($ppgALL as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td><b>".$row['PPG']."</b></td></tr>";
			      $i++;
			    }

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
		  	global $main;
		  	if(!$main){
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
			}else{
				global $apgALL;
				$i = 1;
			    foreach($apgALL as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td><b>".$row['APG']."</b></td></tr>";
			      $i++;
			    }
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
		  	global$main;
		  	if(!$main){
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
			}else{
				global $rpgALL;
				$i = 1;
			    foreach($rpgALL as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td><b>".$row['RPG']."</b></td></tr>";
			      $i++;
			    }	
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
		  	global$main;
		  	if(!$main){
			  	global $spg10;
				//outputing data
				$i = 1;
			    foreach($spg10 as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td>Team ".$row['Team']."</td>";
			      print "<td><b>".$row['SPG']."</b></td></tr>";
			      $i++;
			    }
			}else{
				global $spgALL;
				$i = 1;
			    foreach($spgALL as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td><b>".$row['SPG']."</b></td></tr>";
			      $i++;
			    }	
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
		    global$main;
		  	if(!$main){
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
			}else{
				global $bpgALL;
				$i = 1;
			    foreach($bpgALL as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td><b>".$row['BPG']."</b></td></tr>";
			      $i++;
			    }	
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
		  	global $main;
		  	if(!$main){
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
			}else{
				global $tppALL;
				$i = 1;
			    foreach($tppALL as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td><b>".$row['TPP']."%</b></td></tr>";
			      $i++;
			    }

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
		    global $main;
		  	if(!$main){
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
			}else{
				global $ftpALL;
				$i = 1;
			    foreach($ftpALL as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td><b>".$row['FTP']."%</b></td></tr>";
			      $i++;
			    }

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
		    global $main;
		  	if(!$main){
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
			}else{
				global $fgpALL;
				$i = 1;
			    foreach($fgpALL as $row)
			    {
			      print "<tr><td>".$i."</td>";
			      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
			      print "<td><b>".$row['FGP']."%</b></td></tr>";
			      $i++;
			    }

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
		  	global $main;
		  	if(!$main){
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
			else{
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
		  	global $main;
		  	if(!$main){
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
			}else{

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
		  	global $main;
		  	if(!$main){
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
			}else{

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
		  	global $main;
		  	if(!$main){
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
			}else{

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
		  	global $main;
		  	if(!$main){
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
			}else{

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
		  	global $main;
		  	if(!$main){
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
			}else{

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
		  	global $main;
		  	if(!$main){
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
			}else{

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
		  	global $main;
		  	if(!$main){
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
			else{

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
	  	global $main;
	  	if(!$main){
		    global $ghpt;
		  	//outputing data
			$i = 1;
		    foreach($ghpt as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Points']."</b></td></tr>";
		      $i++;
		    }
		}else{
			global $ghptALL;
			$i = 1;
		    foreach($ghptALL as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><b>".$row['Points']."</b></td></tr>";
		      $i++;
		    }	
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
	    global $main;
	  	if(!$main){
		    global $ghrb;
		  	//outputing data
			$i = 1;
		    foreach($ghrb as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Rebounds']."</b></td></tr>";
		      $i++;
		    }
		}else{
			global $ghrebALL;
			$i = 1;
		    foreach($ghrebALL as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><b>".$row['Rebounds']."</b></td></tr>";
		      $i++;
		    }	
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
	    global $main;
	  	if(!$main){
		    global $ghast;
		  	//outputing data
			$i = 1;
		    foreach($ghast as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Assists']."</b></td></tr>";
		      $i++;
		    }
		}else{
			global $ghastALL;
			$i = 1;
		    foreach($ghastALL as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><b>".$row['Assists']."</b></td></tr>";
		      $i++;
		    }	
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
	    global $main;
	  	if(!$main){
		    global $ghstl;
		  	//outputing data
			$i = 1;
		    foreach($ghstl as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Steals']."</b></td></tr>";
		      $i++;
		    }
		}else{
			global $ghstlALL;
			$i = 1;
		    foreach($ghstlALL as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><b>".$row['Steals']."</b></td></tr>";
		      $i++;
		    }	
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
	    global $main;
	  	if(!$main){
		    global $ghblk;
		  	//outputing data
			$i = 1;
		    foreach($ghblk as $row)
		    {
		      $team = $row['Team'];
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><a href = 'team_info_page.php?tid=".$team."'>Team ".$team."</a></td>";
		      print "<td><b>".$row['Blocks']."</b></td></tr>";
		      $i++;
		    }
		}else{
			global $ghblkALL;
			$i = 1;
		    foreach($ghblkALL as $row)
		    {
		      print "<tr><td>".$i."</td>";
		      print "<td><a href = player_indi_stats.php?id=".$row['Player_ID'].">".$row['First_Name']." ".$row['Last_Name']."</a></td>";
		      print "<td><b>".$row['Blocks']."</b></td></tr>";
		      $i++;
		    }	
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
