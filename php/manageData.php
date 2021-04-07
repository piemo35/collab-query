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

    $data = filter_var_array(array: (count($_POST) ? $_POST : $input), options: FILTER_SANITIZE_STRING); // filter the post

    echo match ($data['req']) {
        'arguments' => json_encode($checker->getArguments()),
        'query' => json_encode($_POST),
        default => $checker->badRequestResponse($data)
    };

} else{

    echo $checker->forbiddenResponse(count($_GET) ? $_GET : $_REQUEST);

}


ob_end_flush();