<?php
session_start();

?>
<?php
include 'CheckLogin.php';
$stato_log= new CheckLogin();
if ($stato_log->IsLogged()) {
    echo "Ciao";
    echo "<p> Buongiorno user <b>";
    echo $_SESSION["utente"];
    // una volta arrivati qui significa che il login è stato fatto quindi
    //non serve tenere la password nella variabile di Sessione
    //unset($_SESSION["utente"]);
    unset($_SESSION["password"]);
    echo "</b></p>";
    echo "<ul><li><a href='esegui_task.php'>inserisci nuova user</a></li>";
    echo "<li><a href= 'form_cancellauser.php'>cancella user esistente</a></li></ul>";
} else {
    echo "<p>Login non effettuato</p>";
    echo "<a href='login.html'> Tornare alla pagina di login </a>";
}

?>