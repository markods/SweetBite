<?php /* 2020-05-15 v0.1 Marko Stanojevic 2017/0081 */ ?>
<script>


// only allow method calls when the document is ready
$(document).ready(function() {
    // ====== constants ======
    const nbsp = '&nbsp;';
    
    
    
    // ====== login ======
    // reset the email field help text and background color
    $("#login-email").on('input', function() {
        let email = $(this);

        // reset the input background colour
        email[0].setCustomValidity('');
        // reset the help tip
        $('#login-email-help').html(nbsp);
        // reset the general form tip
        $("#login-help").html('');
    });
    
    // reset the password field help text and background color
    $("#login-password").on('input', function() {
        let password = $(this);
        
        // reset the input background colour
        password[0].setCustomValidity('');
        // reset the help tip
        $('#login-password-help').html(nbsp);
        // reset the general form tip
        $("#login-help").html('');
    });
    
    
    // check the form fields when the user clicks the login button, if they are valid send a request
    $("#login").on('click', function() {
        // reset the general form tip
        $("#login-help").html('');
        
        // create a request
        let request = {
            kor_email: $("#login-email"   ).val(),
            kor_pwd:   $("#login-password").val()
        };
        
        // if any of the form fields is empty, don't send the request
        if( request.kor_email === ""
         || request.kor_pwd   === ""
        )
        return;

        // send an AJAX request to the given url, with the given JSON object
        $.post(<?php echo '"'.base_url('Gost/login').'"'; ?>, JSON.stringify(request), "json")
        // when the client receives the AJAX response, this function gets called
        .done(function( response ) {
            // if the operation was successful, redirect to the appropriate page
            if( response['redirect'] ) window.location.replace(response['redirect']);
            // otherwise, take the error codes and embed them in the matching form help fields
            for( let [key, val] of Object.entries(response) )
                $(key).html(val);
        })
        // if the response times out or fails (due to some error), this function gets called
        .fail(function() {
            // embed the error code in the register dropdown help field
            $("#login-help").html("neuspesna konekcija ka serveru");
        });
    });
    
    
    
    // ====== register ======
    // check if the username field is valid, if it isn't output help text and change field background color
    $("#register-full-name").on('input', function() {
        let fullname = $(this);
        
        let validity = 'false';   // 'false' is false, '' is valid
        let tip      = nbsp;      // non breaking space -- &nbsp;
        
        // check if the full name length is appropriate
        if     ( fullname.val().length === 0 ) validity = '';
        else if( fullname.val().length > 64  ) tip = 'puno ime predugacko';
        else                                   validity = '';
        
        // set the input background colour according to validity
        fullname[0].setCustomValidity(validity);
        // set the help tip
        $('#register-full-name-help').html(tip);
        // reset the general form tip
        $("#register-help").html('');
    });
    
    // check if the email field is valid, if it isn't output help text and change field background color
    $("#register-email").on('input', function() {
        let email = $(this);
        
        let validity = 'false';   // 'false' is false, '' is valid
        let tip      = nbsp;      // non breaking space -- &nbsp;
        let regex    = RegExp(/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/);
        
        // check if the email length is appropriate and that it is in the correct format (html standard)
        if     ( email.val().length === 0 ) validity = '';
        else if( email.val().length > 128 ) tip = 'email predugacak';
        else if( !regex.test(email.val()) ) tip = 'neispravan format email-a';
        else                                validity = '';
        
        // set the input background colour according to validity
        email[0].setCustomValidity(validity);
        // set the help tip
        $('#register-email-help').html(tip);
        // reset the general form tip
        $("#register-help").html('');
    });
    
    // check if the phone number field is valid, if it isn't output help text and change field background color
    $("#register-phone-num").on('input', function() {
        let phonenum = $(this);
        
        let validity = 'false';   // 'false' is false, '' is valid
        let tip      = nbsp;      // non breaking space -- &nbsp;
        let regex    = RegExp(/\+[0-9]+/);
        
        // check if the username length is appropriate and that it only contains ascii symbols and spaces
        if     ( phonenum.val().length === 0 ) validity = '';
        else if( phonenum.val().length < 8   ) tip = 'broj telefona previse kratak';
        else if( phonenum.val().length > 16  ) tip = 'broj telefona predugacak';
        else if( !regex.test(phonenum.val()) ) tip = 'broj telefona treba da bude bez razmaka';
        else                                   validity = '';
        
        // set the input background colour according to validity
        phonenum[0].setCustomValidity(validity);
        // set the help tip
        $('#register-phone-num-help').html(tip);
        // reset the general form tip
        $("#register-help").html('');
    });

    // check if the password fields are valid, if they aren't output help text and change field background color
    $("#register-password-1, #register-password-2").on('input', function() {
        let kor_pwd_1 = $("#register-password-1");
        let kor_pwd_2 = $("#register-password-2");
        
        let validity = 'false';   // 'false' is false, '' is valid
        let tip      = nbsp;      // non breaking space -- &nbsp;
        
        // check if the password length is appropriate and that the passwords match
        if     ( kor_pwd_1.val().length === 0 )       validity = '';
        else if( kor_pwd_1.val().length < 8   )       tip = 'lozinka previse kratka';
        else if( kor_pwd_1.val().length > 64  )       tip = 'lozinka previse dugacka';
        else if( kor_pwd_1.val() != kor_pwd_2.val() ) tip = 'lozinke se ne poklapaju';
        else                                          validity = '';
        
        // set the inputs' background colours according to validity
        kor_pwd_1[0].setCustomValidity(validity);
        kor_pwd_2[0].setCustomValidity(validity);
        // set the help tip
        $('#register-password-help').html(tip);
        // reset the general form tip
        $("#register-help").html('');
    });
    
    
    // check the form fields when the user clicks the register button, if they are valid send a request
    $("#register").on('click', function() {
        // reset the general form tip
        $("#register-help").html('');
        
        // if any of the form fields is invalid, don't send the request
        if( $("#register-full-name-help").html() != nbsp
         || $("#register-email-help"    ).html() != nbsp
         || $("#register-phone-num-help").html() != nbsp
         || $("#register-password-help" ).html() != nbsp
        )
        return;
    
        // create a request
        let request = {
            kor_naziv: $("#register-full-name" ).val(),
            kor_email: $("#register-email"     ).val(),
            kor_tel:   $("#register-phone-num" ).val(),
            kor_pwd:   $("#register-password-1").val()
        };
        
        // if any of the form fields is empty, don't send the request
        if( request.kor_naziv === ""
         || request.kor_email === ""
         || request.kor_tel   === ""
         || request.kor_pwd   === ""
        )
        return;

        // send an AJAX request to the given url, with the given JSON object
        $.post(<?php echo '"'.base_url('Gost/register').'"'; ?>, JSON.stringify(request), "json")
        // when the client receives the AJAX response, this function gets called
        .done(function( response ) {
            // if the operation was successful, redirect to the appropriate page
            if( response['redirect'] ) window.location.replace(response['redirect']);
            // otherwise, take the error codes and embed them in the matching form help fields
            for( let [key, val] of Object.entries(response) )
                $(key).html(val);
        })
        // if the response times out or fails (due to some error), this function gets called
        .fail(function() {
            // embed the error code in the register dropdown help field
            $("#register-help").html("neuspesna konekcija ka serveru");
        });
    });
    
    
    
    // ====== logout ======
    // log the client out of the system
    $('#logout').on('click', function() {
        $.post(<?php echo '"'.base_url("$tipkor/logout").'"'; ?>)
        .done(function( response ) {
            // if the operation was successful, redirect to the appropriate page
            if( response['redirect'] ) window.location.replace(response['redirect']);
        });
    });
    
    
    
    // ====== page customization ======
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

    // make sidebar visible by default for screens that are bigger than 1400px
    if( $(document).width() >= 1400 )
        $("#sidebar").addClass("active");
    
    $("#sidebar").delay(500).queue(function() {
        $(this).addClass("animation");
    });
});


</script>

