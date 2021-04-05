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

const sendQueryButton    = document.getElementById('sendQuery'),
      selectElement      = $('select'),
      descriptions       = $('.description'),
      textAreaElement    = $('textarea'),
      suggestionsElement = $('.suggestion'),
      file               = "./php/manageData.php";




// all'avvio facciamo una chiamata al server per avere tutti gli argomenti
$.post(file, {"req" : "arguments"}, data => populate(JSON.parse(data)));


/**
 * function to create the party of arguments
 * @param data
 * @author Ahmed Mera
 */
function populate(data){
    // console.log(Object.keys(data[0]))
    // create select
    data.forEach( currentElement => {
        selectElement.append(`<option value = "${currentElement?.id}">  ${currentElement?.title.toUpperCase()} </option>`)
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
    if (isValidQuery($(this).val())){
        removeError()
        console.log('valid')
        sendQueryButton.disabled = false;
    }else{
        setError()
        console.log("not valid")
        sendQueryButton.disabled = true;
    }

    // const suggestions = keywords.filter(ele => ele.toLowerCase().includes($(this).val()));
    //  (suggestions.length) ? populateSuggestions(suggestions) : suggestionsElement.css('display', 'none');
    // console.log(keywords.filter(ele => ele.toLowerCase().includes($(this).val())))
});


// function populateSuggestions(suggests){
//     suggestionsElement.css('display', 'block')
//     let show = '';
//     suggests.forEach(suggest => show += `<p>${suggest}</p>`)
//     suggestionsElement[0].innerHTML = show;
// }


/**
 * function to check if is a valid query or not
 * @param value
 * @returns {boolean}
 */
function isValidQuery(value){
    const regx = /[\/\\?{}#;$\[\]]|(-|=|\+|\*|\/){2,}|(delimiter)/img
    return !value.match(regx) && value.length > 15;
}



sendQueryButton.onclick = event => {
    event.preventDefault();
    $.post(file, {"req" : "query", 'data' : textAreaElement.val()}, data => console.log(data));

} // to block event send


/**
 * function to set error
 * @author Ahmed Mera
 */
function setError(){
    $('.error .active').addClass('redColor')
    $('.error textarea').addClass('redBorder')
}

/**
 * function to remove error
 * @author Ahmed Mera
 */
function removeError(){
    $('.error .active').removeClass('redColor')
    $('.error textarea').removeClass('redBorder')
}



/**
 * list of to do:
 *  chiedere tutti gli argomenti al server e poi metterli nella tendina (OK)
 *  onChange la tendina dobbiamo visualizzare la descrizioni relativa all'argomento (OK)
 *  mandare i dati dal client al server (la query) (ok)
 *  controllare lato cliente sql injection (tutti le possibilità) (ok)
 * TODO checker php per evitare sql injection (tutti le possibilità)
 * TODO visualizzazioni dei dati ricevuti dal server
 * TODO restituire i dati al client in tabella
 * TODO creazione della tabella di riferimento nella parte di partica
 * TODO esmpio di query nella prte di descriptions
 *
 * */