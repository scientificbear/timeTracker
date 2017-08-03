<?php include "header.php"; ?>

</head>
<body>
<h1><a href="home.php">Time Tracking MBT</a></h1>
<br/>
<h2>Elenco aziende</h2>

<?php
    
    // Connessione Database mysql
    include 'connessione.php';

    $sql = "SELECT * FROM aziende ORDER BY rag_sociale"; // Query di ricerca
    $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca

    if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
       die('Could not get data: ' . mysqli_error($conn));
    }

    // inizio a stampare la tabella a video
    echo '<table border cellpadding=3>';
    // intestazione
    echo "<tr><th>id</th><th>ragione sociale</th><th></th></tr>";

    // corpo tabella (<tr> inizia una riga, <th> inizia una cella)
    while($row = mysqli_fetch_assoc($retval)) {
//      $sql_ind = "SELECT indirizzo FROM indirizzi WHERE id_indirizzo=".$row['id_indirizzo_richiesta'];
      echo "<tr><th>{$row['id_azienda']}</th>".
      "<th>{$row['rag_sociale']}</th>".
      "<th><a href='vedi_singola_azienda.php?id_azienda={$row['id_azienda']}'>apri</a></th>".
      "</tr>";
   }
    echo "</table>";
    mysqli_free_result($retval);

    // chiudo connessione con database
    mysqli_close($conn);
 ?>

 <h2>In futuro</h2>
 <ul>
 	<li>altri campi per azienda (se utili)</li>
 </ul>

<?php include "footer.php"; ?>  