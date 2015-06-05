//changes main navbar hovers so viewer understands where they are
$(document).ready(function(){
	var url = $(location).attr('pathname');
	var input;
	if(url.search('index.php')>=0){
		input = '<li class="space"><a href="schedule_scores.php">Schedule and Scores</a></li><li class="space"><a href="league_leaders_page.php">League Leaders</a></li><li class="space"><a href="player_stats.php">Player Stats</a></li><li class="space"><a href="team_info_page.php" >Team Stats</a></li>';
	}else if(url.search('schedule_scores.php')>=0){
		input = '<li class="active space"><a href="schedule_scores.php">Schedule and Scores</a></li><li class="space"><a href="league_leaders_page.php">League Leaders</a></li><li class="space"><a href="player_stats.php">Player Stats</a></li><li class="space"><a href="team_info_page.php" >Team Stats</a></li>';
	}else if(url.search('league_leaders_page.php')>=0){
		input = '<li class="space"><a href="schedule_scores.php">Schedule and Scores</a></li><li class="active space"><a href="league_leaders_page.php">League Leaders</a></li><li class="space"><a href="player_stats.php">Player Stats</a></li><li class="space"><a href="team_info_page.php" >Team Stats</a></li>';
	}else if(url.search('player_stats.php')>=0 || url.search('player_indi_stats.php')>=0){
		input = '<li class="space"><a href="schedule_scores.php">Schedule and Scores</a></li><li class="space"><a href="league_leaders_page.php">League Leaders</a></li><li class="active space"><a href="player_stats.php">Player Stats</a></li><li class="space"><a href="team_info_page.php" >Team Stats</a></li>';
	}else if(url.search('team_info_page.php')>=0){
		input = '<li class="space"><a href="schedule_scores.php">Schedule and Scores</a></li><li class="space"><a href="league_leaders_page.php">League Leaders</a></li><li class="space"><a href="player_stats.php">Player Stats</a></li><li class="active space"><a href="team_info_page.php" >Team Stats</a></li>';
	}else{
		input = '<li class="space"><a href="schedule_scores.php">Schedule and Scores</a></li><li class="space"><a href="league_leaders_page.php">League Leaders</a></li><li class="space"><a href="player_stats.php">Player Stats</a></li><li class="space"><a href="team_info_page.php" >Team Stats</a></li>';
	}
	$('#main_nav').prepend(input);
});
