/*
 * Administracija - Jovana Pavic 0099/17
 * verzija 02 - rowless verzija
 * 
 *      bolje ostaviti redove jer predstavljaju neophodno grupisanje po tipu korisnika,
 *      mogu da se izbace redovi koji okruzuju naziv tipa korisnika
 */

var id = 0;

function addUser(priv, object){
    /* Potrebno:
        id - id korisnika
        name - ime korisnika
        mail - mail korisnika
        date - datum kreiranja naloga
        priv - privilegije korisnika (0-admin, 1-menadzer, 2-kuvar, 3-kupac)
    */

    id++; let name = "Pera Petrovic", mail = "para@email.com", date = new Date();

    var inner = "\
        <table id=" + id + " class=adm>\
            <tr>\
                <td class=name>" + name + "</td>\
                <td class=mail>" + mail + "</td>\
                <td class=date>" + dateString(date) + "</td>\
                <td class=priv>" + showPrivilegy(id, priv) + "</td>\
                <td class=remove><img src='assets/administration_discard.svg' alt='-' onclick='removeAccount(" + id + ")'/></td>\
            </tr>\
        </table>\
    "
    var position = null;
    switch (priv) {
        case 0: position = $(".admin"); break;
        case 1: position = $(".menag"); break;
        case 2: position = $(".cook"); break;
        case 3: position = $(".buyer"); break;
    }

    $(".dummy", position).append(inner);                            //dohvata .dummy unutar elementa position
    $(".dummy", position).removeClass("dummy").addClass("user");

    position.append("<div class='col-md-12 dummy'></div>");
}

//uklanja nalog
function removeAccount(id) {
    //postaviti flag u bazi
    var elem = $("#"+id).parent();
    elem.remove();
}

//prikaz u odnosu na privilegiju
function showPrivilegy(id, priv) {
    //proveriti kako funkcionise menjanje privilegija!
    var str = "";
    switch (priv) {
        case 0: str = "<img src='assets/administration_admin.svg' alt='a' onclick=removePrivilegy(" + id + ")>\
                        <img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",1)>\
                        <img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",2)>"; break;
        case 1: str = "<img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",0)>\
                        <img src='assets/administration_manager.svg' alt='m' onclick=removePrivilegy(" + id + ")>\
                        <img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",2)>"; break;
        case 2: str = "<img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",0)>\
                        <img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",1)>\
                        <img src='assets/administration_cook.svg' alt='k' onclick=removePrivilegy(" + id + ")>"; break;
        case 3: str = "<img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",0)>\
                        <img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",1)>\
                        <img src='assets/administration_nothing.svg' alt='o' onclick=setPrivilegy(" + id + ",2)>"; break;
    }
    return str;
}

//promena privilegije
function setPrivilegy(id, priv) {
    removeAccount(id);
    addUser(priv); //zapravo se salje taj korisnik sa tom privilegijom (promeni mu se taj status)
}

function removePrivilegy(id) {
    removeAccount(id);
    addUser(3); //zapravo se salje taj korisnik sa tom privilegijom (promeni mu se taj status)
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