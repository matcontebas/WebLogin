<?php
/*la classe determina se il login � stato fatto controllando
se la variabile Session "utente" � stata settata*/

class CheckLogin
{
    public function IsLogged() {
        if (isset($_SESSION["utente"])) {
            return true;
        } else {
            return false;
        };
    }
}
?>