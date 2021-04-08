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

ob_start();

// include files automatic
spl_autoload_register(function ($class){
    require_once __DIR__."/{$class}.php";
});


$input = json_decode(file_get_contents("php://input"), true); //request json

$checker = new Checker(); // instance object

if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['req']) || !$checker->isEmptyOrNull($input))){

    $args = array( 'req' => FILTER_SANITIZE_ENCODED,
                  'query' => array('filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FLAG_NO_ENCODE_QUOTES)
    );


    $data = filter_var_array(array: (count($_POST) ? $_POST : $input), options: $args); // filter the post FILTER_FLAG_NO_ENCODE_QUOTES

    echo match ($data['req']) {
        'arguments' => $checker->sendData($checker->getArguments()),
        'query' => $checker->sendData($checker->executeQuery($data['query'])),
        default => $checker->badRequestResponse($data)
    };

} else{

    echo $checker->forbiddenResponse(count($_GET) ? $_GET : $_REQUEST);

}


ob_end_flush();