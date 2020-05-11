var id = 0;

function prikaziJelo(object) { 
    let naziv_jela='Pita sa jabukama';
    let  tagovi=["posno","predjelo","slano"];
    let tip_jela="predjelo";
    let dijeta="posno";
    let ukus="slano";
    let opis_jela="Ovo je nasa najtrazenija poslastica. Deca se posebno raduju ovom dezertu. Zbog toga je preporucujemo za decje rodjendane";
    let gramaza=200;
    let cena=300;
    var str = "";

  str+=  "<div class='ar-image'>";
   str+= "<div class='article-image'>"
   str+=   "<div class='row base'>"
   str+=   " <div class='col-md-10 about'>"
   str+=     "<h3>"+naziv_jela+"</h3>";
   str+=    " <p style='font-weight:bold'>"+ "#"+tagovi[0]+ " #"+tagovi[1]+" #"+tagovi[2]+ "</p>";
            str+=   " <p style='font-weight:bold; font-size:20px;' >"+opis_jela+"</p>";
            str+= " </div>";
            str+=  "<div class='col-md-2 amount'>";
            str+=   " <div class='change'>";
            str+=      "<i class='fas fa-plus' onclick='povecaj()'></i>";
            str+=      "<p id='broj' style='font-weight:bold; margin-top:  17px;'></p>";
            str+=       "<i class='fas fa-minus' onclick='smanji()'></i>";
            str+=       " </div>";
            str+=    " <div id='srce'>";
            str+=      "  <i class='fas fa-heart' onclick='srce()'></i>";
            str+=     " </div>";
            str+=     "</div>";
            str+=  " </div>";
            str+=    "<div class='row price' style='font-weight:bold'>";
            str+=   " <div class='col-sm-8 text-right'>"+gramaza+" g</div>";
            str+=   " <div class='col-sm-4 text-right'>"+ cena+".00 din</div>";
            str+= "  </div>";
            str+=  "</div>";
            str+=" </div>";
    
                //dohvatiti sve dummy elemente
    let dummy = $(".dummy");
    dummy.html(str);
   //dummy[0].id = id;
    dummy.removeClass("dummy").addClass("dish_temp");
    //dodavanje dummy elementa
    $(".cont").append("<div class='dummy'></div>");
    id++;
}

function srce(){
    document.getElementById('srce').innerHTML='<i class="fas fa-heart"></i>';
}

function povecaj(){
    var p=document.getElementById("broj");
    var text=p.textContent;
    var broj=Number(text);
    broj++;
    document.getElementById("broj").innerHTML=broj;
}

function smanji(){
    var p=document.getElementById("broj");
    var text=p.textContent;
    var broj=Number(text); 
    if(broj<=0){
        document.getElementById("broj").innerHTML=broj;
    }
    else{
    broj--;
    document.getElementById("broj").innerHTML=broj;}
}
