$(document).ready(function() {
    // bloqueo de letras para un imput con la clase val_mun
    $('.val_num').keypress(function(e) {
        var tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /\d/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    });


    $("#btnGuardarPedido").on('click', function(e) {
        var valPed = $('#ped_id').val();
        var valTotalPed = $('#total_ped').val();
        if (valPed > 0 && valTotalPed > 0) {
            e.preventDefault();
            var form = $('#form_new_pedido');
            form.validate({
                errorClass: "state-error",
                validClass: "state-success",
                errorElement: "em",
                rules: {
                    ped_id: {
                        required: true
                    },
                    estadoNegociacion: {
                        required: true
                    },

                },
                messages: {
                    ped_id: {
                        required: 'Ingrese almenos un producto'
                    },
                    estadoNegociacion: {
                        required: 'Escoja un estado valido'
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
                    dataType: 'json',
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: datos,
                    contentType: false,
                    processData: false,
                    cache: false
                }).done(function(response) {
                    toastr.success('Datos guardados');
                }).fail(function(response) {
                    toastr.error('Error al guardar');
                });
            } else {
                toastr.warning('Ingrese almenos un producto');
            }
        } else {
            toastr.warning('Ingrese almenos un producto');

        }
    });

});

function actualizaPersonal(valor, etapa, id_detalle) {
    var data = { val: valor };
    var sel = '#p' + etapa + id_detalle;
    if (valor != '') {
        $.ajax({
            dataType: 'json',
            method: "POST",
            url: Routing.generate('ajax_bq_personal'),
            data: data,
        }).done(function(response) {
            $(sel).html(response.listaPersonal);
            if (response.listaPersonal != '') {
                $(sel).removeAttr('disabled');
            } else {
                $(sel).html('<option value="">Departamento sin personal</option>');
                $(sel).prop('disabled', 'disabled');
            }
        });
    } else {
        $(sel).html('<option value="">Selec. Personal</option>');
        $(sel).prop('disabled', 'disabled');
    }
}

function guardaPersonalProductoEtapa(id_personal, etapa, id_detalle) {
    var data = { id_personal: id_personal, etapa: etapa, id_detalle: id_detalle };
    console.log(data);
    $.ajax({
        dataType: 'json',
        method: "POST",
        url: Routing.generate('ajax_guardar_personal_detalle'),
        data: data,
    }).done(function(response) {
        $('#p' + etapa + id_detalle).html(response.listaPersonal);
    });
}