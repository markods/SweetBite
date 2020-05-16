<script>
// 2020-05-15 v0.3 Jovana Pavic 2017/0099

//odgovaralo bi kada bi se umesto tipkor_id slao
//parsiran taj podatak u 0, 1, 2 ili 3 (parametar priv)

//----------------------------------------------- 
/** .ready(function(){...})
//Pri ucitavanju stranice admin-nalozi postavlja izgled
//centralnog dela ('#content')
//ucitava sve naloge i prikazuje ih u odgovarajucoj sekciji
*/
$(document).ready(function(){
   $("#content").append(
           '<div class = "contA">\
                <div class = "row">\
                    <div class = "col-md-12"><p>\
                        Administratori <img src=\
                            "<?php echo base_url("assets/icons/role-admin.svg");?>"\
                        alt="a">\
                    </p></div>\
                </div>\
                <div class = "row admin">\
                    <div class = "col-md-12 dummy"></div>\
                </div>\
                <div class = "row">\
                    <div class = "col-md-12"><p>\
                        Menadzeri <img src=\
                            "<?php echo base_url("assets/icons/role-manager.svg");?>"\
                        alt="m">\
                    </p></div>\
                </div>\
                <div class = "row manag">\
                    <div class = "col-md-12 dummy"></div>\
                </div>\
                <div class = "row">\
                    <div class = "col-md-12"><p>\
                        Kuvari <img src=\
                            "<?php echo base_url("assets/icons/role-chef.svg");?>"\
                        alt="c">\
                    </p></div>\
                </div>\
                <div class = "row cook">\
                    <div class = "col-md-12 dummy"></div>\
                </div>\
                <div class = "row">\
                    <div class = "col-md-12"><p>\
                        Musterije <img src=\
                            "<?php echo base_url("assets/icons/role-user.svg");?>"\
                        alt="o">\
                    </p></div>\
                </div>\
                <div class = "row buyer">\
                    <div class = "col-md-12 dummy"></div>\
                </div>\
            </div>'
        ); 

    //salje AJAX zahtev za dohvatanje svih korisnickih naloga
    $.post("<?php echo base_url('Admin/loadAllUsers'); ?>")
    .done(function( users ){
        for(let i=0; i<users.kor_id.length; i++){
            //od jednog elementa niza pravi JSON objekat koji
            //se prosledjuje funkciji showUser
            let user = {
                "id":   users.kor_id[i],
                "name": users.kor_ime[i],
                "mail": users.kor_mail[i],
                "date": users.kor_datkre[i],
                "priv": users.kor_tipkor[i]
            }
            showUser(user);
        }
    })
    .fail(function() {
        alert("Can't access data, server is down");
    });
});
        
//-----------------------------------------------  
/** function showUser(object){...}
//prikazuje korisnika na osnovu podataka iz tabele kor
//kao parametar prihvata object koji ima atribute
//id, name, mail, date i priv(privilegija)
//privilegije korisnika (0-admin, 1-menadzer, 2-kuvar, 3-kupac)
*/

/*
    !!! Koriste se konstante za tipovekorisnika !!!
 */    

function showUser(object){
    // Parsiranje podataka iz objekta
    let id = object.id;
    let name = object.name;
    let mail = object.mail;
    let date = object.date;
    let priv = object.priv;

    let inner = 
        '<table id=' + id + ' class=adm>\
            <tr>\
                <td class=name>' + name + '</td>\
                <td class=mail>' + mail + '</td>\
                <td class=date>' + date + '</td>\
                <td class=priv>' + showPrivileges(id, priv) + '</td>\
                <td class=remove>\
                    <img src="<?php echo base_url("assets/icons/square-minus.svg");?>"\
                        alt="-" onclick="removeAccount(' + id + ')"/>\
                </td>\
            </tr>\
        </table>'
        ;
    let position = null;
/*
    !!! Koriste se konstante za tipovekorisnika !!!
 */    
    switch (priv) {
        case 0: position = $(".admin"); break;
        case 1: position = $(".manag"); break;
        case 2: position = $(".cook"); break;
        case 3: position = $(".buyer"); break;
    }

    //dohvata .dummy unutar elementa position
    $(".dummy", position).append(inner);
    $(".dummy", position).removeClass("dummy").addClass("user");

    position.append("<div class='col-md-12 dummy'></div>");
}

//-----------------------------------------------
/** function removeAccount(id){...}
//uklanja nalog iz pregleda naloga
//uklanja nalog iz baze (poziva delete, ali
//se radi softDelete)
*/

function removeAccount(id){
    let elemDelete = {
        kor_id: id
    }
    //salje AJAX zahtev za uklanjanje datog elementa
    $.post("<?php echo base_url('Admin/removeAccount'); ?>", 
        JSON.stringify(elemDelete), "json")
    .done(function() {
        //uklanja element iz pregleda
        let elem = $("#"+id).parent();
        elem.remove();  //JQuery metoda
    })
    .fail(function() {
            alert("Uklanjanje naloga nije uspelo, pokusajte ponovo!");
    });
}

//-----------------------------------------------
/** function hideAccount(id){...}
//uklanja nalog iz pogleda
*/

function hideAccount(id){
    let elem = $("#"+id).parent();
    elem.remove();  //JQuery metoda  
}
    
//-----------------------------------------------
/** function showPrivileges(id, priv){...}
//prikaz ikonica u odnosu na privilegiju
*/

/*
    !!! Koriste se konstante za tipovekorisnika !!!
 */    

function showPrivileges(id, priv){
    var str = "";
    switch (priv) {
        case 0: str = 
           '<img src="<?php echo base_url("assets/icons/role-admin.svg");?>"\
                    alt="a" onclick=changePrivileges("' + id + '", 3)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",1)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>" \
                    alt="o" onclick=changePrivileges("' + id + '",2)>';
                break;
        case 1: str = 
           '<img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",0)>\
            <img src="<?php echo base_url("assets/icons/role-manager.svg");?>"\
                    alt="m" onclick=changePrivileges("' + id + '", 3)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",2)>';
                break;
        case 2: str = 
           '<img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",0)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",1)>\
            <img src="<?php echo base_url("assets/icons/role-chef.svg");?>"\
                    alt="k" onclick=changePrivileges("' + id + '", 3)>';
                break;
        case 3: str = 
           '<img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",0)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",1)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",2)>';
                break;
    }
    return str;
}

//-----------------------------------------------
/** function changePrivileges(id, priv){...}
//promena privilegije korisnika
//promena statusa u bazi i promena pogleda
*/

function changePrivileges(id, priv){
    let elemChange = {
        kor_id: id,
        nova_priv: priv
    }
    //salje AJAX zahtev za uklanjanje datog elementa
    $.post("<?php echo base_url('Admin/changePrivileges');?>", 
        JSON.stringify(elemChange), "json")
    .done(function( response ) {
        hideAccount(id);
        //novi AJAX zahtev za samo jednog korisnika
        $.post("<?php echo base_url('Admin/loadAccount');?>",
            JSON.stringify({"kor_id": id}), "json")
        .done(function(users){
            let user = {
                "id":   users.kor_id,
                "name": users.kor_ime,
                "mail": users.kor_mail,
                "date": users.kor_datkre,
                "priv": users.kor_tipkor
            }
            showUser(user);
        })
    })
    .fail(function() {
        alert("Promena privilegije naloga nije uspela, pokusajte ponovo!");
    });
}






//ne koristi se
//-----------------------------------------------
/** function dateString(date){...}
//formatira datum
*/

function dateString(date){
    let year = date.getFullYear();
    let month =  date.getMonth() + 1;
    if (month < 10) month = "0" + month;
    let day = date.getDay();
    if (day < 10) day = "0" + day;
    let hour = date.getHours();
    if (hour < 10) hour = "0" + hour;
    let min = date.getMinutes();
    if (min < 10) min = "0" + min;
    let str = year + "-" + month + "-" + day + " " + hour + ":" + min;
    return str;
}

</script>

