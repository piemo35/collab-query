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


const keywords = {
    "SELECT": null,
    "UPDATE": null,
    "INSERT": null,
    "DELETE": null,
    "VALUES": null,
    "INTO": null,
    "FROM": null,
    "AS": null,
    "WHERE": null,
    "IN": null,
    "ON": null,
    "IS NULL": null,
    "EXISTS": null,
    "CREATE": null,
    "VIEWS": null,
    "VIEW": null,
    "PROCEDURE": null,
    "GROUP BY": null,
    "LIMIT": null,
    "OR": null,
    "AND": null,
    "DISTINCT": null,
    "ORDER BY": null,
    "HAVING": null,

}

const sendQuery = document.getElementById('sendQuery');
const text = document.getElementsByTagName('textarea')[0];

$(document).ready(function(){
    $('select').formSelect();
});

sendQuery.onclick = event => event.preventDefault(); // to block event send

// text.onkeyup = _=> console.log(text.value)







/**
 * list of to do:
 * TODO chiedere tutti gli argomenti al server e poi metterli nella tendina
 * TODO onChange la tendina dobbiamo visualizzare la descrizioni relativa all'argomento
 * TODO mandare i dati dal client al server
 * TODO controllare lato cliente sql injection (tutti le possibilità)
 * TODO checker php per evitare sql injection (tutti le possibilità)
 * TODO visualizzazioni dei dati ricevuti dal server
 * TODO restituire i dati al client
 *
 * */