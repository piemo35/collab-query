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


?>


<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- my css   -->
    <link rel="stylesheet" href="./css/main.css">
    <title>titolo</title>
</head>
<body>

<div class="container-fluid">
    <h1 class="center-align title "> DATABASE </h1>
    <div class="row">
        <!--   teoria     -->
        <div class="col m6 s12 teoria center-align ">
            <div class="content z-depth-3">
                <h2>Teoria</h2>

                <!--        select argument        -->
                <div class="input-field col s12">
                    <select>
                        <option value="" disabled selected>Scegli il tuo argomento:</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>

                <p class="flow-text">I am Flow Text</p>
            </div>
        </div>

        <!--   pratica  -->
        <div class="col m6 s12 pratica center-align ">

            <div class="content z-depth-3">
                <h2>Pratica</h2>

                <!--      query space          -->
                <div class="row ">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s11 query">
                                <i class="fas fa-database material-icons prefix"></i>
<!--                                <i class="material-icons  prefix">mode_edit</i>-->
                                <textarea id="icon_prefix2" class="materialize-textarea"></textarea>
                                <label for="icon_prefix2">Scrivi la tua query</label>
                            </div>

                            <div class="col offset-s9">
                                <button class="btn waves-effect waves-light" disabled type="submit" name="action">Submit
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
    <div class="row"></div>
</div>
<!--fontawesome -->
<script src="https://kit.fontawesome.com/650809f241.js" crossorigin="anonymous"></script>
<!-- jquery -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js" ></script>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>
<!-- my js   -->
<script src="./js/main.js"></script>
</body>
</html>