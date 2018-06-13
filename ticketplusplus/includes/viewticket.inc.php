<?php
include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_POST['change'])){
    if (isset($_POST['ticketid'])) {
        
    }
}
else if (isset($_POST['delete'])){
    if (isset($_POST['ticketid'])){
        $ticketid = $_POST['ticketid'];
    
        $sql = "DELETE FROM ticketplusplus.tickets WHERE ticket_id = '$ticketid'";
    
        if ($mysqli->query($sql) === TRUE) {
            header("Location: ./ticketoverview.php?filter=Alle&ftsearch=&msgid=1");
        }
        else {
            header("Location: ./ticketoverview.php?filter=Alle&ftsearch=&msgid=2&err=$sql");
        }
    }
}