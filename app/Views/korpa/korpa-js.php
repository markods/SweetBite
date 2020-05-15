<script>

/*
 * Virtuelna korpa - Jovana Pavic 0099/17
 * verzija 01 - rowless verzija
 * 
 *      prvobitni dizajn nije sadrzao redove, sve je radjeno preko tabele
 * 
 */

var discount = true;
var price = 0;
var discount_price = 0; 

//dodaje proizvod u korpu i menja kolicinu istog klikom na "+"
function addAmount(name, baseAmount, basePrice) {
    let newName = "basket_" + name;  //pravimo novo ime
    let newNameAmount = newName + "_amount"; 
    
    if ($("#"+newName).length>0) {    //--->ako jelo vec postoji u korpi
        //promeni kolicinu
        let value = parseInt($(".amount_ordered", $("#"+newName))[0].innerHTML) + 1;
        //promeni gramaturu i cenu
        changeAmount(name, value, baseAmount, basePrice);
        setAmountInTextField(name, value);
    }
    else {          //--->ako se prvi put dodaje u korpu
        //struktura koja se ubacuje (uopstena)
        var inner = "\
            <tr id=" + newName + ">\
                <td rowspan=2>\
                    <img src='../../../public/assets/icons/basket_discard.svg' alt='.' onclick=removeFromBasket('" + name + "')>\
                </td>\
                <td>" + name + "</td>\
                <td></td>\
                <td>\
                    <img src='../../../public/assets/icons/basket_sub.svg' alt='-' onclick=subAmount('" + name + "'," + baseAmount + "," + basePrice + ")>\
                </td>\
                <td class=amount_ordered> 1 </td>\
                <td>\
                    <img src='../../../public/assets/icons/basket_add.svg' alt='+' onclick=addAmount('" + name + "'," + baseAmount + "," + basePrice + ")>\
                </td>\
            </tr>\
            <tr id=" + newNameAmount + ">\
                <td></td>\
                <td class=amount>" + baseAmount + "g</td>\
                <td colspan=3 class=price>" + basePrice + "din</td>\
            </tr>\
        "
        
        $("#basket").append(inner);
        setAmountInTextField(name,1);
    }
    
    changeBasket();         //ponovo racuna vrednost korpe
    return;
}

//smanjuje kolicinu proizvoda u korpi klikom na "-"
function subAmount(name, baseAmount, basePrice) {
    let newName = "basket_" + name;  //pravimo novo ime
    
    //ako porudzbina ne postoji izlazimo
    if($("#"+newName).length == 0) return;
    
    let value = parseInt($(".amount_ordered", $("#"+newName))[0].innerHTML) - 1;                                 //smanjuje se
    if (value < 0) value = 0;
    
    //promeni gramaturu i cenu
    changeAmount(name, value, baseAmount, basePrice);
    setAmountInTextField(name, value);

    changeBasket();         //ponovo racuna vrednost korpe
    return
}

//dodaje proizvod  u korpu i menja kolicinu istog unosenjem tacne kolicine
function takeExactAmount(name, baseAmount, basePrice, elem){
    let exactAmount = parseInt(elem.value);
    if (isNaN(exactAmount) || exactAmount < 0) {
        exactAmount = 0;
        elem.value="";
    }
    else {
        addAmount(name, baseAmount, basePrice);
        changeAmount(name, exactAmount, baseAmount, basePrice);
        setAmountInTextField(name,exactAmount);
        changeBasket();
    }
}

//uklanja proizvod iz korpe
function removeFromBasket(name){
    let newName = "basket_" + name;  //pravimo novo ime
    let newNameAmount = newName + "_amount"; 
    
    if ($("#"+newName).length > 0) $("#"+newName).remove();    
    if ($("#"+newNameAmount).length > 0) $("#"+newNameAmount).remove();

    setAmountInTextField(name, 0);
    changeBasket();
}

//menja kolicinu proizvoda
function changeAmount(name, value, baseAmount, basePrice) {
    let amount = value * baseAmount;                                //nova gramatura
    let price = value * basePrice;                                  //nova cena
    let newName = "basket_" + name;  //pravimo novo ime
    let newNameAmount = newName + "_amount";
        
    $(".amount_ordered", $("#"+newName)).html(value);               //postavlja novu kolicinu
    $(".amount", $("#"+newNameAmount)).html(amount+"g");            //postavlja novu gramaturu
    $(".price", $("#"+newNameAmount)).html(price+"din");            //postavlja novu cenu
}

//uklanja prikaz korpe
function deleteBasket(){
    if ($("#basket_line").length > 0) $("#basket_line").remove();
    if ($("#basket_sum").length > 0) $("#basket_sum").remove();

    if (discount) {
        if ($("#discount").length > 0) $("#discount").remove();
        if ($("#empty").length > 0) $("#empty").remove();
        if ($("#discount_basket_line").length > 0) $("#discount_basket_line").remove();
        if ($("#discount_basket_sum").length > 0) $("#discount_basket_sum").remove();
    }
}

//prikazuje korpu i racuna ukupnu cenu i kolicinu i prikazuje popust
function changeBasket() {
    //sabrati kolicinu i cenu porudzbine

    deleteBasket();

    var amount = 0;
    var price = 0;
    var orders_amount = $(".amount");
    var orders_price = $(".price");

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
            <td colspan=4><hr style='border:1px solid black'/></td>\
        </tr>\
        <tr id=basket_sum>\
            <td colspan=2></td>\
            <td class=amount>" + amount +"g</td>\
            <td colspan=3 class=price>" + price + "din</td>\
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
                <td colspan=3 class=price>" + discount_price + "din</td>\
            </tr>\
            <tr id=discount_basket_line>\
                <td colspan=2></td>\
                <td colspan=4><hr style='border:1px solid black'/></td>\
            </tr>\
            <tr id=discount_basket_sum>\
                <td colspan=2></td>\
                <td class=amount>" + amount +"g</td>\
                <td colspan=3 class=price>" + (price + discount_price) + "din</td>\
            </tr>\
        "    
        if (orders_amount.length > 0) $("#basket").append(inner);
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

function setAmountInTextField(name, amount){
    if (amount == 0) amount='';
    let position = -1;
    let inp = $("input");
    for (let i=0; i<inp.length; i++){
        if (inp[i].name == name) {
            position = i;
            break;
        }
    }
    if (position == -1) return;
    inp[position].value = amount;
}

//dodati neko parsiranje podataka za slanje u bazu

</script>
