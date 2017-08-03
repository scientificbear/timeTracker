<?php include "header.php"; ?>

</head>
<body>
<h1><a href="home.php">Time Tracking MBT</a></h1>
<br/>

<h2>Elimina registrazione</h2>


<?php
    include 'connessione.php';
    $id_operazione = $_GET['id_operazione'];
    $sql = 'SELECT * FROM operazioni WHERE id_operazione = '.$id_operazione;
    $result = mysqli_query( $conn, $sql );

    $details = mysqli_fetch_assoc($result);
    $ore_operazione = floor($details['minuti'] /  60);
    $minuti_operazione = $details['minuti'] % 60;
    $retval_azienda = mysqli_query( $conn, "SELECT rag_sociale FROM aziende WHERE id_azienda=".$details['id_azienda'] );
    $rag_sociale = mysqli_fetch_assoc($retval_azienda)['rag_sociale'];
    $retval_utente = mysqli_query( $conn, "SELECT username FROM login WHERE id_utente=".$details['id_utente'] );
	$username = mysqli_fetch_assoc($retval_utente)['username'];

         if(isset($_POST['delete'])) {

             // delete the entry
            $sql = "DELETE FROM operazioni WHERE id_operazione='$id_operazione'";
            $retval = mysqli_query( $conn, $sql );

            if(! $retval ) {
               die('Could not delete data: ' . mysqli_error($retval));
            }

            echo '<p>Cancellata</p>';
            echo '<a href="home.php">Home</a>';


            mysqli_close($conn);
         }else {
            echo '<b>id: </b>'.$details['id_operazione'].'<br/>';
    		echo '<b>data richiesta: </b>'.$details['giorno'].'<br/>';
    		echo '<b>azienda: </b>'.$rag_sociale.'<br/>';
    		echo '<b>utente: </b>'.$username.'<br/>';
		    echo '<b>durata: </b>'.$ore_operazione.' h '.$minuti_operazione.' min<br/>';
            mysqli_free_result($result);
            ?>
               <form method = "post" action = "<?php $_PHP_SELF ?>">
                           <input name = "delete" type = "submit" id = "add"
                              value = "Elimina lavoro">
               </form>

               <?php
            }
         ?>

<?php include "footer.php"; ?>   