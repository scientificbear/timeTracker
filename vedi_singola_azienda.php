<?php include "header.php"; ?>

</head>
<body>
<h1><a href="home.php">Time Tracking MBT</a></h1>
<br/>
<h2>Azienda</h2>

<?php
    
    // Connessione Database mysql
    include 'connessione.php';
    $sql = 'SELECT * FROM aziende where id_azienda = '.$_GET['id_azienda']; // Query di ricerca
    $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca

    if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
       die('Could not get data: ' . mysqli_error($conn));
    }

    while($row = mysqli_fetch_assoc($retval)) {

      echo "<p>id: {$row['id_azienda']}</p>";
      echo "<p>ragione sociale: {$row['rag_sociale']}</p>";

    }

?>

<h2>Registrazioni associalte</h2>

<?php

    $sql = 'SELECT * FROM operazioni where id_azienda = '.$_GET['id_azienda']; // Query di ricerca
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
  <li>aggiunta tasto modifica</li>
  <li>aggiunta tasto elimina</li>
</ul>

<?php include "footer.php"; ?>  