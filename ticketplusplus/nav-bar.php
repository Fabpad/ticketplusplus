		<nav class="navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand" href="home.php">Ticket ++</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item <?php if ($currentPage === 'Home') {echo 'active';} ?>">
						<a class="nav-link" href="home.php">Startseite<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item <?php if ($currentPage === 'New') {echo 'active';} ?>">
						<a class="nav-link" href="createticket.php">Neues Ticket</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Meine Tickets
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="viewticket.php">alle Tickets</a>
							<a class="dropdown-item" href="viewticket.php">offene Tickets</a>
							<a class="dropdown-item" href="viewticket.php">geschlossene Tickets</a>
							<a class="dropdown-item" href="viewticket.php">wartende Tickets</a>
						</div>
					</li>
					<li class="nav-item <?php if ($currentPage === 'Register') {echo 'active';} ?>">
						<a class="nav-link" href="register.php">Register</a>
					</li>
				</ul>
				<form class="form-inline my-2 my-lg-0">
					<div class="input-group">
						<input class="form-control" type="search" placeholder="" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-secondary " type="submit">Suchen</button>
						</div>
					</div>
				</form>
				<div class="dropdown ml-5">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="background-color:#ffb516">
						<span class="fas fa-user" aria-hidden="true"> </span>
						<?php echo htmlentities($_SESSION['username']); ?>
						<span class="caret"> </span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li><span class="fas fa-cog" aria-hidden="true"></span><a href="accview.php">  Konto</a></li>
						<li role="separator" class="dropdown-divider"></li>
						<li><span class="fas fa-power-off" aria-hidden="true"></span><a href="includes/logout.php">  Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>