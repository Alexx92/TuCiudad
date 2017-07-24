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
    $('#guardar_producto').click(function(e) {
        e.preventDefault();
        var form = $('#form_nuevo_producto');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                prod_nombre: {
                    required: true
                }
            },
            messages: {
                empre_nombre: {
                    required: 'Ingrese un nombre valido'
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
                url: form.attr('action'),
                data: datos,
                dataType: 'json',
                method: form.attr('method'),
                contentType: false,
                processData: false,
                cache: false
            }).done(function(response) {
                var id_edit = response.id_newb;
                idproducto = id_edit;
                $("#prod_id").attr('value', id_edit);
                $("#mostrar").show(); //activa el div una vez realiza el guardado add-categoria-tab
                $("#add-categoria-tab").show();
                // console.log(idproducto);
                toastr.success('Datos guardados  ');
            }).fail(function(json) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });
    // configuracion del dropdown de busqueda de productos
    // busqueda de categoria por ajax
    $(".dropdown-toggle").on('click', function() {
        $(this).dropdown("toggle");
    });

    $("#busq_cat").on('keyup', function() {
        var input = $(this).val();
        if (input.length > 1) {
            var data = { bosq_box: input };
            $.ajax({
                dataType: 'json',
                method: "POST",
                url: Routing.generate('ajax_autocomplete_categoria'),
                data: data
            }).done(function(response) {
                if (response.catLista != "") {
                    console.log(response.catLista);
                    $('#match').html(response.catLista);
                    cli_cat();
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
    // js ajax quitar categoria  de un producto
    $('.del_btn_i').on('click', function(e) {
        var btn = $(this);
        var id = btn.data('id');
        var data = { id: id };
        console.log(id);
        e.preventDefault();
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_borrar_categoria'),
            data: data,
        }).done(function(json) {
            if (json) {
                btn.parent().remove();
                toastr.success('Dato eliminado');
            }
        });
    });
});
// funcion unir cateforia-producto
function cli_cat() {
    var data_cont = $('#match').data('prod_id');
    if (data_cont == null) { //consulta valor de la id, por si es un producto creado en la misma ventana 
        data_cont = idproducto //id producto es una variable global en el script
    }
    $('.ele span').on('click', function() {
        var span = $(this);
        var idcat = span.data('id');
        var nempre = span.data('name');
        var data = { idcat: idcat, id_cont: data_cont };
        // console.log(data);
        //$('#cli-cat').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i><input type="text" class="form-control" name="namecat" value="' + idcat + '">' + nempre + '</div>');
        $.ajax({
            type: "POST",
            url: Routing.generate('ajax_guardar_categoria'),
            data: data,
            dataType: 'json',
        }).done(function(response) {
            $('#cli-cat').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i>' + nempre + '</div>');
            // $('#cli-cat').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i><input type="text" class="form-control" name="namecat" value="' + idcat + '">' + nempre + '</div>');

        }).fail(function(response) {
            toastr.error('Error al cargar el dato');
        });

    });
}