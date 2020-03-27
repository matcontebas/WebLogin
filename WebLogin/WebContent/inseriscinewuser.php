<html>
<!--il programma genera la query per inserire un nuovo user e psw nel database provenienti da new.html -->
<title> Modulo inserimento nuova user e password</title>
<body>
<!-- Da decidere se mettere il controllo sulla sessione anche qui -->
<h1><?php echo "Ciao, sono inseriscinewuser.php"; ?></h1>
<p> User: <?php echo $_POST["newuser"]; ?> </p>
<?php 
include 'cerca_chiave.php';
$mia_classe= new cerca_chiave("localhost","matteo","AccountProva","rn5skCZucrBfARRaCzUT.","login","userlogin",$_POST["newuser"]);
if ($mia_classe->controllo_doppi()) {
    echo "si parte" . "\n";
$mysqli = new mysqli('localhost', 'AccountProva', 'rn5skCZucrBfARRaCzUT.', 'matteo');
		if ($mysqli->connect_error) {
    		die('Errore di connessione (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
		} else {
			echo 'Connesso con MySQLi. ' . $mysqli->host_info . "<br>";
			$user=$_POST["newuser"];
			$password=$_POST["newpsw"];
			$password_hashed=hash('SHA256', $password);//creazione dell'hash
			echo 'password hashed: '.$password_hashed . "\n";
			$query = "INSERT INTO login (userlogin, pswlogin) VALUES ('$user', '$password_hashed')";
			if($mysqli->query($query)){
				echo "Query OK";
				} else {
				die($mysqli->error);	
					}
			$mysqli->close();
		}
}
		?>
</body>
</html>