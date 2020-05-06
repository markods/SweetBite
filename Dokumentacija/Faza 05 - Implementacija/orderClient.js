/*
 * Prikaz porudzbine za klijenta - Jovana Pavic 0099/17
 * verzija 01
 */

var id = 0;

function showOrder(object) {
    /*Od ulaza potrebno:
        id - id porudzbine,
        name - ime porudzbine,
        stat - status porudzbine, 
        people - broj osoba, 
        date - datum proslave, 
        orderedName[] - imena narucenih jela, 
        orderedAmount[] - broj porcija,
        orderedWeight[] - ukupna kolicina narucenog jela ili velicina porcije?,
        orderedPrice[] - ukupna cena tog jela
        discount - da li je ostvaren popust
    */
    let name = "ime porudzbine"; let people = 3; let date = new Date(); let orderedName = ["cordon blau", "lasagna"]; 
    let orderedAmount = [2, 3]; let orderedWeight = [600, 400]; let orderedPrice = [1200, 1600]; let discount = true;
    //parsirati objekat u potrebne elemente

    //osnovni izgled bez detalja porudzbine
    var inner = "\
        <div class=about_order>\
            <text class=name>" + name+ "</text>\
            <img src='' alt='r' onhover=showStatus()/>\
            <br/>\
            <p class=about>" + people + " osoba </p>\
            <p class=about>" + date.toString() + "</p>\
        </div>\
        <div class=order_details>\
            <table class=order_amount>\
            </table>\
        </div>\
    "
    //dohvatiti sve dummy elemente
    var dummys = document.getElementsByClassName("dummy");
    dummys[0].innerHTML = inner;
    dummys[0].id = id;
    dummys[0].className = "col-md-6 order";

    //dodavanje detalja porudzbine
    var order_details = document.getElementById(id).getElementsByClassName("order_amount")[0];
    var price = 0;
    var weight = 0;
    for(let i=0; i<orderedName.length; i++) {
        var inner2 = "\
            <tr>\
                <td>" + orderedAmount[i] + "x </td>\
                <td class=name>" + orderedName[i] + "</td>\
                <td></td>\
                <td>" + orderedWeight[i] + "g</td>\
                <td>" + orderedPrice[i] + "din</td>\
            </tr>\
        "
        order_details.innerHTML += inner2;
        price += orderedPrice[i];
        weight += orderedWeight[i];
    }
    //dodavanje popusta
    if (discount == true) {
        var inner2 = "\
            <tr>\
                <td> ! </td>\
                <td colspan=2 class=name> Popust 10 % </td>\
                <td colspan=2>" + Math.round(price * (-0.1)) + "din</td>\
            </tr>\
        "
        order_details.innerHTML += inner2;
        price += Math.round(price * (-0.1));
    }
    //dodavanje konacne cene
    var inner3 = "\
        <tr>\
            <td colspan=2></td>\
            <td colspan=3><hr/></td>\
        </tr>\
        <tr>\
            <td colspan=2></td>\
            <td>" + people + " osoba</td>\
            <td>" + weight + "g</td>\
            <td>" + price + "din</td>\
        </tr>\
    "
    order_details.innerHTML += inner3;

    //dodavanje dummy elementa ako ih vise nema
    if (dummys.length == 0) {
        document.getElementsByTagName("body")[0].innerHTML += "\
            <div class = row>\
                <div class = 'col-md-6 dummy'></div>\
                <div class = 'col-md-6 dummy'></div>\
            </div>\
        "
    }

    id++;
}

function showStatus(){
    
}