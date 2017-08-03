<?php include "header.php"; ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


</head>
<body>
<h1><a href="home.php">Time Tracking MBT</a></h1>
<br/>

<h2>Inserisci azienda</h2>

<p style="color:red">davvero <b>sicuro</b> che non sia gi&agrave in anagrafica?</p>

<?php
// se ho premuto "add", dunque se ho già inserito i dati
if(isset($_POST['add'])) {
    //Connessione database

    include 'connessione.php';
        
    // controlla la presenza di particolari caratteri nella stringa, che in caso vanno corretti con un / davanti
    if(! get_magic_quotes_gpc() ) {
        $rag_sociale = addslashes($_POST['rag_sociale']);
    }else {
        $rag_sociale = $_POST['rag_sociale'];
    }
    

	$sql = "INSERT INTO aziende (rag_sociale) VALUES ('$rag_sociale')";

	if ($conn->query($sql) === TRUE) {
      $last_id = mysqli_insert_id($conn);
	    echo "Nuova azienda aggiunta con successo. <a href='home.php'>Torna alla home.</a> oppure <a href='vedi_singola_azienda.php?id_azienda=$last_id'>vedi quanto inserito</a>";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();

}else { //altrimenti, nel caso in cui dunque io debba ancora inserire valori nel form
    include 'connessione.php';
    ?>
    
    <form method = "post" action = "<?php $_PHP_SELF ?>">
        <table width = "400" border = "0" cellspacing = "1"
        cellpadding = "2">
        
        <tr>
            <td width = "100">Ragione sociale</td>
            <td> <!-- qui si aspetta il testo vero e proprio -->
                <input type="text" name="rag_sociale">
            </td>
        </tr>
        <tr>
            <td width = "100"> </td>
            <td> <!-- qui crea il bottone aggiungi-->
                <input name = "add" type = "submit" value = "Aggiungi registrazione">
            </td>
        </tr>
        
    </table>
</form>

<?php
}
?>



<?php include "footer.php"; ?> 