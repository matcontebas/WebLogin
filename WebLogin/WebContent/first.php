<html>
<!--il programma controlla i dati di login provenienti da login.html -->
<body>
<?php
// session_start() avvia la sessione
session_start();
?>
<?php
//ho inserito un blocco try/catch per verificare se la connessione con il DB è in piedi
//se viene eseguito il blocco try, la variabile $db viene impostata con la connessione ad DB; se invece viene eseguito il
//catch, la variabile $db viene impostata a null
try {
    //********Credenziali MySQL Altervista******
    //$hostname = "localhost";
    //$dbname = "my_matteobas";
    //$user = "matteobas";
    //$pass = "";
    
    //*********credenziali mio DB MySQL***********
    $hostname = "localhost";
    $dbname = "matteo";
    $user = "AccountProva";
    $pass = "rn5skCZucrBfARRaCzUT.";
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
    echo "<p> errore connessione al DB</p>";
    $db = null;
}
//il codice per accedere ai record del DB viene eseguito solamente se la connessione è in piedi
if ($db != null) {
    try {
        // echo 'Connesso MySQL con POD (PHP DATA OBJECT). ' . "<br><br>";
        // filter_var serve per "sanificare" ovvero per evitare SQL Injection; trim toglie gli spazi all'inizio e alla fine della stringa
        $usersicura = trim(filter_var($_POST["user"], FILTER_SANITIZE_STRING));
        $pswtemp = trim(filter_var($_POST["psw"], FILTER_SANITIZE_STRING));
        $pswsicura = hash('sha256', $pswtemp);
        //Preparazione della query con i prepared statement con parametri variabili :user e :psw
        //che vengono assegnati come valore per mezzo del binding (bindParam)
        $sql = "SELECT * FROM login WHERE userlogin = :user AND pswlogin = :psw";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user', $usersicura, PDO::PARAM_STR);
        $stmt->bindParam(':psw', $pswsicura, PDO::PARAM_STR);
        $stmt->execute();
        $totale = $stmt->rowCount();
        if ($totale > 0) {
            echo "<p><b> Login corretto </b></p>";
            // se il login è corretto memorizzo nell'array Session la user e la psw
            // $_SESSION["utente"] = $_POST["user"];
            $_SESSION["utente"] = $usersicura;
            $_SESSION["password"] = $pswsicura;
            header("Location: esegui_task.php");
        } else {
            echo "<p> Login NON corretto </p>";
            // l'istruzione header rimanda al sito LoginErrato.html per indicare all'utente l'errore e riproporre il form
            header("Location: LoginErrato.html");
        }
        // gestione errore
        $db = null;
    } catch (PDOException $e) {
        echo "Errore: " . $e->getMessage();
        die();
    }
} else {
    echo "<p>Errore PDO: non si riesce a stabilire la connessione con DB</p>";
}
?>
</body>
</html>