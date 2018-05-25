<?php $title = 'Home - Ticketplusplus'; ?>
<?php $currentPage = 'Home'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
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
	<?php 
		$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.user_id WHERE tickets.status_id = 4 AND users.username = '$_SESSION[username]'";
		$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		while(list($temp) = mysqli_fetch_row($result)){
			echo $temp;
		}
	?>
	 offene(s) Ticket(s).

	<br>
	<br>

	<?php 
		$stmt = "SELECT COUNT(*) FROM ticketplusplus.tickets INNER JOIN ticketplusplus.users ON users.id=tickets.user_id WHERE tickets.status_id = 3 AND users.username = '$_SESSION[username]'";
		$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		while(list($temp) = mysqli_fetch_row($result)){
			echo $temp;
		}
	?>
	 Ticket(s) erwartet/erwarten Ihre Antwort.
</div>
<canvas id="myChart" width="400" height="400"></canvas>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>
<?php include('footer.php'); ?>