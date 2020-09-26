/**
 * http://usejsdoc.org/
 */
function MyFunction(campouser, campopsw) {
	var user=campouser;
	var lunguser=user.length;
	var psw=campopsw;
	var lungpsw=psw.length;
	//alert("lunghezza password: " + lungpsw);
	if (lunguser < 5 || lungpsw < 5) {
		alert ("lunghezza user o psw minore di 5 caratteri: "+ user + " "+ lunguser + " password " + psw + " " + lungpsw +" form bloccato");
		return false;
	} else {
		alert ("Viva!!! lunghezza user e psw maggiore uguale a 5 caratteri;  \n user: "+ user + " lunghezza: " + lunguser + "; \n password: "+ psw + " lunghezza: "+ lungpsw +"; \n Form va avanti");
		return true;
	}
}