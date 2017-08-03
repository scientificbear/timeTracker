<?php include "header.php"; ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

  
<!-- <style>
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
  </style>

  --> 
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
</head>
<body>
<h1><a href="home.php">Time Tracking MBT</a></h1>
<br/>

<h2>Modifica registrazione</h2>


<?php

$id_operazione = $_GET['id_operazione'];

    include 'connessione.php';

    $id_operazione = $_GET['id_operazione'];
    $sql = 'SELECT * FROM operazioni where id_operazione='.$id_operazione;

    $retval = mysqli_query( $conn, $sql ); // eseguo la ricerca

    if(! $retval ) { // se non ottiene $retval, per cui se non può eseguire la ricerca
     die('Could not get data: ' . mysqli_error($conn));
   }

    // ottengo valori da $retval
   $details = mysqli_fetch_assoc($retval);
   $ore = floor($details['minuti'] / 60);
   $minuti = $details['minuti'] % 60;

   $sql_azienda = 'SELECT rag_sociale FROM aziende where id_azienda='.$details['id_azienda'];
    $retval_azienda = mysqli_query( $conn, $sql_azienda );
    $dettagli_azienda = mysqli_fetch_assoc($retval_azienda);

    ?>    

    <script>
  $( function() {
    $('#datepicker_today').datepicker({ dateFormat: 'yy-mm-dd' }).datepicker("setDate", '<?php echo $details['giorno']; ?>').val();
  } );
</script>

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
          value = selected.val() ? selected.text() : "<?php echo $dettagli_azienda['rag_sociale'] ?>";

        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
//           .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            classes: { "ui-tooltip": "ui-state-highlight" }
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
 
      /*_createShowAllButton: function() {
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


<?php
// se ho premuto "add", dunque se ho già inserito i dati
if(isset($_POST['add'])) {
    //Connessione database

    include 'connessione.php';
    
    $data_operazione = $_POST['data_operazione'];
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
    

	$sql = "UPDATE operazioni SET id_utente=$logged_userid,id_azienda='$id_azienda_operazione',descrizione='$descrizione_operazione',giorno='$data_operazione',minuti=$minuti_totali where id_operazione=$id_operazione";

	if ($conn->query($sql) === TRUE) {
      $last_id = mysqli_insert_id($conn);
	    echo "Registrazione modificata con successo. <a href='home.php'>Torna alla home.</a> oppure <a href='vedi_singola_operazione.php?id_operazione=$id_operazione'>vedi quanto inserito</a>";
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
            <td width = "100">Utente</td>
            <td> <!-- qui si aspetta il testo vero e proprio -->
                <?php echo $logged_username ?>
            </td>
        </tr>
        
        <tr>
            <td width = "100">Data operazione</td>
            <td> <!-- qui si aspetta il testo vero e proprio -->
                <input type="text" id="datepicker_today" name="data_operazione">
            </td>
        </tr>

        <tr class="ui-widget">
            <td width = "100">Cliente</td>
            <td>
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
            </td>
        </tr>
        
                <tr>
            <td width = "100">Ore</td>
            <td> <!-- qui si aspetta il testo vero e proprio -->
                <input type="text" type="number" name="ore_operazione" value="<?php echo $ore; ?>">
            </td>
        </tr>
                <tr>
            <td width = "100">Minuti</td>
            <td> <!-- qui si aspetta il testo vero e proprio -->
                <input type="text" id="datepicker_today" type="number" name="minuti_operazione" value="<?php echo $minuti; ?>">
            </td>
        </tr>
        <tr>
            <td width = "100">Descrizione</td>
            <td>
                <input name = "descrizione_operazione" type = "text" maxlength="500" value="<?php echo $details['descrizione']; ?>">
            </td>
        </tr>
        <tr>
            <td width = "100"> </td>
            <td> <!-- qui crea il bottone aggiungi-->
                <input name = "add" type = "submit" value = "Modifica registrazione">
                <button onclick="history.go(-1);">Annulla </button>
            </td>
        </tr>
        
    </table>
</form>

<?php
}
?>



<?php include "footer.php"; ?>  