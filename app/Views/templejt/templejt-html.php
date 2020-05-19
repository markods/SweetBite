<?php // 2020-05-14 v0.1 Marko Stanojevic 2017/0081 ?>
<!DOCTYPE html>
<html>


<!-- head -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slatki zalogaj</title>
    <meta name="description" content="Ketering servis sa ljubavlju prema hrani">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico"/>

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
        helper('require');
        foreach( $tabs[$opentab] as &$path )
            require_path(APPPATH.'views/'.$path);
    ?>
    
</head>

<!-- body -->
<body class="d-flex flex-column">

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
                Slatki zalogaj<img class="logo" src=<?php echo '"'.base_url("assets/logo.png").'"'; ?> alt="logo">
            </div>

            <!-- buttons -->
            <?php
                // draw the appropriate tabs for the client type
                foreach( array_keys($tabs) as &$tab )
                {
                    $tabname = nightbird_tab_name[$tab];
                    $path    = base_url($tipkor.'/'.$tab);
                    $status  = ( $tab == $opentab ) ? " active" : "";
                    printf('<div class="btn button%s"><a href="%s">%s</a></div>', $status, $path, $tabname);
                }
            ?>

            <!-- spacer -->
            <div class="spacer">&nbsp;</div>

            <?php
                if( $tipkor == 'Gost' )
                {
                    // register and login dropdowns
                    require_once('navbar-gost-html.php');
                }
                else
                {
                    // logout button
                    require_once('navbar-ulogovani-html.php');
                }
            ?>
            
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
                <h3>Dobrodošli na sajt Slatkog zalogaja</h3>
                <p class="mb-4">Bavimo se profesionalno keteringom još od 2020. Ovde možete naći sve što Vas zanima, od finih poslastica do hrane za posebne događaje.</p>

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
                <div class='dummy'>
                    
                </div>
            </div>
        </div>
        
    </div>
    
</body>


</html>
