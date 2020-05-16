<script>         
//Autori:
//Filip Lucic 0188/17
//Jovana Jankovic 0586/17

var id=0;


$('#openImgUpload').click(function() {
$('#upload_img').trigger('click');
 });



function hide_dish() {
    
    alert('jocka je najlepsa');

}

function show_dish() {

}

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
           $('#'+data["jelo_id"]).css("background-image","url(<?php echo base_url("assets/icons/cevapi.jpg");?>)");
    })
    .fail(function() {
            alert("Dodavanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
    });  
}


function ucitajJela() {
    menjanje();
    //izbirsan JSON jer ne prosledjujem nista
    $.post("<?php echo base_url('Menadzer/dohvatiSvaJela'); ?>")  
    .done(function(data) {
           for(let i = 0; i<data.length; i++) {            
           menjanje(data[i]);
           $('#'+data[i]["jelo_id"]).css("background-image","url(<?php echo base_url("assets/icons/cevapi.jpg");?>)");
           }  
    })
    .fail(function() {
            alert("Dodavanje jela nije uspelo, molimo Vas, pokusajte ponovo!");
    });  
    
}


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
        str+='<option value="Vegeterijansko">Vegeterijansko</option>';
        str+='<option value="Bez glutena">Bez glutena</option>';
        str+='<option value="Mrsno">Mrsno</option>';
        str+='<option value="Bez laktoze">Bez laktoze</option>';
        str+='</select>';
        str+='</div>';
        str+='<div class= "col-sm-2 text-right">';
        str+='<img src = "<?php echo base_url("assets/icons/eye-open.svg");?>" onclick="insertuj()"width = "20px" height = "20px" style="margin-right:5px;">';
        str+='</div>';                     
        str+='</div>';
        str+='<div class = "row">';
        str+='<div class = "col-sm-10">';
        str+='</div>';
        str+='<div class = "col-sm-2 text-right">';
        str+='<img src = "<?php echo base_url("assets/icons/trash.svg");?>" width = "20px" height = "20px" style="margin-top: 3px; margin-right: 5px;">';
        str+='</div>';
        str+='</div>' ;
        str+='<div class = "row">';
        str+='<div class = "col-sm-12 text-left" style="overflow: hidden;">';
        str+='<textarea  draggable="false" style = "margin-bottom:4px; resize: none; " name="opis_jela_temp" id="opis_jela_temp" form="menjanje_jela_temp" placeholder = "Unesite opis novog jela" rows = "8" cols="35" ></textarea>';
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
        
        
       
        //vidi za formu
//        var dummy = $(".dummy");
//        dummy.html(str);
//        dummy[0].id = id;
//        dummy.removeClass("dummy").addClass("dish_temp");
//        $(".cont").append("<div class='dummy'></div>");
//
//        id++;

    } 
    else {
    var str ="";
    
    str+='<div id="'+ obj["jelo_id"]+'"class="dish_wrapper" >';
    str+='<div class="elem"';
    str+='<form name = "menjanje_jela" method = "POST" >';
    str+='<div class = "row">';
    str+='<div class = "col-sm-10 text-left">';
    str+='<input  type = "text" id="naziv_jela" name = "naziv_jela" placeholder ="'+obj["jelo_naziv"]+'"style = margin-top:4px; margin-bottom:4px; height: 25px;">';
    str+= '</div>';              
    str+='<div class = "col-sm-2 text-right">';
    str+='<img src = "<?php echo base_url("assets/icons/plain-check.svg");?>" width = "20px" height = "20px" onclick="potvrdi_promenu()" style="margin-top: 10px; margin-right: 5px;">';   
    str+='</div>';
    str+='</div>';
    str+='<div class = "row">';
    str+='<div class="col-sm-10 text-left">';
    str+='<select name="vrsta_jela_temp" id="vrsta_jela" class = "opcija text-left" style = "margin-bottom:4px; font-size: 12px;">';
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
    str+='<select name="ukus" id="ukus" class = "opcija"  style = "margin-bottom:4px;font-size: 12px;">';
    str+='<option value="Slatko">Slatko</option>';
    str+='<option value="Slano">Slano</option>';
    str+='<option value="Ljuto">Ljuto</option>';
    str+='<option value="Gorko">Gorko</option>';
    str+='<option value="Kiselo">Kiselo</option>';
    str+='</select>';
    str+='<select name="dijeta" id="dijeta" class = "opcija" style = "margin-bottom:4px;font-size: 12px;">';
    str+='<option value="Nije dijetalno">Nije dijetalno</option>';
    str+='<option value="Posno">Posno</option>';
    str+='<option value="Vegeterijansko">Vegeterijansko</option>';
    str+='<option value="Bez glutena">Bez glutena</option>';
    str+='<option value="Mrsno">Mrsno</option>';
    str+='<option value="Bez laktoze">Bez laktoze</option>';
    str+='</select>';
    str+='</div>';
    str+='<div class= "col-sm-2 text-right">';
    if(obj['jelo_datsakriv']==null)
        str+='<img src = "<?php echo base_url("assets/icons/eye-open.svg");?>" width = "20px" height = "20px" style="margin-right:5px;" onclick = "hide_dish()">';
    else
        str+='<img src = "<?php echo base_url("assets/icons/eye-closed.svg");?>.png" width = "20px" height = "20px" style="margin-right:5px;" onclick = "show_dish()">';
    str+='</div>';                     
    str+='</div>';
    str+='<div class = "row">';
    str+='<div class = "col-sm-10">';
    str+='</div>';
    str+='<div class = "col-sm-2 text-right">';
    str+='<img src = "<?php echo base_url("assets/icons/trash.svg");?>" width = "20px" height = "20px" style="margin-top: 3px; margin-right: 5px;">';
    str+='</div>';
    str+='</div>' ;
    str+='<div class = "row">';
    str+='<div class = "col-sm-12 text-left" style="overflow: hidden;">';
    str+='<textarea draggable="false" id="opis_jela" style = "margin-bottom:4px; resize: none; " name="opis_jela" form="menjanje_jela" placeholder = "'+obj["jelo_opis"]+'" rows = "8" cols="35" ></textarea>';
    str+='</div>';
    str+='</div>' ;
    str+='<div class = "row cena_i_masa">';
    str+='<div class = "col-sm-12 text-right" style = "margin-bottom:4px">';
    str+='<input class = "text-right" type="text" name="gramaza" id="gramaza" placeholder="'+obj["jelo_masa"]+'">';
    str+='<input class = "text-right"  type="text" name="cena" id="cena" placeholder="'+obj["jelo_cena"]+'">';
    str+='</div>';
    str+='</div>';
   
    str+= '</form>';
    str+='</div>';
    str+='</div>';


    $('#content').append(str);

    //vidi za formu
//    var dummy = $(".dummy");
//    dummy.html(str);
//    dummy[0].id = id;
//    dummy.removeClass("dummy").addClass("dish_temp");
//    $(".cont").append("<div class='dummy'></div>");
//
//    id++;

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


function add_picture() {
    alert("usao u dodavanje");
}

</script>

