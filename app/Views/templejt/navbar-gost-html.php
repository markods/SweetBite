<?php // 2020-05-19 v0.1 Marko Stanojevic 2017/0081 ?>


<!-- dropdown -- register -->
<div class="dropdown btn-group">

    <!-- register button -->
    <button class="btn btn-link p-0" data-toggle="dropdown">
        Registracija
    </button>

    <!-- register dropdown menu -->
    <form class="dropdown-menu dropdown-menu-right p-3">
        <small id="register-help"></small>
        <div class="form-group">
            <label for="register-full-name">ime i prezime</label>
            <input type="text" class="form-control" id="register-full-name" placeholder="Petar Petrović">
            <small id="register-full-name-help">&nbsp;</small>
        </div>
        <div class="form-group">
            <label for="register-email">email</label>
            <input type="email" class="form-control" id="register-email" placeholder="email@example.com">
            <small id="register-email-help">&nbsp;</small>
        </div>
        <div class="form-group">
            <label for="register-phone-num">broj telefona</label>
            <input type="tel" class="form-control" id="register-phone-num" placeholder="+381012345678">
            <small id="register-phone-num-help">&nbsp;</small>
        </div>
        <div class="form-group">
            <label for="register-password-1">lozinka</label>
            <input type="password" class="form-control" id="register-password-1" placeholder="lozinka">
        </div>
        <div class="form-group">
            <label for="register-password-2">ponovite lozinku</label>
            <input type="password" class="form-control" id="register-password-2" placeholder="lozinka">
            <small id="register-password-help">&nbsp;</small>
        </div>
        <div>
            <div class="spacer"></div>
            <div id="register" class="btn btn-outline-dark">registruj</div>
        </div>
    </form>

</div>

<!-- dropdown -- login -->
<div class="dropdown btn-group pr-0">

    <!-- login button -->
    <button class="btn btn-link p-0" data-toggle="dropdown">
        Prijava
    </button>

    <!-- login dropdown menu -->
    <form class="dropdown-menu dropdown-menu-right p-3">
        <small id="login-help"></small>
        <div class="form-group">
            <label for="login-email">email</label>
            <input type="email" class="form-control" id="login-email" placeholder="email@example.com">
            <small id="login-email-help">&nbsp;</small>
        </div>
        <div class="form-group">
            <label for="login-password">lozinka</label>
            <input type="password" class="form-control" id="login-password" placeholder="lozinka">
            <small id="login-password-help">&nbsp;</small>
        </div>
        <div>
            <div class="spacer"></div>
            <div id="login" class="btn btn-outline-dark">prijava</div>
        </div>
    </form>

</div>





