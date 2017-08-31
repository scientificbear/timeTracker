<?php include "header.php" ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="home.php" class="site_title"><i class="fa fa-paw"></i> <span>Time tracking</span></a>
          </div>

          <div class="clearfix"></div>

          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic">
              <img src="images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
              <span>Ciao,</span>
              <h2><?php echo $logged_username; ?></h2>
            </div>
          </div>
          <!-- /menu profile quick info -->

          <br />
          
          <?php
            // Connessione Database mysql
          include 'connessione.php';

          ?>

          <?php include "sidebar.php" ?>

          <?php include "topbar.php" ?>

          <!-- page content -->
          <div class="right_col" role="main">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Tutte le registrazioni</h2>
                    <div class="clearfix"></div>
                  </div>



                  <div class="x_content">

                    <?php

    $sql = "SELECT * FROM operazioni ORDER BY id_operazione DESC"; // Query di ricerca
    $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca

    if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
     die('Could not get data: ' . mysqli_error($conn));
   } ?>

   <table id="datatable" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Data</th>
        <th>Azienda</th>
        <th>Utente</th>
        <th>Tempo</th>
        <th>Descrizione</th>
        <th>Azioni</th>
      </tr>
    </thead>

    <tbody>

<?php    // corpo tabella (<tr> inizia una riga, <th> inizia una cella)
    while($row = mysqli_fetch_assoc($retval)) {
//      $sql_ind = "SELECT indirizzo FROM indirizzi WHERE id_indirizzo=".$row['id_indirizzo_richiesta'];
      $retval_azienda = mysqli_query( $conn, "SELECT rag_sociale FROM aziende WHERE id_azienda=".$row['id_azienda'] );
      $rag_sociale_azienda = mysqli_fetch_assoc($retval_azienda);
      $retval_utente = mysqli_query( $conn, "SELECT username FROM login WHERE id_utente=".$row['id_utente'] );
      $nome_utente = mysqli_fetch_assoc($retval_utente);
      $ore_operazione = floor($row['minuti'] /  60);
      $minuti_operazione = $row['minuti'] % 60;
      echo "<tr>".
        "<td>{$row['giorno']}</td>".
        "<td>{$rag_sociale_azienda['rag_sociale']}</td>".
        "<td>{$nome_utente['username']}</td>".
        "<td>$ore_operazione h $minuti_operazione min </td>".
        "<td>{$row['descrizione']}</td>".
        "<td><a href='modifica_operazione.php?id_operazione=".$row['id_operazione']."'>modifica</a> - <a href='elimina_operazione.php?id_operazione=".$row['id_operazione']."'>elimina</a></td>".
      "</tr>";
    }
mysqli_free_result($retval);
?>
    </tbody>
  </table>

</div>
</div>
</div>



</div>

</div>
<!-- /page content -->

<!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>

<!-- footer content -->
<?php include "footer.php" ?>