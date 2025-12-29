<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Esito cancellazione</title>
</head>
<body>
	<h1>Esito cancellazione</h1>

<?php
include 'cerca_chiave.php';
$hostname = "localhost";
$NomeDB = "matteo";
$tabellaDB = "login";
$user_DB = "AccountProva";
$psw_DB = "rn5skCZucrBfARRaCzUT.";
$campouser="userlogin";
// Dati del server Altervista
// $hostname= "localhost";
// $NomeDB="my_matteobas";
// $tabellaDB="login";
// $user_DB="matteobas";
// $psw_DB="";
//$campouser="userlogin";


session_start();
if (IsLogged()) {
    echo "<h2>esito cancellazione</h2>";
    echo "<p> Buongiorno user <b>";
    echo $_SESSION["utente"];
    echo "</b></p>";
    // purifico l'input utente con la function controllo_input
    $user = controllo_input($_POST["user_da_cancellare"]);
    $utentecorrente=$_SESSION["utente"];
    // l'if sottostante consente di evitare di cancellare l'account amministratore o l'account corrente
    // la funzione strcasecmp serve per fare confronti tra due stringhe case insensitive
    // in questo caso Administrator e administrator sono uguali e pippo e Pippo sono uguali
    if (strcasecmp($user, "Administrator") != 0 && strcasecmp($user,$utentecorrente)!=0) {
        echo "<p>" . "User da cancellare: " . $user . "</p>";
        $mia_classe = new cerca_chiave($hostname, $NomeDB, $user_DB, $psw_DB, $tabellaDB, "userlogin", $user);
        //il metodo controllo_doppi consente di controllare che la user oggetto di cancellazione sia presente nel DB
        if (! $mia_classe->controllo_doppi()) {
            echo "<p>user presente nel DB</p>";
            //inserire sql di cancellazione
            try {
                
                $dB = new PDO("mysql:host=$hostname;dbname=$NomeDB", $user_DB, $psw_DB);
                $sql="DELETE FROM ".$tabellaDB. " WHERE ".$campouser." = :user";
                $stmt = $dB->prepare($sql);
                $stmt->bindParam(':user',$user,PDO::PARAM_STR);
                $esito_cancellazione= $stmt->execute();
                if ($esito_cancellazione) {
                    echo "<p>record cancellato</p>";
                } else {
                    echo "<p>record non cancellato</p>";
                }
            } catch (PDOException $e) {
                echo "<p> errore connessione al DB</p>";
                $dB = null;
            }
            

            echo "<p><a href='form_cancellauser.php'>cancella altri record</a>";
            echo "<p><a href='login.html'>oppure ritorna alla homepage</a></p>";
        } else {
            echo "<p>user non presente nel DB</p>";
            echo "<p><a href='form_cancellauser.php'>Riprova l'inserimento</a>";
            echo "<p><a href='login.html'>oppure ritorna alla homepage</a></p>";
        }
    } else {
        echo "<p>Non si puo' cancellare l'account Administrator o l'utente corrente</p>";
        echo "<p><a href='form_cancellauser.php'>Riprova l'inserimento</a>";
        echo "<p><a href='login.html'>oppure ritorna alla homepage</a></p>";
    }
} else {
    echo "<p>Login non effettuato</p>";
    echo "<a href='login.html'> Tornare alla pagina di login </a>";
}

// fine if per IsLogged
//function da cancellare? E' da implementare come negli altri moduli con CheckLogin.php
function IsLogged()
{
    if (isset($_SESSION["utente"])) {
        return true;
    } else {
        return false;
    }
}

/**
 * La function toglie da un generico dato di input utente proveniente da un FORM html
 * tutti i caratteri speciali che potrebbero prestarsi ad attacchi hacker
 *
 * @param generico $data:
 *            dato in ingresso utente da form
 * @return generico: restituisce il dato purificato dai caratteri speciali
 */
function controllo_input($data)
{
    // si tolgono gli spazi
    $data = trim($data);
    // toglie i backslashes
    $data = stripslashes($data);
    // FILTER_SANITIZE_STRING filter removes tags and remove or encode special characters from a string.
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    // converte i caratteri speciali come per esempio < in HTML entities in modo da non permettere
    // l'inserimento di script Javascript
    $data = htmlspecialchars($data);
    return $data;
}
?>

</body>
</html>