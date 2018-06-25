<?php $title = 'Ihre Tickets - Ticketplusplus'; ?>
<?php $currentPage = 'Overview'; ?>
<?php include('head.php'); ?>
<?php include_once 'includes/viewticket.inc.php'; ?> 
<body>
<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>

<?php
	$id = $_GET['ticketid'];
	$stmt = "SELECT users.username 
	FROM ticketplusplus.users, ticketplusplus.tickets
	WHERE tickets.ticket_id = $id AND tickets.user_id = users.id";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($temp) = mysqli_fetch_row($result)){
		$username = $temp;
	}

	$stmt = "SELECT users.username 
	FROM ticketplusplus.users, ticketplusplus.tickets
	WHERE tickets.ticket_id = $id AND tickets.agent_id = users.id";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($temp) = mysqli_fetch_row($result)){
		$agentname = $temp;
	}
?>

<?php if(!empty($msgid)){
        if ($msgid == 1) {
            $modalTitel = 'Erfolgreich!';
            $modalMessage = 'Das Ticket wurde erfolgreich geändert!';
        }
        else if ($msgid == 2) {
            $modalTitel = 'Upsi!';
            $modalMessage = "Leider ist beim Ändern des Tickets ein Fehler aufgetreten.";
        }
}
?>

<?php if (!empty($modalMessage)) : ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#messageModal").modal('show');
		});
	</script>
<?php endif; ?>

<!-- SUCCESS MODAL -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle"><?php if (!empty($modalTitel)){echo $modalTitel; }?></h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php if (!empty($modalMessage)){echo $modalMessage;} ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
			</div>
		</div>
	</div>
</div>
<!-- SUCCESS MODAL END -->

<form action="" method="post" name="viewticket_form">
<?php if (($roleperm == '1' && htmlentities($_SESSION['username']) == $username) || ($roleperm == '2' && htmlentities($_SESSION['username']) == $agentname) || $roleperm == '3' ) : ?>
	
	<input id="ticketid" name="ticketid" type="hidden" value="<?php echo $id ?>" />

	<div class="ml-5 mt-5 col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
		<label for="txt_betreff">Betreff</label>
		<input class="form-control" id="txt_betreff" name="txt_betreff" type="text" placeholder="Benutzer entsperren, Speicherplatz erweitern, PC installieren ..." aria-label="Betreff" <?php if($roleperm != 3){echo'readonly="readonly"';}?> value=
			"<?php
				$stmt = "SELECT betreff FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					echo $temp;
				}
			?>"
		/>
	</div>

	<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
		<label for="txt_beschreibung">Beschreibung</label>
		<!-- DO NOT FORMAT TEXTAREAS OR YOU GET TABS AND WHITESPACES -->
		<textarea class="form-control" id="txt_beschreibung" name="txt_beschreibung" placeholder="Beschreibung" aria-label="Beschreibung" rows="20" style="resize:none" <?php if($roleperm != 3){echo'readonly="readonly"';}?>><?php
				$stmt = "SELECT beschreibung FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					echo $temp;
				}
			?></textarea>
	</div>
	
	<div class="ml-5 mt-3 col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 row">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="txt_user">Anforderer</label>
			<input class="form-control" list="choose_user" type="text" id="txt_user" name="txt_user"<?php if($roleperm == 1){echo'readonly="readonly"';}?> value=
			"<?php
				$stmt = "SELECT user_id FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					$userid = $temp;
				}
				$stmt = "SELECT username FROM ticketplusplus.users WHERE id = '$userid'";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					echo $temp;
				}
			?>"
			/>
			<datalist id="choose_user">
				<?php
					//Run Query
					$stmt = "SELECT DISTINCT username, vorname, nachname FROM ticketplusplus.users";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while($agentlist = mysqli_fetch_row($result)){
						echo '<option value="'.$agentlist[0].'">'.$agentlist[2].', '.$agentlist[1].'</option>';
					}
				?>
 			</datalist>
		</div>
		<div class=" col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="status_menu">Status</label>
			<select class="custom-select d-block w-100" id="status_menu" name="status_menu" required>
				<option value=""> --- Bitte wählen --- </option>
				<?php
					$stmt = "SELECT status_id FROM ticketplusplus.tickets WHERE ticket_id = $id";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$statusid = $temp;
					}
					$stmt = "SELECT beschreibung FROM ticketplusplus.status WHERE status_id = '$statusid'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$statusname = $temp;
					}	
					$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.status";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($category) = mysqli_fetch_row($result)){
						if ($statusname === $category){
							echo '<option value="'.$category.'" selected>'.$category.'</option>';
						}
						else {
							echo '<option value="'.$category.'">'.$category.'</option>';
						}
					}
				?>
			</select>
			<div class="invalid-feedback">
				Bitte einen Status auswählen.
			</div>
		</div>
		<div class=" col-43 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="priority_menu">Priorität</label>
			<select class="custom-select d-block w-100" id="priority_menu" name="priority_menu" required>
				<option value=""> --- Bitte wählen --- </option>
				<?php
					$stmt = "SELECT priority_id FROM ticketplusplus.tickets WHERE ticket_id = $id";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$priorityid = $temp;
					}
					$stmt = "SELECT beschreibung FROM ticketplusplus.priority WHERE priority_id = '$priorityid'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$priorityname = $temp;
					}	
					$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.priority";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($category) = mysqli_fetch_row($result)){
						if ($priorityname === $category){
							echo '<option value="'.$category.'" selected>'.$category.'</option>';
						}
						else {
							echo '<option value="'.$category.'">'.$category.'</option>';
						}
					}
				?>
			</select>
			<div class="invalid-feedback">
				Bitte eine Priorität auswählen.
			</div>
		</div>
	</div>
	
	<div class="ml-5 mt-3 col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 row">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="txt_agent">Techniker</label>
			<input class="form-control" list="choose_agent" type="text" id="txt_agent" name="txt_agent" <?php if($roleperm == 1){echo'readonly="readonly"';}?> value=
			"<?php
				$stmt = "SELECT agent_id FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					$agentid = $temp;
				}
				$stmt = "SELECT username FROM ticketplusplus.users WHERE id = '$agentid'";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					echo $temp;
				}
			?>"
			/>
			<datalist id="choose_agent">
				<?php
					//Run Query
					$stmt = "SELECT DISTINCT username, vorname, nachname FROM ticketplusplus.users WHERE role_id = 2";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while($agentlist = mysqli_fetch_row($result)){
						echo '<option value="'.$agentlist[0].'">'.$agentlist[2].', '.$agentlist[1].'</option>';
					}
				?>
 			</datalist>
		</div>
		<div class=" col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="category_menu">Kategorie</label>
			<select <?php if($roleperm != 3){echo'disabled';}?> class="custom-select d-block w-100" id="category_menu" name="category_menu" required>
				<option < value=""> --- Bitte wählen --- </option>
				<?php
					$stmt = "SELECT category_id FROM ticketplusplus.tickets WHERE ticket_id = $id";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$categoryid = $temp;
					}
					$stmt = "SELECT beschreibung FROM ticketplusplus.category WHERE category_id = '$categoryid'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$categoryname = $temp;
					}	
					$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.category";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($category) = mysqli_fetch_row($result)){
						if ($categoryname === $category){
							echo '<option value="'.$category.'" selected>'.$category.'</option>';
						}
						else {
							echo '<option value="'.$category.'">'.$category.'</option>';
						}
					}
				?>
			</select>
			<div class="invalid-feedback">
				Bitte eine Kategorie auswählen.
			</div>
		</div>
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="specification_menu">Unterkategorie</label>
			<select <?php if($roleperm != 3){echo'disabled';}?> class="custom-select d-block w-100" id="specification_menu" name="specification_menu" required >
				<option value=""> --- Eine Kategorie wählen --- </option>
				<?php
					$stmt = "SELECT specification_id FROM ticketplusplus.tickets WHERE ticket_id = $id";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$specificationid = $temp;
					}
					$stmt = "SELECT beschreibung FROM ticketplusplus.specification WHERE specification_id = '$specificationid'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$specificationname = $temp;
					}	
					$stmt = "SELECT specification.beschreibung 
							FROM ticketplusplus.specification
							WHERE specification.category_id = $categoryid";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($category) = mysqli_fetch_row($result)){
						if ($specificationname === $category){
							echo '<option value="'.$category.'" selected>'.$category.'</option>';
						}
						else {
							echo '<option value="'.$category.'">'.$category.'</option>';
						}
					}
				?> 
			</select>
			<div class="invalid-feedback">
				Bitte eine Unterkategorie auswählen.
			</div>
		</div>
	</div>
	
	<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
		<label for="txt_loesung">Lösung</label>
		<!-- DO NOT FORMAT TEXTAREAS OR YOU GET TABS AND WHITESPACES -->
		<textarea class="form-control" id="txt_loesung" name="txt_loesung" placeholder="Lösung" aria-label="Lösung" rows="20" style="resize:none" <?php if($roleperm ==1){echo'readonly="readonly"';}?>><?php
				$stmt = "SELECT loesung FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					if (!empty($temp)) {
						echo $temp;
					}	
				}
			?></textarea>
	</div>
	
	<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
		<label for="txt_notizen">Notizen</label>
		<!-- DO NOT FORMAT TEXTAREAS OR YOU GET TABS AND WHITESPACES -->
		<textarea class="form-control" id="txt_notizen" name="txt_notizen" placeholder="Notizen" aria-label="Notizen" rows="10" style="resize:none"><?php
				$stmt = "SELECT notizen FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					if (!empty($temp)) {
						echo $temp;
					}
				}
			?></textarea>
	</div>

	<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
		<button type="button" class="btn btn-secondary" id="btnSave" value="Change" onclick="return changeticket(	this.form, 
																																this.form.ticketid.value, 
																																this.form.txt_betreff.value, 
																																this.form.txt_beschreibung.value, 
																																this.form.txt_user.value, 
																																this.form.txt_agent.value, 
																																this.form.status_menu.value, 
																																this.form.priority_menu.value, 
																																this.form.category_menu.value, 
																																this.form.specification_menu.value,
																																this.form.txt_loesung.value,
																																this.form.txt_notizen.value);">
			Änderungen speichern
		</button>
		<?php
			if ($roleperm == '3') {
				echo '<button type="button" class="btn btn-danger ml-3" value="Löschen" data-toggle="modal" data-target="#deleteModal">Löschen</button>';
			}
		?>
	</div>

	<!-- DELETE MODAL START -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalTitle2">Löschen bestätigen</h5>
					<button type="button" class="close" data-dismiss="modal">
						<span>&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Wollen Sie das Ticket wirklich Löschen?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" value="Delete" onclick="return deleteticket(this.form, this.form.ticketid.value);">Löschen</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
				</div>
			</div>
		</div>
	</div>
	<!-- DELETE MODAL END -->

</form>

<?php else : ?>
				<p>
					<span class="error">Sie sind nicht berechtigt dieses Ticket anzusehen.</span> Zurück zu <a href="ticketoverview.php">meinen Tickets</a>.
				</p>	
<?php endif; ?>

<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>

<?php include('footer.php'); ?>