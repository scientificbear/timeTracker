<?php
session_start();
//se non c'è la sessione registrata
if ($_SESSION["autorizzato"] != 1) {
    header("Location: index.php?error=unknown_user");
    exit;
}

//Altrimenti Prelevo il codice identificatico dell'utente loggato
session_start();
$logged_username = $_SESSION['logged_username']; //id cod recuperato nel file di verifica
$logged_userid = $_SESSION['logged_userid'];

?>