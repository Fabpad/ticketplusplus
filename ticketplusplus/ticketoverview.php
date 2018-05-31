<?php $title = 'Meine Tickets - Ticketplusplus'; ?>
<?php $currentPage = 'Overview'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include('head.php'); ?>
<link rel="stylesheet" href="js/tablesorter/themes/blue/style.css" />
<link rel="stylesheet" href="styles/table.css" />

<body>
<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>
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
			<table name="ticketOverview" id="ticketOverview" class="tablesorter">
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