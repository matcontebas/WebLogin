<?php
class cerca_chiave
{
protected $db;
protected $val;
/**
 * Costruttore: crea l'oggetto dB connesso al database e acquisisce il valore da cercare nella query
 * @param stringa $hostname
 * @param stringa $dbname
 * @param stringa $user
 * @param stringa $pass
 * @param generico $valore_da_cercare: è il valore da cercare nel database e sul quale si imposta la query
 */
    public function __construct($hostname, $dbname, $user, $pass,$valore_da_cercare)
    {
        // inizializzazione connessione dB MySql e creazione dell'oggetto $db
        $dB = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
        //inizializzazione variabile protetta $db con $dB
        $this->db=$dB; 
        $this->val=$valore_da_cercare;
    }
    public function controllo_doppi () {
        try {           
        $valsicura = trim(filter_var($this->val, FILTER_SANITIZE_STRING));
        $sql = "SELECT * FROM login WHERE userlogin = '$valsicura'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $totale = $stmt->rowCount();
        if ($totale>0) {
           echo "user già presente" ;
           return false;
        } else {
            echo "user non presente nel DB";
            return true;
        }
        $this->db=null;
        } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die();
        }
    }
}

?>
