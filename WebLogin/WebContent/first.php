<html>
<!--il programma controlla i dati di login provenienti da login.html -->
<body>
<?php
// session_start() avvia la sessione
session_start();
?>
<?php
try {
    $hostname = "localhost";
    $dbname = "matteo";
    $user = "AccountProva";
    $pass = "rn5skCZucrBfARRaCzUT.";
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
    // echo 'Connesso MySQL con POD (PHP DATA OBJECT). ' . "<br><br>";
    // filter_var serve per "sanificare" ovvero per evitare SQL Injection; trim toglie gli spazi all'inizio e alla fine della stringa
    $usersicura = trim(filter_var($_POST["user"], FILTER_SANITIZE_STRING));
    $pswtemp = trim(filter_var($_POST["psw"], FILTER_SANITIZE_STRING));
    $pswsicura = hash('sha256', $pswtemp);
    $sql = "SELECT * FROM login WHERE userlogin = '$usersicura' AND pswlogin = '$pswsicura'";
    // echo $sql;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $totale = $stmt->rowCount();
    if ($totale > 0) {
        echo "<p><b> Login corretto </b></p>";
        // se il login è corretto memorizzo nell'array Session la user e la psw
        //$_SESSION["utente"] = $_POST["user"];
        $_SESSION["utente"]=$usersicura;
        $_SESSION["password"] = $pswsicura;
        header("Location: esegui_task.php");
    } else {
        echo "<p> Login NON corretto </p>";
        // l'istruzione header rimanda al sito LoginErrato.html per indicare all'utente l'errore e riproporre il form
        header("Location: LoginErrato.html");
    }
    //gestione errore
    $db = null;
} catch (PDOException $e) {
    echo "Errore: " . $e->getMessage();
    die();
}
?>
</body>
</html>