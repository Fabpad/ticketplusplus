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

<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>
<?php include('footer.php'); ?>