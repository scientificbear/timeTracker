<?php
session_start();
$_SESSION = array();
session_destroy(); //distruggo tutte le sessioni

//ritorno a index.php usando GET posso recuperare e stampare a schermo il messaggio di avvenuto logout
header("location: index.php?error=logout");
exit();
?>