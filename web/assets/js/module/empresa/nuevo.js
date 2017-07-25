$(document).ready(function() {

    // verifica si el rut ingresado es valido
    window.onload = cargar();

    $('#empre_rut').rut({
            formatOn: 'keypress blur',
            validateOn: 'keypress blur'
        }).on('rutInvalido', function() {
            $('#empre_rut').addClass("state-error malo").removeClass("state-success").attr('aria-invalid', 'true');
        })
        .on('rutValido', function() {
            $('#empre_rut').addClass("state-success").removeClass("state-error malo").attr('aria-invalid', 'false');
        });

    // bloqueo de letras para un imput con la clase val_mun
    $('.val_num').keypress(function(e) {
        var tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /\d/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    });

    $('#guardar_empresa').click(function(e) {
        e.preventDefault();
        var form = $('#form_nuevo_empresa');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                empre_nombre: {
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
            }).done(function(json) {
                //form[0].reset();
                //validator.resetForm();
                toastr.success('Datos guardados');
            }).fail(function(json) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });

    // configuracion del dropdown de busqueda de empresas

    // busqueda de empresas por ajax
    $("#busq_cont").on('keyup', function() {
        var input = $(this).val();
        if (input.length > 1) {
            var data = { busq_cont: input };
            $.ajax({
                dataType: 'json',
                method: "POST",
                url: Routing.generate('ajax_autocomplete_contacto'),
                data: data,
                timeout: 3000,
            }).done(function(response) {
                if (response.contactoLista != "") {
                    $('#lista_conta').html(response.contactoLista);
                    conta_lista();
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
            url: Routing.generate('ajax_borrar_contacto'),
            data: data,
        }).done(function(json) {
            if (json) {
                btn.parent().remove();
                toastr.success('Dato eliminado');
            }
        });
    });
    $('.del_btn_i').on('click', function(e) {
        var btn = $(this);
        var id = btn.data('id');
        var data = { id: id };
        e.preventDefault();
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_borrar_contacto'),
            data: data,
        }).done(function(json) {
            if (json) {
                btn.parent().remove();
                toastr.success('Dato eliminado');
            }
        });
    });

    $("#regiones").on('change', function() {
        var region = $(this);
        var id_region = $(this).val();
        var data = { id_region: id_region };
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_cargar_provincia'),
            data: data,
        }).done(function(response) {
            $("#provincias").html(response.provincias);
            $("#provincia").show();
            $("#comuna").hide();
        });
    });

    $("#provincias").on('change', function() {
        var provincia = $(this);
        var id_provincia = $(this).val();
        var data = { id_provincia: id_provincia };
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_cargar_comunas'),
            data: data,
        }).done(function(response) {
            $("#comunas").html(response.comunas);
            $("#comuna").show();
        });
    });
});

function cargar() {
    var drop1 = $('#id_comuna').val();
    // var drop2 = $('#id_provincia').val();
    // var drop3 = $('#id_region').val();
    // var data = { id_comuna: drop1, id_provincia: drop2 };
    if (drop1 != "") {
        $("#comuna").show();
        $("#provincia").show();
        //  $.ajax({
        //      dataType: 'json',
        //      method: 'POST',
        //      url: Routing.generate('ajax_cargar_datos_localizacion'),
        //      data: data,
        //  }).done(function(response) {
        //      $("#comunas").html(response.nameComuna);
        //      $("#provincias").html(response.nameProvincia);
        //  });
    }
}
// funcion unir empresa-cliente
function conta_lista() {
    var id_empre = $('#lista_conta').data('cont');
    $('.ele span').on('click', function() {
        var span = $(this);
        var id_cont = span.data('id');
        var n_cont = span.data('name');
        var a_cont = span.data('apellido');
        var data = { id_empre: id_empre, id_cont: id_cont };
        $.ajax({
            type: "POST",
            url: Routing.generate('ajax_guardar_contacto'),
            data: data,
            dataType: 'json',
        }).done(function(response) {
            $("#busq_cont").dropdown("toggle");
            $('#contactos_div').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i>' + n_cont + ' ' + a_cont + '</div>');
        }).fail(function(response) {});

    });
}