/**
 * http://usejsdoc.org/
 */
function MyFunction(campo) {
	var user=campo;
	var lung=user.length;
	if (lung < 5) {
		alert ("lunghezza stringa minore di 5 caratteri: "+ user + " "+ lung + " form bloccato");
		return false;
	} else {
		alert ("lunghezza stringa maggiore uguale a 5 caratteri; user: "+ user + " lunghezza: " + lung + " Form va avanti");
		return true;
	}
}