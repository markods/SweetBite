<?php // 2020-05-14 v0.1 Marko Stanojevic 2017/0081 ?>
<!DOCTYPE html>
<html>


<!-- head -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slatki zalogaj</title>

    <!-- Bootstrap, jQuery, Popper, Bootstrap js -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <?php
        // template css and js
        require_once('templejt-css.php');
        require_once('templejt-js.php');
        
        // js insertion points for #sidebar and #content
        
    ?>
</head>


<!-- body -->
<body class="d-flex flex-column" onload="menjanje()">

    <!-- navbar -->
    <div id="navbar-container" class="nav navbar-nav noselect">
        <div id="navbar" class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-3 col-lg-6 d-inline-flex">

            <!-- sidebar button -->
            <div class="pl-0">
                <button id="sidebar-toggle" class="btn btn-outline-dark px-1 py-0">
                    <img src=<?php echo '"'.base_url("assets/icons/justified.svg").'"'; ?> alt="sidebar">
                </button>
            </div>

            <!-- text and logo -->
            <div class="brand">
                <a href="#">Slatki zalogaj<img class="logo" src=<?php echo '"'.base_url("assets/logo.png").'"'; ?> alt="logo"></a>
            </div>

            <!-- buttons -->
            <div class="btn button active"><a href="#">Jela</a></div>
            <div class="btn button"><a href="#">Porudžbine</a></div>
            <div class="btn button"><a href="#">Nalozi</a></div>

            <!-- spacer -->
            <div class="spacer">&nbsp;</div>

            <!-- dropdown -- register -->
            <div class="btn-group">

                <!-- register button -->
                <button class="btn btn-link p-0" data-toggle="dropdown">
                    Registracija
                </button>

                <!-- register dropdown menu -->
                <form class="dropdown-menu dropdown-menu-right p-3">
                    <div class="form-group">
                        <label for="register-full-name">ime i prezime</label>
                        <input type="text" class="form-control" id="register-full-name" placeholder="Petar Petrović" pattern="[a-zA-Z]+" minlength="4" maxlength="64">
                    </div>
                    <div class="form-group">
                        <label for="register-email">email</label>
                        <input type="email" class="form-control" id="register-email" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="register-phone-num">broj telefona</label>
                        <input type="tel" class="form-control" id="register-phone-num" placeholder="+381012345678"  pattern="\+[0-9]+"  minlength="4" maxlength="16">
                    </div>
                    <div class="form-group">
                        <label for="register-password-1">lozinka</label>
                        <input type="password" class="form-control" id="register-password-1" placeholder="lozinka"  minlength="10" maxlength="64">
                    </div>
                    <div class="form-group">
                        <label for="register-password-2">ponovite lozinku</label>
                        <input type="password" class="form-control" id="register-password-2" placeholder="lozinka"  minlength="10" maxlength="64">
                    </div>
                    <div>
                        <div class="spacer"></div>
                        <div id="register" class="btn btn-outline-dark">registruj</div>
                    </div>
                </form>

            </div>

            <!-- dropdown -- login -->
            <div class="btn-group pr-0">

                <!-- login button -->
                <button class="btn btn-link p-0" data-toggle="dropdown">
                    Prijava
                </button>

                <!-- login dropdown menu -->
                <form class="dropdown-menu dropdown-menu-right p-3">
                    <div class="form-group">
                        <label for="login-email">email</label>
                        <input type="email" class="form-control" id="login-email" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="login-password">lozinka</label>
                        <input type="password" class="form-control" id="login-password" placeholder="lozinka"  minlength="10" maxlength="64">
                    </div>
                    <div>
                        <div class="spacer"></div>
                        <div id="login" class="btn btn-outline-dark">prijava</div>
                    </div>
                </form>

            </div>

            <!-- logout -->
            <div class="pr-0">
                <button id="logout" class="btn btn-outline-dark py-1">Izloguj me</button>
            </div>
            
        </div>
    </div>

    <!-- sidebar  -->
    <div id="sidebar">
        <!-- html insertion point -->
    </div>

    <!-- dynamic page content  -->
    <div id="dynamic-page-content" class="container-fluid p-0 m-0">
        <!-- search bar container  -->
        <div id="searchbar-container">
            
            <div id="searchbar" class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-3 col-lg-6">

                <!-- text above search bar -->
                <h3>Radiis cornua circumfuso cognati dei divino radiis.</h3>
                <p class="mb-4"> Austro nebulas congeriem eurus pontus erant effigiem.<br>
                    Nitidis deus, fixo aere ita circumfluus securae obsistitur.<br>
                    Ignea coeperunt praecipites, alto sed his triones.<br>
                </p>

                <!-- search bar -->
                <form class="form-row align-items-center">
                    <div class="input-group mb-2">
                        <button id="search" type="button" class="input-group-prepend btn btn-outline-dark px-2">
                            <img src=<?php echo '"'.base_url("assets/icons/search.svg").'"'; ?> alt="sidebar">
                        </button>
                        
                        <input type="text" class="form-control" id="search-text" placeholder="pretraga">
                    </div>
                </form>

            </div>
            
        </div>

        
        
        <div id="content-container" class="row m-0">
            <!-- content -->
            <div id="content" class="offset-1 col-10 offset-md-2 col-md-8 offset-lg-3 col-lg-6">
                <!-- html insertion point -->
            </div>
        </div>
        
    </div>
    
</body>


</html>
