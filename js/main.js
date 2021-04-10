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

],

  sendQueryButton    = document.getElementById('sendQuery'),
  selectElement      = $('select'),
  descriptions       = $('.description'),
  textAreaElement    = $('textarea'),
  suggestionsElement = $('.suggestion'),
  file               = "./php/manageData.php",
 table               = document.getElementById("table");




// all'avvio facciamo una chiamata al server per avere tutti gli argomenti
$.post(file, {"req" : "arguments"})
    .done(data => populate(JSON.parse(data)))
    .fail(data => populate(JSON.parse(data?.responseText)));


/**
 * function to create the party of arguments and description
 * @param data
 * @author Ahmed Mera
 */
function populate(data){
    // console.log(Object.keys(data[0]))
    // console.log(data);

    if(data !== null && data?.success) {

        // create select
        (data?.response).forEach(currentElement => {
            selectElement.append(`<option value = "${currentElement?.id}">  ${currentElement?.title.toUpperCase()} </option>`)

            descriptions.append($(
                `<div id = "${currentElement?.id}">
                 <h6>L'argomento scelto é <b>${currentElement?.title.toUpperCase()}</b>:</h6>
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
    }


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
        ableBtn(null)
    }else{
        setError()
        disableBtn(null)
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
    const regx = /[\/\\?{}|#;$\[\]]|(-|=|\+|\*|\/|@){2,}|(delimiter)/img
    return !value.match(regx) && value.length > 14;
}



sendQueryButton.onclick = event => {
    event.preventDefault();
    const query = textAreaElement.val().trim();

    if(isValidQuery(query)) {
        $.post(file, {"req" : "query", "query" : query}, data => createTable(JSON.parse(data)));
    } else {
        setError()
        disableBtn(null)
    }

} // to block event send


/**
 * function to set error
 * @author Ahmed Mera
 */
function setError(){
    $('.error .fa-database, .error label').addClass('redColor')
    $('.error textarea').addClass('redBorder')
}

/**
 * function to remove error
 * @author Ahmed Mera
 */
function removeError(){
    $('.error .fa-database, .error label').removeClass('redColor')
    $('.error textarea').removeClass('redBorder')
}

/**
 * arrow function to disable button
 * @returns {boolean}
 */
const disableBtn = _=> {
    $(sendQueryButton).removeClass('pulse')
    sendQueryButton.disabled = true;
}

/**
 * arrow function to able button
 * @returns {boolean}
 */
const ableBtn = _=> {
    $(sendQueryButton).addClass('pulse')
    sendQueryButton.disabled = false;
}


function createTable(resultSet){

    let thead = `<thead> <tr>`,
        tbody = `<tbody>`;

    if(resultSet?.success) {

        if (Array.isArray(resultSet?.response)){

            // console.log(Object.keys(resultSet?.response[0]));
            $(table).show();
        $('.errors').hide();

        // create thead
        (Object.keys(resultSet?.response[0])).forEach(currentKey => thead += `<th> ${currentKey} </th>`);
        thead += `</tr>`;


        // create tbody
        resultSet?.response.forEach(currentRecord => {
            let row = `<tr>`;

            Object.values(currentRecord).forEach(currentValue => row += `<td> ${currentValue} </td>`)

            row += `</tr>`
            tbody += row;
        });

        tbody += `</tbody>`;

        table.innerHTML = (thead + tbody);

    }else {
        $(table).hide();
        $('.errors').html(resultSet?.response).show();
    }

    }else{
        // console.log(resultSet)
        $(table).hide();
        setError()
        disableBtn(null)
        $('.errors').html(resultSet?.response).show();
    }

}

