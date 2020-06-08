<script>
// 2020-05-20 v0.4 Jovana Pavic 2017/0099
//      dinamicko ucitavanje korpe
// 2020-05-10 v0.1 Jovana Jankovic 2017/0586
//      staticki prikaz forme za porucivanje

/*
// iz html-a se pozivaju samo funkcije:
//  takeAmount(object) - add, sub i takeExactAmount spojene
//  removeFromBasket(id)
// ostale su pomocne funkcije
// svaki put kada se promeni nesto u korpi njen pregled se uklanja
// i iscrtava se nova
*/

let discount = false; 

//-----------------------------------------------
/** function takeAmount(object){...}
// Dodaje proizvod u korpu
// Ako jelo postoji u korpi promenice njegovu kolicinu
//  ako jelo ne postoji u korpi dodace ga               
// Kao parametar prima kolicinu i objekat sa sledecim atributima:
//  jelo_naziv, jelo_cena, jelo_masa, jelo_id 
*/   
  
function takeAmount(object) {
    let id = object.jelo_id;
    let name = object.jelo_naziv;
    let basePrice = object.jelo_cena;
    let baseAmount = object.jelo_masa;
    let kol = object.kol;
    
    let newId = "b_" + id;  //pravimo novo ime
    let newIdAmount = newId + "_a"; 
    
    //ako jelo vec postoji u korpi povecace kolicinu
    if ($("#"+newId).length>0) {
        //dohvati i uveca njegovu kolicinu
        let value = kol;
        //promeni gramaturu i cenu u korpi
        changeAmount(object, value);
    }
    //ako se prvi put dodaje u korpu
    else {
        //struktura koja se ubacuje (uopstena)
        let inner = 
           '<tr class=par id=' + newId + '>\
                <td rowspan=2>\
                    <img src="<?php echo base_url("assets/icons/square-minus.svg");?>"\
                        alt="." onclick=removeFromBasket("' + id + '")>\
                </td>\
                <td>' + name + '</td>\
                <td></td>\
                <td>\
                    <img src="<?php echo base_url("assets/icons/circle-minus.svg");?>"\
                        alt="-" onclick=smanji("' + id + '")>\
                </td>\
                <td class=amount_ordered>' + kol + '</td>\
                <td>\
                    <img src="<?php echo base_url("assets/icons/circle-plus.svg");?>"\
                        alt="+" onclick=povecaj("' + id + '")>\
                </td>\
            </tr>\
            <tr id=' + newIdAmount + '>\
                <td></td>\
                <td class=b_amount>' + baseAmount + 'g</td>\
                <td colspan=3 class=b_price>' + basePrice + 'din</td>\
            </tr>\
        ';
        if (kol > 0) {
            $("#basket").append(inner);
            changeAmount(object, kol);
        }
    }
    
    changeBasket();         //ponovo racuna vrednost korpe
    return;
}

//-----------------------------------------------
/** function removeFromBasket(id){...}
//uklanja proizvod iz korpe i stavku iz baze
*/

function removeFromBasket(id){
    //odredjuje da li je gost ili korisnik
    let uslov = "<?php 
            if(!array_key_exists('kor_id', $_SESSION)){
                echo print_r('false');
            }
            else{
                echo print_r('true');
            }
        ?>";
    if (uslov == "true1") {
        //ulogovani korisnik
        //uklanjamo stavku iz baze
        $.post("<?php echo base_url('Korisnik/removeFromOrder');?>",
                JSON.stringify({jelo_id: id}), 'json')
        .done(function(){
            //uklanja se iz pregleda korpe
            let newId = "b_" + id;  //pravimo novo ime
            let newIdAmount = newId + "_a"; 

            if ($("#"+newId).length > 0) $("#"+newId).remove();    
            if ($("#"+newIdAmount).length > 0) $("#"+newIdAmount).remove();

            //menjemo broj na opisu jela
            $("#broj_" + id + "").val('');

            //ponovo se racuna korpa
            deleteBasket();
            changeBasket();
        });
    }
    else {
        //gost
        //uklanja se iz pregleda korpe
        let newId = "b_" + id;  //pravimo novo ime
        let newIdAmount = newId + "_a"; 

        if ($("#"+newId).length > 0) $("#"+newId).remove();    
        if ($("#"+newIdAmount).length > 0) $("#"+newIdAmount).remove();

        //menjemo broj na opisu jela
        $("#broj_" + id + "").val('');

        //ponovo se racuna korpa
        deleteBasket();
        changeBasket();
        saveBasket();
    };
}

//-----------------------------------------------
/** function changeAmount(object, value)
//menja kolicinu proizvoda u prikazu korpe
*/

function changeAmount(object, value) {
    let id = object.jelo_id;
    let basePrice = object.jelo_cena;
    let baseAmount = object.jelo_masa;
    
    let newId = "b_" + id;  //pravimo novo ime
    let newIdAmount = newId + "_a"; 
    
    let amount = value * baseAmount;                                //nova gramatura
    let price = value * basePrice;                                  //nova cena
        
    $(".amount_ordered", $("#"+newId)).html(value);               //postavlja novu kolicinu
    $(".b_amount", $("#"+newIdAmount)).html(amount+"g");            //postavlja novu gramaturu
    $(".b_price", $("#"+newIdAmount)).html(price+"din");            //postavlja novu cenu
}

//-----------------------------------------------
/** function deleteBasket(){...}
//uklanja prikaz korpe
*/

function deleteBasket(){
    if ($("#basket_line").length > 0) $("#basket_line")[0].remove();
    if ($("#basket_sum").length > 0) $("#basket_sum")[0].remove();
    if ($("#forma_poruci").length > 0) $("#forma_poruci")[0].remove();

    if (discount) {
        if ($("#discount").length > 0) $("#discount").remove();
        if ($("#empty").length > 0) $("#empty").remove();
        if ($("#discount_basket_line").length > 0) $("#discount_basket_line").remove();
        if ($("#discount_basket_sum").length > 0) $("#discount_basket_sum").remove();
    }
}

//-----------------------------------------------
/** function changeBasket(){...}
//prikazuje korpu i racuna ukupnu cenu i kolicinu i prikazuje popust
//prikazuje formu za porucivanje
*/

function changeBasket() {
    //sabrati kolicinu i cenu porudzbine

    deleteBasket();
    
    let amount = 0;
    let price = 0;
    let orders_amount = $(".b_amount");
    let orders_price = $(".b_price");

    for(let i=0; i<orders_amount.length; i++){
        let str = orders_amount[i].innerHTML;
        amount += parseInt(str.slice(0,str.indexOf("g")));
    }

    for(let i=0; i<orders_price.length; i++){
        let str = orders_price[i].innerHTML;
        price += parseInt(str.slice(0,str.indexOf("d")));
    }
    
    let inner = "\
        <tr id=basket_line>\
            <td colspan=2></td>\
            <td colspan=4><hr style='border:1px solid black'/></td>\
        </tr>\
        <tr id=basket_sum>\
            <td colspan=2></td>\
            <td class=b_amount>" + amount +"g</td>\
            <td colspan=3 class=b_price>" + price + "din</td>\
        </tr>\
    ";
    if (orders_amount.length > 0) $("#basket").append(inner);
    
    //ako ima popust prikazi ga
    if (discount == true) {
        discount_price = Math.round(price * (-0.1));
        inner = "\
            <tr id=discount>\
                <td style=text-align:center> ! </td>\
                <td>Popust 10%</td>\
                <td></td>\
                <td colspan=3 class=b_price>" + discount_price + "din</td>\
            </tr>\
            <tr id=discount_basket_line>\
                <td colspan=2></td>\
                <td colspan=4><hr style='border:1px solid black'/></td>\
            </tr>\
            <tr id=discount_basket_sum>\
                <td colspan=2></td>\
                <td class=b_amount>" + amount +"g</td>\
                <td colspan=3 class=b_price>" + (price + discount_price) + "din</td>\
            </tr>\
        ";
        if(orders_amount.length > 0) $("#basket").append(inner);
    };

    //ispis statisckog dela
    let forma = 
       '<form id="forma_poruci" method="post" action="<?php base_url("Korisnik/order");?>">\
            <table class="text-center" cellpadding="5">\
                <tr >\
                    <td class="text-left vece" colspan=2>\
                        <div class="form-group por">\
                            <input type="text" class="form-control" name="naziv_porudzbine" \
                                id="imePor" placeholder="Naziv porudzbine(opciono)"/>\
                            <small id="imePor_help">&nbsp;</small>\
                        </div>\
                    </td>\
                </tr>\
                <tr style="display:block;">\
                    <td class="text-left">\
                        <div class="form-group por">\
                            <input type="text" class="form-control" name="brOsoba" \
                                id="kolikoOsoba" placeholder="Broj osoba">\
                            <small id="kolikoOsoba_help">&nbsp;</small>\
                        </div>\
                    </td>\
                    <td>\
                        <div class="form-group por">\
                            <select name="povod" class="form-control" id="kojiPovod">\
                                ' + listaPovoda() + '\
                            </select>\
                            <small id="kojiPovod_help">&nbsp;</small>\
                        </div>\
                    </td>\
                </tr>\
                <tr>\
                    <td class="text-left vece">\
                        <div class="form-group por">\
                            <input type="datetime-local" class="form-control" \
                                name="doKada" id="doKada"/>\
                            <small id="doKada_help">&nbsp;</small>\
                        </div>\
                    </td>\
                </tr>\
                <tr>\
                    <td class="text-center" colspan=2>\
                        <button type="button" name="potvrdi" \
                            class="btn btn-success" onclick=sendOrder()>Potvrdi\
                        </button>\
                        <button type="reset" name="odustani" class="btn btn-light">Odustani</button>\
                    </td>\
                </tr>\
            </table>\
        </form>\
        ';
    if (orders_amount.length > 0) 
        $(".poruci").append(forma);
}

//-----------------------------------------------
/** function activateDiscount(){...}
// Aktivira popust od 10%
*/

function activateDiscount() {
    discount = 1;
    changeBasket();
}

//-----------------------------------------------
/** function deactivateDiscount(){...}
// Uklanja popust 
*/

function deactivateDiscount() {
    discount = 0;
    changeBasket();
}

//-----------------------------------------------
/** function sendOrder(){...}
// Proverava unete podatke iz forme
// Ako je sve uredu salje zahtev za upis u bazu
//  i uklanja korpu i formu
// Ako nije obavestava korisnika sta nije uredu
*/

function sendOrder() {
    let error = false;
    
    let kol = $(".b_amount");
    kol = kol[kol.length-1].innerHTML
    if (kol == "0g"){
        $(".poruci").append('<p style="color:red; text-align:center;">Korpa je prazna</p>');
        return;
    }
    
    //provera broja osoba
    let naziv = $("#imePor")[0].value;
    let br_osoba = $("#kolikoOsoba");
    let br_osoba_num = parseInt(br_osoba[0].value);
    if (isNaN(br_osoba_num) || br_osoba_num < 0){
        br_osoba[0].value = '';
        br_osoba[0].style.backgroundColor = "red"; 
        $("#kolikoOsoba_help").html("Unesite broj osoba!");
        $("#kolikoOsoba_help")[0].style.color="red";
        error=true;
    }
    else {
        br_osoba[0].style.backgroundColor = "white";   
        $("#kolikoOsoba_help").html("&nbsp;");
    }
    
    //provera povoda
    let povod = $("#kojiPovod");
    let povod_id = povod[0].value;
    if (povod_id == 0){
        povod[0].style.backgroundColor = "red"; 
        $("#kojiPovod_help").html("Izaberite povod!");
        error = true;
    }
    else{
        povod[0].style.backgroundColor = "white";
        $("#kojiPovod_help").html("&nbsp;");
    }
    
    //provera datuma
    let datum = $("#doKada");
    let datum_date = datum[0].value;
    let datum1 = datum[0].value;
    datum_date = datum_date.replace("T", " ");
    datum_date = new Date(datum_date);
    let danasnjiDatum = new Date();
    if (datum_date <= danasnjiDatum || datum1 == "") {
        datum[0].style.backgroundColor = "red";
        $("#doKada_help").html("Odaberite datum!");
        error = true;
    }
    else{
        datum[0].style.backgroundColor = "white";
        $("#doKada_help").html("&nbsp;");
    }
    
    //php provera da li je ulogovan
    let uslov = "<?php 
            if(!array_key_exists('kor_id', $_SESSION)){
                echo print_r('false');
            }
            else{
                echo print_r('true');
            }
        ?>";
    if (uslov == "true1") {
        
        //ako nesto nije dobro popunjeno vrati korisniku
        if(error != false) return;
    
        datum_date = dateString(datum_date);
    
        $.post("<?php echo base_url('Korisnik/poruci');?>",
                JSON.stringify({"por_naziv": naziv, 
                                "por_br_osoba": br_osoba_num,
                                "por_za_dat": datum_date,
                                "povod_id": povod_id}), 'json')
        .done(function(){
            //u opisu jela uklanja narucenu kolicinu
            let stavke = $(".par");
            for(let i=0; i<stavke.length; i++){
                let id = stavke[i].id;
                id = id.substring(2);
                $("#broj_" + id + "").val('');
            }
            //uklanja korpu i formu za porucivanje
            $("#basket").empty();
            $(".poruci").empty();
        });
    }
    else {
        $(".poruci").append('<p style="color:red; text-align:center;">Niste prijavljeni</p>');
    }
}

//-----------------------------------------------
/** function listaPovoda(){...}
// Ucitava sve povode iz baze
*/

function listaPovoda() {
    //ugradjuje se u #kojiPovod
    $.post("<?php if(array_key_exists('kor_id', $_SESSION)){
                    echo base_url('Korisnik/sviPovodi');
                  }else{
                    echo base_url('Gost/sviPovodi');  
                  }
            ?>")
    .done(function(povodi){
        let str='<option value=0>Povod:</option>';
        for(let i=0; i<povodi.id.length; i++){
            str += '<option value="' + povodi.id[i] + '">' + povodi.opis[i] + '</option>';
        }
        $("#kojiPovod").html(str);
    });
}

//-----------------------------------------------
/** function dateString(){...}
// Parsira objekat tipa datum u odgovarajuci string
*/

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
    let str = year + "-" + month + "-" + day + " " + hour + ":" + min + ":00";
    return str;
}

</script>
