<?php /* 2020-05-15 v0.1 Marko Stanojevic 2017/0081 */ ?>
<script>

$(document).ready(function () {
    
    $("#register-password-1, #register-password-2").on('input', function() {
        let kor_pwd_1 = $("#register-password-1");
        let kor_pwd_2 = $("#register-password-2");
        
        debugger;
        if( kor_pwd_1.val() != kor_pwd_2.val() )
        {
            kor_pwd_1[0].setCustomValidity('false');
            kor_pwd_2[0].setCustomValidity('false');
        }
        else
        {
            kor_pwd_1[0].setCustomValidity('');
            kor_pwd_2[0].setCustomValidity('');
        }
    });
    
    // ====== button events ======
    $("#register").on('click', function() {
        
        let kor_naziv = $("#register-full-name" );
        let kor_email = $("#register-email"     );
        let kor_tel   = $("#register-phone-num" );
        let kor_pwd_1 = $("#register-password-1");
        let kor_pwd_2 = $("#register-password-2");
        
        if( kor_pwd_1.val() != kor_pwd_2.val() ) return;
        
        let request = {
            kor_naziv: kor_naziv.val(),
            kor_email: kor_email.val(),
            kor_tel:   kor_tel  .val(),
            kor_pwd:   kor_pwd_1.val()
        };
        
        $.post(<?php echo '"'.base_url('Gost/register').'"'; ?>, JSON.stringify(request), "json")
        .done(function( response ) {
            alert(response.kor_pwd);
            alert(response.heyy);
        })
        .fail(function() {
            alert("Failed to register");
        });
    });
    
    
    // ====== template page customization ======
    $("#sidebar").mCustomScrollbar({
        theme: "minimal-dark",
        scrollEasing: "easeInOut",
        scrollInertia: 100
    });

    $("#sidebar-toggle").on('click', function () {
        $("#sidebar").toggleClass("active");
    });

    let width = $(document).width();
    if( width >= 768 )
        $("#sidebar").addClass("active");
});

</script>

