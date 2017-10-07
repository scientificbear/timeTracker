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
  <script>
  $( function() {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        // this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content  ui-corner-left form-control" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            classes: {
              "ui-tooltip": "ui-state-highlight"
            }
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 /*
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .on( "mousedown", function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .on( "click", function() {
            input.trigger( "focus" );
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      }, */
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " non corrisponde a nessuna azienda" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
 
    $( "#combobox" ).combobox();
    $( "#toggle" ).on( "click", function() {
      $( "#combobox" ).toggle();
    });
  } );
  </script>
  
    <script>
  $( function() {
    $('#datepicker_today').datepicker({ dateFormat: 'yy-mm-dd' }).datepicker("setDate", new Date()).val();
  } );
</script>

<script>
    $(function() {
        $('.chart').easyPieChart({
            lineWidth: 5,
            lineCap: 'butt',
            barColor: '#26b99a'
        });
    });
</script>

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="home.php" class="site_title"><i class="fa fa-paw"></i> <span>Time Tracking</span></a>
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
              <div class="col-md-8 col-sm-8 col-xs-8">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Inserisci registrazione <small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
<?php
// se ho premuto "add", dunque se ho già inserito i dati
if(isset($_POST['add'])) {
    //Connessione database

    include 'connessione.php';
    
    $data_operazione = date('Y-m-d',strtotime($_POST['data_operazione']));
    $ore_operazione = $_POST['ore_operazione'];
    $minuti_operazione = $_POST['minuti_operazione'];
    $minuti_totali = ($ore_operazione * 60) + $minuti_operazione;
    $id_azienda_operazione = $_POST['id_azienda_operazione'];
    
    // controlla la presenza di particolari caratteri nella stringa, che in caso vanno corretti con un / davanti
    if(! get_magic_quotes_gpc() ) {
        $descrizione_operazione = addslashes($_POST['descrizione_operazione']);
    }else {
        $descrizione_operazione = $_POST['descrizione_operazione'];
    }
    

  $sql = "INSERT INTO operazioni (id_utente,id_azienda,descrizione,giorno,minuti) VALUES ('$logged_userid','$id_azienda_operazione','$descrizione_operazione','$data_operazione','$minuti_totali')";

  if ($conn->query($sql) === TRUE) {
      $last_id = mysqli_insert_id($conn);
      echo "Nuova registrazione aggiunta con successo. <a href='home.php'>Torna alla home.</a> oppure <a href='vedi_singola_operazione.php?id_operazione=$last_id'>vedi quanto inserito</a>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

}else { //altrimenti, nel caso in cui dunque io debba ancora inserire valori nel form
    include 'connessione.php';
    ?>
                    <!-- start form for validation -->
                    <form method = "post" action = "<?php $_PHP_SELF ?>">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <label for="fullname">Data :</label>
                      <input type="text" class="form-control" id="single_cal2" placeholder="First Name" aria-describedby="inputSuccess2Status2" name="data_operazione">
                      <br />
                      <label for="fullname">Azienda :</label>
                      <select id="combobox" name="id_azienda_operazione">
                        <option value="">Select one...</option>
                        <?php 
                        $sql_ind="SELECT * FROM aziende ORDER BY rag_sociale ASC";
                        $retval_ind = mysqli_query( $conn, $sql_ind );
                        if(! $retval_ind ) {
                            die('Could not enter data: ' . mysql_error());
                        }
                        while($row_ind = mysqli_fetch_assoc($retval_ind)) {//Array or records stored in $row
                            echo "<option value=$row_ind[id_azienda]>$row_ind[rag_sociale]</option>";
                        }
                        ?>
                      </select>
                      <br />
                      <label for="message">Descrizione (500 max) :</label>
                      <textarea required="required" class="form-control" name = "descrizione_operazione" type = "text" data-parsley-trigger="keyup"  data-parsley-maxlength="500"></textarea>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <label for="email">Ore :</label>
                      <input class="form-control" type="number" name="ore_operazione" required />
                      <br />
                      <label for="fullname">Minuti :</label>
                      <input class="form-control" type="number" name="minuti_operazione" required value="0"/>
                      <br /><label></label><br /><br />
                      <div align="center">
                      <input name = "add" type = "submit" value = "Aggiungi registrazione" class="btn btn-primary">
                      </div>
                    </div>

                    </form>
                    <!-- end form for validations -->
<?php } ?>
                  </div>
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>La tua giornata <small></small></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="dashboard-widget-content">
                      <!-- <h2 class="line_30">Titolo</h2> --> 
                      <?php 
                          $sql = "SELECT sum(minuti) as minuti FROM operazioni where giorno=CURRENT_DATE() and id_utente='$logged_userid'"; // Query di ricerca
                          $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca
                          if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
                           die('Could not get data: ' . mysqli_error($conn));
                            }
                          $row = mysqli_fetch_assoc($retval);
                          $ore_operazione = floor($row['minuti'] /  60);
                          $minuti_operazione = $row['minuti'] % 60; 
                          $percentuale = round(100 * $row['minuti'] / 480);

                          echo "<h3>$percentuale%</h3>";
                          echo "<p>Hai inserito $ore_operazione h $minuti_operazione m</p>";

                          echo '<div class="chart" data-percent="'.$percentuale.'"><br><br><h4>'.$percentuale.'%</h4></div>';

 					?>
                        

                    </div>
                  </div>
                </div>
              </div>

            </div>


            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Le tue registrazioni di oggi</h2>
                    <div class="clearfix"></div>
                  </div>



                  <div class="x_content">

                    <?php

    $sql = "SELECT * FROM operazioni where giorno=CURRENT_DATE() and id_utente='$logged_userid' ORDER BY id_operazione"; // Query di ricerca
    $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca

    if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
     die('Could not get data: ' . mysqli_error($conn));
   } ?>

   <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Data</th>
        <th>Azienda</th>
        <th>Tempo</th>
        <th>Azioni</th>
      </tr>
    </thead>


    <tbody>

<?php    // corpo tabella (<tr> inizia una riga, <th> inizia una cella)
    while($row = mysqli_fetch_assoc($retval)) {
//      $sql_ind = "SELECT indirizzo FROM indirizzi WHERE id_indirizzo=".$row['id_indirizzo_richiesta'];
      $retval_azienda = mysqli_query( $conn, "SELECT rag_sociale FROM aziende WHERE id_azienda=".$row['id_azienda'] );
      $rag_sociale_azienda = mysqli_fetch_assoc($retval_azienda);
      $ore_operazione = floor($row['minuti'] /  60);
      $minuti_operazione = $row['minuti'] % 60;
      echo "<tr>".
        "<td>{$row['giorno']}</td>".
        "<td>{$rag_sociale_azienda['rag_sociale']}</td>".
        "<td>$ore_operazione h $minuti_operazione min </td>".
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

<!-- footer content -->
<?php include "footer.php" ?>