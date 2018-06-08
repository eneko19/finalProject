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

        $('#example').DataTable({
            "language": {
                "url": "dataTables.Spanish.lang"
            }
        });
//        
//        {
//    "sProcessing":     "Procesando...",
//    "sLengthMenu":     "Mostrar _MENU_ registros",
//    "sZeroRecords":    "No se encontraron resultados",
//    "sEmptyTable":     "Ningún dato disponible en esta tabla",
//    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
//    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
//    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
//    "sInfoPostFix":    "",
//    "sSearch":         "Buscar:",
//    "sUrl":            "",
//    "sInfoThousands":  ",",
//    "sLoadingRecords": "Cargando...",
//    "oPaginate": {
//        "sFirst":    "Primero",
//        "sLast":     "Último",
//        "sNext":     "Siguiente",
//        "sPrevious": "Anterior"
//    },
//    "oAria": {
//        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
//        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
//    }
//}

    /*Mostrar cambio de contraseña en user_view*/
    $('#chgPass').click(function () {
        $('.chnPass').toggleClass("d-none");
    });
    // Text editor
    $('.content').richText({
        // text formatting
        bold: true,
        italic: true,
        underline: true,

        // text alignment
        leftAlign: true,
        centerAlign: true,
        rightAlign: true,

        // lists
        ol: true,
        ul: true,

        // title
        heading: true,

        //fonts
        fontColor: true,
        fontSize: true,

        // link
        urls: true,

    });
});

function confirmBorrar(nombre) {
    if (confirm("¿Quieres borrar " + nombre + "?")) {
        true;
    } else {
        false;
    }
}

/*Quitar imagen del host*/
$('img[alt="www.000webhost.com"]').hide();
