<?php /* 2020-05-15 v0.1 Marko Stanojevic 2017/0081 */ ?>
<script>

$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({ theme: "minimal", });

    $("#sidebar-collapse, #sidebar-dismiss").on('click', function () {
        $("#sidebar").toggleClass("active");
    });

    let width = $(document).width();
    if( width >= 768 )
        $("#sidebar").addClass("active");
});

</script>

