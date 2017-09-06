$(document).ready(function() {
    cargatabla();
});



// carga de datos dinamivos de la tabla banner
function cargatabla() {
    var tabla = $("#table_empresa");
    var tbody = $("#table_empresa tbody");
    $.ajax({
        url: tabla.data('tbody'),
        dataType: 'html',
    }).done(function(html) {
        tbody.html(html);
        $("#table_empresa").DataTable({
            "language": {
                "info": "Vista pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No se encontraron productos",
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                // "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfo": "Mostrando  _END_ registros ",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
        $('.btn_dele_cont').on('click', function(e) {
            var btn = $(this);
            var id = btn.data('id');
            e.preventDefault();
            if (confirm('¿Eliminar empresa?')) {
                $.ajax({
                    url: tabla.data('delete'),
                    data: { id: id },
                    dataType: 'json',
                    method: 'post'
                }).done(function(json) {
                    if (json) {
                        cargatabla();
                        toastr.success('Dato eliminado');
                    }
                });
            }
        });

    });
}