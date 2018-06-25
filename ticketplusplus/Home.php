<?php $title = 'Home - Ticketplusplus'; ?>
<?php $currentPage = 'Home'; ?>
<?php include('head.php'); ?>
<body>
<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>


<div class="container">
	<h5>Hallo 
	<?php 
		$stmt = "SELECT vorname FROM ticketplusplus.users WHERE users.username = '$_SESSION[username]'";
		$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		while(list($temp) = mysqli_fetch_row($result)){
			echo "$temp ";
		}
		$stmt2 = "SELECT nachname FROM ticketplusplus.users WHERE users.username = '$_SESSION[username]'";
		$result2 = mysqli_query($mysqli,$stmt2) or die(mysqli_error($mysqli));
		while(list($temp2) = mysqli_fetch_row($result2)){
			echo $temp2;
		}
	?>
	</h5>
	<br>

	Sie haben 
	<?php if($roleperm == 1) : ?>
		<?php 
			$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.user_id WHERE tickets.status_id = 4 AND users.username = '$_SESSION[username]'";
			$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
			while(list($temp) = mysqli_fetch_row($result)){
				$openTicketsUser = $temp;
				echo $temp;
			}
		?>
	<?php else : ?>
		<?php 
			$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.agent_id WHERE tickets.status_id = 4 AND users.username = '$_SESSION[username]'";
			$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
			while(list($temp) = mysqli_fetch_row($result)){
				$openTicketsUser = $temp;
				echo $temp;
			}
		?>
	<?php endif; ?>
	 offene(s) Ticket(s).

	<br>
	<br>

	<?php if($roleperm == 1) : ?>
		<?php 
			$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.user_id WHERE tickets.status_id = 3 AND users.username = '$_SESSION[username]'";
			$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
			while(list($temp) = mysqli_fetch_row($result)){
				$waitTicketsUser = $temp;
				echo $temp; 
			}
		?>
	<?php else : ?>
		<?php 
			$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.agent_id WHERE tickets.status_id = 3 AND users.username = '$_SESSION[username]'";
			$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
			while(list($temp) = mysqli_fetch_row($result)){
				$waitTicketsUser = $temp;
				echo $temp; 
			}
		?>
	<?php endif; ?>
	 Ticket(s) erwartet/erwarten Ihre Antwort.

	<br>
	<br>

	<div class="row">
	
		<?php if($roleperm == 1) : ?>
			<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<label for="tktOvPieChartYou">Ticketübersicht (Sie)</label>
				<canvas id="tktOvPieChartYou"></canvas>
				<?php
					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.user_id WHERE tickets.status_id = 2 AND users.username = '$_SESSION[username]'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$workTicketsUser = $temp;
					}

					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.user_id WHERE tickets.status_id = 3 AND users.username = '$_SESSION[username]'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$waitTicketsUser = $temp;
					}

					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.user_id WHERE tickets.status_id = 4 AND users.username = '$_SESSION[username]'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$openTicketsUser = $temp;
					}
					
					echo "<script>
					var ctx = document.getElementById(\"tktOvPieChartYou\").getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'pie',
						data: {
						labels: [\"Offen\", \"In Bearbeitung\", \"Warten\"],
							datasets: [{
								data: [$openTicketsUser, $workTicketsUser, $waitTicketsUser],
								backgroundColor: [
									'rgba(255, 99, 132, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(255, 206, 86, 1)'
								],
								borderWidth: 1
							}]
						}
					});
					</script>";
				?>
			</div>
		<?php else : ?>
			<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<label for="tktOvPieChartYou">Ticketübersicht (Sie)</label>
				<canvas id="tktOvPieChartYou"></canvas>
				<?php
					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.agent_id WHERE tickets.status_id = 2 AND users.username = '$_SESSION[username]'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$workTicketsUser = $temp;
					}

					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.agent_id WHERE tickets.status_id = 3 AND users.username = '$_SESSION[username]'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$waitTicketsUser = $temp;
					}

					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.agent_id WHERE tickets.status_id = 4 AND users.username = '$_SESSION[username]'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$openTicketsUser = $temp;
					}
					
					echo "<script>
					var ctx = document.getElementById(\"tktOvPieChartYou\").getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'pie',
						data: {
						labels: [\"Offen\", \"In Bearbeitung\", \"Warten\"],
							datasets: [{
								data: [$openTicketsUser, $workTicketsUser, $waitTicketsUser],
								backgroundColor: [
									'rgba(255, 99, 132, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(255, 206, 86, 1)'
								],
								borderWidth: 1
							}]
						}
					});
					</script>";
				?>
			</div>		
		<?php endif; ?>

		<?php if($roleperm == 2 || $roleperm == 3) : ?>
			<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<label for="tktOvPieChartAll">Ticketübersicht (Gesamt)</label>
				<canvas id="tktOvPieChartAll"></canvas>
				<?php
					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets WHERE tickets.status_id = 3";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$waitTicketsAll = $temp;
					}

					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets WHERE tickets.status_id = 4";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$openTicketsAll = $temp;
					}

					$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets WHERE tickets.status_id = 2";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$workTicketsAll = $temp;
					}
					
					echo "<script>
					var ctx = document.getElementById(\"tktOvPieChartAll\").getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'pie',
						data: {
						labels: [\"Offen\", \"In Bearbeitung\", \"Warten\"],
							datasets: [{
								data: [$openTicketsAll, $workTicketsAll, $waitTicketsAll],
								backgroundColor: [
									'rgba(255, 99, 132, 1)',
									'rgba(54, 162, 235, 1)',
									'rgba(255, 206, 86, 1)'
								],
								borderWidth: 1
							}]
						}
					});
					</script>";
				?>
			</div>					
		<?php endif; ?>

	</div>
</div>

<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>

<?php include('footer.php'); ?>