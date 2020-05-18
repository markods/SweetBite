<script>
// 2020-05-18 v0.3 Jovana Pavic 2017/0099

//-----------------------------------------------
/** .ready
// od baze dobija sve potrebne informacije
// postavlja pocetni izgled stranice
*/

$(document).ready(function(){
    $("#content").append('<div class="content-dummy" id=0></div>');
   
    $.post("<?php echo base_url('Kuvar/loadNotFinishedOrders')?>")
    .done(function(orders){
        for(let i=0; i<orders.por_id.length; i++){
            let order = {
                id:            orders.por_id[i],
                name:          orders.por_povod[i],
                date:          orders.por_za_dat[i],
                orderedId:     orders.stavke_id[i],
                orderedName:   orders.stavke_naziv[i],
                orderedAmount: orders.stavke_kol[i],
                orderedWeight: orders.stavke_masa[i],
                orderedStatus: orders.stavke_status[i],
            };
            showOrder(order);
        }
    })
    .fail(function(){
        alert("Can't access data, server is down");
    });  
});

//-----------------------------------------------
/** function showOrder(object){...}
// prikazuje jednu porudzbinu
*/

function showOrder(object) {
    let id = object.id;
    let name = object.name;
    let date = object.date;
    let orderedId = object.orderedId;   //id stavke
    let orderedName = object.orderedName;
    let orderedAmount = object.orderedAmount;
    let orderedWeight = object.orderedWeight;
    let orderedStatus = object.orderedStatus;

    let inner = 
       '<div class=about_order>\
            <text class=name>' + name + '</text>\
            <text class=stat>\
                <input type=checkbox class="check_done order_complited"\
                    onclick=orderDone("' + id + '")></text>\
            <p></p>\
            <text class=about>' + date + '</text>\
        </div>\
        <div class=order_details>\
            <table class=order_amount>\
            </table>\
        </div>';
                
    //dohvatiti sve dummy elemente
    let dummy = $(".content-dummy");
    dummy.html(inner);
    dummy[0].id = id;
    dummy.removeClass("content-dummy").addClass("order");

    //dodavanje detalja porudzbine
    let order_details = $(".order_amount", $("#"+id));
    for(let i=0; i<orderedName.length; i++) {
        let statusTemp = orderedStatus[i] === true? "checked=on" : "";
        let inner2 =
           '<tr class="d_' + orderedId[i] + '">\
                <td>' + orderedAmount[i] + 'x </td>\
                <td class=name>' + orderedName[i] + '</td>\
                <td></td>\
                <td>' + orderedWeight[i]*orderedAmount[i] + 'g</td>\
                <td>\
                    <input type=checkbox class="check_done order_part"\
                        onclick=dishDone("' + orderedId[i] + '") ' + statusTemp + '>\
                </td>\
            </tr>';
        order_details.append(inner2);
    }

    //dodavanje dummy elementa
    $(".cont").append("<div class='content-dummy'></div>");
    id++;
}

//-----------------------------------------------
/** function dishDone(id_stavke, check){...}
// Poziva promene u bazi u odnosu na to da li je
// jelo napravljeno ili ne
*/

function dishDone(id_stavke) {
    let check = $('.check_done', $(".d_"+id_stavke)); 
    if(check[0].checked === true){
        $.post("<?php echo base_url('Kuvar/dishDone');?>", 
                JSON.stringify({stavka_id: id_stavke}), 'json')
        .fail(function(){
            check.checked = false;
        });
    }
    else{
        $.post("<?php echo base_url('Kuvar/dishNotDone');?>", 
                JSON.stringify({stavka_id: id_stavke}), 'json')
        .fail(function(){
            check.checked = true;
        });    
    }
}

//-----------------------------------------------
/** public function orderDone(id){...}
// proverava da li su sve stavke napravljene
// ako jesu u bazi oznacava porudzbinu kao napravljenu
// i uklanja je iz pogleda
// a ako nisu odcekira dugme
*/

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
        $.post("<?php echo base_url('Kuvar/orderDone');?>", 
                JSON.stringify({"por_id": id}), 'json')
        .done(function(){
            $("#"+id).remove(); //uklonjeno iz pregleda
        })
        .fail(function(){
            $(".order_complited", $("#"+id))[0].checked = false;
        });
    }
}

</script>

