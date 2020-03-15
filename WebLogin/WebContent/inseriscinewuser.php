<html>
<!--il programma genera la query per inserire un nuovo user e psw nel database provenienti da new.html -->
<body>
<h1><?php echo "Ciao, sono inseriscinewuser.php"; ?></h1>
<p> Benvenuto: <?php echo $_POST["newuser"]; ?> </p>
<?php 
$mysqli = new mysqli('localhost', 'AccountProva', 'rn5skCZucrBfARRaCzUT.', 'matteo');
		if ($mysqli->connect_error) {
    		die('Errore di connessione (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
		} else {
			echo 'Connesso con MySQLi. ' . $mysqli->host_info . "<br>";
			$user=$_POST["newuser"];
			$password=$_POST["newpsw"];
			$password_hashed=hash('SHA256', $password);//creazione dell'hash
			echo $password_hashed . "\n";
			$query = "INSERT INTO login (userlogin, pswlogin) VALUES ('$user', '$password_hashed')";
			if($mysqli->query($query)){
				echo "Query OK";
				} else {
				die($mysqli->error);	
					}
			$mysqli->close();
		}
		?>
</body>
</html>