<?php
include_once 'psl-config.php';
 
function sec_session_start() {
    $session_name = 'sec_session_id';   // vergib einen Sessionnamen
    $secure = SECURE;					// Damit wird verhindert, dass JavaScript auf die session id zugreifen kann.
	$httponly = true;					
	
	// Zwingt die Sessions nur Cookies zu benutzen.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
	}
	
	// Holt Cookie-Parameter.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
		$httponly);
		
    session_name($session_name);	// Setzt den Session-Name zu oben angegebenem.
    session_start();            	// Startet die PHP-Sitzung 
    session_regenerate_id();    	// Erneuert die Session, löscht die alte. 
}

function login($email, $password, $mysqli) {

    // Das Benutzen vorbereiteter Statements verhindert SQL-Injektion.
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
        FROM users
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  	// Bind "$email" to parameter.
        $stmt->execute();    				// Führe die vorbereitete Anfrage aus.
        $stmt->store_result();
 
        // hole Variablen von result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();
 
        // hasht das Passwort mit dem eindeutigen salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {

            // Wenn es den Benutzer gibt, dann wird überprüft ob das Konto
            // blockiert ist durch zu viele Login-Versuche 
            if (checkbrute($user_id, $mysqli) == true) {
                // Konto ist blockiert
				header('Location: ../login.php?msg=2');
                return false;
            } else {
                // Überprüfe, ob das Passwort in der Datenbank mit dem vom
                // Benutzer angegebenen übereinstimmt.
                if ($db_password == $password) {
                    // Passwort ist korrekt!
                    // Hole den user-agent string des Benutzers.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS-Schutz, denn eventuell wir der Wert gedruckt
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS-Schutz, denn eventuell wir der Wert gedruckt
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
                    // Login erfolgreich.
                    return true;
                } else {
                    // Passwort ist nicht korrekt
                    // Der Versuch wird in der Datenbank gespeichert
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
									VALUES ('$user_id', '$now')");
					header('Location: ../login.php?msg=1');
                    return false;
                }
            }
        } else {
			//Es gibt keinen Benutzer.
			header('Location: ../login.php?msg=3');
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {

    // Hole den aktuellen Zeitstempel 
    $now = time();
 
    // Alle Login-Versuche der letzten zwei Stunden werden gezählt.
    $valid_attempts = $now - (0.25 * (60 * 60));
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             		FROM ticketplusplus.login_attempts
                             		WHERE user_id = ? 
                            		AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Führe die vorbereitet Abfrage aus. 
        $stmt->execute();
        $stmt->store_result();
 
        // Wenn es mehr als 5 fehlgeschlagene Versuche gab 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    // Überprüfe, ob alle Session-Variablen gesetzt sind 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Hole den user-agent string des Benutzers.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM users 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" zum Parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Führt die SQL-Query aus
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // Wenn es den Benutzer gibt, hole die Variablen von result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Eingeloggt!!!! 
                    return true;
                } else {
                    // Nicht eingeloggt
                    return false;
                }
            } else {
                // Nicht eingeloggt
                return false;
            }
        } else {
            // Nicht eingeloggt
            return false;
        }
    } else {
        // Nicht eingeloggt
        return false;
    }
}

// Funktion zum Escapen einer URL
function esc_url($url) {

    if ('' == $url) {
        return $url;
	}
	
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}

function fillTicketTable($username, $mysqli, $filterkey, $ftsearch) {
	$ftsearch = "%".$ftsearch."%";
	
	// Hole die User ID aus der Datenbank
	$stmt = "SELECT id FROM ticketplusplus.users WHERE username = '$username'";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($temp) = mysqli_fetch_row($result)){
		$userid = $temp;
    }

	// Hole die Rollen ID aus der Datenbank
    $stmt = "SELECT role_id FROM ticketplusplus.users WHERE username = '$username'";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($temp) = mysqli_fetch_row($result)){
		$role = $temp;
	}

	// Abfrage auf aktive Filter
	if($filterkey == "Warten" || $filterkey == "In Bearbeitung" || $filterkey == "Offen" || $filterkey == "Abgeschlossen"){

		// Hole die Status ID des gesetzten Filters aus der Datenbank
		$stmt = "SELECT status_id FROM ticketplusplus.status WHERE beschreibung = '$filterkey'";
		$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		while(list($temp) = mysqli_fetch_row($result)){
			$keyword = $temp;
		}

		// Falls der User "User" ist
		if ($role == 1) {

			// Speichern der SQL Abfrage mit Berücksichtigung des Suchwortes
			$stmt = "SELECT * FROM (
				SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung, tickets.notizen
				FROM ticketplusplus.tickets 
				INNER JOIN ticketplusplus.status
				INNER JOIN ticketplusplus.users
				INNER JOIN ticketplusplus.priority
				WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.user_id = '$userid' AND tickets.status_id = '$keyword'
				)AS Resulttable
				WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";

			// Ausführen der Query und Speichern des Ergebnisses in einem Array
			$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));

			// Auslesen des Arrays und Speichern in einzelnen Variablen
			while($ticket = mysqli_fetch_row($result)) {
				$ticketid = $ticket[0];
				$ticketbetreff = $ticket[1];
				$ticketstat = $ticket[2];
				$ticketerst = $ticket[3];
				$ticketprio = $ticket[4];
				$ticketdate = $ticket[5];
				
				//Auslesen des Agentennamens des jeweiligen Tickets aus der Datenbank
				$stmt2 = "SELECT users.username
					FROM ticketplusplus.users 
					INNER JOIN ticketplusplus.tickets
					WHERE tickets.agent_id = users.id AND tickets.ticket_id = '$ticketid'";
				$result2 = mysqli_query($mysqli,$stmt2) or die(mysqli_error($mysqli));
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
					$tickettech = $temp;
				}	

				// Ausgeben der ausgefüllten Tabellenzeile
				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}
		// Falls der User "Techniker" ist
		else if ($role == 2) {
			$stmt = "SELECT * FROM (
				SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung,tickets.notizen
				FROM ticketplusplus.tickets 
				INNER JOIN ticketplusplus.status
				INNER JOIN ticketplusplus.users
				INNER JOIN ticketplusplus.priority
				WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND (tickets.agent_id = '$userid' OR tickets.agent_id IS NULL) AND tickets.status_id = '$keyword'
				)AS Resulttable
				WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";
        
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
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
					$tickettech = $temp;
				}
            
				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}
		// Falls der User "Admin" ist
		else if ($role == 3) {
			$stmt = "SELECT * FROM (
					SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung,tickets.notizen
					FROM ticketplusplus.tickets 
					INNER JOIN ticketplusplus.status
					INNER JOIN ticketplusplus.users
					INNER JOIN ticketplusplus.priority
					WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.status_id = '$keyword'
					)AS Resulttable
					WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";
 
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
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
					$tickettech = $temp;
				}
            
				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}	
	}
	// Abfrage auf Filter "Alle ohne Abgeschlossen"
	else if($filterkey == "AlleoA"){

		// Hole die Status ID des gesetzten Filters aus der Datenbank
		$stmt = "SELECT status_id FROM ticketplusplus.status WHERE beschreibung = 'Abgeschlossen'";
		$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
		while(list($temp) = mysqli_fetch_row($result)){
			$keyword = $temp;
		}

		// Falls der User "User" ist
		if ($role == 1) {
			$stmt = "SELECT * FROM (
				SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung, tickets.notizen
				FROM ticketplusplus.tickets 
				INNER JOIN ticketplusplus.status
				INNER JOIN ticketplusplus.users
				INNER JOIN ticketplusplus.priority
				WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.user_id = '$userid' AND tickets.status_id != '$keyword'
				)AS Resulttable
				WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";
        
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
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
						$tickettech = $temp;
				}	

				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}
		// Falls der User "Techniker" ist
		else if ($role == 2) {
			$stmt = "SELECT * FROM (
				SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung,tickets.notizen
				FROM ticketplusplus.tickets 
				INNER JOIN ticketplusplus.status
				INNER JOIN ticketplusplus.users
				INNER JOIN ticketplusplus.priority
				WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND (tickets.agent_id = '$userid' OR tickets.agent_id IS NULL) AND tickets.status_id != '$keyword'
				)AS Resulttable
				WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";
        
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
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
					$tickettech = $temp;
				}
            
				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}
		// Falls der User "Admin" ist
		else if ($role == 3) {
			$stmt = "SELECT * FROM (
					SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung,tickets.notizen
					FROM ticketplusplus.tickets 
					INNER JOIN ticketplusplus.status
					INNER JOIN ticketplusplus.users
					INNER JOIN ticketplusplus.priority
					WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.status_id != '$keyword'
					)AS Resulttable
					WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";
 
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
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
					$tickettech = $temp;
				}
            
				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}
	}
	// Wenn kein Filter aktiv ist (Alle Tickets)
	else {
		// Falls der User "User" ist
		if ($role == 1) {
			$stmt = "SELECT * FROM (
				SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung, tickets.notizen
				FROM ticketplusplus.tickets 
				INNER JOIN ticketplusplus.status
				INNER JOIN ticketplusplus.users
				INNER JOIN ticketplusplus.priority
				WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND tickets.user_id = '$userid'
				)AS Resulttable
				WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";
		
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
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
					$tickettech = $temp;
				}

				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}
		// Falls der User "Techniker" ist
		else if ($role == 2) {
			$stmt = "SELECT * FROM (
				SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung,tickets.notizen
				FROM ticketplusplus.tickets 
				INNER JOIN ticketplusplus.status
				INNER JOIN ticketplusplus.users
				INNER JOIN ticketplusplus.priority
				WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id AND (tickets.agent_id = '$userid' OR tickets.agent_id IS NULL)
				)AS Resulttable
				WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";
 
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
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
					$tickettech = $temp;
				}
            
				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}
		// Falls der User "Admin" ist
		else if ($role == 3) {
			$stmt = "SELECT * FROM (
				SELECT tickets.ticket_id, tickets.betreff, status.beschreibung AS Stat, users.username, priority.beschreibung AS Prio, tickets.erstell_datum, tickets.beschreibung, tickets.loesung,tickets.notizen 
				FROM ticketplusplus.tickets 
                INNER JOIN ticketplusplus.status
                INNER JOIN ticketplusplus.users
                INNER JOIN ticketplusplus.priority
				WHERE tickets.user_id = users.id AND status.status_id = tickets.status_id AND priority.priority_id = tickets.priority_id
				)AS Resulttable
				WHERE ticket_id LIKE '$ftsearch' OR stat LIKE '$ftsearch' OR username LIKE '$ftsearch' OR prio LIKE '$ftsearch' OR erstell_datum LIKE '$ftsearch' OR betreff LIKE '$ftsearch' OR loesung LIKE '$ftsearch' OR notizen LIKE '$ftsearch'";
 
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
				$tickettech = "ohne Techniker";
				while(list($temp) = mysqli_fetch_row($result2)) {
					$tickettech = $temp;
				}

				echo "<tr><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketid."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketbetreff."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketstat."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketerst."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$tickettech."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketprio."</a></td><td><a href='viewticket.php?ticketid=$ticketid'>".$ticketdate."</a></td></tr>";
			}
		}
	}
}


function fillUserTable($mysqli) {
	
	// Speichern der SQL Abfrage
	$stmt = "SELECT users.id, users.username, users.email, users.vorname, users.nachname, users.telefonnummer, department.beschreibung, roles.role_name
			FROM ticketplusplus.users, ticketplusplus.roles, ticketplusplus.department
			WHERE roles.role_id = users.role_id AND department.dept_id = users.dept_id";

	// Ausführen der SQL Abfrage und speichern in einem Array
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	
	// Auslesen des Arrays und speichern in einzelnen Variablen
	while($users = mysqli_fetch_row($result)) {
		$userid = $users[0];
		$username = $users[1];
		$useremail = $users[2];
		$uservorname = $users[3];
		$usernachname = $users[4];
		$usertel = $users[5];
		$userdept = $users[6];
		$userrole = $users[7];
		
		// Ausgeben der gefüllten Tabellenzeile
		echo "<tr><td><a href='viewuser.php?userid=$userid'>".$userid."</a></td><td><a href='viewuser.php?userid=$userid'>".$username."</a></td><td><a href='viewuser.php?userid=$userid'>".$useremail."</a></td><td><a href='viewuser.php?userid=$userid'>".$uservorname."</a></td><td><a href='viewuser.php?userid=$userid'>".$usernachname."</a></td><td><a href='viewuser.php?userid=$userid'>".$usertel."</a></td><td><a href='viewuser.php?userid=$userid'>".$userdept."</a></td><td><a href='viewuser.php?userid=$userid'>".$userrole."</a></td></tr>";
	}
}