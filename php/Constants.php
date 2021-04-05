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

final class Constants {

    protected string $ERROR_MSG = "Qualcosa è andato storto, riprova ancora oppure comunica l'amministratore col codice di error  ";

    /**
     * helper function to generate msg error
     * @param string $codError
     * @return string
     * @author Ahmed Mera
     */
    public function getErrorMSG(string $codError): string
    {
        return  $this->ERROR_MSG . "<b> {$codError} </b>" ;
    }






}