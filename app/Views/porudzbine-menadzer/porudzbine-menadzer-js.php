<script>

/*
 * Prikaz porudzbine za menadzera - Jovana Pavic 0099/17
 * Prikaz porudzbina menadzera i komunikacija sa kontrolerom Menadzer radi dohvatanja podataka iz baze - Jovana Jankovic 0586/17
 * verzija 02 - rowless verzija
 */

//var id = 0;

//razlika u odnosu na Prikaz porudzbine za kupca (orderClient.js) je u prikazu opisa porudzbine
//dodato je ime klijenta i njegov broj telefona u metodi showOrder()
//drugacija metoda statusOptions()

/** Autor: Jovana Jankovic 0586/17 - Pomocna funkcija koja zove funkciju kontrolera Menadzer za dodavanje nove porudzbine */
function dodajPorudzbinu(){
    alert("Usao u dodaj porudzbinu");
     $.post("<?php echo base_url('Menadzer/dodajPorudzbinu'); ?>")
    .done(function(data) {
            alert("Uspesno ste dodali porudzbinu u bazu!");
    })
    .fail(function() {
            alert("Niste dodali porudzbinu u bazu!");
    });          
}

/** Autor: Jovana Jankovic 0586/17 - Pomocna funkcija koja zove funkciju kontrolera Menadzer za dodavanje nove stavke */
function dodajStavku(){
    alert("Usao u stavku");
    $.post("<?php echo base_url('Menadzer/dodajStavku'); ?>")
    .done(function(data) {
            alert("Uspesno ste dodali stavku u bazu!");
    })
    .fail(function() {
            alert("Niste dodali stavku u bazu!");
    });      
}

/** Autor: Jovana Jankovic 0586/17 - Funkcija koja komunicira sa kontrolerom Menadzer i poziva njegovu funkciju dohvatiPorudzbine()  */
/** Nakon toga, dohvacene podatke prosledjuje funkciji showOrder(data) */
$(document).ready(function() { 
   $.post("<?php echo base_url('Menadzer/dohvatiPorudzbine'); ?>")
    .done(function(data) {
        $('#content').append("<div class='dummy'></div>");
   for(let i=0;i<data.length;i++){
        showOrder(data[i]);
        }
    })
    .fail(function() {
            alert("Prikaz porudzbine nije uspelo, molimo Vas, pokusajte ponovo!");
    });    
}
 );

/** Dopune funkcije: Jovana Jankovic 0586/17 - dopunjena funkcija za prikaz porudzbina koristeci stvarne podatke iz baze*/
function showOrder(object) {
    /*Od ulaza potrebno:
        id - id porudzbine, 
        name - ime porudzbine, x
        stat - status porudzbine (0-nije potvr/odb, 1-potvrdjena, 2-odbijena, 3-nap), 
        clientName - ime kupca, x
        clientNumber - broj telefona kupca, x
        people - broj osoba, x
        date - datum proslave, x
        orderedName[] - imena narucenih jela, x
        orderedAmount[] - broj porcija, x
        orderedWeight[] - ukupna kolicina narucenog jela ili velicina porcije?, x
        orderedPrice[] - ukupna cena tog jela x
        discount - da li je ostvaren popust 
    */
//    let name = "ime porudzbine"; let people = 3; let date = new Date(); let orderedName = ["cordon blau", "lasagna"]; 
//    let orderedAmount = [2, 3]; let orderedWeight = [600, 400]; let orderedPrice = [1200, 1600]; let discount = true;
//    let stat = 3; let clientName = "Petar Petrovic"; let clientNumber = "061 23456789";
    //parsirati objekat u potrebne elemente
      let id = object['por_id'];
      let name = object['por_naziv'];
      let people = object['por_br_osoba'];
      let date = object['por_za_dat'];
      
      let orderedName=[];
      for(let i=0;i<object['naziv_jela'].length;i++){
            orderedName[i]=object['naziv_jela'][i];
      }
      
      let orderedAmount = [];
         for(let i=0;i<object['kol_jela'].length;i++){
            orderedAmount[i]=object['kol_jela'][i];
      }
      
      let orderedWeight = [];  
      for(let i=0;i<object['masa_jela'].length;i++){
            orderedWeight[i]=object['masa_jela'][i];
      }
      
      let orderedPrice = [];
      for(let i=0;i<object['cena_jela'].length;i++){
            orderedPrice[i]=object['cena_jela'][i];
      }
      
      let discount = true;
      let stat = object['status'];
      let clientName = object['ime_korisnika'];
      let clientNumber = object['telefon_korisnika'];
   
    //osnovni izgled bez detalja porudzbine
    var inner = "\
        <div class=about_order>\
            <text class=name>" + name+ "</text>\
            <text class=stat>" + statusOptions(stat, id) + "</text>\
            <p></p>\
            <text class=about_client>" + clientName + "</text>\
            <text class=about>" + people + " osoba </text>\
            <br/>\
            <text class=about_client>" + clientNumber + "</text>\
            <text class=about>" + date + "</text>\
        </div>\
        <div class=order_details>\
            <table class=order_amount>\
            </table>\
        </div>\
    ";
    //dohvatiti sve dummy elemente
    var dummy = $(".dummy");
    dummy.html(inner);
    dummy[0].id = id;
    dummy.removeClass("dummy").addClass("order");

    //dodavanje detalja porudzbine
    var order_details = $(".order_amount", $("#"+id));
    var price = 0;
    var weight = 0;
    for(let i=0; i<orderedName.length; i++) {
        var inner2 = "\
            <tr>\
                <td>" + orderedAmount[i] + "x </td>\
                <td class=name>" + orderedName[i] + "</td>\
                <td></td>\
                <td>" + orderedWeight[i]*orderedAmount[i] + "g</td>\
                <td>" + orderedPrice[i]*orderedAmount[i] + "din</td>\
            </tr>\
        "
        order_details.append(inner2);
        price += orderedPrice[i]*orderedAmount[i];
        weight += orderedWeight[i]*orderedAmount[i];
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
        order_details.append(inner2);
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
    order_details.append(inner3);

    //dodavanje dummy elementa
    $("#content").append("<div class='dummy'></div>");
    
}


/**Filip Lucic 0188/17 - sredio putanje u skladu sa back-endom*/
function statusOptions(stat, id) {
    //status porudzbine (0-nije potvr/odb, 1-potvrdjena, 2-odbijena, 3-nap, 4-pokupljena)
    var str="";
    switch (stat) {
        case 0: str = "<img id='"+id+"' src='<?php echo base_url("assets/icons/plain-cross.svg");?>' alt='-' onclick=declineOrder(" + "this" + ")>\
                       <img id='"+id+"' src='<?php echo base_url("assets/icons/plain-check.svg");?>' alt='+' onclick=acceptOrder(this)>\
                    "; 
                break;
        case 1: str = "<img src='<?php echo base_url("assets/icons/plain-cross.svg");?>' alt='-'/>\
                       <img src='<?php echo base_url("assets/icons/circle-check.svg");?>' alt='++'/>\
                    "; 
                break;
        case 2: str = "<img src='<?php echo base_url("assets/icons/circle-cross.svg");?>' alt='--'/>\
                       <img src='<?php echo base_url("assets/icons/plain-check.svg");?>' alt='+'/>\
                    "; 
                break;
        case 3: str = "<img id='"+id+"' src='<?php echo base_url("assets/icons/plain-double-check.svg");?>' alt='!' onclick=archive(this)>"; break;
        case 4: str = "<img id='"+id+"' src='<?php echo base_url("assets/icons/plain-archive.svg");?>' alt='.'/>"
    }
    return str;
    //   
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

//hover
function showStatus(){   
}

/**Autor: Filip Lucic 0188/17 - funkcija za prihvatanje porudzbine*/
function acceptOrder(input) {
    object = {
        'por_id':input.id
    };
     $.post("<?php echo base_url('Menadzer/prihvatiPorudzbinu'); ?>", 
            JSON.stringify(object), "json")
    .done(function(data) {
          alert("Uspesno ste prihvatili porudzbinu");
          $(".stat", $("#"+input.id)).html(statusOptions(1, input.id));
    })
    .fail(function() {
            alert("Prihvatanje porudzbine nije uselo, molimo Vas, pokusajte opet!");
    }); 
}

/**Autor: Filip Lucic 0188/17 - funkcija za odbijanje porudzbine*/
function declineOrder(input) {
     object = {
        'por_id':input.id
    };
     $.post("<?php echo base_url('Menadzer/odbijPorudzbinu'); ?>", 
            JSON.stringify(object), "json")
    .done(function(data) {
          alert("Uspesno ste odbili porudzbinu");
          $(".stat", $("#"+input.id)).html(statusOptions(2, input.id));
    })
    .fail(function() {
            alert("Odbijanje porudzbine nije uselo, molimo Vas, pokusajte opet!");
    });   
}

/**Autor: Filip Lucic 0188/17 - funkcija za arhiviranje porudzbine*/
function archive(input) {
      object = {
        'por_id':input.id
        };
     $.post("<?php echo base_url('Menadzer/arhivirajPorudzbinu'); ?>", 
            JSON.stringify(object), "json")
    .done(function(data) {
          alert("Uspesno ste arhivirali porudzbinu");
          $(".stat", $("#"+input.id)).html(statusOptions(data['status'], data['por_id']));
    })
    .fail(function() {
            alert("Arhiviranje porudzbine nije uselo, molimo Vas, pokusajte opet!");
    }); 
}

</script>

