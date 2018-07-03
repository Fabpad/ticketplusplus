<?php $title = 'Administration - Ticketplusplus'; ?>
<?php $currentPage = 'administration'; ?>
<?php include('head.php'); ?>
<link rel="stylesheet" href="js/tablesorter/themes/blue/style.css" />
<link rel="stylesheet" href="styles/table.css" />
<body>
<?php if (login_check($mysqli) == true) : ?>
<?php if ($roleperm == 3): ?>
<?php include('nav-bar.php'); ?>
<?php include('nav-bar-admin.php'); ?>

<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
	<div class="container-fluid">
        <div class="row">

            <?php if (isset($_GET['msgid'])) {
                if (isset($_GET['err'])) {
                    $err = $_GET['err'];
                }
                if ($_GET['msgid'] == 1) {
                    $message = '<div class="alert alert-success">Der User wurde erfolgreich gelöscht!</div>';
                }
                else if ($_GET['msgid'] == 2) {
                    $message = "<div class='alert alert-danger'>Leider ist beim Ändern des Users ein Fehler aufgetreten. Fehlercode: $err</div>";
                }
            }
            ?>

            <?php
                if (!empty($message)) {
                    echo $message;
                }
            ?>
            
            <table name="ticketOverview" id="ticketOverview" class="tablesorter {sortlist: [[0,0]]}">
                <thead class="blacktext">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Vorname</th>
                        <th>Nachname</th>
                        <th>Telefonnummer</th>
                        <th>Abteilung</th>
                        <th>Rolle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        fillUserTable($mysqli);
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</main>

<?php else : ?>
	<p>
		<span class="error">Sie haben nicht die Berechtigung diese Seite aufzurufen. <a href="home.php">Zurück zur Startseite</a>.
	</p>
<?php endif; ?>

<?php else : ?>
	<p>
		<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
	</p>
<?php endif; ?>

<?php include('footer.php'); ?>