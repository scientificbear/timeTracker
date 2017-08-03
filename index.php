<html>
<head>
</head>
<body>
<?php 
$error_message = $_GET['error'];
if ($error_message == 'unknown_user')
    echo '<p style="text-align: center; color: red">Devi prima effettuare il login</p>';
    if ($error_message == 'wrong_credential')
        echo '<p style="text-align: center; color: red">Username o password errata</p>';
        if ($error_message == 'logout')
            echo '<p style="text-align: center; color: red">Hai effettuato il logout</p>';
?>
<form id="login" action="verifica_credenziali.php" method="post">
<table width = "400" border = "0" cellspacing = "1"
    cellpadding = "2">

    <tr>
      <td width = "100">Nome utente</td>
      <td>
        <input type="text" name="username">
      </td>
    </tr>

    <tr>
      <td width = "100">password</td>
      <td>
        <input name = "password" type = "password">
      </td>
    </tr>

              <tr>
                <td width = "100"> </td>
                <td> </td>
              </tr>

              <tr>
                <td width = "100"> </td>
                <td>
                 <input name = "add" type = "submit" id = "add"
                 value = "entra">
               </td>
             </tr>


</form>

</table>
</body>
</html>