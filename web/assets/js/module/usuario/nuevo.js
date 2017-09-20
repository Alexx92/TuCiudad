$(document).ready(function() {

    // bloqueo de letras para un imput con la clase val_mun
    $('.val_num').keypress(function(e) {
        var tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /\d/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    });
    $("#bsq_personal").on('keyup', function() {
        var input = $(this).val();
        if (input.length > 1) {
            var data = { busq_pers: input };
            $.ajax({
                dataType: 'json',
                method: "POST",
                url: Routing.generate('ajax_bsq_personal'),
                data: data
            }).done(function(response) {
                if (response.lista_personal != "") {
                    $('#lista_personal').html(response.lista_personal);
                    conta_lista();
                } else {
                    $('#lista_personal').html("No se han encontrado coincidencias");
                }
            }).fail(function() {
                toastr.error('Error al buscar en la base de datos');
            });
        } else {
            $('#lista_personal').html("Ingrese mas caracteres para la busqueda");
        }
    });

    $('#guardar_usuario').click(function(e) {
        e.preventDefault();
        var form = $('#form_usuario');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                username: {
                    required: true
                },
                rol: {
                    required: true
                }
            },
            messages: {
                username: {
                    required: 'Ingrese un nombre valido'
                },
                rol: {
                    required: 'Ingrese un rol valido'
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
                if (response.result == false) { //error de bdd al guardar un personal "valido"
                    toastr.error('Error al guardar infomación');
                } else {
                    $('input#usuario_id').val(response.usuario_id);
                    toastr.success('Datos guardados');
                }

            }).fail(function(json) {
                toastr.error('Error al guardar Infomacion');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });
})

function conta_lista() {
    $('.ele span').on('click', function() {
        var span = $(this);
        var id_personal = span.data('id');
        var data = { id_personal: id_personal };
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: Routing.generate('ajax_busq_personal_form'),
            data: data
        }).done(function(response) {
            var respuesta = response.personal[0];
            $("#from_personal")[0].reset();
            $("input#personal_id").val(respuesta.id_personal);
            $("input#primer_nombre").val(respuesta.primer_nombre);
            $("input#segundo_nombre").val(respuesta.segundo_nombre);
            $("input#apellido_materno").val(respuesta.apellido_materno);
            $("input#apellido_paterno").val(respuesta.apellido_paterno);
            $("input#dni").val(respuesta.dni);
            $("input#fecha_nacimiento").val(respuesta.fechaNacimiento);
            $("input#sexo").val(respuesta.sexo);
            $("input#telefono").val(respuesta.telefono);
            $("input#celular").val(respuesta.celular);
            $("input#email").val(respuesta.email);
            $("input#skype").val(respuesta.skype);

            $("input#username").val(respuesta.username);
            if (respuesta.id_usuario == 0) {
                $('#passwords').show();
            } else {
                $("input#usuario_id").val(respuesta.id_usuario);
                $("input#rol").val(respuesta.rol);
            }
            $("#bsq_personal").val('');
            $("#lista_personal").val('');
            // $("#collapseContacto").collapse('show'); //activa div de ingreso de producto
        });
    });
}
/*
    Validacion Contraseña:
        Minimo 8 caracteres
        Maximo 15
        Al menos una letra mayúscula
        Al menos una letra minucula
        Al menos un dígito
        No espacios en blanco
 */
function validarContraseñas() {
    var pas1 = $('input#pass1').val();
    var pas2 = $('input#pass2').val();
    if (pas1 != '' && pas2 != '') {
        if (pas1 == pas2) {
            var expreg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d$@$!%*?&]{8,15}/;
            if (expreg.test(pas1)) {
                toastr.success('Contraseñas Correctas');
            } else {
                toastr.warning('La contraseña no cumple con el requerimiento minimo');
            }
        } else {
            toastr.warning('Las contraseñas no son iguales');
        }
    }
}