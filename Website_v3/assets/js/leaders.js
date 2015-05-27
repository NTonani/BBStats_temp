//called by player_stats.php and index.php to show per game/season totals
function leaderUpdate(input) {
	if(input == 'player_'){
		$('#player_').addClass("active");
		$('#team_').removeClass("active");
		$('#player_leaders').show();
		$('#team_leaders').hide();

	}
	else if(input == 'team_'){
		$('#team_').addClass("active");
		$('#player_').removeClass("active");
		$('#team_leaders').show();
		$('#player_leaders').hide();

	}

	else
		alert("an error occured");
}
function leaderUpdateShooting(input) {
	if(input == 'player_'){
		$('#player_shooting').addClass("active");
		$('#team_shooting').removeClass("active");
		$('#player_leaders_shooting').show();
		$('#team_leaders_shooting').hide();

	}
	else if(input == 'team_'){
		$('#team_shooting').addClass("active");
		$('#player_shooting').removeClass("active");
		$('#team_leaders_shooting').show();
		$('#player_leaders_shooting').hide();

	}
		
	else
		alert("an error occured");
}

function leaderUpdateGH(input) {
	if(input == 'player_'){
		$('#player_gh').addClass("active");
		$('#team_gh').removeClass("active");
		$('#player_leaders_gh').show();
		$('#team_leaders_gh').hide();

	}
	else if(input == 'team_'){
		$('#team_gh').addClass("active");
		$('#player_gh').removeClass("active");
		$('#team_leaders_gh').show();
		$('#player_leaders_gh').hide();

	}
		
	else
		alert("an error occured");
}