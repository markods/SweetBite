<script>
// 2020-05-15 v0.3 Jovana Pavic 2017/0099
//      dinamicko ucitavanje korpe
// 2020-05-10 v0.1 Jovana Jankovic 2017/0586
//      staticki prikaz forme za porucivanje

// iz html-a se pozivaju samo funkcije:
//  takeAmount(object) - add, sub i takeExactAmount spojene
//  removeFromBasket(id)
// ostale su pomocne funkcije
// svaki put kada se promeni nesto u korpi njen pregled se uklanja
// i iscrtava se nova

var discount = false; 

//-----------------------------------------------
/** function takeAmount(object){...}
// dodaje proizvod u korpu
// ako jelo postoji u korpi promenice njegovu kolicinu
// ako jelo ne postoji u korpi dodace ga               
// Kao parametar prima kolicinu i objekat sa sledecim atributima:
// jelo_naziv, jelo_cena, jelo_masa, jelo_id 
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
           '<tr id=' + newId + '>\
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
        
        $("#basket").append(inner);
        changeAmount(object, kol);
    }
    
    changeBasket();         //ponovo racuna vrednost korpe
    return;
}

//-----------------------------------------------
/** function removeFromBasket(id){...}
//uklanja proizvod iz korpe i stavku iz baze
*/

function removeFromBasket(id){
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
                    <td class="text-left">\
                        <input type="text" size=24 name="naziv_porudzbine" placeholder="Naziv porudzbine(opciono)"/>\
                    </td>\
                </tr>\
                <tr>\
                    <td class="text-left">\
                        <input type="text" size="10" name="brOsoba" placeholder="Broj osoba">\
                        <select name="povod">\
                            <option value="0">Povod</option>\
                            <option value="1">Rodjendan</option>\
                            <option value="2">Krstenje</option>\
                            <option value="3">Svadba</option>\
                            <option value="4">Zurka</option>\
                            <option value="5">Diplomski</option>\
                        </select>\
                    </td>\
                </tr>\
                <tr>\
                    <td class="text-left">\
                        <input type="date" name="doKadaD">\
                        <input type="time" name="doKadaV">\
                    </td>\
                </tr>\
                <tr>\
                    <td class="text-center">\
                        <button type="submit" name="potvrdi" class="btn btn-success" >Potvrdi</button>\
                        <button type="reset" name="odustani" class="btn btn-light">Odustani</button>\
                    </td>\
                </tr>\
            </table>\
        </form>\
        ';
    $(".poruci").append(forma);
}

//-----------------------------------------------
//aktivira popust od 10%
function activateDiscount() {
    discount = 1;
    changeBasket();
}

//uklanja popust 
function deactivateDiscount() {
    discount = 0;
    changeBasket();
}

</script>
