<?php
/*la classe determina se il login è stato fatto controllando
se la variabile Session "utente" è stata settata*/

class CheckLogin
{
 /**
 * la funzione IsLogged controlla se la variabile di Sessione utente è stata impostata.
 * Se tale variabile restituisce falso, significa che è necessario rifare il login.
 * @return boolean: se la variabile di sessione "utente" è settata restituisce vero altrimenti falso
 */
    public function IsLogged() {
        if (isset($_SESSION["utente"])) {
            return true;
        } else {
            return false;
        };
    }
}
?>