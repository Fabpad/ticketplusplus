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
	if($filterkey == "Alle"){
		echo fillTicketTable($username,$mysqli);
		return;
	}
	else {
		$stmt = "SELECT status_id FROM ticketplusplus.status WHERE beschreibung = '$filterkey'";
		$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		while(list($temp) = mysqli_fetch_row($result)){
			$keyword = $temp;
		}
	}

    if ($role == 1) {
        $stmt = "SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum 
            FROM ticketplusplus.tickets 
            INNER JOIN ticketplusplus.status
            INNER JOIN ticketplusplus.users
            INNER JOIN ticketplusplus.priority
            WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.user_id = '$userid'  AND tickets.status_id = '$keyword'";
        
        $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
        while($ticket = mysqli_fetch_row($result)) {
            $ticketid = $ticket[0];
            $ticketbetreff = $ticket[1];
            $ticketstat = $ticket[2];
            $ticketerst = $ticket[3];
            $ticketprio = $ticket[4];
            $ticketdate = $ticket[5];
            
            $stmt2 = "SELECT users.username
            FROM ticketplusplus.users 
            INNER JOIN ticketplusplus.tickets
            WHERE tickets.agent_id = users.id AND tickets.ticket_id = '$ticketid'";
            $result2 = mysqli_query($mysqli,$stmt2) or die(mysqli_error($mysqli));
            while(list($temp) = mysqli_fetch_row($result2)) {
                $tickettech = $temp;
            }

            echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
        }
    }
    else if ($role == 2) {
        $stmt = "SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum 
            FROM ticketplusplus.tickets 
            INNER JOIN ticketplusplus.status
            INNER JOIN ticketplusplus.users
            INNER JOIN ticketplusplus.priority
            WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.agent_id = '$userid'  AND tickets.status_id = '$keyword'";
        $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
        while($ticket = mysqli_fetch_row($result)) {
            $ticketid = $ticket[0];
            $ticketbetreff = $ticket[1];
            $ticketstat = $ticket[2];
            $ticketerst = $ticket[3];
            $ticketprio = $ticket[4];
            $ticketdate = $ticket[5];

            $stmt2 = "SELECT users.username
            FROM ticketplusplus.users 
            INNER JOIN ticketplusplus.tickets
            WHERE tickets.agent_id = users.id AND tickets.ticket_id = '$ticketid'";
            $result2 = mysqli_query($mysqli,$stmt2) or die(mysqli_error($mysqli));
            while(list($temp) = mysqli_fetch_row($result2)) {
                $tickettech = $temp;
            }
            
            echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
        }
    }
    else if ($role == 3) {
        $stmt = "SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum 
                FROM ticketplusplus.tickets 
                INNER JOIN ticketplusplus.status
                INNER JOIN ticketplusplus.users
                INNER JOIN ticketplusplus.priority
                WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.status_id = '$keyword'";
        $result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
        while($ticket = mysqli_fetch_row($result)) {
            $ticketid = $ticket[0];
            $ticketbetreff = $ticket[1];
            $ticketstat = $ticket[2];
            $ticketerst = $ticket[3];
            $ticketprio = $ticket[4];
            $ticketdate = $ticket[5];

            $stmt2 = "SELECT users.username
            FROM ticketplusplus.users 
            INNER JOIN ticketplusplus.tickets
            WHERE tickets.agent_id = users.id AND tickets.ticket_id = '$ticketid'";
            $result2 = mysqli_query($mysqli,$stmt2) or die(mysqli_error($mysqli));
            while(list($temp) = mysqli_fetch_row($result2)) {
                $tickettech = $temp;
            }
            
            echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
        }
    }	
}