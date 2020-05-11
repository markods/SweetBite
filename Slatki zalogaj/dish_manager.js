                //TODO implement image upload amd background image
                //TODO see dish availability through database and hiding date, where does date get converted to string, here or somewhere else

                var id=0;


                $('#openImgUpload').click(function() {
                $('#upload_img').trigger('click');
                 });
    
    
    
                function hide_dish() {
    
                }
    
                function show_dish() {
    
                }
    
    
                function menjanje(obj) {
                   
                   
                    //TODO implement image upload amd background image
                    //TODO see dish availability through database and hiding date, where does date get converted to string, here or somewhere else
    
                    if(obj == null)  {
    
    
    
                      
    
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
                        // dodavanje slike
                        // str+='<input type = "file" id = "upload_img" style="display:none"/>';
                        // str+='<button style = "text-align:left" id = "openImgUpload">Okacite sliku jela</button>';
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
                    else {
                    var str ="";
    
                    //naziv gramaza cena opis slika tag status
                    //treba videti gde datum sakrivanja pretvaram u string dostupno/nedostupno
                    let object = {
                        id:id,
                        naziv_jela:"punejna pljeskavica",
                        gramaza:200,
                        opis:"Pljeskavica od 200 grama punjena sunkom i sirom, srednje pecena",
                        cena:350,
                        tag:"slano",
                        status:"dostupno", //status dostupno 0, nedostupno 1 
                    }
                    
    
                   
                    //pokusaj
                    str+='<div style = "background-color:lightblue;">';
                    str+='<div class="elem" style = "background-color:lightblue;">';
                    str+='<form name = "menjanje_jela_temp" method = "POST" >';
                    str+='<div class = "row" style = "background-color:lightblue;">';
                    str+='<div class = "col-sm-10 text-left">';
                    str+='<input  type = "text" name = "naziv_jela" placeholder ="'+object.naziv_jela+'"style = margin-top:4px; margin-bottom:4px; height: 25px;">';
                    str+= '</div>';              
                    str+='<div class = "col-sm-2 text-right">';
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
                    if(object.status=="dostupno")
                        str+='<img src = "assets/baseline_visibility_black_18dp.png" width = "20px" height = "20px" style="margin-right:5px;" onclick = "hide_dish()">';
                    else
                        str+='<img src = "assets/baseline_visibility_off_black_18dp.png" width = "20px" height = "20px" style="margin-right:5px;" onclick = "show_dish()">';
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
                    str+='<textarea draggable="false" style = "margin-bottom:4px; resize: none; " name="opis_jela_temp" form="menjanje_jela_temp" placeholder = "'+object.opis+'" rows = "8" cols="40" ></textarea>';
                    str+='</div>';
                    str+='</div>' ;
                    str+='<div class = "row" style = "background-color:lightblue;">';
                    str+='<div class = "col-sm-12 text-right" style = "margin-bottom:4px">';
                    str+='<input class = "text-right" type="text" name="gramaza_temp" id="gramaza_temp" placeholder="'+object.gramaza+'">';
                    str+='<input class = "text-right"  type="text" name="cena_temp" id="cena_temp" placeholder="'+object.cena+'">';
                    str+='</div>';
                    str+='</div>';
                   
                    str+= '</form>';
                    //pokisaj
                    str+='</div>';
                    str+='</div>';
    
    
                    //vidi za formu
                    var dummy = $(".dummy");
                    dummy.html(str);
                    dummy[0].id = id;
                    dummy.removeClass("dummy").addClass("dish_temp");
                    $(".cont").append("<div class='dummy'></div>");
    
                    id++;
    
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
               
    