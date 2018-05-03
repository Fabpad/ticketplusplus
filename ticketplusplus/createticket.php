<?php $title = 'Neues Ticket - Ticketplusplus'; ?>
<?php $currentPage = 'New'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include_once 'includes/createticket.inc.php';?>
<?php include('head.php'); ?>
<body>
		<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>
<?php
        if (!empty($$message)) {
            echo $$message;
        }
        ?>
	<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="createticket_form">
		<div class="ml-5 mt-5 col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<label for="txt_betreff">Betreff</label>
			<input class="form-control" id="txt_betreff" name="betreff" type="text" placeholder="Benutzer entsperren, Speicherplatz erweitern, PC installieren ..." aria-label="Betreff" />
		</div>
		
		<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
			<label for="txt_beschreibung">Beschreibung</label>
			<textarea class="form-control" id="txt_beschreibung" name="beschreibung" placeholder="Beschreibung" aria-label="Beschreibung" rows="20" style="resize:none"></textarea>
		</div>
		
		<div class="ml-5 mt-3 col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 row">
			<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
				<label for="txt_user">Benutzer</label>
				<input class="form-control" type="text" id="txt_user" name="user">
			</div>
			<div class="ml-2 col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
				<label for="status_menu">Status</label>
				<select class="custom-select d-block w-100" id="status_menu" name="status_menu" required>
					<option value=""> --- Bitte wählen --- </option>
					<?php
						//Run Query
						$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.status";
						$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
						while(list($category) = mysqli_fetch_row($result)){
							echo '<option value="'.$category.'">'.$category.'</option>';
						}
					?>
				</select>
				<div class="invalid-feedback">
					Bitte einen Status auswählen.
				</div>
			</div>
			<div class="ml-2 col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
				<label for="priority_menu">Priorität</label>
				<select class="custom-select d-block w-100" id="priority_menu" name="priority_menu" required>
					<option value=""> --- Bitte wählen --- </option>
					<?php
						//Run Query
						$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.priority";
						$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
						while(list($category) = mysqli_fetch_row($result)){
							echo '<option value="'.$category.'">'.$category.'</option>';
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
				<select class="custom-select d-block w-100" id="category_menu" name="category_menu" required>
					<option value=""> --- Bitte wählen --- </option>
					<?php
						//Run Query
						$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.category";
						$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
						while(list($category) = mysqli_fetch_row($result)){
							echo '<option value="'.$category.'">'.$category.'</option>';
						}
					?>
				</select>
				<div class="invalid-feedback">
					Bitte eine Kategorie auswählen.
				</div>
			</div>
			<div class="ml-2 col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
				<label for="specification_menu">Unterkategorie</label>
				<select class="custom-select d-block w-100" id="specification_menu" name="specification_menu" required>
					<option value=""> --- Eine Kategorie wählen --- </option>
				</select>
				<div class="invalid-feedback">
					Bitte eine Unterkategorie auswählen.
				</div>
			</div>
		</div>
		<input type="button" class="ml-5 mt-3 btn btn-secondary" id="submit_ticket" value="Ticket anlegen" onclick="return createnewticket(	this.form, 
																																			this.form.betreff, 
																																			this.form.beschreibung, 
																																			this.form.user, 
																																			this.form.status_menu.value, 
																																			this.form.priority_menu.value,
																																			this.form.category_menu.value,
																																			this.form.specification_menu.value)">
	</form>
	
<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>
<?php include('footer.php'); ?>