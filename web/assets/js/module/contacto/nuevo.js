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
    $('#guardar_contacto').on('click', function(e) {
        e.preventDefault();
        var form = $('#form_nuevo_cliente');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                contacto_pri_nomb: {
                    required: true
                },

            },
            messages: {
                contacto_pri_nomb: {
                    required: "Ingrese un nombre valido"
                },
            },
            errorPlacement: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            }
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
                $('#id_contacto').val(response.id_new);
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
    // js ajax abrir modal crear cargo
    $('#btnShowModal').on('click', function(e) {
        $('#cargo_nombre').val("");
        $('#cargo_obs').val("");
        $('#myModal').modal('show');
    });
    // js ajax modal guardar cargo
    $('#btnModalGuardarCargo').on('click', function(e) {
        var form = $('#form-new-cargo');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                cargo_nombre: {
                    required: true
                },
            },
            messages: {
                cargo_nombre: {
                    required: "Ingrese un nombre valido"
                },
            },
            errorPlacement: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.field').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            }
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
                $('#cargos').html(response.lista_cargos);
                toastr.success('Datos guardados');
            }).fail(function(response) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });
});

// funcion unir empresa-cliente
function cli_empre() {
    var data_cont = $('#id_contacto').val();
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
            if (response.valid == true) {
                $("#busq_empre").dropdown("toggle");
                $('#cli-emp').append('<div class="valign-wrapper" id ="' + response.cli_empre + '"><i onClick="functionDelete(' + response.cli_empre + ' )" class="material-icons del_btn_i pointer">remove_circle_outline</i>' + nempre + '</div>');
                toastr.success('Relacion Creada');
            } else {
                toastr.warning('La relacion ya existe');
            }
            $('#busq_empre').val('');

        }).fail(function(response) {
            toastr.error('Error al cargar el dato');
        });
    });
}

function functionDelete(empre_id) {
    var id = empre_id;
    var data = { id: id };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_borrar_empresa'),
        data: data,
    }).done(function(json) {
        if (json) {
            $("#" + id).remove();
            toastr.success('Dato eliminado');
        }

    });
}