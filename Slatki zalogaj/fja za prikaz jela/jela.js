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

                str+="<div class='ar-image'>";
                str+=" <div class='article-image'>";
                str+="<div class='row k' style='padding:15px;'> <div class='col-sm-10 k'><h3>"+naziv_jela+"</h3>";
                str+="<p style='font-weight:bold'>"
                str+=" #"+tip_jela;    
                str+=" #"+ukus;
                str+=" #"+dijeta;
                str+="</p>";
                str+="<p style='font-weight:bold; font-size:20px;' >"+opis_jela+"</p></div>"; 
                str+='<div class="col-sm-2 text-right"><i class="fas fa-plus" style="margin:5px;" onclick="povecaj()"></i>'+"<p id='broj' style='font-weight:bold; margin:5px;'>"+0+"</p>"+ '<i class="fas fa-minus" onclick="smanji()" style="margin:5px;"></i> <div id="srce"><i class="far fa-heart" onclick="srce()" style="margin:5px;"></i></div></div></div>';
           /*  str+="<div class='row k' style='padding:15px; font-weight:bold'><div class='col-sm-8 text-right'>"+gramaza+"g "+"</div><div class='col-sm-4 text-right'>" +cena +".00 din"+"</div></div>";*/
                str+="</div></div>";
    
                //dohvatiti sve dummy elemente
    let dummy = $(".dummy");
    dummy.html(str);
    dummy[0].id = id;
    dummy.removeClass("dummy").addClass("jelo"+id);
    //dodavanje dummy elementa
    $(".cont").append("<div class='dummy'></div>");
    id++;
}

function srce(){
    document.getElementById('srce').innerHTML='<i class="fas fa-heart" style="margin:5px;"></i>';
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
