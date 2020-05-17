<script>         
/**Autori: Filip Lucic 0188/17, Jovana Jankovic 0586/17 */

var id=0;

$('#openImgUpload').click(function() {
$('#upload_img').trigger('click');
 });

/** Autor : Jovana Jankovic 0586/17 - funkcija koja poziva kontroler Menadzer radi sakrivanja jela iz ponude*/
function sakrijJelo(input) {
     let niz= input.id.split("_");
     let jelo_id=niz[1];
     let object = {
       'jelo_id': jelo_id 
      };
    $.post("<?php echo base_url('Menadzer/sakrijJelo'); ?>", 
            JSON.stringify(object), "json")
    .done(function(data) {
           $("#eye_"+data['jelo_id']).attr('src',"<?php echo base_url("assets/icons/eye-closed.svg");?>").attr('onclick','otkrijJelo(this)');
            alert("Uspesno ste sakrili jelo iz ponude!");
    })
    .fail(function() {
            alert("Sakrivanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
    });  
}
/** Autor: Filip Lucic 0188/17 - funkcija za vracanje jela u ponudu */
function otkrijJelo(input) {

     let niz= input.id.split("_");
     let jelo_id=niz[1];
     let object = {
       'jelo_id': jelo_id 
      };
     $.post("<?php echo base_url('Menadzer/otkrijJelo'); ?>", 
            JSON.stringify(object), "json")
     .done(function(data) {
         $("#eye_"+data['jelo_id']).attr('src',"<?php echo base_url("assets/icons/eye-open.svg");?>").attr('onclick','sakrijJelo(this)'); 
         alert("Uspesno ste vratili jelo iz ponudu!");
     })
     .fail(function() {
            alert("Sakrivanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
     });  

}

/** Autor: Jovana Jankovic 17/0586 - pomocna fja za dodavanje tipova jela*/
function insertuj(){   
    alert("usao u insertuj");
     $.post("<?php echo base_url('Menadzer/unesiTipove'); ?>")
    .done(function(data) {
       alert(data['success']);
    })
    .fail(function() {
            alert("Dodavanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
    });  
}

/** Autor: Filip Lucic 17/0188 - omogucava menadzeru da doda novo jelo u bazu podataka */
function potvrdi_unos() {
   let object = {
       'jelo_naziv':document.getElementById("naziv_jela_temp").value,
       'jelo_tipjela':document.getElementById("vrsta_jela_temp").value,
       'jelo_ukus':document.getElementById("ukus_temp").value,
       'jelo_dijeta':document.getElementById("dijeta_temp").value,
       'jelo_opis':document.getElementById("opis_jela_temp").value,
       'jelo_cena':parseFloat(document.getElementById("cena_temp").value),
       'jelo_masa':parseInt(document.getElementById("gramaza_temp").value)
   };
    $.post("<?php echo base_url('Menadzer/dodajJelo'); ?>", 
            JSON.stringify(object), "json")
    .done(function(data) {
           menjanje(data);
           $('#div'+data["jelo_id"]).css("background-image","url(<?php echo base_url("assets/icons/cevapi.jpg");?>)");
           $('#vrsta_jela'+data['jelo_id']).val(data['jelo_tipjela']);
           $('#dijeta'+data['jelo_id']).val(data['jelo_dijeta']);
           $('#ukus'+data['jelo_id']).val(data['jelo_ukus']);
           alert("Uspesno ste uneli novo jelo!");
    })
    .fail(function() {
            alert("Dodavanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
    });  
}

/** Autor: Jovana Jankovic 0586/17 - fja za update jela za menadzera*/
function potvrdi_promenu(input){
       let jelo_id= input.id;
       let jelo_naziv = document.getElementById("naziv_jela"+input.id).value;
       let jelo_tipjela = document.getElementById("vrsta_jela"+input.id).value;
       let jelo_ukus = document.getElementById("ukus"+input.id).value;
       let jelo_dijeta = document.getElementById("dijeta"+input.id).value;
       let jelo_opis = document.getElementById("opis_jela"+input.id).value;
       let jelo_cena = parseFloat(document.getElementById("cena"+input.id).value);
       let jelo_masa = parseInt(document.getElementById("gramaza"+input.id).value);
       
       if(jelo_naziv=="")
           jelo_naziv = document.getElementById("naziv_jela"+input.id).getAttribute("placeholder");
       if(jelo_tipjela=="")
           jelo_tipjela = document.getElementById("vrsta_jela"+input.id).getAttribute("placeholder");
       if(jelo_ukus=="")
           jelo_ukus = document.getElementById("ukus"+input.id).getAttribute("placeholder");
       if(jelo_dijeta=="")
           jelo_dijeta = document.getElementById("dijeta"+input.id).getAttribute("placeholder");
       if(jelo_opis=="")
           jelo_opis = document.getElementById("opis_jela"+input.id).getAttribute("placeholder");
       if(isNaN(jelo_cena))
           jelo_cena = parseFloat(document.getElementById("cena"+input.id).getAttribute("placeholder"));    
        if(isNaN(jelo_masa))
           jelo_masa = parseFloat(document.getElementById("gramaza"+input.id).getAttribute("placeholder"));
       
     let object = {
       'jelo_id': input.id, 
       'jelo_naziv':jelo_naziv,
       'jelo_tipjela':jelo_tipjela,
       'jelo_ukus':jelo_ukus,
       'jelo_dijeta':jelo_dijeta,
       'jelo_opis':jelo_opis,
       'jelo_cena':jelo_cena,
       'jelo_masa':jelo_masa
   };
    $.post("<?php echo base_url('Menadzer/updateJelo'); ?>", 
            JSON.stringify(object), "json")
    .done(function(data) {
           alert('Uspesno ste promenili osobine jela!');
           update_polja(data);
//           $('#div'+data["jelo_id"]).css("background-image","url(<?php echo base_url("assets/icons/cevapi.jpg");?>)");
    })
    .fail(function() {
            alert("Dodavanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
    });  
}


/** Autor: Filip Lucic 17/0188 funkcija koja dinamicki menja tacno ono jelo koje smo promenili, bez menjanja ostatka stranice*/
function update_polja(obj) {
    $('#naziv_jela'+obj['jelo_id']).attr("placeholder", obj['jelo_naziv']);
    $('#naziv_jela'+obj['jelo_id']).val("");
    $('#opis_jela'+obj['jelo_id']).attr("placeholder", obj['jelo_opis']);
    $('#opis_jela'+obj['jelo_id']).val("");
    $('#cena'+obj['jelo_id']).attr("placeholder", obj['jelo_cena']);
    $('#cena'+obj['jelo_id']).val("");
    $('#gramaza'+obj['jelo_id']).attr("placeholder", obj['jelo_masa']);
    $('#gramaza'+obj['jelo_id']).val("");
    $('#div'+obj["jelo_id"]).css("background-image","url(<?php echo base_url("assets/icons/cevapi.jpg");?>)");
}

/** Autor: Jovana Jankovic 17/0586 - Funkcija za ucitavanje svih jela na menadzerovu stranicu*/
function ucitajJela() {
    menjanje();
    //izbirsan JSON jer ne prosledjujem nista
    $.post("<?php echo base_url('Menadzer/dohvatiSvaJela'); ?>")  
    .done(function(data) {
           for(let i = 0; i<data.length; i++) {            
           menjanje(data[i]);
           $('#div'+data[i]["jelo_id"]).css("background-image","url(<?php echo base_url("assets/icons/cevapi.jpg");?>)");
           }  
    })
    .fail(function() {
            alert("Dodavanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
    });  
}

/** Autor: Jovana Jankovic 0586/17 - fja za soft delete jela iz ponude */
function obrisiJelo(input){ 
     let niz= input.id.split("_");
     let jelo_id=niz[1];
       let object = {
       'jelo_id': jelo_id, 
   };
    $.post("<?php echo base_url('Menadzer/obrisiJelo'); ?>", 
            JSON.stringify(object), "json")
    .done(function(data) {
           alert("Uspesno ste obrisali jelo iz ponude");
           var content=document.getElementById("content");
           content.removeChild(document.getElementById('div'+data["jelo_id"]));
    })
    .fail(function() {
            alert("Brisanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
    });  
}

 /** Autor: Filip Lucic 17/0188 - omogucava ispis sablona za dodavanje novog jela, kao i ispis svih jela */
function menjanje(obj) { 
    //TODO implement image upload amd background image
    //TODO see dish availability through database and hiding date, where does date get converted to string, here or somewhere else

    if(obj == null)  {
        var str =""; 
        str+='<div class="dish_wrapper">'
        str+='<form name = "menjanje_jela_temp" method = "POST" >';
        str+='<div class = "row" >';
        str+='<div class = "col-sm-10 text-left">';
        str+='<input  type = "text" name = "naziv_jela_temp" id="naziv_jela_temp" placeholder = "Unesite naziv jela" style = "margin-top:4px; margin-bottom:4px; height: 25px;">';
        str+= '</div>';
                
        str+='<div class = "col-sm-2 text-right" >';
        str+='<img src = "<?php echo base_url("assets/icons/plain-check.svg");?>" width = "20px" height = "20px" onclick="potvrdi_unos()" style="margin-top: 10px; margin-right: 5px;">';   
        str+='</div>';
        str+='</div>';
        str+='<div class = "row">';
        str+='<div class="col-sm-10 text-left">';
        str+='<select name="vrsta_jela_temp" id="vrsta_jela_temp" class = "opcija text-left" style = "margin-bottom:4px; font-size: 12px;">';
        str+='<option value="Predjelo">Predjelo</option>';
        str+='<option value="Kuvano jelo">Kuvano jelo</option>';
        str+='<option value="Rostilj">Rostilj</option>';
        str+='<option value="Salata">Salata</option>';
        str+='<option value="Supa">Supa</option>';
        str+='<option value="Corba">Corba</option>';
        str+='<option value="Riba">Riba</option>';
        str+='<option value="Morski plodovi">Morski plodovi</option>';
        str+='<option value="Pasta">Pasta</option>';
        str+='<option value="Pica">Pica</option>';
        str+='<option value="Pita">Pita</option>';
        str+='<option value="Kolac">Kolac</option>';
        str+='<option value="Pecivo">Pecivo</option>';
        str+='<option value="Torta">Torta</option>';
        str+='</select>';
        str+='<select name="ukus_temp" id="ukus_temp" class = "opcija" style = "margin-bottom:4px;font-size: 12px;">';
        str+='<option value="Slatko">Slatko</option>';
        str+='<option value="Slano">Slano</option>';
        str+='<option value="Ljuto">Ljuto</option>';
        str+='<option value="Gorko">Gorko</option>';
        str+='<option value="Kiselo">Kiselo</option>';
        str+='</select>';
        str+='<select name="dijeta_temp" id="dijeta_temp" class = "opcija"  style = "margin-bottom:4px;font-size: 12px;">';
        str+='<option value="Nije dijetalno">Nije dijetalno</option>';
        str+='<option value="Posno">Posno</option>';
        str+='<option value="Vegetarijansko">Vegetarijansko</option>';
        str+='<option value="Bez glutena">Bez glutena</option>';
        str+='<option value="Mrsno">Mrsno</option>';
        str+='<option value="Bez laktoze">Bez laktoze</option>';
        str+='</select>';
        str+='</div>';
        //prazan red
        str+='<div class= "col-sm-2 text-right">';
        str+='</div>'; 
        //prazan red end
        str+='</div>';
        //prazan red
        str+='<div class = "row">';
        str+='<div class = "col-sm-10">';
        str+='<br>';
        str+='</div>';
        str+='<div class = "col-sm-2 text-right">';
        str+='<br>';
        str+='</div>';
        str+='</div>' ;
        //prazan red end
        str+='<div class = "row">';
        str+='<div class = "col-sm-12 text-left" style="overflow: hidden;">';
        str+='<textarea  draggable="false" style = "margin-bottom:4px; resize: none; " name="opis_jela_temp" id="opis_jela_temp" form="menjanje_jela_temp" placeholder = "Unesite opis novog jela" rows = "8" cols="32" ></textarea>';
        str+='</div>';
        str+='</div>' ;
        str+='<div class = "row cena_i_masa">';
        str+='<div class = "col-sm-12 text-right" style = "margin-bottom:4px">';
        // dodavanje slike
        // str+='<input type = "file" id = "upload_img" style="display:none"/>';
        // str+='<button style = "text-align:left" id = "openImgUpload">Okacite sliku jela</button>';
        str+='<input type="text" name="gramaza_temp" id="gramaza_temp" placeholder="Gramaza">';
        str+='<input type="text" name="cena_temp" id="cena_temp" placeholder="Cena">';
        str+='</div>';
        str+='</div>';
    
        str+= '</form>';
        str+='</div>';

        $('#content').append(str);
        
        
        $('#vrsta_jela_temp').val("");
        $('#ukus_temp').val("");
        $('#dijeta_temp').val("");
    } 
    else {
    var str ="";
    
    str+='<div id="div'+obj["jelo_id"]+'" class="dish_wrapper" >';
    str+='<div class="elem"';
    str+='<form name = "menjanje_jela" method = "POST" >';
    str+='<div class = "row">';
    str+='<div class = "col-sm-10 text-left">';
    str+='<input  type = "text" id="naziv_jela'+obj["jelo_id"]+'" name = "naziv_jela" placeholder ="'+obj["jelo_naziv"]+'"style = margin-top:4px; margin-bottom:4px; height: 25px;">';
    str+= '</div>';              
    str+='<div class = "col-sm-2 text-right">';
    str+='<img src = "<?php echo base_url("assets/icons/plain-check.svg");?>" width = "20px" height = "20px" id="'+ obj["jelo_id"]+'" onclick="potvrdi_promenu(this)" style="margin-top: 10px; margin-right: 5px;">';   
    str+='</div>';
    str+='</div>';
    str+='<div class = "row">';
    str+='<div class="col-sm-10 text-left">';
    str+='<select name="vrsta_jela_temp" id="vrsta_jela'+obj["jelo_id"]+'" class = "opcija text-left" style = "margin-bottom:4px; font-size: 12px;">';
    str+='<option value="Predjelo">Predjelo</option>';
    str+='<option value="Kuvano jelo">Kuvano jelo</option>';
    str+='<option value="Rostilj">Rostilj</option>';
    str+='<option value="Salata">Salata</option>';
    str+='<option value="Supa">Supa</option>';
    str+='<option value="Corba">Corba</option>';
    str+='<option value="Riba">Riba</option>';
    str+='<option value="Morski plodovi">Morski plodovi</option>';
    str+='<option value="Pasta">Pasta</option>';
    str+='<option value="Pica">Pica</option>';
    str+='<option value="Pita">Pita</option>';
    str+='<option value="Kolac">Kolac</option>';
    str+='<option value="Pecivo">Pecivo</option>';
    str+='<option value="Torta">Torta</option>';
    str+='</select>';
    str+='<select name="ukus" id="ukus'+obj["jelo_id"]+'" class = "opcija"  style = "margin-bottom:4px;font-size: 12px;">';
    str+='<option value="Slatko">Slatko</option>';
    str+='<option value="Slano">Slano</option>';
    str+='<option value="Ljuto">Ljuto</option>';
    str+='<option value="Gorko">Gorko</option>';
    str+='<option value="Kiselo">Kiselo</option>';
    str+='</select>';
    str+='<select name="dijeta" id="dijeta'+obj["jelo_id"]+'" class = "opcija" style = "margin-bottom:4px;font-size: 12px;">';
    str+='<option value="Nije dijetalno">Nije dijetalno</option>';
    str+='<option value="Posno">Posno</option>';
    str+='<option value="Vegetarijansko">Vegetarijansko</option>';
    str+='<option value="Bez glutena">Bez glutena</option>';
    str+='<option value="Mrsno">Mrsno</option>';
    str+='<option value="Bez laktoze">Bez laktoze</option>';
    str+='</select>';
    str+='</div>';
    str+='<div class= "col-sm-2 text-right">';
    if(obj['jelo_datsakriv']==null)
        str+='<img src = "<?php echo base_url("assets/icons/eye-open.svg");?>" id="eye_'+obj['jelo_id']+'" width = "20px" height = "20px" style="margin-right:5px;" onclick = "sakrijJelo(this)">';
    else
        str+='<img src = "<?php echo base_url("assets/icons/eye-closed.svg");?>" id="eye_'+obj['jelo_id']+'" width = "20px" height = "20px" style="margin-right:5px;" onclick = "otkrijJelo(this)">';
    str+='</div>';                     
    str+='</div>';
    str+='<div class = "row">';
    str+='<div class = "col-sm-10">';
    str+='</div>';
    str+='<div class = "col-sm-2 text-right">';
    str+='<img src = "<?php echo base_url("assets/icons/trash.svg");?>" id="del_'+obj["jelo_id"]+'"onclick="obrisiJelo(this)" width = "20px" height = "20px" style="margin-top: 3px; margin-right: 5px;">';
    str+='</div>';
    str+='</div>' ;
    str+='<div class = "row">';
    str+='<div class = "col-sm-12 text-left" style="overflow: hidden;">';
    str+='<textarea draggable="false" id="opis_jela'+obj["jelo_id"]+'" style = "margin-bottom:4px; resize: none; " name="opis_jela" form="menjanje_jela" placeholder = "'+obj["jelo_opis"]+'" rows = "8" cols="32" ></textarea>';
    str+='</div>';
    str+='</div>' ;
    str+='<div class = "row cena_i_masa">';
    str+='<div class = "col-sm-12 text-right" style = "margin-bottom:4px">';
    str+='<input class = "text-right" type="text" name="gramaza" id="gramaza'+obj["jelo_id"]+'" placeholder="'+obj["jelo_masa"]+'">';
    str+='<input class = "text-right"  type="text" name="cena" id="cena'+obj["jelo_id"]+'" placeholder="'+obj["jelo_cena"]+'">';
    str+='</div>';
    str+='</div>';
   
    str+= '</form>';
    str+='</div>';
    str+='</div>';
    $('#content').append(str);
    }
}

function menjanje_temp() {
 
    //var temp = document.getElementById('menjanje_temp');
    var str ="";
    str+='<form name = "menjanje_jela_temp" method = "POST" >';
    str+='<div class = "row" style = "background-color:lightblue;">';
    str+='<div class = "col-sm-10 text-left">';
    str+='<input  type = "text" name = "naziv_jela" placeholder = "Unesite naziv jela" style = "margin-top:4px; margin-bottom:4px; height: 25px;">';
    str+= '</div>';
            
    str+='<div class = "col-sm-2 text-right" >';
    str+='<img src = "assets/baseline_done_black_18dp.png" width = "20px" height = "20px" onclick="potvrdi_promenu()" style="margin-top: 10px; margin-right: 5px;">';   
    str+='</div>';
    str+='</div>';
    str+='<div class = "row" style = "background-color:lightblue;" >';
    str+='<div class="col-sm-10 text-left">';
    str+='<select name="vrsta_jela_temp" id="vrsta_jela_temp" class = "opcija text-left" value = "Vrsta jela" style = "margin-bottom:4px; font-size: 12px;">';
    str+='<option value="Predjelo">Predjelo</option>';
    str+='<option value="Kuvano jelo">Kuvano jelo</option>';
    str+='<option value="Rostilj">Rostilj</option>';
    str+='<option value="Salata">Salata</option>';
    str+='<option value="Supa">Supa</option>';
    str+='<option value="Corba">Corba</option>';
    str+='<option value="Riba">Riba</option>';
    str+='<option value="Morski plodovi">Morski plodovi</option>';
    str+='<option value="Pasta">Pasta</option>';
    str+='<option value="Pica">Pica</option>';
    str+='<option value="Pita">Pita</option>';
    str+='<option value="Kolac">Kolac</option>';
    str+='<option value="Pecivo">Pecivo</option>';
    str+='<option value="Torta">Torta</option>';
    str+='</select>';
    str+='<select name="ukus_temp" id="ukus_temp" class = "opcija" value = "Ukus" style = "margin-bottom:4px;font-size: 12px;">';
    str+='<option value="Slatko">Slatko</option>';
    str+='<option value="Slano">Slano</option>';
    str+='<option value="Ljuto">Ljuto</option>';
    str+='</select>';
    str+='<select name="dijeta_temp" id="dijeta_temp" class = "opcija" value = "Dijeta" style = "margin-bottom:4px;font-size: 12px;">';
    str+='<option value="Posno">Posno</option>';
    str+='<option value="Vegeterijansko">Vegeterijansko</option>';
    str+='<option value="Bez glutena">Bez glutena</option>';
    str+='</select>';
    str+='</div>';
    str+='<div class= "col-sm-2 text-right">';
    str+='<img src = "assets/baseline_visibility_black_18dp.png" width = "20px" height = "20px" style="margin-right:5px;">';
    str+='</div>';                     
    str+='</div>';
    str+='<div class = "row" style = "background-color:lightblue;" >';
    str+='<div class = "col-sm-10">';
    str+='</div>';
    str+='<div class = "col-sm-2 text-right">';
    str+='<img src = "assets/baseline_delete_black_18dp.png" width = "20px" height = "20px" style="margin-top: 3px; margin-right: 5px;">';
    str+='</div>';
    str+='</div>' ;
    str+='<div class = "row" style = "background-color:lightblue;" >';
    str+='<div class = "col-sm-12 text-left" style="overflow: hidden;">';
    str+='<textarea  draggable="false" style = "margin-bottom:4px; resize: none; " name="opis_jela_temp" form="menjanje_jela_temp" placeholder = "Unesite opis novog jela" rows = "8" cols="40" ></textarea>';
    str+='</div>';
    str+='</div>' ;
    str+='<div class = "row" style = "background-color:lightblue;">';
    str+='<div class = "col-sm-12 text-right" style = "margin-bottom:4px">';
    str+='';
    str+='<input type="text" name="gramaza_temp" id="gramaza_temp" placeholder="Gramaza">';
    str+='<input type="text" name="cena_temp" id="cena_temp" placeholder="Cena">';
    str+='</div>';
    str+='</div>';
   
    str+= '</form>';


    //vidi za formu
    var dummy = $(".dummy");
    dummy.html(str);
    dummy[0].id = id;
    dummy.removeClass("dummy").addClass("dish_temp");
    $(".cont").append("<div class='dummy'></div>");

    id++;

}
</script>

