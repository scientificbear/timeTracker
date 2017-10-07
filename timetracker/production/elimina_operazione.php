<?php include "header.php" ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
                    <h2>Elimina registrazione <small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
<?php
    include 'connessione.php';
    $sql = 'SELECT * FROM operazioni where id_operazione = '.$_GET['id_operazione']; // Query di ricerca
    $mioid = $_GET['id_operazione'];
    $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca

    if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
       die('Could not get data: ' . mysqli_error($conn));
    }
     if(isset($_POST['delete'])) {

             // delete the entry
            $sql = "DELETE FROM operazioni WHERE id_operazione='$mioid'";
            $retval = mysqli_query( $conn, $sql );

            if(! $retval ) {
               die('Could not delete data: ' . mysqli_error($retval));
            }

            echo '<p>Registrazione cancellata definitivamente.</p>';

            mysqli_close($conn);
         }else {
    ?>

    <?php
    while($row = mysqli_fetch_assoc($retval)) {
      $retval_azienda = mysqli_query( $conn, "SELECT rag_sociale FROM aziende WHERE id_azienda=".$row['id_azienda'] );
      $rag_sociale_azienda = mysqli_fetch_assoc($retval_azienda);
      $ore_operazione = floor($row['minuti'] /  60);
      $minuti_operazione = $row['minuti'] % 60;
?>
                    <!-- start form for validation -->
                  <form id="demo-form2" class="form-horizontal form-label-left" method = "post" action = "<?php $_PHP_SELF ?>">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Data
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo '<input class="form-control" disabled value="'.$row["giorno"].'">'; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Azienda
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo '<input class="form-control" disabled value="'.$rag_sociale_azienda['rag_sociale'].'">'; ?>
                      </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ore
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo '<input class="form-control" disabled value="'.$ore_operazione.'">'; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Minuti
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo '<input class="form-control" disabled value="'.$minuti_operazione.'">'; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Descrizione
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control" disabled><?php echo $row['descrizione']; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                      <div align="center">
                      <input class="btn btn-primary"  name = "delete" type = "submit" id = "add" value = "Elimina definitivamente"> <button onclick="history.go(-1);" class="btn btn-primary">Annulla </button>
                      </div>
                    </div>
                    </form>
                    <?php } } ?>
                    <!-- end form for validations -->
                  </div>
                </div>
              </div>

            </div>

          </div>
<!-- /page content -->

<!-- footer content -->
<?php include "footer.php" ?>