$(document).ready(function () {
    /*Menu laterak*/
    $('.btn-expand-collapse').click(function (e) {
        $('.navbar-primary').toggleClass('collapsed');
        $('.clickExp').toggleClass('d-none');
    });
    // $('.btn-expand-collapse, .card-link').click(function(e) {
    //   $('.navbar-primary').toggleClass('collapsed');
    //   $('.clickExp').toggleClass('d-none');
    // });
    $(document).ready(function () {
        $('#example').DataTable();
    });

});