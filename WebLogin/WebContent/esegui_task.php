<html>
<head>
<title>Modulo di inserimento new user</title>
<script type="text/javascript" src="controlloinput.js"></script>
<link type="text/css" rel="stylesheet" href="StileModuloNewUser.css">
</head>
<body>
<h1> Form di inserimento nuovo user e psw </h1>
<?php
session_start();
if (IsLogged()) {
    //echo "<p> esegui task </p>";
    echo "<p> Buongiorno user <b>";
    echo $_SESSION["utente"];
    echo "</b></p>";
?>
<!-- article � un contenitore analogo a div -->
<article>    
    <form name="moduloinserimento" action="inseriscinewuser.php" method="post" onsubmit="return MyFunction(document.getElementById('new_user').value ,document.getElementById('new_psw').value)">
    <p> user: <input name="newuser" id="new_user" type="text" required> </p>
    <p> psw: <input name="newpsw" id="new_psw" type="password" required> </p>
    <p> <input name="bottoneinvio" value="invio" type="submit">
    <input value="Reimposta" type="reset"> </p>
    </form>
</article>
 <?php
    // una volta controllata la variabile di sessione, la elimino per evitare che rimanga memorizzata
    // pi� a lungo di quello che serve.
    //unset($_SESSION["utente"]);
    unset($_SESSION["password"]);
 } else {
    echo "<p>Login non effettuato</p>";
    echo "<a href='login.html'> Tornare alla pagina di login </a>";
}
/**
 * la funzione IsLogged controlla se la variabile di Sessione utente � stata impostata.
 * Se tale variabile restituisce falso, significa che � necessario rifare il login.
 * @return boolean: se la variabile di sessione "utente" � settata restituisce vero altrimenti falso
 */
function IsLogged()
{
    if (isset($_SESSION["utente"])) {
        return true;
    } else {
        return false;
    }
}
?>
<footer>
<p id="err" class= "errore"></p>
<p>modulo PHP in esecuzione: esegui_task</p>
</footer>
</body>
</html>