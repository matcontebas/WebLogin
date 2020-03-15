<html>
<?php
session_start();
if (IsLogged()) {
    echo "<p> esegui task </p>";
    echo "<p> Buongiorno user <b>";
    echo $_SESSION["utente"];
    echo "</b></p>";
    // una volta controllata la variabile di sessione, la elimino per evitare che rimanga memorizzata
    // pi� a lungo di quello che serve.
    echo "<form name='moduloinserimento' action='inseriscinewuser.php' method='post'>";
    echo "<p> user: <input name='newuser' type='text'> </p>";
    echo "<p> psw: <input name='newpsw' type='password'> </p>";
    echo "<p> <input name='bottoneinvio' value='invio' type='submit'> </p>";
    echo "</form>";
    unset($_SESSION["utente"]);
 } else {
    echo "Login non effettuato";
    echo "<a href='login.html'> Tornare alla pagina di login </a>";
}
?>
<?php

// la funzione IsLogged controlla se la variabile di Sessione utente � stata impostata
function IsLogged()
{
    if (isset($_SESSION["utente"])) {
        return true;
    } else {
        return false;
    }
}
?>
</html>