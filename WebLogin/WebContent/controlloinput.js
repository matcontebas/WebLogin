/**
 * http://usejsdoc.org/
 */
function MyFunction(campouser, campopsw) {
	var user=campouser;
	var lunguser=user.length;
	var psw=campopsw;
	var lungpsw=psw.length;
	alert("lunghezza password: " + lungpsw);
	if (lunguser < 5 || lungpsw < 5) {
		alert ("lunghezza user o psw minore di 5 caratteri: "+ user + " "+ lunguser + " password " + psw + " " + lungpsw +" form bloccato");
		return false;
	} else {
		alert ("lunghezza user maggiore uguale a 5 caratteri; user: "+ user + " lunghezza: " + lunguser + "; password "+ psw + " "+ lungpsw +". </br> Form va avanti");
		return true;
	}
}