<html>
<head>
<link type="text/css" rel="stylesheet" href="StileModuloNewUser.css">
<title>form di cancellazione</title>
</head>
<body>
	<h1>Cancellazione user</h1>
<?php
session_start();
if (IsLogged()) {
    echo "<p> Buongiorno user <b>";
    echo $_SESSION["utente"];
    echo "</b></p>";
    ?>
    	<article>
		<form action="cancellauser.php" method="post">
			<p>
				user da cancellare:<input name="user_da_cancellare" type="text" required>
			</p>
			<p>
				<input type="submit" value="invia">
				<input type="reset" value="reset">
			</p>
		</form>
	</article>
    <?php
} else {
    echo "<p>Login non effettuato</p>";
    echo "<a href='login.html'> Tornare alla pagina di login </a>";
}

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

