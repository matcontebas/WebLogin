<?php

class cerca_chiave
{

    private $db;
    private $val;
    //è il campo del DB da utilizzare nell'SQL
    private $campoDB;

    /**
     * getter della variabile $campoDB
     * @return mixed
     */
    public function getCampoDB()
    {
        return $this->campoDB;
    }

    /**
     * setter della variabile $campoDB
     * @param mixed $campoDB
     */
    public function setCampoDB($campoDB)
    {
        $this->campoDB = $campoDB;
    }

    /**
     *getter della variabile $db
     * @return Ambigous <NULL, PDO>
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     *getter della variabile $val
     * @return mixed
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     *setter della variabile $db
     * @param
     *            Ambigous <NULL, PDO> $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     *setter della variabile $val
     * @param mixed $val
     */
    public function setVal($val)
    {
        $this->val = $val;
    }

    /**
     * Costruttore: crea l'oggetto dB connesso al database e acquisisce il valore da cercare nella query
     *
     * @param stringa $hostname
     * @param stringa $dbname
     * @param stringa $user
     * @param stringa $pass
     * @param generico $valore_da_cercare:
     *            è il valore da cercare nel database e sul quale si imposta la query
     */
    public function __construct($hostname, $dbname, $user, $pass, $campoDBricerca, $valore_da_cercare)
    {
        // inizializzazione connessione dB MySql e creazione dell'oggetto $db
        $dB = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
        // inizializzazione variabile protetta $db con $dB
        $this->setdB($dB);
        // $this->db=$dB;
        $this->setVal($valore_da_cercare);
        //$this->val = $valore_da_cercare;
        //inizializzo il campo del DB nel quale fare la ricerca ovvero da inserire nell'sql
        $this->setCampoDB($campoDBricerca);
    }

    public function controllo_doppi()
    {
        try {
            $valsicura = trim(filter_var($this->val, FILTER_SANITIZE_STRING));
            //$sql = "SELECT * FROM login WHERE userlogin = '$valsicura'";
            /*compongo la query inserendo come campo del DB in cui cercare il valore che si ottiene
             * dal getter getCampoDB() che è un valore da fornire al costruttore chiamato $campoDBricerca
             */
            $sql = "SELECT * FROM login WHERE " . $this->getCampoDB()."= '$valsicura'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $totale = $stmt->rowCount();
            if ($totale > 0) {
                echo "user presente nel DB";
                return false;
            } else {
                echo "user non presente nel DB";
                return true;
            }
            $this->db = null;
        } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die();
        }
    }
}

?>
