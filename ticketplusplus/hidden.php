<?php $title = 'Hidden - Ticketplusplus'; ?>
<?php $currentPage = 'Hidden'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include('head.php'); ?>
<body>
<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>


<img src="assets/gif.gif" alt="Gif" style="width:480px;height:480px;">

<embed src="assets/music.mp3" width="180" height="90" loop="true" autostart="true" hidden="true" />
	
<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>
<?php include('footer.php'); ?>