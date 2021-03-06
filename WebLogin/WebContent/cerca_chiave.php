<?php

class cerca_chiave
{
    //$db � una classe POD che contiene la connessione ad DB
    private $db;
    //$tabella � il nome della tabella del DB MySQL
    private $tabella;
    //$val contiene la stringa da ricercare nel DB
    private $val;
    //� il campo del DB da utilizzare nell'SQL
    private $campoDB;

    /**
     * setter di $tabella
     * @return mixed
     */
    public function getTabella()
    {
        return $this->tabella;
    }

    /**
     * setter di $tabella
     * @param mixed $tabella
     */
    public function setTabella($tabella)
    {
        $this->tabella = $tabella;
    }

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
     * @param stringa $hostname: nome o indirizzo dell'host MySQL
     * @param stringa $dbname: nome del DB (schema)
     * @param stringa $user: user di accesso al server MySQL
     * @param stringa $pass: psw di accesso al server MySQL
     * @param stringa $Tabella: nome della tabella su cui si fa la query
     * @param stringa $campoDBricerca: � il nome del campo della tabella in cui cercare il valore $valore_da_cercare ovvero il nome del campo da mettere nell'sql
     * @param generico $valore_da_cercare: � il valore da cercare nel database e sul quale si imposta la query
     */
    public function __construct($hostname, $dbname, $user, $pass, $Tabella, $campoDBricerca, $valore_da_cercare)
    {
        // inizializzazione connessione dB MySql e creazione dell'oggetto $db
        $dB = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
        // inizializzazione variabile protetta $db con $dB
        $this->setdB($dB);
        // $this->db=$dB;
        //inizializzazione variabile $tabella
        $this->setTabella($Tabella);
        //inizializzazione variabile $val
        $this->setVal($valore_da_cercare);
        //$this->val = $valore_da_cercare;
        //inizializzo il campo del DB nel quale fare la ricerca ovvero da inserire nell'sql
        $this->setCampoDB($campoDBricerca);
    }
    /**
     * Il metodo controllo_doppi() controlla se la stringa $valore_da_cercare, ovvero
     * la user, � gi� presente nella tabella del database. Se � assente si procede all'inserimento nel
     * DB, altrimenti no. Proprio per questo restituisce un boolean
     * @return boolean
     */

    public function controllo_doppi()
    {
        try {
            // la seguente istruzione serve per evitare l'SQL Injection
            $valsicura = trim(filter_var($this->getVal(), FILTER_SANITIZE_STRING));
            //$sql = "SELECT * FROM login WHERE userlogin = '$valsicura'";
            /*compongo la query inserendo come campo del DB in cui cercare il valore che si ottiene
             * dal getter getCampoDB() che � un valore da fornire al costruttore chiamato $campoDBricerca
             * il valore da ricercare � parametrico (:valore) e viene definito con il binding
             * (stmt->bindParam). Questo serve per evitare l'SQL Injection
             */
            $sql = "SELECT * FROM ".$this->getTabella(). " WHERE " . $this->getCampoDB()."= :valore";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':valore', $valsicura, PDO::PARAM_STR);
            $stmt->execute();
            $totale = $stmt->rowCount();
            if ($totale > 0) {
                //echo "user presente nel DB";
                return false;
            } else {
                //echo "user non presente nel DB";
                return true;
            }
            //chiudo la connessione con il database
            $this->getDb().close();
            //$this->db.close();
            $this->db = null;
        } catch (PDOException $e) {
            echo "Errore: " . $e->getMessage();
            die();
        }
    }
}

?>
