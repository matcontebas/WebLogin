<html>
<head>
<title>Modulo di inserimento new user</title>
<script type="text/javascript" src="controlloinput.js"></script>
</head>
<body>
<h1> form di inserimento nuovo user e psw </h1>
<?php
session_start();
if (IsLogged()) {
    echo "<p> esegui task </p>";
    echo "<p> Buongiorno user <b>";
    echo $_SESSION["utente"];
    echo "</b></p>";
?>    
    <form name="moduloinserimento" action="inseriscinewuser.php" method="post" onsubmit="return MyFunction(document.getElementById('new_user').value ,document.getElementById('new_psw').value)">
    <p> user: <input name="newuser" id="new_user" type="text" required> </p>
    <p> psw: <input name="newpsw" id="new_psw" type="password" required> </p>
    <p> <input name="bottoneinvio" value="invio" type="submit">
    <input value="Reimposta" type="reset"> </p>
    </form>
 <?php
    // una volta controllata la variabile di sessione, la elimino per evitare che rimanga memorizzata
    // più a lungo di quello che serve.
    unset($_SESSION["utente"]);
 } else {
    echo "<p>Login non effettuato</p>";
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