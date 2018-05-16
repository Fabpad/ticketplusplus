<?php
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();

if (isset($_POST['filter'])){
	$username = htmlentities($_SESSION['username']);
	$filterkey = $_POST['filter'];
	
	$stmt = "SELECT id FROM ticketplusplus.users WHERE username = '$username'";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($temp) = mysqli_fetch_row($result)){
		$userid = $temp;
    }

    $stmt = "SELECT role_id FROM ticketplusplus.users WHERE username = '$username'";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($temp) = mysqli_fetch_row($result)){
		$role = $temp;
    }
	
	$stmt = "SELECT status_id FROM ticketplusplus.status WHERE beschreibung = '$filterkey'";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($temp) = mysqli_fetch_row($result)){
		$keyword = $temp;
	}

    if ($role == 1) {
        $stmt = "SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum 
				FROM ticketplusplus.tickets, ticketplusplus.status, ticketplusplus.users, ticketplusplus.priority
				WHERE users.id = '$userid' AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.user_id = '$userid' AND tickets.status_id = 'keyword'"; 
	    $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	    while($ticket = mysqli_fetch_row($result)) {
			$ticketid = $ticket[0];
			$ticketbetreff = $ticket[1];
			$ticketstat = $ticket[2];
			$ticketma = $ticket[3];
			$ticketprio = $ticket[4];
			$ticketdate = $ticket[5];
			
			echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketma."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
	    }	
    }
    else if ($role == 2) {
        $stmt = "SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum 
				FROM ticketplusplus.tickets, ticketplusplus.status, ticketplusplus.users, ticketplusplus.priority
				WHERE users.id = '$userid' AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.agent_id = users.id  AND tickets.status_id = 'keyword'"; 
	    $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	    while($ticket = mysqli_fetch_row($result)) {
			$ticketid = $ticket[0];
			$ticketbetreff = $ticket[1];
			$ticketstat = $ticket[2];
			$ticketma = $ticket[3];
			$ticketprio = $ticket[4];
			$ticketdate = $ticket[5];
			
			echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketma."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
	    }	
    }
    else if ($role == 3) {
        $stmt = "SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum 
				FROM ticketplusplus.tickets, ticketplusplus.status, ticketplusplus.users, ticketplusplus.priority
				WHERE users.id = '$userid' AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id  AND tickets.status_id = 'keyword'";
	    $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	    while($ticket = mysqli_fetch_row($result)) {
			$ticketid = $ticket[0];
			$ticketbetreff = $ticket[1];
			$ticketstat = $ticket[2];
			$ticketma = $ticket[3];
			$ticketprio = $ticket[4];
			$ticketdate = $ticket[5];
			
			echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketma."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
	    }	
    }
}
?>