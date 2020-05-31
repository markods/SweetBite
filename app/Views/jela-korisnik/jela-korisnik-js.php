<script>
/**Jovana Jankovic 0586/17 -Funkcija za prikaz jela kod korisnika*/ 
// 2020-05-21 v0.3 Jovana Pavic 2017/0099 - prilagodjeno ostatku sistema 

/** .ready()
// Prikazuje sva jela iz baze, ucitava favorite i korpu, ako postoji
*/
$(document).ready(function(){
    // struktura za korpu
    // mora u #mCSB_1_container da bi se prikazalo, ne moze samo #sidebar
    $("#mCSB_1_container").append('<table id="basket"></table>\n\
                          <div class="poruci"></div>');
    $("#content").append("<div class='row' id='content1'></div>");
    
    let uslov = "<?php 
            if(!array_key_exists('kor_id', $_SESSION)){
                echo print_r('false');
            }
            else{
                echo print_r('true');
            }
        ?>";
    if (uslov == "true1") {
        let arr = localStorage.getItem("korpa");

        $.post("<?php echo base_url('Korisnik/hasBasket')?>")
        .done(function(has){
            if(has){
                if (arr != null){
                    arr = JSON.parse(arr);
                    if(confirm("Da li zelite da zadrzite trenutnu korpu?\n\
                                Ako zelite pritisnite 'ok'\n\
                                Ako zelite korpu iz prethodne posete pritisnite 'cancel'")){
                        //Zadrzi ovu korpu
                        $.post("<?php echo base_url('Korisnik/emptyBasket')?>")
                        .done(function(){
                            for(let i=0; i<arr.jelo_id.length; i++){
                                if (arr.kol[i]>0){
                                    $.post("<?php echo base_url('Korisnik/changeAmount');?>",
                                        JSON.stringify({jelo_id: arr.jelo_id[i], kol: arr.kol[i]}), 'json');
                                }
                            }
                            localStorage.removeItem("korpa");
                        });
                    }
                    else{
                        //uzmi iz baze
                        localStorage.removeItem("korpa");
                    }
                }
            }
            else {
                //sacuva trenutnu korpu
                if(arr != null){
                    for(let i=0; i<arr.jelo_id.length; i++){
                        if (arr.kol[i]>0){
                            $.post("<?php echo base_url('Korisnik/changeAmount');?>",
                                JSON.stringify({jelo_id: arr.jelo_id[i], kol: arr.kol[i]}), 'json');
                        }
                    }
                    localStorage.removeItem("korpa");
                }
            }
        });
    }   
    
    $.post("<?php if(array_key_exists('kor_id', $_SESSION)){
                    echo base_url('Korisnik/loadAllFood');
                  }else{
                    echo base_url('Gost/loadAllFood');  
                  }
            ?>")
    .done(function(meals){
        if (meals.disc == true)
            activateDiscount();
        else
            deactivateDiscount();
        
        for(let i=0; i<meals.jelo_id.length; i++){
            let food = {
                'id':       meals.jelo_id[i],
                'naziv':    meals.jelo_naziv[i],
                'opis':     meals.jelo_opis[i],
                'slika':    meals.jelo_slika[i],
                'cena':     meals.jelo_cena[i],
                'masa':     meals.jelo_masa[i],
                'tip_jela': meals.jelo_tipjela[i],
                'ukus':     meals.jelo_ukus[i],
                'dijeta':   meals.jelo_dijeta[i],
                'fav':      meals.favor[i],
                'kol':      meals.kol[i]
            }
            prikaziJelo(food);
        }
    })
    .fail(function(){
        alert("Can't access data, server is down");
    });   
});

//-----------------------------------------------
/** function prikaziJelo(object){...}
// Prikazuje jelo u odgovarajucem formatu
*/

function prikaziJelo(object) { 
    let id         = object.id;
    let naziv_jela = object.naziv;
    let tip_jela   = object.tip_jela;
    let dijeta     = object.dijeta;
    let ukus       = object.ukus;
    let tagovi     = [dijeta, tip_jela, ukus];
    let opis_jela  = object.opis;
    let gramaza    = object.masa;
    let cena       = object.cena;
    let slika      = object.slika;
    let favor      = object.fav;
    let kol        = object.kol;
    let kol_ispi   = '';
    if (kol != null) kol_ispi=kol;
    
    $.post("<?php if(array_key_exists('kor_id', $_SESSION)){
                    echo base_url('Korisnik/dohvatiSliku');
                  }else{
                    echo base_url('Gost/dohvatiSliku');  
                  }
            ?>", JSON.stringify({"jelo_id": id}), "json")
    .done(function(data){
        let str = 
           '<div class="ar-image col-md-6 col-sm-12" id="' + id + '">\
                <div class="article-image">\
                    <div class="row base">\
                        <div class="col-md-10 about1">\
                            <h3 class="text-left">' + naziv_jela + '</h3>\
                            <p class="levo-poravnanje">#' + tagovi[0] + ' #' + tagovi[1] + ' #' + tagovi[2] + '</p>\
                            <p class="opis">' + opis_jela + '</p>\
                        </div>\
                        <div class="col-md-2 amount">\
                            <div class="change">\
                                <img src="<?php echo base_url("assets/icons/plain-plus.svg");?>" \
                                    onclick=povecaj("' + id + '") />\
                                <input type="text" id="broj_' + id + '" \
                                    onchange=tacnaKolicina("' + id + '",this) value="' + kol_ispi +'" />\
                                <img src="<?php echo base_url("assets/icons/plain-minus.svg");?>" \
                                    onclick=smanji("' + id + '") />\
                            </div>\
                            <div id="srce_' + id + '">\
                                ' + prikazFavorita(id, favor) + '\
                            </div>\
                        </div>\
                    </div>\
                    <div class="row price">\
                        <div class="col-sm-9 col-md-7 col-lg-7 text-right">' + gramaza + ' g</div>\
                        <div class="col-sm-3 col-md-5 col-lg-5 text-right no-left-padding">' + cena + '.00 din</div>\
                    </div>\
                </div>\
            </div>';

        $("#content1").append(str);
        if (kol>0){
            jelo = {
                jelo_id:    id,
                jelo_naziv: naziv_jela,
                jelo_cena:  cena,
                jelo_masa:  gramaza,
                kol:        kol
            };
            takeAmount(jelo);
        }
        $(".article-image", $('#' + id)[0]).css("background-image","url(" + data['jelo_slika'] + ")");
    });
}

//-----------------------------------------------
/** function srce(id){...}
// Postavlja jelo u favorite toga korisnika
*/

function srce(id){
    $.post("<?php echo base_url('Korisnik/addFavorit'); ?>", 
            JSON.stringify({"jelo_id": id}), 'json')
    .done(function(){
        $('#srce_' + id).html(
            '<img src="<?php echo base_url("assets/icons/heart.svg");?>"\
                onclick=neSrce("' + id + '") />');
    });
}

//-----------------------------------------------
/** function neSrce(id){...}
// Uklanja jelo iz favorita toga korisnika
*/

function neSrce(id){
    $.post("<?php echo base_url('Korisnik/removeFavorit'); ?>", 
            JSON.stringify({"jelo_id": id}), 'json')
    .done(function(){
        $('#srce_' + id).html(
            '<img src="<?php echo base_url("assets/icons/heart-outline.svg");?>"\
                onclick=srce("' + id + '") />');
    });
}

//-----------------------------------------------
/** function prikazFavorita(id, fav){...}
// prikazuje srce u odnosu na to da li je to jelo favorit
*/

function prikazFavorita(id, fav){
    let str='';
    if (fav == false)
        str += '<img src="<?php echo base_url("assets/icons/heart-outline.svg");?>" \
                        onclick=srce("' + id + '") />';
    else if (fav == true)
        str += '<img src="<?php echo base_url("assets/icons/heart.svg");?>" \
                        onclick=neSrce("' + id + '") />';
    return str;
}

//-----------------------------------------------
/** function povecaj(id_jela){...}
// Kada se klikne na + zavrsava posao sa bazom / locaStorage
// Poziva promenu izgleda korpe
*/

function povecaj(id_jela){
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
        $.post("<?php echo base_url('Korisnik/changeAmount');?>",
                JSON.stringify({jelo_id: id_jela, kol:"p1"}), 'json')
        .done(function(resp){
            //izmeniti vednost u inputu
            if (resp.disc == true) activateDiscount();
            else deactivateDiscount();
            let kol = resp.kol;
            let am = '';
            if (kol > 0) am += kol;
            $("#broj_" + id_jela + "").val(am);

            $.post("<?php echo base_url('Korisnik/getFood');?>",
                    JSON.stringify({jelo_id: id_jela}))
            .done(function(food) {
                jelo = {
                    jelo_id:    food.jelo_id,
                    jelo_naziv: food.jelo_naziv,
                    jelo_cena:  food.jelo_cena,
                    jelo_masa:  food.jelo_masa,
                    kol:        kol
                };
                takeAmount(jelo);            
            });        
        });  
    }
    else {
        //gost
        let kol = 1;
        let newId = "b_" + id_jela;
        if ($("#"+newId).length>0) {
            kol = parseInt($(".amount_ordered", $("#"+newId))[0].innerHTML) + 1;
        }
        
        //prikazuje kolicinu u korpi na jelu
        let am = '';
        if (kol > 0) am += kol;
        $("#broj_" + id_jela + "").val(am);
            
        //dohvata info o jelu
        $.post("<?php echo base_url('Gost/getFood');?>",
                    JSON.stringify({jelo_id: id_jela}))
        .done(function(food) {
            jelo = {
                jelo_id:    food.jelo_id,
                jelo_naziv: food.jelo_naziv,
                jelo_cena:  food.jelo_cena,
                jelo_masa:  food.jelo_masa,
                kol:        kol
            };
            takeAmount(jelo, kol);        
            
            saveBasket();
        });
    };
}

//-----------------------------------------------
/** function smanji(id_jela){...}
// Kada se klikne na - zavrsava posao sa bazom / localStorage
// Poziva promenu izgleda korpe
*/

function smanji(id_jela){
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
        $.post("<?php echo base_url('Korisnik/changeAmount');?>",
                JSON.stringify({jelo_id: id_jela, kol:'-1'}), 'json')
        .done(function(resp){
            //izmeniti vednost u inputu
            let kol = resp.kol;
            let am = '';
            if (kol > 0) am += kol;
            $("#broj_" + id_jela + "").val(am);
            if (kol < 0) return;
            $.post("<?php echo base_url('Korisnik/getFood');?>",
                    JSON.stringify({jelo_id: id_jela}))
            .done(function(food) {
                jelo = {
                    jelo_id:    food.jelo_id,
                    jelo_naziv: food.jelo_naziv,
                    jelo_cena:  food.jelo_cena,
                    jelo_masa:  food.jelo_masa,
                    kol:        kol
                };
                takeAmount(jelo, kol);            
            });
        }); 
    }
    else {
        //gost
        let kol = 0;
        let newId = "b_" + id_jela;
        if ($("#"+newId).length>0) {
            kol = parseInt($(".amount_ordered", $("#"+newId))[0].innerHTML) - 1;
        }
        
        //prikazuje kolicinu u korpi na jelu
        let am = '';
        if (kol > 0) am += kol;
        $("#broj_" + id_jela + "").val(am);
          
        if (kol<0) return;
        
        //dohvata info o jelu
        $.post("<?php echo base_url('Gost/getFood');?>",
                    JSON.stringify({jelo_id: id_jela}))
        .done(function(food) {
            jelo = {
                jelo_id:    food.jelo_id,
                jelo_naziv: food.jelo_naziv,
                jelo_cena:  food.jelo_cena,
                jelo_masa:  food.jelo_masa,
                kol:        kol
            };
            takeAmount(jelo, kol);    
            
            saveBasket();
        });
    }
}

//-----------------------------------------------
/** function tacnaKolicina (id_jela, input){...}
// Kada se unese tacna vrednost zavrsava posao sa bazom / localStorage
// Poziva promenu izgleda korpe
*/

function tacnaKolicina(id_jela, input){
    //odredjuje da li je gost ili korisnik
    let uslov = "<?php 
            if(!array_key_exists('kor_id', $_SESSION)){
                echo print_r('false');
            }
            else{
                echo print_r('true');
            }
        ?>";
    if (uslov == "true1"){
        //ulogovani korisnik
        let exactAmount = parseInt(input.value); 
        //ako nije uneta ispravna vrednost nece imati efekte
        if (isNaN(exactAmount) || exactAmount < 0) {
            exactAmount = 0;
            input.value = '';
        }
        else {
            $.post("<?php echo base_url('Korisnik/changeAmount');?>",
                    JSON.stringify({jelo_id: id_jela, kol: exactAmount}), 'json')
            .done(function(resp){
                //izmeniti vednost u inputu
                let kol = resp.kol;
                let am = '';
                if (kol > 0) am += kol;
                $("#broj_" + id_jela + "").val(am);

                $.post("<?php echo base_url('Korisnik/getFood');?>",
                        JSON.stringify({jelo_id: id_jela}))
                .done(function(food) {
                    jelo = {
                        jelo_id:    food.jelo_id,
                        jelo_naziv: food.jelo_naziv,
                        jelo_cena:  food.jelo_cena,
                        jelo_masa:  food.jelo_masa,
                        kol:        kol
                    };
                    takeAmount(jelo);            
                });
            });
        };
    }
    else {
        //gost
        
        //da li je unet br veci od 0
        let exactAmount = parseInt(input.value); 
        //ako nije uneta ispravna vrednost nece imati efekte
        if (isNaN(exactAmount) || exactAmount < 0) {
            exactAmount = 0;
            input.value = '';
        }
        else {
            let kol = exactAmount;

            //prikazuje kolicinu u korpi na jelu
            let am = '';
            if (kol > 0) am += kol;
            $("#broj_" + id_jela + "").val(am);

            //dohvata info o jelu
            $.post("<?php echo base_url('Gost/getFood');?>",
                        JSON.stringify({jelo_id: id_jela}))
            .done(function(food) {
                jelo = {
                    jelo_id:    food.jelo_id,
                    jelo_naziv: food.jelo_naziv,
                    jelo_cena:  food.jelo_cena,
                    jelo_masa:  food.jelo_masa,
                    kol:        kol
                };
                takeAmount(jelo, kol);    
                       
                saveBasket();
            });
        };
    };
};
   
//-----------------------------------------------
/** function saveBasket(){...}
// Cuva trenutnu korpu gosta u localStorage
*/

function saveBasket() {
    //novu korpu cuva u local storage
    localStorage.removeItem("korpa");
    let jela_id = [];
    let kolicine = [];
    let uKorpi = $(".par");
    let koli = $(".amount_ordered");
    for(let i=0; i<uKorpi.length; i++){
        jela_id[i] = (uKorpi[i].id).substring(2);
        kolicine[i] = parseInt(koli[i].innerHTML);
    }
    let korpa = {
        'jelo_id': jela_id,
        'kol': kolicine
    };
    localStorage.setItem("korpa", JSON.stringify(korpa)); 
}

</script>