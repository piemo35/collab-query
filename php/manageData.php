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

$checker = new Checker(); // instance object

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['req'])){

    $data = filter_var_array($_POST,FILTER_SANITIZE_STRING); // filter the post

    echo match ($data['req']) {
        'arguments' => json_encode([["id" => 1, "title" => "vista", "description" => "vista"], ["id" => 2, "title" => "procedure", "description" => "procedure"]]),
        'query' => json_encode($_POST),
        default => null
    };

} else{

    $checker->getConfigurationDB()->saveError(new PDOException("no post request"));
    print_r( json_decode($checker->sendData(data: $checker->getErrorMSG(), success: false)));

}


ob_end_flush();