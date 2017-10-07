<?php include "header.php" ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<!--  
<style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
  </style>-->
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
                    <h2>Inserisci azienda <small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
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
      echo "Nuova azienda aggiunta con successo. <a href='home.php'>Torna alla home</a> oppure <a href='vedi_singola_azienda.php?id_azienda=$last_id'>vedi quanto inserito</a>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

}else { //altrimenti, nel caso in cui dunque io debba ancora inserire valori nel form
    include 'connessione.php';
    ?>
    <p>Sei <b>davvero sicuro</b> che l'azienda che stai per inserire non sia gi&agrave presente nel sistema? Prova a <a href="vedi_aziende.php">verificare nell'elenco...</a><br/><br/></p>
                    <!-- start form for validation -->
                  <form method="post" id="demo-form2" class="form-horizontal form-label-left" action="<?php $_PHP_SELF ?>">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ragione sociale
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control" name="rag_sociale">
                        </div>
                    </div>

                    <div class="form-group">
                      <div align="center">
                      <input name = "add" type = "submit" value = "Aggiungi azienda" class="btn btn-primary">
                      </div>
                    </div>



                    </form>
                    <!-- end form for validations -->
<?php } ?>
                  </div>
                </div>
              </div>

            </div>

          </div>
<!-- /page content -->

<!-- footer content -->
<?php include "footer.php" ?>