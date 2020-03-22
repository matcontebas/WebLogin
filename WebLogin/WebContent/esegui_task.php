<html>
<body>
<?php
session_start();
if (IsLogged()) {
    echo "<p> esegui task </p>";
    echo "<p> Buongiorno user <b>";
    echo $_SESSION["utente"];
    echo "</b></p>";
    echo "<h1> form di inserimento nuovo user & psw </h1>";
?>    
    <form name="moduloinserimento" action="inseriscinewuser.php" method="post">
    <p> user: <input name="newuser" type="text"> </p>
    <p> psw: <input name="newpsw" type="password"> </p>
    <p> <input name="bottoneinvio" value="invio" type="submit">
    <input value="Reimposta" type="reset"> </p>
    </form>
 <?php
    // una volta controllata la variabile di sessione, la elimino per evitare che rimanga memorizzata
    // più a lungo di quello che serve.
    unset($_SESSION["utente"]);
 } else {
    echo "Login non effettuato";
    echo "<a href='login.html'> Tornare alla pagina di login </a>";
}
// la funzione IsLogged controlla se la variabile di Sessione utente è stata impostata
function IsLogged()
{
    if (isset($_SESSION["utente"])) {
        return true;
    } else {
        return false;
    }
}
?>
</body>
</html>