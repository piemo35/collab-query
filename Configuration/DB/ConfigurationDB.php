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
 * Class ConfigurationDB
 */
class ConfigurationDB{

    private string $dsn;
    private string $user;
    private string $pass;
    private string $dataBasename;
    private string $host;
    private int    $port;
    private string $errorID;

    /**
     * ConfigurationDB constructor.
     * @param string $user default {@value admin}
     * @param string $pass default {@value 1998}
     * @param string $dataBasename default {@value microservizi}
     * @param string $host default {@value MySQL}
     * @param int $port default {@value 3306}
     * @author Ahmed Mera
     */
    public function __construct(string $user = 'admin', string $pass = '1998', string $dataBasename = 'test', string $host = 'MySQL', int $port = 3306){
        $this->user = $user;
        $this->pass = $pass;
        $this->dataBasename = $dataBasename;
        $this->host = $host;
        $this->port = $port;
        $this->dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dataBasename}";
    }


    /**
     * For connection to your DB
     * @return PDO object to use.
     * @throws PDOException if the attempt to connect to the requested database fails.
     * @author Ahmed Mera
     */
    public function connect(): PDO {
        $con = new PDO($this->dsn , $this->user, $this->pass);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $con;
    }


    /**
     * helper function to save error
     * @param PDOException $e
     * @return int | false The function returns the number of bytes that were written to the file, or
     */
    public function saveError(PDOException $e): bool | int
    {
        $file = __DIR__.'/error.json';

        $this->checkFile($file);

        $ERROR = (array)json_decode(file_get_contents($file)); //get content from file

        $this->errorID = uniqid() . count($ERROR); // id error

        $ERROR[$this->errorID] =  array(
            'error_msg'  => $e->getMessage(),
            'error_file' => $e->getFile(),
            'error_line' => $e->getLine(),
            'error_code' => $e->getCode(),
            'trace'      => $e->getTrace(),
            'date'       => date("d-m-Y H:i:s")
        );

        return file_put_contents($file, json_encode($ERROR),  LOCK_EX); // save on file

    }


    /**
     * helper function to check if file is exist or not and create it if not
     * @param string $file
     * @return bool | string
     * @author Ahmed Mera
     */
    private function checkFile(string $file): bool | string
    {
        if(! file_exists($file)) {
            touch($file); // create file
           return chmod($file, 0766); // change permission all for owner, read and write for other
        }else{
            return "file is exist.";
        }
    }


    /**
     * @return string
     * @see dns must be like that e.x 'mysql:host=MySQL;dbname=microservizi'
     */
    public function getDns(): string
    {
        return $this->dsn;
    }

    /**
     * @param string $dsn
     */
    public function setDns(string $dsn): void
    {
        $this->dsn = $dsn;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @return string
     */
    public function getDataBasename(): string
    {
        return $this->dataBasename;
    }

    /**
     * @param string $dataBasename
     */
    public function setDataBasename(string $dataBasename): void
    {
        $this->dataBasename = $dataBasename;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getErrorID(): string
    {
        return $this->errorID;
    }

    /**
     * @param string $errorID
     */
    public function setErrorID(string $errorID): void
    {
        $this->errorID = $errorID;
    }


}