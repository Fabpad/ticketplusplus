        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded navbar-light sidebar">
			<div class="container">
                <ul class="nav navbar-nav nav-pills flex-column">
					<li class="nav-item <?php if ($currentPage === 'administration') {echo 'active';} ?>">
						<a class="nav-link" href="administration.php">Userverwaltung<span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item <?php if ($currentPage === 'Register') {echo 'active';} ?>">
						<a class="nav-link" href="register.php">Neuen User anlegen</a>
					</li>
					<li class="nav-item <?php if ($currentPage === '?????') {echo 'active';} ?>">
						<a class="nav-link" href="#">????</a>
					</li>
				</ul>
			</div>
		</nav>