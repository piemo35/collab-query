<?php

/*
 *
 *  *  Copyright (c) 2021
 *  *  Version: AM FREE 1.0.0
 *  *
 *  *  Copyright: Ahmed Mera
 *  *  https://mera.ddns.net
 *  *
 *  *  Contact: meraahmedibrahim@itis-molinari.eu
 *
 */


/**
 * Class Queries to mange the query request
 * @author Ahmed Mera
 */

class Queries{

    private PDO $pdo;


    /**
     * Queries constructor.
     * @param ConfigurationDB $configurationDB
     */
     public function __construct(private ConfigurationDB $configurationDB){
        $this->configurationDB = new ConfigurationDB(user: "admin", pass: "1998", dataBasename: "azienda");

         try {
            $this->pdo = $this->configurationDB->connect();
         }catch (PDOException $exception){
             $this->configurationDB->saveError($exception);
         }
    }



    /**
     * helper function to execute the query and his args if exist
     * @param string $query
     * @param array | null $arg
     * @return array | null
     */
    public function executeQuery(string $query, array | null $arg): array | null {
        $statement = $this->pdo->prepare(query: $query);
        $statement->execute($arg);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * helper function to map the query that will be execute
     * @param string|int $questionNumber
     * @return string | null
     * @author Ahmed Mera
     */
    public function getQuery(string | int $questionNumber): string | null{
        return match (strval($questionNumber)){
            "4" => "SELECT codImp, cognome FROM impiegati WHERE cognome LIKE 'a%'",
            "5" => "SELECT cognome FROM impiegati i JOIN dipartimenti d ON i.codDip = d.codDip AND d.citta = ? ORDER BY cognome ASC;",
            "6" => "SELECT t.codImp, t.data, t.oraI, t.oraF FROM turni t JOIN impiegati i ON t.codImp = i.codImp AND i.stipendio > 10000 AND i.codDip IN (SELECT codDip FROM dipartimenti  WHERE citta = ?);",
            "6.1" => "SELECT t.codImp, t.data, t.oraI, t.oraF FROM turni t, impiegati i, dipartimenti d WHERE t.CodImp = i.CodImp AND i.CodDip = d.CodDip AND d.Citta = ? AND i.stipendio > 10000;",
            "7" => "SELECT MAX(stipendio) as massimo FROM impiegati i JOIN dipartimenti d ON i.codDip = d.codDip AND d.citta = ?;",
            "7.1" => "SELECT MAX(stipendio) as massimo FROM impiegati i, dipartimenti d WHERE i.codDip = d.codDip AND d.citta = ? GROUP BY d.citta;",
            "8" => "SELECT i.codDip FROM impiegati i, dipartimenti d WHERE i.codDip = d.codDip GROUP BY d.codDip HAVING SUM(i.stipendio) > 10000000",
            "9" => "SELECT i.codDip, AVG(i.stipendio) as media FROM impiegati i, dipartimenti d WHERE i.CodDip = d.codDip AND d.citta = ? GROUP BY d.codDip",
            "10" => "SELECT d.codDip, d.denominazione, MAX(i.stipendio) AS massimo FROM impiegati i, dipartimenti d WHERE i.codDip = d.codDip AND d.citta = ? GROUP BY d.codDip HAVING SUM(i.stipendio) > 100000000",
            default => null
        };

    }


    /**
     * helper function to get the arg if exist
     * @param string|int $questionNumber
     * @return array | null
     */
    public function getArg(string | int $questionNumber): array | null{
        return match(strval($questionNumber)){
            "5", "9", "10" => array("torino"),
            "6" => array("roma"),
            "7" => array("milano"),
            default => null
        };
    }



    /**
     * helper function to check if is empty or null
     * @param mixed $object
     * @return bool
     */
    public function isEmptyOrNull(mixed $object): bool{
         return $object == null || empty($object);
    }


    /**
     * helper function to print
     * @param mixed $element
     */
    public function print(mixed $element): void{
        if (is_array($element))
            print_r($element);
        else
            echo $element;
    }


    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @param PDO $pdo
     */
    public function setPdo(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }



}