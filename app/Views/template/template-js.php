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

