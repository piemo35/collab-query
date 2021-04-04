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


const keywords = [
    "SELECT",
    "UPDATE",
    "INSERT",
    "DELETE",
    "VALUES",
    "INTO",
    "FROM",
    "AS",
    "WHERE",
    "IN",
    "ON",
    "IS NULL",
    "EXISTS",
    "CREATE",
    "VIEWS",
    "VIEW",
    "PROCEDURE",
    "GROUP BY",
    "LIMIT",
    "OR",
    "AND",
    "DISTINCT",
    "ORDER BY",
    "HAVING",

]

const sendQueryButton = document.getElementById('sendQuery'),
      selectElement   = $('select'),
      descriptions    = $('.description'),
      textAreaElement = $('textarea');


sendQueryButton.onclick = event => event.preventDefault(); // to block event send



// all'avvio facciamo una chiamata al server per avere tutti gli argomenti
$.post("./php/mangeData.php", {"req" : "arguments"}, data => populate(JSON.parse(data)));


/**
 * function to create the party of arguments
 * @param data
 * @author Ahmed Mera
 */
function populate(data){
    // create select
    data.forEach( currentElement => {
        selectElement.append(`<option value = "${currentElement?.id}">  ${currentElement?.title} </option>`)
        descriptions.append($(`<p id = "${currentElement?.id}" class="flow-text">${currentElement?.description}</p>`))
    });

    descriptions.children().hide()

    $(document).ready(_=> selectElement.formSelect()); // init select
}


// will show only description if argument is chosen from select
$(document).on('change', 'select', function() {
    $(`#${$(this).val()}`).show(500).siblings().hide(300)
});


// get the query
$(document).on('keyup', 'textarea', function() {
    console.log($(this).val())
});

/**
 * list of to do:
 *  chiedere tutti gli argomenti al server e poi metterli nella tendina (OK)
 *  onChange la tendina dobbiamo visualizzare la descrizioni relativa all'argomento (OK)
 * TODO mandare i dati dal client al server (la query)
 * TODO controllare lato cliente sql injection (tutti le possibilità)
 * TODO checker php per evitare sql injection (tutti le possibilità)
 * TODO visualizzazioni dei dati ricevuti dal server
 * TODO restituire i dati al client in tabella
 *
 * */