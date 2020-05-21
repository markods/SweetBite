<script>
// 2020-05-20 v0.4 Jovana Pavic 2017/0099

//----------------------------------------------- 
/** .ready(function(){...})
// Pri ucitavanju stranice Admin/nalozi postavlja
//  izgled centralnog dela ('#content')
// Ucitava sve naloge i prikazuje ih u odgovarajucoj sekciji
*/

$(document).ready(function(){
    // osnovna struktura pregleda naloga
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
                    <table class="t_adm"></table>\
                </div>\
                <div class = "row">\
                    <div class = "col-md-12"><p>\
                        Menadzeri <img src=\
                            "<?php echo base_url("assets/icons/role-manager.svg");?>"\
                        alt="m">\
                    </p></div>\
                </div>\
                <div class = "row manag">\
                    <table class="t_mng"></table>\
                </div>\
                <div class = "row">\
                    <div class = "col-md-12"><p>\
                        Kuvari <img src=\
                            "<?php echo base_url("assets/icons/role-chef.svg");?>"\
                        alt="c">\
                    </p></div>\
                </div>\
                <div class = "row cook">\
                    <table class="t_chef"></table>\
                </div>\
                <div class = "row">\
                    <div class = "col-md-12"><p>\
                        Musterije <img src=\
                            "<?php echo base_url("assets/icons/role-user.svg");?>"\
                        alt="o">\
                    </p></div>\
                </div>\
                <div class = "row buyer">\
                    <table class="t_user"></table>\
                </div>\
            </div>'
        ); 

    // salje AJAX zahtev za dohvatanje svih korisnickih naloga
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
// Prikazuje korisnika na osnovu podataka iz tabele kor
// Kao parametar prihvata object koji ima atribute
//  id, name, mail, date i priv(privilegija)
*/

function showUser(object){
    // parsiranje podataka iz objekta
    let id = object.id;
    let name = object.name;
    let mail = object.mail;
    let date = object.date;
    let priv = object.priv;

    let inner = 
       '<tr id=' + id + ' class=adm>\
            <td class=name>' + name + '</td>\
            <td class=mail>' + mail + '</td>\
            <td class=date>' + date + '</td>\
            <td class=priv>' + showPrivileges(id, priv) + '</td>\
            <td class=remove>\
                <img src="<?php echo base_url("assets/icons/square-minus.svg");?>"\
                    alt="-" onclick="removeUser(' + id + ')"/>\
            </td>\
        </tr>'
        ;
    let position = null;

    // bira se odgovarajuca sekcija u odnosu na tip korisnika
    switch (priv) {
        case "Admin":    position = $(".t_adm"); break;
        case "Menadzer": position = $(".t_mng"); break;
        case "Kuvar":    position = $(".t_chef"); break;
        case "Korisnik": position = $(".t_user"); break;
    }

    position.append(inner);
}

//-----------------------------------------------
/** function removeUser(id){...}
// Uklanja nalog iz pregleda naloga
// Poziva uklanjanje nalog iz baze 
//  (poziva delete, ali se radi softDelete)
*/

function removeUser(id){
    let elemDelete = {
        kor_id: id
    }
    // salje AJAX zahtev za uklanjanje datog elementa
    $.post("<?php echo base_url('Admin/removeUser'); ?>", 
        JSON.stringify(elemDelete), "json")
    .done(function() {
        //uklanja element iz pregleda
        $("#"+id).remove();
    })
    .fail(function() {
        alert("Uklanjanje naloga nije uspelo, pokusajte ponovo!");
    });
}
    
//-----------------------------------------------
/** function showPrivileges(id, priv){...}
// Prikaz ikonica u odnosu na privilegiju
*/

function showPrivileges(id, priv){
    let str = "";
    switch (priv) {
        case "Admin": str = 
           '<img src="<?php echo base_url("assets/icons/role-admin.svg");?>"\
                    alt="a" onclick=changePrivileges("' + id + '",3)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",1)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>" \
                    alt="o" onclick=changePrivileges("' + id + '",2)>';
                break;
        case "Menadzer": str = 
           '<img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",0)>\
            <img src="<?php echo base_url("assets/icons/role-manager.svg");?>"\
                    alt="m" onclick=changePrivileges("' + id + '",3)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",2)>';
                break;
        case "Kuvar": str = 
           '<img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",0)>\
            <img src="<?php echo base_url("assets/icons/square-checkbox.svg");?>"\
                    alt="o" onclick=changePrivileges("' + id + '",1)>\
            <img src="<?php echo base_url("assets/icons/role-chef.svg");?>"\
                    alt="k" onclick=changePrivileges("' + id + '",3)>';
                break;
        case "Korisnik": str = 
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
// Promena privilegije korisnika
// Poziva promenu statusa u bazi i promenu pogleda
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
        $("#"+id).remove();
        //novi AJAX zahtev za samo jednog korisnika
        $.post("<?php echo base_url('Admin/loadUser');?>",
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

</script>

