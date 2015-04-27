<html lan='en'>
<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href = "boxscore.css">
		<script type="text/javascript"> function showModal(input){
			$('.modal-body').empty();

			$.ajax({
				url: 'boxscore_test.php',
				data: {'game': input},
				type: "POST",
				success: function(data){
					$('.modal-body').append(data);
				}


			});
			$('#login_modal').modal('show');
		} </script>
		<script type="text/javascript">
		function
		</script>
		<div class="container-fluid">
			<button id="1" onclick="showModal(1)">Push1</button>
			<button id="2" onclick="showModal(2)">Push2</button>
			<button id="3" onclick="showModal(3)">Push3</button>
		</div>
	    <!-- Modal HTML -->
    <div id="login_modal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Boxscore</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</html>