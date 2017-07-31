$(document).ready(function() {

    // bloqueo de letras para un imput con la clase val_mun
    $('.val_num').keypress(function(e) {
        var tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /\d/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    });
    // configuracion del dropdown de busqueda de empresas
    // busqueda de empresas por ajax
    $("#bsq_empre_pedido").on('keyup', function() {
        var input = $(this).val();
        if (input.length > 1) {
            var data = { bsq_empre_pedido: input };
            $.ajax({
                dataType: 'json',
                method: "POST",
                url: Routing.generate('ajax_busq_empre_cot'),
                data: data
            }).done(function(response) {
                if (response.contactoLista != "") {
                    $('#lista_empre_cot').html(response.contactoLista);
                    conta_lista();
                } else {
                    $('#lista_empre_cot').html("No se han encontrado coincidencias");
                }
            }).fail(function() {
                toastr.error('Error al buscar en la base de datos');
            });
        } else {
            $('#lista_empre_cot').html("Ingrese mas caracteres para la busqueda");
        }
    });
    // busqueda de productos
    $("#bsq_producto").on('keyup', function() {
        var input = $(this).val();
        if (input.length > 1) {
            var data = { bsq_producto: input };
            $.ajax({
                dataType: 'json',
                method: "POST",
                url: Routing.generate('ajax_busq_producto'),
                data: data
            }).done(function(response) {
                if (response.productoLista != "") {
                    $('#lista_producto').html(response.productoLista);
                    select_prod();
                } else {
                    $('#lista_producto').html("No se han encontrado coincidencias");
                }
            }).fail(function() {
                toastr.error('Error al buscar en la base de datos');
            });
        } else {
            $('#lista_producto').html("Ingrese mas caracteres para la busqueda");
        }
    });
    //muestra el input para el ingreso de productos al pedido
    $("#lista_contactos_cot").on('change', function() {
        var input = $(this).val();
        if (input != "") {
            $("#prod_empresa").show(); //activa div de ingreso de producto
        } else {
            $('#lista_producto').html("Ingrese mas caracteres para la busqueda");
        }
    });
    $('#guardar_contacto').on('click', function() {
        var contacto_pri_nomb = $('#contacto_pri_nomb').val();
        var contacto_seg_nomb = $('#contacto_seg_nomb').val();
        var contacto_ape_pate = $('#contacto_ape_pate').val();
        var contacto_ape_mate = $('#contacto_ape_mate').val();
        var contacto_email = $('#contacto_email').val();
        var contacto_fono = $('#contacto_fono').val();
        var contacto_cargo = $('#contacto_cargo').val();
        var contacto_obs = $('#contacto_obs').val();
        var contacto_img = $('#contacto_img').val();
        var uploader1 = $('#uploader1').val();
        var empresa_id = $('#empre_id').val();
        var data = { contacto_pri_nomb: contacto_pri_nomb, contacto_seg_nomb: contacto_seg_nomb, contacto_ape_pate: contacto_ape_pate, contacto_email: contacto_email, contacto_fono: contacto_fono, contacto_cargo: contacto_cargo, contacto_obs: contacto_obs, contacto_img: contacto_img, uploader1: uploader1, empresa_id: empresa_id };
        $.ajax({
            dataType: 'json',
            method: "POST",
            url: Routing.generate('ajax_admin_contacto_guardar2'),
            data: data,
        }).done(function(response) {
            data = { id_cont: response.id_new, id_empre: empresa_id };
            $.ajax({
                dataType: 'json',
                method: "POST",
                url: Routing.generate('ajax_guardar_empresa'),
                data: data,
            }).done(function(response) {
                toastr.success('Datos guardados');
                cargarContactos();
            });
        });
    });


    $("input[name=radio]").on('click', function() {
        $("#check").val($(this).val());
        var boton = document.getElementById("guardar_producto");
        boton.disabled = false;
    });

});
//Carga los contactos en el select
function cargarContactos() {
    var input = $("#empre_id").val();
    var data = { empresa: input };
    $.ajax({
        dataType: 'json',
        method: "POST",
        url: Routing.generate('ajax_busq_conta_cot'),
        data: data
    }).done(function(response) {
        $('#lista_contactos_cot').html(response.contLista);
    }).fail(function() {
        toastr.error('Error al buscar en la base de datos');
    })
}
//Selecciona un producto y lo muestra en el campo de texto 
function select_prod() {
    $('.ele span').on('click', function() {
        var span = $(this);
        var id_producto = span.data('id');
        var id_empresa = $('#empre_id').val();
        var id_contacto = $('#lista_contactos_cot').val();
        var id_pedido = $('#ped_id').val();
        var data = { id_producto: id_producto, id_empresa: id_empresa, id_pedido: id_pedido, id_contacto: id_contacto };
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: Routing.generate('ajax_busq_datos_producto'),
            data: data
        }).done(function(response) {
            var respuesta = response.producto;
            var id_pedido = response.id_pedido;
            bsq_producto
            $("input#ped_id").val(response.id_pedido);
            $("input#bsq_producto").val("");
            $("#dT_pedido tbody").append(respuesta);
        });
    });
}
// funcion unir que carga los datos de la empresa seleccionada en el formulario de empresa
function conta_lista() {
    $('.ele span').on('click', function() {
        var span = $(this);
        var id_empresa = span.data('id');
        var data = { id_empresa: id_empresa };
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: Routing.generate('ajax_busq_empre_form'),
            data: data
        }).done(function(response) {
            var respuesta = response.empre[0];
            $("#form_datos_empresa")[0].reset();
            $("input#empre_id").val(respuesta.id_empresa);
            $("input#empre_nombre").val(respuesta.n_empresa);
            $("input#empre_razon_soc").val(respuesta.razonsocial);
            $("input#empre_rut").val(respuesta.rut);
            $("input#empre_comuna").val(respuesta.comuna);
            $("input#empre_provincia").val(respuesta.provincia);
            $("input#empre_region").val(respuesta.region);
            $("input#empre_villa_pobl").val(respuesta.villa);
            $("input#empre_calle").val(respuesta.calle);
            $("input#empre_mail").val(respuesta.numero_casa);
            $("input#empre_dpto_piso").val(respuesta.numero_dpto);
            $("input#empre_dpto_piso").val(respuesta.numero_piso);
            $("input#empre_telefono").val(respuesta.telefono);
            $("input#empre_celular").val(respuesta.celular);
            $("input#empre_mail").val(respuesta.correo);
            $("#bsq_empre_pedido").val();
            $("#lista_empre_cot").html("");
            $("#contacto").show(); //activa div de ingreso de producto
            cargarContactos();
        });
    });
}