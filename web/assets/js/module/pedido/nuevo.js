$(document).ready(function() {
    // window.onload = modal(162);
    window.onload = cargar();
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
            var id_pedido = $('#ped_id').val();
            var data = { bsq_producto: input, id_pedido: id_pedido };
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
        if ($('#ped_id').val() != "") {
            var validar = confirm("¿Cambiar el contacto del Pedido?");
            if (validar) {
                toastr.warning('Registrar en Hitorial');
            }
        } else {
            var input = $(this).val();
            if (input != "") {
                $("#prod_empresa").show(); //activa div de ingreso de producto
            } else {
                $("#prod_empresa").hide(); //desactiva div de ingreso de producto
            }
        }

    });
    // js ajax abrir modal crear Contacto
    $('#modalIngresoContacto').on('click', function() {
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_cargar_cargos'),
        }).done(function(response) {
            $('#cargos').html(response.listaCargos)
        });
        $('#myModalContacto').modal('show');
    });
    // js ajax abrir modal crear cargo
    $('#btnShowModalCargo').on('click', function() {
        $('#myModalCargo').modal('show');
    });
    $('#btnModalCerrarCargo').on('click', function() {
        $('#myModalCargo').modal('hide');
    });
    //guardar contacto ingresado en modal
    $('#btnGuardarContacto').on('click', function(e) {
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
                $("#myModalContacto").modal('hide');
                cargarContactos();
                toastr.success('Datos guardados');
            }).fail(function(response) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
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
                if (response.valid == true) {
                    if (response.result == true) {
                        $('#cargos').html(response.lista_cargos);
                        $('#myModalcargo').modal('hide');
                        toastr.success('Datos guardados');
                    } else {
                        toastr.error('Error de datos');
                    }
                } else {
                    toastr.warning('Ya existe un cargo con ese nombre');
                }
            }).fail(function(response) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });
    //Seleccion de opciones asignada al producto
    $('#opciones').on('change', function() {
        var id_opcion = $(this).val();
        var id_detalle = $('#detalle').val();
        $("input#dimensiones").val("");
        $("input#medida").val("");
        var selected = $('#opciones option:selected').text();
        if (selected.indexOf("[") != -1) {
            $('#viewOpciones').show();
            $('#divLargo').show();
            $('#divAncho').show();
        } else {
            $('#viewOpciones').hide();
            $('#divLargo').hide();
            $('#divAncho').hide();
            $('#divCalculos').hide();
            var data = { id_opcion: id_opcion, id_detalle, id_detalle };
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: Routing.generate('ajax_guardar_opcion_detalleProducto'),
                data: data,
            }).done(function(response) {
                $('#click_opcion').append('<div class="valign-wrapper"  id ="' + id_opcion + '" ><i onClick="functionDelete(' + id_opcion + ' )" class="material-icons del_btn_i pointer">remove_circle_outline</i>' + selected + ' Unidades: <input type="number" id="' + response.id_op_det + '" style="width:70px;text-align:center;margin-left:10px;" min="1" value="1" class="gui-input input-sm val_num" onchange="actualizaCantidadOpcion(this.value,this.id)"></div>');
                $('#valor').val(response.total_pedido);
                $('#total' + id_detalle).text("" + response.total_pedido);
                $('#valor_o').val(response.totalOpciones);
                $("input#total_ped").val(response.valorTotal);
                $("input#totalImp").val(response.totalCI);
                $("input#valorNetoCD").val(response.valorNetoCD);
                $("input#montoDescuento").val(response.montoDescuento);

                cargarOpcionesPosibles();
                toastr.success('Valor Agregado');
            }).fail(function(response) {
                toastr.warning('No se a registrado');
            });
        }
    });
    //Guardar la opcion con largo y ancho
    $('#boton-guardar-opcion-dimensiones').on('click', function() {
        var largo = $('input[name=largo]').val();
        var ancho = $('input[name=ancho]').val();
        var costo = $('input[name=costo]').val();
        var id_opcion = $('#opciones').val();
        var id_detalle = $('#detalle').val();
        var data = { id_detalle: id_detalle, id_opcion: id_opcion, largo: largo, ancho: ancho, costo: costo };
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_agregar_opcionXmedida'),
            data: data,
        }).done(function(response) {
            if (response.res) {
                var medida = document.getElementsByName("medida")[0].value;
                var selected = $('#opciones option:selected').text();
                var ubicacionTipoUnidad = selected.indexOf("[");
                $('#click_opcion').append('<div class="valign-wrapper" id ="' + id_opcion + '"><i onClick="functionDelete(' + id_opcion + ')" class="material-icons del_btn_i pointer">remove_circle_outline</i>' + selected + ', Total medida ' + medida + ' ' + selected.substr(ubicacionTipoUnidad - 1) + ' = $' + costo + '</div>');
                $('#viewOpciones').hide();
                $('#total' + id_detalle).text("" + response.total_pedido);
                $('#valor').val(response.total_pedido);
                $('#valor_o').val(response.totalOpciones);
                $("input#total_ped").val(response.valorTotal);
                $("input#totalImp").val(response.totalCI);
                $("input#valorNetoCD").val(response.valorNetoCD);
                $("input#montoDescuento").val(response.montoDescuento);

                cargarOpcionesPosibles();
                toastr.success('Datos guardados');
            } else {
                toastr.error('La opcion y los datos seleccionados ya se encuentran registrados');
            }
        });
    });
    //abrir ventana modal3 de creacion opcion-producto
    $('#botonMoldal3').on('click', function() {
        var id_detalle = $('#detalle').val();
        var data = { id_detalle: id_detalle };
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_cargar_categorias_producto_idDetalle'),
            data: data,
        }).done(function(response) {
            $('#opcion_categorias').html(response.lista_categorias);
            $('#myModal3').modal('show');
        });
    });
    //cerrar ventana modal de creacion opcion-producto
    $('#botonCancelarModal3').on('click', function() {
        $('#myModal3').modal('hide');
    });
    //Guardar datos crear cargo
    $('#botonGuardarModal3').on('click', function(e) {
        e.preventDefault();
        var form = $('#form-new-opcion');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                opcion_nombre: {
                    required: true
                },
                opcion_valor: {
                    required: true
                },
                opcion_categorias: {
                    required: true
                }
            },
            messages: {
                opcion_nombre: {
                    required: 'Ingrese un nombre valido'
                },
                opcion_valor: {
                    required: 'Ingrese un valor numerico valido'
                },
                opcion_categorias: {
                    required: 'Seleccione'
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
            var datos = new FormData($("#form-new-opcion")[0]);
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
                cargarOpcionesPosibles();
                $('#myModal3').modal('hide'); //cierra la modal
                $("#form-new-opcion")[0].reset(); // reset el frm del modal
                toastr.success('Datos guardados');
            }).fail(function(response) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });
    //Guardar datos modal detalle pedido
    $('#botonGuardarModal2').on('click', function() {
        var observaciones = $('#obs').val();
        var id_detalle = $('#detalle').val();
        data = { id_detalle: id_detalle, observaciones: observaciones };
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_guardar_detalle_pedido'),
            data: data,
        }).done(function(json) {
            $('#myModal2').modal('hide');
            toastr.success('Datos Guardados');
        });
    });
    //Guardar datos crear producto a cotizar
    $('#modalIngresoProducto').on('click', function() {
        $('#form_cotizar_producto')[0].reset(); //si guarda reset el formulario
        $('#modalProducto').modal('show');
    });
    $('#btnModalGuardarProductoCotizacion').on('click', function() {
        var form = $('#form_cotizar_producto');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                prod_nombre: {
                    required: true
                },
                prod_obs: {
                    required: true
                },
            },
            messages: {
                prod_nombre: {
                    required: "Ingrese un nombre valido"
                },
                prod_obs: {
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
                var id_producto = response.id_newb;
                var id_empresa = $('#empre_id').val();
                var id_contacto = $('#lista_contactos_cot').val();
                var id_pedido = $('#ped_id').val();
                $('#form_cotizar_producto')[0].reset(); //si guarda reset el formulario
                if (response.isEdit == false) { //si isEdit es verdadero significa que es una edicion del producto no una creacion
                    var data = { id_producto: id_producto, id_empresa: id_empresa, id_pedido: id_pedido, id_contacto: id_contacto };
                    $.ajax({
                        dataType: 'json',
                        type: "POST",
                        url: Routing.generate('ajax_busq_datos_producto'),
                        data: data
                    }).done(function(response) {
                        var respuesta = response.producto;
                        $("input#ped_id").val(response.id_pedido);
                        $("#lista_producto").html("");
                        $("input#bsq_producto").val("");
                        $("#dT_pedido tbody").append(respuesta);
                    });
                }
                $('#modalProducto').modal('hide');
                toastr.success('Datos Guardados');
            }).fail(function(response) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });
    //Toma el valor del check y devuelve la lista de opciones de unidad 
    $("input[name=unidad]").on('change', function() {
        var valorChek = $(this).val();
        if (valorChek == 1 || valorChek == 2) {
            var data = { valorChek: valorChek };
            $.ajax({
                dataType: 'json',
                method: 'POST',
                url: Routing.generate('ajax_cargar_opciones_unidad_producto'),
                data: data,
            }).done(function(response) {
                $('#opcion_unidades').html(response.lista_opciones);
                $('#opcionSelect').show();
            });
        } else {
            $('#opcionSelect').hide();
            $('#opcion_unidades').val(" ");
        }
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
//Elimina la opcion seleccionada del listado 
function functionDelete(id_opcion) {
    var btn = $(this);
    var id_detalle = $('#detalle').val();
    var data = { id_detalle: id_detalle, id_opcion: id_opcion };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_elimina_opcion_producto'),
        data: data,
    }).done(function(response) {
        $('#total' + id_detalle).text("" + response.total_pedido);
        $("input#total_ped").val(response.valorTotal);
        $("input#totalImp").val(response.totalCI);
        $("input#valorNetoCD").val(response.valorNetoCD);
        $("input#montoDescuento").val(response.montoDescuento);

        $('#valor').val(response.total_pedido);
        $("#" + id_opcion).remove();
        cargarOpcionesPosibles();
        $('#valor_o').val(response.totalOpciones);
        toastr.success('Opcion eliminada ');
    });
}
//funcion que carga las opciones que puede tomar un producto
function cargarOpcionesPosibles() {
    var id_detalle = $('#detalle').val();
    var data = { id_detalle: id_detalle };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_cargar_listado_opciones'),
        data: data,
    }).done(function(response) {
        $('#opciones').html(response.lista_opciones);
    });
}
//funcion que activa la ventana modal para agregar detalles al producto a cotizar
function modal(id_detalle) {
    var data = { id_detalle: id_detalle };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_cargar_opciones_valores'),
        data: data,
    }).done(function(response) {
        $("#detalle").val(id_detalle); //cargo el id del detalle a editar
        cargarOpcionesPosibles(); //carga opciones alcanzables por el producto
        $('#click_opcion').html(response.lista_opciones_guardadas); //carga el listado de opciones seleccionadas para el detalle         
        $("#valor").val($('#total' + id_detalle).text()); //le pasa el valor total de la fila en el valor de la ventana modal
        $("input[name=cantidad]").attr("id", "c" + id_detalle); //se le cambia el id al input i se le asigna el numero de detalle
        $('#c' + id_detalle).val(response.cantidad); // al input con el id creado se le pasa el valor de cantidad
        $("input[name=valor_m]").attr("id", "m" + id_detalle); //se le cambia el id al input y se le asigna el numero de detalle
        $('#m' + id_detalle).val(response.valorModificado);
        $('#valor_o').val(response.totalOpciones);
        $('#myModal2').modal('show');
    });
}
//modal de ingreso de producto a cotizar
function modalVerEditarProductoCotizar(id_prod) {
    var data = { id_prod: id_prod };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_cargar_producto_id'),
        data: data,
    }).done(function(response) {
        $('#id_prod_cot').val(id_prod);
        $('#prod_nombre').val(response.nombre);
        $('#prod_obs').val(response.observacion);
        $('#modalProducto').modal('show');
    });
}
//funcion que actualiza el total de valor del producto dependiendo de la entrada de largo y ancho
function actualizaValor() {
    var id_detalle = $('#detalle').val();
    var largo = $('input[name=largo]').val();
    var ancho = $('input[name=ancho]').val();
    var selected = $('#opciones option:selected').text();
    var data = { largo: largo, ancho: ancho, id_detalle: id_detalle };
    if (ancho != "" && largo != "") {
        $('#divCalculos').show();
        var ubicacionTipoUnidad = selected.indexOf("[");
        var ubicacionPrecio1 = selected.indexOf("$");
        var precio = selected.substring(ubicacionPrecio1 + 1, ubicacionTipoUnidad - 2);
        var dimension = Math.round((largo * ancho) * 100) / 100;
        var costoTotal = Math.ceil(precio * dimension);
        var opcion2 = '<form class="form-inline "><div class="form-group col-md-6 "><label class="field"> Dimension Total:<div class="input-group"><input  style="text-align:right;" type="text" class="form-control"  name="medida" id="medida" value="' + dimension + '" disabled="true"><div class="input-group-addon"  disabled="true">' + selected.substr(ubicacionTipoUnidad - 1) + '</div></div></label></div><div class="form-group col-md-6 "><label class="field"> Costo:<div class="input-group"><div class="input-group-addon">$</div><input   type="text" class="form-control" name="costo" id="costo" value="' + costoTotal + '" disabled="true"></div></label></div></form>';
        $('#divCalculos').html(opcion2);
        $('#boton-guardar-opcion-dimensiones').attr("disabled", false);
    } else {
        // document.getElementById('boton-guardar-opcion-dimensiones').disabled = true;
        $('#boton-guardar-opcion-dimensiones').attr("disabled", true);
    }
}
//funcion que modifica la cantidad total del detalle 
function myFunction(val, id) {
    var cantidad = val;
    var id_detalle = (id.indexOf("c") != -1) ? id.substring(id.indexOf("c") + 1) : id; //me aseguro de que tome el valor de la id proveniente de la ventana modal
    var data = { cantidad: cantidad, id_detalle: id_detalle };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_actualizar_cantidad_detalle'),
        data: data,
    }).done(function(response) {
        $('#total' + id_detalle).text(response.result);
        $("#valor").val(response.result); //le pasa el valor total de la fila en el valor de la ventana modal
        $("#nc" + id_detalle).val(cantidad); //le pasa el valor total de la fila en el valor de la ventana modal
        $("input#total_ped").val(response.valorTotal);
        $("input#valorNetoCD").val(response.valorNetoCD);
        $("input#montoDescuento").val(response.montoDescuento);

        $("input#totalImp").val(response.totalCI);
        toastr.success('Datos guardados');
    });
}
//funcion que actualiza la cantidad de la opcion seleccionada 
function actualizaCantidadOpcion(val, id) {
    var cantidad = val;
    var id_detalle_opc = id; //ide de la opcion
    var id_detalle = $('#detalle').val();
    var data = { cantidad: cantidad, id_detalle_opc: id_detalle_opc, id_detalle: id_detalle };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_actualizar_cantidad_opciones'),
        data: data,
    }).done(function(response) {
        toastr.success('Datos guardados');
        $('#total' + id_detalle).text(response.result);
        $("input#total_ped").val(response.valorTotal);
        $("input#totalImp").val(response.totalCI);
        $("input#valorNetoCD").val(response.valorNetoCD);
        $("input#montoDescuento").val(response.montoDescuento);


        $('#valor').val(response.result);
        $('#valor_o').val(response.totalOpciones);
    });
}
//funcion que actualiza el % de descuento y el valor del pedido
function actualizaDescuento(val) {
    var porcentaje = val;
    var id_pedido = $('#ped_id').val();
    var data = { porcentaje: porcentaje, id_pedido: id_pedido };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_actualiza_porcentaje_descuento'),
        data: data,
    }).done(function(response) {
        $("input#totalImp").val(response.totalCI);
        $("input#valorNetoCD").val(response.valorNetoCD);
        $("input#montoDescuento").val(response.montoDescuento);
        toastr.success('Datos guardados');
    });
}
//funcion que actualiza el valor por detalle al cambiar el valor de la cotizacion
function myFunctionValCotizacion(val, id) {
    var id_detalle = (id.indexOf("m") != -1) ? id.substring(id.indexOf("m") + 1) : id; //me aseguro de que tome el valor de la id proveniente de la ventana modal    
    var valorCotizacion = val;
    var data = { valorCotizacion: valorCotizacion, id_detalle: id_detalle };
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_actualizar_valorCotizacion_detalle'),
        data: data,
    }).done(function(response) {
        $('#total' + id_detalle).text(response.result);
        $("input#total_ped").val(response.valorTotal);
        $("input#totalImp").val(response.totalCI);
        $("input#valorNetoCD").val(response.valorNetoCD);
        $("input#montoDescuento").val(response.montoDescuento);

        $("#valor").val(response.result); //le pasa el valor total de la fila en el valor de la ventana modal
        $('#vm' + id_detalle).val(valorCotizacion);
        toastr.success('Datos guardados');
    });
}
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
//Eliminar detalle producto del pedido
function eliminarProductoDetalle(id_detalle_pedido) {
    var id_detalle = id_detalle_pedido;
    var validar = confirm("¿Eliminar producto de pedido?");
    if (validar) {
        var data = { id_detalle: id_detalle };
        $.ajax({
            dataType: 'json',
            method: "POST",
            url: Routing.generate('ajax_eliminar_detalle_pedido'),
            data: data
        }).done(function(response) {
            $("input#total_ped").val(response.valorTotal);
            $("input#valorNetoCD").val(response.valorNetoCD);
            $("input#montoDescuento").val(response.montoDescuento);
            $("input#totalImp").val(response.totalCI);
            $("#tr" + id_detalle_pedido).remove();
            toastr.success('Eliminacion exitosa');
        }).fail(function() {
            toastr.error('Error al Eliminar');
        })
    }
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
            $("input#ped_id").val(response.id_pedido);
            $("input#n_cot").val(response.codigoCotizacion);
            $("input#total_ped").val(response.valorTotal);
            $("input#valorNetoCD").val(response.valorNetoCD);
            $("input#montoDescuento").val(response.montoDescuento);

            $("input#totalImp").val(response.totalCI);
            $("#lista_producto").html("");
            $("input#bsq_producto").val("");
            $("#dT_pedido tbody").append(respuesta);
            // $('#collapseEmpresa').collapse('hide')
            // $('#collapseContacto').collapse('hide')
            $("#bsq_empre_pedido").prop('disabled', true);
            $("#datosPedido").show();
            $('#btnGuardarPedido').attr("disabled", false);

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
            $("#collapseContacto").collapse('show'); //activa div de ingreso de producto
            cargarContactos();
        });
    });
}

function cargar() {
    var drop1 = $('#ped_id').val();
    if (drop1 != "") {
        data = { ped_id: drop1 };
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_cargar_tabla_ingresada'),
            data: data,
        }).done(function(response) {
            if (response.producto != "") {
                $("#dT_pedido tbody").append(response.producto);
            } else {
                $("#dT_pedido tbody").append('No se han seleccionado productos');
            }
        });
    }
}