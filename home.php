<?php include "header.php"; ?>

</head>
<body>
<h1><a href="home.php">Time Tracking MBT</a></h1>
<br/>

<?php echo "<p>Ciao ".$logged_username." (userid: ".$logged_userid.")!</p>"; ?>
<p>Seleziona un'opzione:<ul>
<li><a href="inserisci_operazione.php">Aggiungi registrazione</a></li>
<li><a href="vedi_operazioni.php">Vedi tutte le tue registrazioni</a></li>
<li><a href="vedi_aziende.php">Vedi aziende</a></li>
<li><a href="inserisci_azienda.php">Aggiungi azienda</a></li>
</ul>
</p>
<br>
<p><a href="logout.php">logout</a></p>
<br>
<h2>Registrazioni di oggi</h2>
<?php
    
    // Connessione Database mysql
    include 'connessione.php';

    $sql = "SELECT * FROM operazioni where giorno=CURRENT_DATE() and id_utente='$logged_userid' ORDER BY id_operazione"; // Query di ricerca
    $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca

    if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
       die('Could not get data: ' . mysqli_error($conn));
    }

    // inizio a stampare la tabella a video
    echo '<table border cellpadding=3>';
    // intestazione
    echo "<tr><th>id</th><th>data</th><th>azienda</th><th>tempo</th><th>operazioni</th></tr>";

    // corpo tabella (<tr> inizia una riga, <th> inizia una cella)
    while($row = mysqli_fetch_assoc($retval)) {
//      $sql_ind = "SELECT indirizzo FROM indirizzi WHERE id_indirizzo=".$row['id_indirizzo_richiesta'];
      $retval_azienda = mysqli_query( $conn, "SELECT rag_sociale FROM aziende WHERE id_azienda=".$row['id_azienda'] );
      $rag_sociale_azienda = mysqli_fetch_assoc($retval_azienda);
      $ore_operazione = floor($row['minuti'] /  60);
      $minuti_operazione = $row['minuti'] % 60;
      echo "<tr><th>{$row['id_operazione']}</th>".
      "<th>{$row['giorno']}</th>".
      "<th>{$rag_sociale_azienda['rag_sociale']}</th>".
      "<th>$ore_operazione h $minuti_operazione min </th>".
      "<th><a href='modifica_operazione.php?id_operazione=".$row['id_operazione']."'>modifica</a> <a href='elimina_operazione.php?id_operazione=".$row['id_operazione']."'>elimina</a></th>".
      "</tr>";
   }
    echo "</table>";
    mysqli_free_result($retval);

    // chiudo connessione con database
    mysqli_close($conn);
 ?>

<?php include "footer.php"; ?>