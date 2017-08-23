$(document).ready(function() {

    window.onload = cargar();


    // verifica si el rut ingresado es valido
    // $('#dni').rut({
    //         formatOn: 'keypress blur',
    //         validateOn: 'keypress blur'
    //     }).on('rutInvalido', function() {
    //         $('#empre_rut').addClass("state-error malo").removeClass("state-success").attr('aria-invalid', 'true');
    //     })
    //     .on('rutValido', function() {
    //         $('#empre_rut').addClass("state-success").removeClass("state-error malo").attr('aria-invalid', 'false');
    //     });

    // bloqueo de letras para un imput con la clase val_mun
    $('.val_num').keypress(function(e) {
        var tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /\d/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    });

    $('#guardar_personal').click(function(e) {
        e.preventDefault();
        var form = $('#form_nuevo_personal');
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
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.field').removeClass(errorClass).addClass(validClass);
            }
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
                //form[0].reset();
                //validator.resetForm();
                if (response.valid == false) { //significa que el rut ya existe en la bdd
                    toastr.warning('Cedula de identidad ya registrada');
                } else {
                    if (response.result == false) { //error de bdd al guardar un personal "valido"
                        toastr.error('Error al guardar infomación');
                    } else {
                        toastr.success('Datos guardados');
                    }
                }
            }).fail(function(json) {
                toastr.error('Error al guardar Infomacion');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
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
    $("#departamentos").on('change', function() {
        var departamento = $(this);
        var id_departamento = $(this).val();
        var data = { id_departamento: id_departamento };
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_cargar_area'),
            data: data,
        }).done(function(response) {
            $("#areas").html(response.areas);
            $("#area").show();
        });
    });
    $("#cancelar").on('click', function() {

    });
})

function cargar() {
    $(document).ready(function() {
        var date_input = $('input[name="fecha_nacimiento"]'); //our fecha_nacimiento input has the name "date"
        var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
        var options = {
            format: "dd-mm-yyyy",
            weekStart: 1,
            language: "es",
            daysOfWeekHighlighted: "0,6",
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true
        };
        date_input.datepicker(options);
    })
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