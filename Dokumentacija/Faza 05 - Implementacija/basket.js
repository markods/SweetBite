/*
 * Virtuelna korpa - Jovana Pavic 0099/17
 * verzija 01
 */

var discount = 0; 

//dodaje proizvod u korpu i menja kolicinu istog klikom na "+"
function addAmount(name, baseAmount, basePrice) {
    let newName = "basket_" + name;  //pravimo novo ime
    let newNameAmount = newName + "_amount"; 
    
    let existing_elem = document.getElementById(newName);       //dohvatamo tu porudzbinu ako postoji   
    if (existing_elem != null) {    //--->ako jelo vec postoji u korpi
        //promeni kolicinu
        let value_elem = existing_elem.getElementsByClassName("amount_ordered")[0];     //dohvata se stara kolicina
        let value = parseInt(value_elem.innerHTML) + 1;                                 //uvecava se
        
        //promeni gramaturu i cenu
        changeAmount(name, value, baseAmount, basePrice);

    }
    else {          //--->ako se prvi put dodaje u korpu
        //struktura koja se ubacuje (uopstena)
        var inner = "\
            <tr id=" + newName + ">\
                <td rowspan=2>\
                    <img src='' alt='.' onclick=removeFromBasket('" + name + "')>\
                </td>\
                <td>" + name + "</td>\
                <td></td>\
                <td>\
                    <button type=button onclick=subAmount('" + name + "'," + baseAmount + "," + basePrice + ")>-</button>\
                </td>\
                <td class=amount_ordered> 1 </td>\
                <td>\
                    <button type=button onclick=addAmount('" + name + "'," + baseAmount + "," + basePrice + ")>+</button>\
                </td>\
            </tr>\
            <tr id=" + newNameAmount + ">\
                <td></td>\
                <td class=amount>" + baseAmount + "g</td>\
                <td colspan=3 class=price>" + basePrice + "din</td>\
            </tr>\
        "
        
        //dodaje se novi red (novi dummy_order), mora da se doda u tbody, a ne u table!
        document.getElementById("basket").getElementsByTagName("tbody")[0].innerHTML += inner;
    }
    
    changeBasket();         //ponovo racuna vrednost korpe
    return;
}

//smanjuje kolicinu proizvoda u korpi klikom na "-"
function subAmount(name, baseAmount, basePrice) {
    let newName = "basket_" + name;  //pravimo novo ime
    let newNameAmount = newName + "_amount";
    
    let existing_elem = document.getElementById(newName);       //dohvatamo tu porudzbinu ako postoji   
    //promeni kolicinu
    let value_elem = existing_elem.getElementsByClassName("amount_ordered")[0];     //dohvata se stara kolicina
    let value = parseInt(value_elem.innerHTML) - 1;                                 //smanjuje se
    if (value < 0) value = 0;
    
    //promeni gramaturu i cenu
    changeAmount(name, value, baseAmount, basePrice);

    changeBasket();         //ponovo racuna vrednost korpe
    return
}

//dodaje proizvod  u korpu i menja kolicinu istog unosenjem tacne kolicine
function takeExactAmount(name, baseAmount, basePrice, elem){
    let exactAmount = parseInt(elem.value);

    addAmount(name, baseAmount, basePrice);
    changeAmount(name, exactAmount, baseAmount, basePrice);

    changeBasket();
}

//uklanja proizvod iz korpe
function removeFromBasket(name){
    let newName = "basket_" + name;  //pravimo novo ime
    let newNameAmount = newName + "_amount"; 
    
    let order = document.getElementById(newName); 
    if (order != null) order.parentNode.removeChild(order);
    order = document.getElementById(newNameAmount); 
    if (order != null) order.parentNode.removeChild(order);

    changeBasket();
}

//menja kolicinu proizvoda
function changeAmount(name, value, baseAmount, basePrice) {
    let amount = value * baseAmount;                                                //nova gramatura
    let price = value * basePrice;   
    let newName = "basket_" + name;  //pravimo novo ime
    let newNameAmount = newName + "_amount";                                                  //nova cena
        
    let existing_elem = document.getElementById(newName);
    existing_elem.getElementsByClassName("amount_ordered")[0].innerHTML = value;
    
    existing_elem = document.getElementById(newNameAmount);
    existing_elem.getElementsByClassName("amount")[0].innerHTML = amount + "g";           //postavlja novu gramaturu
    existing_elem.getElementsByClassName("price")[0].innerHTML = price + "din";             //postavlja novu cenu
}

//uklanja prikaz korpe
function deleteBasket(){
    let basket_line = document.getElementById("basket_line"); 
    if (basket_line != null) basket_line.parentNode.removeChild(basket_line);
    let basket_sum = document.getElementById("basket_sum");  //dohvata se element za zamenu
    if (basket_sum != null) basket_sum.parentNode.removeChild(basket_sum);

    if (discount) {
        let discount = document.getElementById("discount"); 
        if (discount != null) discount.parentNode.removeChild(discount);
        let empty = document.getElementById("empty");  //dohvata se element za zamenu
        if (empty != null) empty.parentNode.removeChild(empty);
        let discount_basket_line = document.getElementById("discount_basket_line"); 
        if (discount_basket_line != null) discount_basket_line.parentNode.removeChild(discount_basket_line);
        let discount_basket_sum = document.getElementById("discount_basket_sum");  //dohvata se element za zamenu
        if (discount_basket_sum != null) discount_basket_sum.parentNode.removeChild(discount_basket_sum);
    }
}

//prikazuje korpu i racuna ukupnu cenu i kolicinu i prikazuje popust
function changeBasket() {
    //sabrati kolicinu i cenu porudzbine

    deleteBasket();

    var amount = 0;
    var price = 0;
    var orders_amount = document.getElementsByClassName("amount");
    var orders_price = document.getElementsByClassName("price");

    for(let i=0; i<orders_amount.length; i++){
        let str = orders_amount[i].innerHTML
        amount += parseInt(str.slice(0,str.indexOf("g")));
    }

    for(let i=0; i<orders_price.length; i++){
        let str = orders_price[i].innerHTML
        price += parseInt(str.slice(0,str.indexOf("d")));
    }
    
    var inner = "\
        <tr id=basket_line>\
            <td colspan=2></td>\
            <td colspan=4><hr/></td>\
        </tr>\
        <tr id=basket_sum>\
            <td colspan=2></td>\
            <td class=amount>" + amount +"g</td>\
            <td clospan=3 class=price>" + price + "din</td>\
        </tr>\
    ";

    if (orders_amount.length > 0) document.getElementById("basket").getElementsByTagName("tbody")[0].innerHTML += inner;

    if (discount) {

        let discount_amount = Math.round(price * (-0.1));

        inner = "\
            <tr id=discount>\
                <td rowspan=2> ! </td>\
                <td>Popust 10%</td>\
                <td></td>\
                <td colspan=3 class=price>" + discount_amount + "din</td>\
            </tr>\
            <tr id=empty><td colspan=5></td></tr>\
            <tr id=discount_basket_line>\
                <td colspan=2></td>\
                <td colspan=4><hr/></td>\
            </tr>\
            <tr id=discount_basket_sum>\
                <td colspan=2></td>\
                <td class=amount>" + amount +"g</td>\
                <td clospan=3 class=price>" + (price - discount_amount) + "din</td>\
            </tr>\
        "    

        if (orders_amount.length > 0) document.getElementById("basket").getElementsByTagName("tbody")[0].innerHTML += inner;
    }
}

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