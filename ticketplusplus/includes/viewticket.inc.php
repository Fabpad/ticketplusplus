<?php
include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_POST['change'])){
    if (isset($_POST['ticketid'], $_POST['txt_betreff'], $_POST['txt_beschreibung'], $_POST['txt_user'], $_POST['txt_agent'], $_POST['status_menu'], $_POST['priority_menu'], $_POST['category_menu'], $_POST['specification_menu'], $_POST['txt_loesung'], $_POST['txt_notizen'])) {
        $ticketid = $_POST['ticketid'];
        $betreff =  filter_input(INPUT_POST, 'txt_betreff', FILTER_SANITIZE_STRING);
        $beschreibung =  filter_input(INPUT_POST, 'txt_beschreibung', FILTER_SANITIZE_STRING);

        $username = filter_input(INPUT_POST, 'txt_user', FILTER_SANITIZE_STRING);
        $stmt = "SELECT id FROM ticketplusplus.users WHERE username = '$username'";
        $result = mysqli_query($mysqli,$stmt) or die($mysqli);
        while(list($temp) = mysqli_fetch_row($result)) {
            $userID = $temp;
        }

        $agentname = filter_input(INPUT_POST, 'txt_agent', FILTER_SANITIZE_STRING);
        $stmt = "SELECT id FROM ticketplusplus.users WHERE username = '$agentname'";
        $result = mysqli_query($mysqli,$stmt) or die($mysqli);
        while(list($temp) = mysqli_fetch_row($result)) {
            $agentID = $temp;
        }

        $statusname = $_POST['status_menu'];
        $stmt = "SELECT status_id FROM ticketplusplus.status WHERE beschreibung = '$statusname'";
        $result = mysqli_query($mysqli,$stmt) or die($mysqli);
        while(list($temp) = mysqli_fetch_row($result)) {
            $statusID = $temp;
        }

        $priorityname = $_POST['priority_menu'];
        $stmt = "SELECT priority_id FROM ticketplusplus.priority WHERE beschreibung = '$priorityname'";
        $result = mysqli_query($mysqli,$stmt) or die($mysqli);
        while(list($temp) = mysqli_fetch_row($result)) {
            $priorityID = $temp;
        }

        $categoryname = $_POST['category_menu'];
        $stmt = "SELECT category_id FROM ticketplusplus.category WHERE beschreibung = '$categoryname'";
        $result = mysqli_query($mysqli,$stmt) or die($mysqli);
        while(list($temp) = mysqli_fetch_row($result)) {
            $categoryID = $temp;
        }

        $specificationsname = $_POST['specification_menu'];
        $stmt = "SELECT specification_id FROM ticketplusplus.specification WHERE beschreibung = '$specificationsname'";
        $result = mysqli_query($mysqli,$stmt) or die($mysqli);
        while(list($temp) = mysqli_fetch_row($result)) {
            $specificationsID = $temp;
        }

        $loesung =  filter_input(INPUT_POST, 'txt_loesung', FILTER_SANITIZE_STRING);
        $notizen =  filter_input(INPUT_POST, 'txt_notizen', FILTER_SANITIZE_STRING);


        $sql = "UPDATE ticketplusplus.tickets
                SET betreff = '$betreff', beschreibung = '$beschreibung', user_id = '$userID', agent_id = '$agentID', status_id = '$statusID', priority_id = '$priorityID', category_id = '$categoryID', specification_id = '$specificationsID', loesung = '$loesung', notizen = '$notizen' 
                WHERE ticket_id = $ticketid";
            
        if ($mysqli->query($sql) === TRUE) {
            $msgid= 1 ;
        }
        else {
            $msgid= 2 ;
        }
    }
}
else if (isset($_POST['deleteinput'])){
    if (isset($_POST['ticketid'])){
        $ticketid = $_POST['ticketid'];
    
        $sql = "DELETE FROM ticketplusplus.tickets WHERE ticket_id = '$ticketid'";
    
        if ($mysqli->query($sql) === TRUE) {
            echo "<script>
            window.location.href = './ticketoverview.php?filter=Alle&ftsearch=&msgid=1';
            </script>";
        }
        else {
            echo "<script>
            window.location.href = './ticketoverview.php?filter=Alle&ftsearch=&msgid=2&err=$sql';
            </script>";
        }
    }
}