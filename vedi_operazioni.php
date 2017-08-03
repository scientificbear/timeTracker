<?php include "header.php"; ?>

</head>
<body>
<h1><a href="home.php">Time Tracking MBT</a></h1>
<br/>
<h2>Elenco tue operazioni</h2>

<?php
    
    // Connessione Database mysql
    include 'connessione.php';

    $sql = "SELECT * FROM operazioni where id_utente='$logged_userid' ORDER BY id_operazione"; // Query di ricerca
    $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca

    if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
       die('Could not get data: ' . mysqli_error($conn));
    }

    // inizio a stampare la tabella a video
    echo '<table border cellpadding=3>';
    // intestazione
    echo "<tr><th>id</th><th>data</th><th>azienda</th><th>utente</th><th>tempo</th><th>operazioni</th></tr>";

    // corpo tabella (<tr> inizia una riga, <th> inizia una cella)
    while($row = mysqli_fetch_assoc($retval)) {
//      $sql_ind = "SELECT indirizzo FROM indirizzi WHERE id_indirizzo=".$row['id_indirizzo_richiesta'];
      $retval_azienda = mysqli_query( $conn, "SELECT rag_sociale FROM aziende WHERE id_azienda=".$row['id_azienda'] );
      $rag_sociale_azienda = mysqli_fetch_assoc($retval_azienda);
      $retval_utente = mysqli_query( $conn, "SELECT username FROM login WHERE id_utente=".$row['id_utente'] );
      $nome_utente = mysqli_fetch_assoc($retval_utente);
      $ore_operazione = floor($row['minuti'] /  60);
      $minuti_operazione = $row['minuti'] % 60;
      echo "<tr><th>{$row['id_operazione']}</th>".
      "<th>{$row['giorno']}</th>".
      "<th>{$rag_sociale_azienda['rag_sociale']}</th>".
      "<th>{$nome_utente['username']}</th>".
      "<th>$ore_operazione h $minuti_operazione min </th>".
      "<th><a href='home.php?id=".$row['id_operazione']."'>modifica (da fare)</a></th>".
      "</tr>";
   }
    echo "</table>";
    mysqli_free_result($retval);

    // chiudo connessione con database
    mysqli_close($conn);
 ?>

 <h2>In futuro</h2>
 <ul>
 	<li>possibilità scegliere utente</li>
 	<li>possibilità scegliere periodo temporale</li>
 	<li>possibilità scegliere azienda</li>
 	<li>possibilità esportare risultati?</li>
 </ul>

<?php include "footer.php"; ?>  