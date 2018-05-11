<?php $title = 'Meine Tickets - Ticketplusplus'; ?>
<?php $currentPage = 'Overview'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include('head.php'); ?>
<link rel="stylesheet" href="styles/ticketoverview.css" />
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
		<table name="ticketOverview" id="ticketOverview">
			<tr>
				<th scope="col"><button class="btn btn-link" style="background:none;border:none;" onclick="sortTktOv(0)"><b>ID</b><i class="fa fa-fw fa-sort"></i></button></th>
				<th scope="col"><button class="btn btn-link" style="background:none;border:none;" onclick="sortTktOv(1)"><b>Betreff</b><i class="fa fa-fw fa-sort"></i></button></th>
				<th scope="col"><button class="btn btn-link" style="background:none;border:none;" onclick="sortTktOv(2)"><b>Status</b><i class="fa fa-fw fa-sort"></i></button></th>
				<th scope="col"><button class="btn btn-link" style="background:none;border:none;" onclick="sortTktOv(3)"><b>Mitarbeiter</b><i class="fa fa-fw fa-sort"></i></button></th>
				<th scope="col"><button class="btn btn-link" style="background:none;border:none;" onclick="sortTktOv(4)"><b>Priorit&auml;t</b><i class="fa fa-fw fa-sort"></i></button></th>
				<th scope="col"><button class="btn btn-link" style="background:none;border:none;" onclick="sortTktOv(5)"><b>Erstellt am</b><i class="fa fa-fw fa-sort"></i></button></th>
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