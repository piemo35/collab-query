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
 * function to create the party of arguments and description
 * @param data
 * @author Ahmed Mera
 */
function populate(data){
    // console.log(Object.keys(data[0]))
    console.log(data);
    // create select
    data.forEach( currentElement => {
        selectElement.append(`<option value = "${currentElement?.id}">  ${currentElement?.title.toUpperCase()} </option>`)

        descriptions.append($(
            `<div id = "${currentElement?.id}">
                 <h6>Argomento Scelto é <b>${currentElement?.title.toUpperCase()}</b>:</h6>
                  <p>${currentElement?.description}</p>
                    <!-- Modal Trigger -->
                   <a class="waves-effect waves-light btn modal-trigger" href="#modal${currentElement?.id}">Query di esempio</a>
                   <!-- Modal Structure -->
                  <div id="modal${currentElement?.id}" class="modal bottom-sheet">
                    <div class="modal-content">
                      <h4 class="header">Query di esempio</h4>
                      <p>Qua trovi una query di esempio per creare <b>${currentElement?.title.toUpperCase()}</b></p>
                      <code class="queryExample">${currentElement?.queryExample}</code>

                    </div>
                    <div class="modal-footer">
                      <a href="javascript:void(0)" class="modal-close waves-effect waves-green btn-flat">Ho Capito</a>
                    </div>
                  </div>
              </div>`
            )
        )

    });

    $('.teoria .description > div').hide()

    $(document).ready(_=> {
        selectElement.formSelect();
        $('.modal').modal();
    }); // init select and model

}


// will show only description if argument is chosen from select
$(document).on('change', 'select', function() {
    $(`#${$(this).val()}`).show(100).siblings().hide()
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
    //const regx = /[\/\\?{}#;$\[\]]|(-|=|\+|\*|\/){2,}|(delimiter)/img
    const regx = /[\/\\?{}|#;$\[\]]|(-|=|\+|\*|\/){2,}|(delimiter)/img
    return !value.match(regx) && value.length > 14;
}



sendQueryButton.onclick = event => {
    event.preventDefault();
    const query = textAreaElement.val();

    if(isValidQuery(query))
        $.post(file, {"req" : "query", 'data' : query}, data => console.log(data));

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
 *  checker php per evitare sql injection (tutti le possibilità) (ok)
 * creazione della tabella di riferimento nella parte di pratica (ok)
 *  esempio di query nella parte di descriptions (ok)
 * TODO visualizzazioni dei dati ricevuti dal server
 * TODO restituire i dati al client in tabella
 *
 * */
