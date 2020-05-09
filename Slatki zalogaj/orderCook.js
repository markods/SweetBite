/*
 * Prikaz porudzbine za menadzera - Jovana Pavic 0099/17
 * verzija 02 - rowless verzija
 */

var id = 0;

//razlika u odnosu na Prikaz porudzbine za kupca (orderClient.js) je u prikazu opisa porudzbine
//dodato je ime klijenta i njegov broj telefona u metodi showOrder()
//drugacija metoda statusOptions()

function showOrder(object) {
    /*Od ulaza potrebno:
        id - id porudzbine,
        name - ime porudzbine,
        date - datum proslave, 
        orderedName[] - imena narucenih jela, 
        orderedAmount[] - broj porcija,
        orderedWeight[] - ukupna kolicina narucenog jela ili velicina porcije?
        orderedStatus[] - statusi jela (0-nije napravljeno, 1-napravljeno)
    */

    let name = "ime porudzbine";  let date = new Date(); let orderStatus = 1; let orderedName = ["cordon blau", "lasagna"]; 
    let orderedAmount = [2, 3]; let orderedWeight = [600, 400]; let orderedStatus = [1,0];
    //parsirati objekat u potrebne elemente

    //osnovni izgled bez detalja porudzbine
    var inner = "\
        <div class=about_order>\
            <text class=name>" + name+ "</text>\
            <text class=stat><input type=checkbox class='check_done order_complited' onclick=orderDone(" + id + ")></text>\
            <p></p>\
            <text class=about>" + dateString(date) + "</text>\
        </div>\
        <div class=order_details>\
            <table class=order_amount>\
            </table>\
        </div>\
    "
    //dohvatiti sve dummy elemente
    var dummy = $(".dummy");
    dummy.html(inner);
    dummy[0].id = id;
    dummy.removeClass("dummy").addClass("order");

    //dodavanje detalja porudzbine
    var order_details = $(".order_amount", $("#"+id));
    for(let i=0; i<orderedName.length; i++) {
        var statusTemp = orderedStatus[i] == 1? "checked=on" : "";
        var inner2 = "\
            <tr class=" + i + ">\
                <td>" + orderedAmount[i] + "x </td>\
                <td class=name>" + orderedName[i] + "</td>\                <td></td>\
                <td>" + orderedWeight[i] + "g</td>\
                <td><input type=checkbox class='check_done order_part' onclick=dishDone(" + id + "," + i + ") " + statusTemp + "></td>\
            </tr>\
        "
        order_details.append(inner2);
    }

    //dodavanje dummy elementa
    $(".cont").append("<div class='dummy'></div>");
    id++;
}

function dishDone(id, pos) {
    //menja se status u bazi
}

function orderDone(id) {
    let parts = $(".order_part", $("#"+id));
    let all = true;
    for(let i=0; i<parts.length; i++) {
        if (parts[i].checked == false) {
            all = false;
            break;
        }
    }
    if (all == false) {
        $(".order_complited", $("#"+id))[0].checked = false;
    }
    else {
        //menja status u bazi na gotovo
        //uklanja se porudzbina iz prikaza

        $("#"+id).remove(); //obrisemo nas order        
    }
}

//formatira datum
function dateString(date) {
    let year = date.getFullYear();
    let month =  date.getMonth() + 1;
    if (month < 10) month = "0" + month;
    let day = date.getDay();
    if (day < 10) day = "0" + day;
    let hour = date.getHours()
    if (hour < 10) hour = "0" + hour;
    let min = date.getMinutes();
    if (min < 10) min = "0" + min;
    let str = year + "-" + month + "-" + day + " " + hour + ":" + min;
    return str;
}