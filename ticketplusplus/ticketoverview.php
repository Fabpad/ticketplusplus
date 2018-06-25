<?php $title = 'Meine Tickets - Ticketplusplus'; ?>
<?php $currentPage = 'Overview'; ?>
<?php include('head.php'); ?>
<link rel="stylesheet" href="js/tablesorter/themes/blue/style.css" />
<link rel="stylesheet" href="styles/table.css" />
<body>
<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>

<div>
	<?php if (isset($_GET['msgid'])) {
		if (isset($_GET['err'])) {
			$err = $_GET['err'];
		}
		if ($_GET['msgid'] == 1) {
			$message = '<div class="alert alert-success">Das Ticket wurde erfolgreich gelöscht!</div>';
		}
		else if ($_GET['msgid'] == 2) {
			$message = "<div class='alert alert-danger'>Leider ist beim Löschen des Tickets ein Fehler aufgetreten. Fehlercode: $err</div>";
		}
	}
	?>

	<?php
		if (!empty($message)) {
			echo $message;
		}
	?>
</div>

<div class="container">
	<div class="ml-2 row">

		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<select class="custom-select" name="ticketfilter" id="ticketfilter" onchange="tktTable()">
				<option id="AlleoA" <?php if($_GET['filter'] == "AlleoA"): ?> selected <?php endif; ?>>Alle Tickets (ohne Abgeschlossene)</option>
				<option id="Offen" <?php if($_GET['filter'] == "Offen"): ?> selected <?php endif; ?>>Offene Tickets</option>
				<option id="In Bearbeitung"<?php if($_GET['filter'] == "In Bearbeitung"): ?> selected <?php endif; ?>>Tickets in Bearbeitung</option>
				<option id="Warten"<?php if($_GET['filter'] == "Warten"): ?> selected <?php endif; ?>>Wartende Tickets</option>
				<option id="Abgeschlossen"<?php if($_GET['filter'] == "Abgeschlossen"): ?> selected <?php endif; ?>>Geschlossene Tickets</option>
				<option id="Alle" <?php if($_GET['filter'] == "Alle"): ?> selected <?php endif; ?>>Alle Tickets</option>
			</select>
		</div>

		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 input-group">
			<input id="searchtxt" name="searchtxt" class="form-control" type="search" value="<?php echo $_GET['ftsearch'] ?>" aria-label="Search">
			<div class="input-group-append">
				<button class="btn btn-secondary " onclick="tktTable()">Suchen</button>
			</div>
		</div>

	</div>

	</br>

	<div class="container">

		<table name="ticketOverview" id="ticketOverview" class="tablesorter {sortlist: [[0,0],[4,0]]}">
		<thead>
			<tr>
				<th>ID</th>
				<th>Betreff</th>
				<th>Status</th>
				<th>Ersteller</th>
				<th>Techniker</th>
				<th>Priorit&auml;t</th>
				<th>Erstellt am</th>
			</tr>
		</thead>	
		<tbody name="tktOvBody" id="tktOvBody">
			<?php
				fillTicketTable($user,$mysqli,$_GET['filter'],$_GET['ftsearch']);
			?>
		</tbody>
		</table>

	</div>
</div>

<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>

<?php include('footer.php'); ?>