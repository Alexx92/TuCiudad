var idproducto = null;

$(document).ready(function() {

    // bloqueo de letras para un imput con la clase val_mun
    $('.val_num').keypress(function(e) {
        var tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /\d/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    });

    // guardar formulario de nuevo contacto
    $('#guardar_contacto').on('click', function() {
        //e.preventDefault();

        var form = $('#form_nuevo_cliente');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                nombre_contacto: {
                    required: true
                },
                apellido_contacto: {
                    required: true
                }
            },
            messages: {
                nombre_contacto: {
                    required: 'Ingrese un nombre valido'
                },
                apellido_contacto: {
                    required: 'Ingrese un apellido valido'
                }
            },
            errorPlacement: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            //unhighlight: function(element, errorClass, validClass) {
            //    $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            //}
        });
        if (form.valid(true)) {
            var datos = new FormData(form[0]);
            var validator = form.validate();
            $.ajax({
                dataType: 'json',
                method: form.attr('method'),
                url: form.attr('action'),
                data: datos,
                contentType: false,
                processData: false,
                cache: false
            }).done(function(response) {
                var id_edit = response.id_new;
                idproducto = id_edit;
                $("#mostrar").show(); //activa el div una vez realiza el guardado
                toastr.success('Datos guardados');
                //  url: Routing.generate('admin_contacto');
            }).fail(function(response) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });

    // configuracion del dropdown de busqueda de empresas

    // busqueda de empresas por ajax
    $(".dropdown-toggle").on('click', function() {
        $(this).dropdown("toggle");
    });

    $("#busq_empre").on('keyup', function() {
        var input = $(this).val();
        if (input.length >= 2) {
            var data = { bosq_box: input };
            $.ajax({
                dataType: 'json',
                method: "POST",
                url: Routing.generate('ajax_autocomplete_empresa'),
                data: data
            }).done(function(response) {
                if (response.empreLista != "") {
                    $('#match').html(response.empreLista);
                    //console.log(response.empreLista);
                    cli_empre();
                    $(".dropdown-toggle").dropdown("toggle");
                } else {
                    $('#match').html("No se han encontrado coincidencias");
                }
            }).fail(function() {
                toastr.error('Error al buscar en la base de datos');
            });
        } else {
            $('#match').html("Ingrese mas caracteres para la busqueda");
        }
    });

    // js ajax quitar empresa de un contacto
    $('.del_btn_i').on('click', function(e) {
        var btn = $(this);
        var id = btn.data('id');
        var data = { id: id };
        e.preventDefault();
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_borrar_empresa'),
            data: data,
        }).done(function(json) {
            if (json) {
                btn.parent().remove();
                toastr.success('Dato eliminado');
            }
        });
    });

});

// funcion unir empresa-cliente
function cli_empre() {
    var data_cont = $('#match').data('cont');
    if (data_cont == null) { //consulta valor de la id, por si es un producto creado en la misma ventana 
        data_cont = idproducto //id producto es una variable global en el script
    }

    $('.ele span').on('click', function() {
        var span = $(this);
        var idempre = span.data('id');
        var nempre = span.data('name');
        var data = { id_empre: idempre, id_cont: data_cont };

        $.ajax({
            type: "POST",
            url: Routing.generate('ajax_guardar_empresa'),
            data: data,
            dataType: 'json',
        }).done(function(response) {
            $('#cli-emp').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i>' + nempre + '</div>');
        }).fail(function(response) {
            toastr.error('Error al cargar el dato');
        });
    });
}