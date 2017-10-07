<?php
session_start(); //inizio la sessione
//includo i file necessari a collegarmi al db con relativo script di accesso
include("connessione.php");

//variabili POST con anti sql Injection
$username=mysqli_real_escape_string($conn, $_POST['username']); //faccio l'escape dei caratteri dannosi
$password=mysqli_real_escape_string($conn, sha1($_POST['password'])); //sha1 cifra la password anche qui in questo modo corrisponde con quella del db

 $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password' ";
 $ris = mysqli_query($conn, $query) or die (mysqli_error($conn));
 $riga=mysqli_fetch_array($ris);

/*Prelevo l'identificativo dell'utente */
$logged_username=$riga['username'];
$logged_userid=$riga['id_utente'];

/* Effettuo il controllo */
if ($logged_username == NULL) $trovato = 0 ;
else $trovato = 1;

/* Username e password corrette */
if($trovato === 1) {

 /*Registro la sessione*/

  $_SESSION["autorizzato"] = 1;

  /*Registro il logged_usernameice dell'utente*/
  $_SESSION['logged_username'] = $logged_username;
  $_SESSION['logged_userid'] = $logged_userid;


 /*Redirect alla pagina riservata*/
   echo '<script language=javascript>document.location.href="home.php"</script>';

} else {

/*Username e password errati, redirect alla pagina di login*/
 echo '<script language=javascript>document.location.href="index.php?error=wrong_credential"</script>';

}
?>