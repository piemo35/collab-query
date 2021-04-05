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


if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['req'] == 'arguments'){
    echo json_encode([["id" => 1, "title" => "vista", "description" => "vista"], ["id" => 2, "title" => "procedure", "description" => "procedure"]]);
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['req'] == 'query'){
    echo json_encode($_POST);
} else{
    echo json_encode(["esito" => "KO"]);
}