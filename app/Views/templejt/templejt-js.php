<?php /* 2020-05-15 v0.1 Marko Stanojevic 2017/0081 */ ?>
<script>


// only allow method calls when the document is ready
$(document).ready(function() {
    
    // ====== button events ======
    // change the input background colour to red if the passwords don't match
    $("#register-password-1, #register-password-2").on('input', function() {
        let kor_pwd_1 = $("#register-password-1");
        let kor_pwd_2 = $("#register-password-2");
        
        // if the passwords don't match
        if( kor_pwd_1.val() != kor_pwd_2.val() )
        {
            // set their inputs' background colours to red
            kor_pwd_1[0].setCustomValidity('false');
            kor_pwd_2[0].setCustomValidity('false');
        }
        else
        {
            // otherwise reset the inputs' background colours
            kor_pwd_1[0].setCustomValidity('');
            kor_pwd_2[0].setCustomValidity('');
        }
    });

    // when the user clicks the register button in the register form
    $("#register").on('click', function() {
        
        // create variables that hold the register form jQuery! objects
        let kor_naziv = $("#register-full-name" );
        let kor_email = $("#register-email"     );
        let kor_tel   = $("#register-phone-num" );
        let kor_pwd_1 = $("#register-password-1");
        let kor_pwd_2 = $("#register-password-2");
        
        // if the passwords don't match, do nothing (don't send a request)
        if( kor_pwd_1.val() != kor_pwd_2.val() ) return;
        
        // create a request
        let request = {
            kor_naziv: kor_naziv.val(),
            kor_email: kor_email.val(),
            kor_tel:   kor_tel  .val(),
            kor_pwd:   kor_pwd_1.val()
        };
        
        // send an AJAX request to the given url, with the given JSON object
        $.post(<?php echo '"'.base_url('Gost/register').'"'; ?>, JSON.stringify(request), "json")
        // when the client receives the AJAX response, this function gets called
        .done(function( response ) {
            alert("Registered successfully.");
        })
        // if the response times out or fails (due to some error), this function gets called
        .fail(function() {
            // alert the user that the request has failed (there should be a better way, but this is okay for the time being)
            alert("Failed to register.");
        });
    });
    
    
    // ====== template page customization ======
    // setting custom sidebar settings
    $("#sidebar").mCustomScrollbar({
        theme: "minimal-dark",
        scrollEasing: "easeInOut",
        scrollInertia: 100
    });

    // setting the sidebar toggle button action
    $("#sidebar-toggle").on('click', function() {
        $("#sidebar").toggleClass("active");
    });

    // make sidebar visible by default for screens that are bigger than 768px
    if( $(document).width() >= 768 )
        $("#sidebar").addClass("active");
});


</script>

