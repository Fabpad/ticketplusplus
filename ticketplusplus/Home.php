<?php $title = 'Home - Ticketplusplus'; ?>
<?php $currentPage = 'Home'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include('head.php'); ?>
<body>
		<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>

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

<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>
<?php include('footer.php'); ?>