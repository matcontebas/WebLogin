<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type"
	content="text/html; charset=windows-1252">
<!--il programma genera la query per inserire un nuovo user e psw nel database provenienti da new.html -->
<title>Modulo inserimento nuova user e password</title>
</head>
<body>
<?php
include 'cerca_chiave.php';
$host = "localhost";
$NomeDB = "matteo";
$tabellaDB = "login";
$user_DB = "AccountProva";
$psw_DB = "rn5skCZucrBfARRaCzUT.";
// Dati del server Altervista
// $host= "localhost";
// $NomeDB="my_matteobas";
// $tabellaDB="login";
// $user_DB="matteobas";
// $psw_DB="";

// ingresso
session_start();
if (IsLogged("utente")) {

    echo "<h2>" . "Esito inserimento new user e psw nel DB" . "</h2>";
    // purifico l'input utente con la funzione controllo_input
    $user = controllo_input($_POST["newuser"]);
    echo "<p>" . "User: " . $user . "</p>";
    // il prossimo if consente di controllare se la stringa user è vuota
    if ($user != "") {
        $mia_classe = new cerca_chiave($host, $NomeDB, $user_DB, $psw_DB, $tabellaDB, "userlogin", $user);
        if ($mia_classe->controllo_doppi()) {
            echo " avvio inserimento nuove user nel DB" . "<br>";
            $mysqli = new mysqli($host, $user_DB, $psw_DB, $NomeDB);
            if ($mysqli->connect_error) {
                die('Errore di connessione (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            } else {
                echo 'Connesso con MySQLi. ' . $mysqli->host_info . "<br>";
                /*
                 * purifico la password con controllo input. Attenzione bisogna che la password
                 * non contenga nè spazi, nè backslashes, nè caratteri tipo<,>, etc altrimenti
                 * sarà dicersa da quella che l'utente ha pensato di inserire.
                 */
                $password = controllo_input($_POST["newpsw"]);
                // echo "<br>". $password . "<br>";
                $password_hashed = hash('SHA256', $password); // creazione dell'hash
                /*
                 * Creazione dell'oggetto statement $stmt utilizzando i prepared statement.
                 * i due punti interrogativi sono i segnaposto da associare poi alle variabili attraverso il metodo
                 * bind_param
                 */
                $stmt = $mysqli->prepare("INSERT INTO login (userlogin, pswlogin) VALUES (?, ?)");
                $stmt->bind_param('ss', $user, $password_hashed);
                if ($stmt->execute()) {
                    echo "<p> Query OK</p>";
                    // il seguente metodo indica quante righe sono state inserite
                    echo "<p>Righe generate: " . $mysqli->affected_rows . "</p>";
                    // il seguente metodo indica l'ultimo id inserito
                    echo "<p>Ultimo ID inserito: " . $mysqli->insert_id . "</p>";
                    echo "<p><a href='login.html'> Tornare alla pagina di login </a></p>";
                    // echo "<p><a href='index.html'> Tornare alla pagina di login </a></p>"; //da utilizzare per Altervista
                } else {
                    die($mysqli->error);
                }
                $mysqli->close();
            }
        } else {
            echo "Buongiorno la user " . $user . " inserita &egrave presente nel database. Nessun inserimento effettuato" . "<br>";
            echo "<br/>";
            echo "<p><a href='esegui_task.php'>Riprovare</a></p>";
            echo "<a href='login.html'> Tornare alla pagina di login </a>";
            // echo "<a href='login.html'> Tornare alla pagina di login </a>"; //da utilizzare per Altervista
        }
        // Fine if controllo doppi----------------------------------------------------------------
    } else {
        // &ograve corrisponde alla ò
        echo "la user non pu&ograve essere una stringa vuota";
    }
} else {
    echo "<p>Login non effettuato</p>";
    echo "<a href='login.html'> Tornare alla pagina di login </a>";
}// fine ciclo if per controllo login

/**
 * La function controlla se il login è stato fatto.
 *
 * @param unknown $chiave:
 *            è la chiave della variabile $_SESSION
 * @return boolean: ritorna true se il login è attivo, altrimenti false
 */
function IsLogged($chiave)
{
    if (isset($_SESSION[$chiave])) {
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
<footer>
		<p id="err" class="errore"></p>
		<p>modulo PHP in esecuzione: inseriscinewuser</p>
	</footer>
</body>
</html>