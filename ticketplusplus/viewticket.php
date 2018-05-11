<?php $title = 'Ihre Tickets - Ticketplusplus'; ?>
<?php $currentPage = 'View'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include('head.php'); ?>
<?php //include_once('includes/query_specifications.php'); ?> 
<body>
<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>
	
	<div class="ml-5 mt-5 col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
		<label for="txt_betreff">Betreff</label>
		<input class="form-control" id="txt_betreff" type="text" placeholder="Benutzer entsperren, Speicherplatz erweitern, PC installieren ..." aria-label="Betreff" <?php if($roleperm != 3){echo'readonly="readonly"';}?> value=
			<?php
				$id = $_GET['ticketid'];
				$stmt = "SELECT betreff FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					echo $temp;
				}
			?>
		/>
	</div>
	
	<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
		<label for="txt_beschreibung">Beschreibung</label>
		<!-- DO NOT FORMAT TEXTAREAS OR YOU GET TABS AND WHITESPACES -->
		<textarea class="form-control" id="txt_beschreibung" placeholder="Beschreibung" aria-label="Beschreibung" rows="20" style="resize:none" <?php if($roleperm != 3){echo'readonly="readonly"';}?>><?php
				$id = $_GET['ticketid'];
				$stmt = "SELECT beschreibung FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					echo $temp;
				}
			?></textarea>
	</div>
	
	<div class="ml-5 mt-3 col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 row">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="txt_user">Benutzer</label>
			<input class="form-control" type="text" id="txt_user" <?php if($roleperm != 3){echo'readonly="readonly"';}?> value=
			<?php
				$id = $_GET['ticketid'];
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
			?>
		/>
		</div>
		<div class="ml-2 col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="status_menu">Status</label>
			<select class="custom-select d-block w-100" id="status_menu" required>
				<option value=""> --- Bitte wählen --- </option>
				<?php
					$id = $_GET['ticketid'];
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
		<div class="ml-2 col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
			<label for="priority_menu">Priorität</label>
			<select class="custom-select d-block w-100" id="priority_menu" required>
				<option value=""> --- Bitte wählen --- </option>
				<?php
					$id = $_GET['ticketid'];
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
			<label for="category_menu">Kategorie</label>
			<select <?php if($roleperm != 3){echo'disabled';}?> class="custom-select d-block w-100" id="category_menu" required>
				<option < value=""> --- Bitte wählen --- </option>
				<?php
					$id = $_GET['ticketid'];
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
		<div class="ml-2 col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="specification_menu">Unterkategorie</label>
			<select <?php if($roleperm != 3){echo'disabled';}?> class="custom-select d-block w-100" id="specification_menu" required >
				<option value=""> --- Eine Kategorie wählen --- </option>
				<?php
					$id = $_GET['ticketid'];
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
					$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.specification";
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
		<textarea class="form-control" id="txt_loesung" placeholder="Lösung" aria-label="Lösung" rows="20" style="resize:none"><?php
				$id = $_GET['ticketid'];
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
		<textarea class="form-control" id="txt_notizen" placeholder="Notizen" aria-label="Notizen" rows="10" style="resize:none"><?php
				$id = $_GET['ticketid'];
				$stmt = "SELECT notizen FROM ticketplusplus.tickets WHERE ticket_id = $id";
				$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temp) = mysqli_fetch_row($result)){
					if (!empty($temp)) {
						echo $temp;
					}
				}
			?></textarea>
	</div>
	<input type="button" class="ml-5 mt-3 btn btn-secondary" id="btnSave" value="Speichern">
	<?php
		if ($roleperm == '3') {
			echo '<input type="button" class="ml-5 mt-3 btn btn-danger" id="btnDelete" value="Ticket Löschen" >';
		}
	?>
<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>
<?php include('footer.php'); ?>