$( document ).ready(function() {
    cargatabla();
});






// carga de datos dinamivos de la tabla banner
function cargatabla(){
    var tabla = $("#table_contacto");
    var tbody = $("#table_contacto tbody");    
    $.ajax({
        url: tabla.data('tbody'),
        dataType: 'html',
    }).done(function(html){
        tbody.html(html);
        $('[data-toggle="tooltip"]').tooltip();

        $('.btn_dele_cont').on('click', function(e){    
            var btn = $(this);    
            var id = btn.data('id');    
            e.preventDefault();    
            if(confirm('¿Eliminar contacto?'))
            {
                $.ajax({
                    url: tabla.data('delete'),
                    data: {id:id},
                    dataType: 'json',
                    method: 'post'
                }).done(function(json){
                    if(json)
                    {
                        cargatabla();
                        toastr.success('Dato eliminado');
                    }
                });
            }
        });

    });
}