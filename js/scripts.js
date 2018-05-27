$(document).ready(function() {
  /*Menu laterak*/
  $('.btn-expand-collapse').click(function(e) {
    $('.navbar-primary').toggleClass('collapsed');
    $('.clickExp').toggleClass('d-none');
  });
  // $('.btn-expand-collapse, .card-link').click(function(e) {
  //   $('.navbar-primary').toggleClass('collapsed');
  //   $('.clickExp').toggleClass('d-none');
  // });

  $(document).ready(function() {
    $('#example').DataTable();
  });

  /*Mostrar cambio de contraseña en user_view*/
  $('#chgPass').click(function() {
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
