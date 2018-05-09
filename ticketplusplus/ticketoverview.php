<?php $title = 'Meine Tickets - Ticketplusplus'; ?>
<?php $currentPage = 'Overview'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include('head.php'); ?>
<body>
<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>

	<div class="container">
		<div class="ml-8 col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<select class="custom-select">
				<option selected>Alle Tickets</option>
				<option>Offene Tickets</option>
				<option>Tickets in Bearbeitung</option>
				<option>Wartende Tickets</option>
				<option>Geschlossene Tickets</option>
			</select>
		</div>
	</div>

	<br>

	<div class="container">
		<table>
			<tr>
				<th>ID</th>
				<th>Betreff</th>
				<th>Status</th>
				<th>Mitarbeiter</th>
				<th>Priorit&auml;t</th>
				<th>Erstellt am</th>
			</tr>
			<?php
				fillTicketTable(htmlentities($_SESSION['username']), $mysqli);
			?>
		</table>
	</div>

<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>
<?php include('footer.php'); ?>