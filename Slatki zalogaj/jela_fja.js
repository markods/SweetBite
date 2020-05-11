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
    let slika='prikazjela/jabuka.jpg';
    var str = "";

  str+=  "<div class='ar-image'>";
   str+= "<div class='article-image'>";
   str+=   "<div class='row base'>"
   str+=   " <div class='col-md-10 about1'>"
   str+=     "<h3 class='text-left'>"+naziv_jela+"</h3>";
   str+=    " <p style='font-weight:bold'>"+ "#"+tagovi[0]+ " #"+tagovi[1]+" #"+tagovi[2]+ "</p>";
            str+=   " <p style='font-weight:bold; font-size:15px;' >"+opis_jela+"</p>";
            str+= " </div>";
            str+=  "<div class='col-md-2 amount'>";
            str+=   " <div class='change'>";
            str+=      "<i class='fas fa-plus' id='povecaj_" +id+"' onclick='povecaj(this)'></i>";
            str+=      "<p id='broj_"+id+"'style='font-weight:bold; margin-top:  17px; margin-left:12px;'></p>";
            str+=       "<i class='fas fa-minus' id='smanji_"+id+"' onclick='smanji(this)'></i>";
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
    dummy.removeClass("dummy").addClass("dish_customer");
    //dodavanje dummy elementa
    $(".cont1").append("<div class='dummy'></div>");
    id++;
}

function srce(){
    document.getElementById('srce').innerHTML='<i class="fas fa-heart"></i>';
}

//radi do 100 slika 
function povecaj(input){
    //alert("povecaj");
    var id_1=$(input).attr("id")[8];
    var id_2= $(input).attr("id")[9];
    if(isNaN(id_2)){
        var id_=parseInt(id_1);
    }
    else{
        var id_=id_1+id_2;
        var id_=parseInt(id_);
    }
    var p=document.getElementById("broj_"+id_);
    var text=p.textContent;
    var broj=Number(text);
    broj=broj+1;
    document.getElementById("broj_"+id_).innerHTML=broj;
    
}

//radi do 100 slika
function smanji(input){
    var id_1=$(input).attr("id")[7];
    var id_2=$(input).attr("id")[8];
    if(isNaN(id_2)){
        var id_=parseInt(id_1);
    }
    else{
        var id_=id_1+id_2;
        var id_=parseInt(id_);
    }
    var p=document.getElementById("broj_"+id_);
    var text=p.textContent;
    var broj=Number(text); 
    if(broj<=0){
        document.getElementById("broj_"+id_).innerHTML=broj;
    }
    else{
    broj--;
    document.getElementById("broj_"+id_).innerHTML=broj;}
}


/*
 <div class="container-fluid">
        <div id="content" class="col-12 offset-sm-2 col-sm-8 offset-lg-3 col-lg-6">
            <h2 onclick="prikaziJelo()">Jela</h2>
            <div class="cont">
                <div class="dummy"></div>
            </div>
        </div>
    </div> */ 