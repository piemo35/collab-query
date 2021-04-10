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

use JetBrains\PhpStorm\Pure;

class Checker{

    public static string $ERROR_MSG = "Qualcosa andato storto, riprova ancora oppure comunica l'amministratore col codice di error  ";
    protected string $pattern = '/[\/\\?{}|#;$\[\]]|(-|=|\+|\*|\/|@){2,}|(delimiter)/im';
    private ConfigurationDB $configurationDB;
    private ? PDO $pdo;
    private bool $success = false;


    /**
     * checker constructor.
     */
    public function __construct()
    {
        $this->configurationDB = new ConfigurationDB(user: "admin", pass: "1998", dataBasename: "sql_injection");

        try {
            $this->pdo = $this->configurationDB->connect();
        }catch (PDOException $exception){
            $this->pdo = null;
            $this->configurationDB->saveError($exception);
        }
    }


    /**
     * function to get all arguments
     * @return array|string|null
     * @author Ahmed Mera
     */
    public function getArguments(): array | string | null{
        return $this->executeQuery("SELECT * FROM arguments");
    }


    /**
     * helper function to execute the query and his args if exist
     * @param string $query
     * @return array|string|null
     * @author Ahmed Mera
     */
    public function executeQuery(string $query): array | string | null  {
        try{

            if(!$this->isValidData($query))
                throw new PDOException("Query dose NOT Valid. query --> " . $query);

            $statement = $this->pdo->prepare(query: $query);
            $statement->execute();
            $recordSet = $statement->fetchAll(PDO::FETCH_ASSOC);

            $this->setSuccess(true);

            return $recordSet;

        }catch (PDOException $exception){
            $this->configurationDB->saveError($exception);
            $this->setSuccess(false);
            return $this->getErrorMSG();
        }

    }


    /**
     * function to check if data is valid or not
     * @param string $data
     * @return bool <b>preg_match</b> returns 1 if the <i>pattern</i>
     * matches given <i>subject</i>, 0 if it does not, or <b>FALSE</b>
     * if an error occurred.
     * @author Ahmed Mera
     */
    public function isValidData(string $data): bool
    {
        return !preg_match($this->pattern, $data);
    }


    /**
     * helper function to check if is empty or null
     * @param mixed $object
     * @return bool
     * @author Ahmed Mera
     */
    public function isEmptyOrNull(mixed $object): bool{
        return $object == null || empty($object);
    }


    /**
     * helper function to print
     * @param mixed $element
     * @author Ahmed Mera
     */
    public function print(mixed $element): void{
        if (is_array($element) || is_object($element))
            print_r($element);
        else
            echo $element;
    }


    /**
     * function to send data to client
     * @param mixed $data
     * @return string|false a JSON encoded string on success or <b>FALSE</b> on failure.
     * @author Ahmed Mera
     */
    public function sendData(mixed $data): bool|string
    {
         return json_encode(['success' => $this->isSuccess(), 'response' => $data]);
    }


    /**
     * @param string $data
     * @return mixed the value encoded in <i>json</i> in appropriate
     * PHP type. Values true, false and
     * null (case-insensitive) are returned as <b>TRUE</b>, <b>FALSE</b>
     * and <b>NULL</b> respectively. <b>NULL</b> is returned if the
     * <i>json</i> cannot be decoded or if the encoded
     * data is deeper than the recursion limit.
     * @author Ahmed Mera
     */
    public function readData(string $data): mixed
    {
        return json_decode($data);
    }


    /**
     * helper function to generate msg error
     * @return string
     * @author Ahmed Mera
     */

    #[Pure]
    public function getErrorMSG(): string
    {
        return  Checker::$ERROR_MSG . "<b> <mark> {$this->configurationDB->getErrorID()} </mark></b>" ;
    }


    /**
     * function to print json response
     * @param array $args
     * @return string
     */
    public function forbiddenResponse(array $args): string
    {
        $this->configurationDB->saveError(new Exception("no post request or missed param req"));
        http_response_code(403);
        return '{"success": false, "error": {"status" : 403, "message": "Forbidden"}}';
    }


    /**
     * function to print json response
     * @param array $args
     * @return string
     */
    public function badRequestResponse(array $args): string
    {
        $this->configurationDB->saveError(new Exception("Bad args"));
        http_response_code(400);
        return '{"success": false, "error": {"status" : 400, "message": "Bad Request"}}';
    }


    /**
     * function to print json response
     * @param array $args
     * @return string
     */
    public function serviceUnavailable(array $args): string
    {
        $this->configurationDB->saveError(new Exception("Service Unavailable errorCode ---> {$this->configurationDB->getErrorID()}"));
        http_response_code(503);
        return '{"success": false, "error": {"status" : 503, "message": "Service Unavailable"}}';
    }


    /**
     * @return ConfigurationDB
     */
    public function getConfigurationDB(): ConfigurationDB
    {
        return $this->configurationDB;
    }

    /**
     * @param ConfigurationDB $configurationDB
     */
    public function setConfigurationDB(ConfigurationDB $configurationDB): void
    {
        $this->configurationDB = $configurationDB;
    }

    /**
     * @return PDO|null
     */
    public function getPdo(): PDO | null
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

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }




}