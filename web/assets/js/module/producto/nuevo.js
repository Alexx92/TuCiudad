var idproducto = null;

$(document).ready(function() {
    window.onload = cargar();

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
                var id_edit = response.id_newb;
                idproducto = id_edit;
                $("#prod_id").attr('value', id_edit);
                $("#mostrar").show(); //activa el div una vez realiza el guardado add-categoria-tab
                $("#add-categoria").show();
                $("#primera_categoria").hide();
                var opcion_seleccionada = $("#selectCat option:selected").text();


                $('#cli-cat').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i>' + opcion_seleccionada + '</div>');

                // console.log(idproducto);
                toastr.success('Datos guardados  ');
                // $("#add-categoria-tab").show();

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
                    // console.log(response.catLista);
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
        e.preventDefault();
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_borrar_categoria'),
            data: data,
        }).done(function(json) {
            if (json) {
                btn.parent().remove();
                cargarOpciones();
                toastr.success('Dato eliminado');
            }
        });
    });

    $("input[name=radio]").on('click', function() {
        $("#check").val($(this).val());
        var boton = document.getElementById("guardar_producto");
        boton.disabled = false;
    });

    $('#add-categoria').on('click', function() {
        var prod_id = $('#prod_id').val();
        var data = { prod_id: prod_id };
        console.log(data);
        $.ajax({
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_cargar_opciones'),
            data: data,
        }).done(function(response) {
            if (response.lista_opciones != "") {
                $('#opciones_accesibles').html(response.lista_opciones);
            } else {
                $('#opciones_accesibles').html("<li>No hay opciones ya que no se ha seleccionado categoria o la categoria no tiene opciones asociadas </li>");
            }
            $('#opciones').html(response.lista_all_opciones);
        });
    });
    $('#botonCancelarModal3').on('click', function() {
        $('#myModal3').modal('hide');
    });
    $('#btnModalAgregarCat').on('click', function() {
        $('#myModal').modal('show');
    });
    $('#botonMoldal3').on('click', function() {
        $("#form-new-opcion")[0].reset();
        cargarOpciones();
        var prod_id = $('#prod_id').val();
        var data = { prod_id: prod_id };
        $.ajax({ //cargar todas las categoras del producto 
            dataType: 'json',
            method: 'POST',
            url: Routing.generate('ajax_cargar_categorias_producto_id'),
            data: data,
        }).done(function(response) {
            $('#opcion_categorias').html(response.lista_categorias);
        });
        $('#myModal3').modal('show');
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
    $('#btnModalGuardarOpcion').on('click', function(e) {
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
            console.log(datos);
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
                cargarOpciones();
                toastr.success('Datos Guardados');
                $('#myModal3').modal('hide');
                $("#form-new-opcion")[0].reset();
                toastr.success('Datos guardados ;) ');
            }).fail(function(response) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }

        // --------------------------------------------
        // var nombre = $('#opcion_nombre').val();
        // var valor = $('#opcion_valor').val();
        // var id_select = $('#opcion_unidades').val();
        // var id_categoria = $('#opcion_categorias').val();
        // var observaciones = $('#opcion_obs').val();
        // if (nombre != "" && valor != "" && id_categoria != "") {
        //     var data = { nombre: nombre, valor: valor, id_select: id_select, id_categoria: id_categoria, observaciones: observaciones };
        //     $.ajax({
        //         dataType: 'json',
        //         method: 'POST',
        //         url: Routing.generate('ajax_guarda_new_opcion_producto'),
        //         data: data,
        //     }).done(function(response) {
        //         cargarOpciones();
        //         toastr.success('Datos Guardados');
        //         $('#myModal3').modal('hide');
        //         $("#form-new-opcion")[0].reset();
        //     });
        // } else {
        //     toastr.warning('Complete los campos');
        // }
    });
    // $('#btnGuardarCategoria').on('click', function() {
    //     var cat_nombre = $('#cat_nombre').val();
    //     var cat_imagen = $('#cat_imagen').val();
    //     if (cat_nombre != "") {
    //         var data = { cat_nombre: cat_nombre, cat_imagen: cat_imagen };
    //         $.ajax({
    //             dataType: 'json',
    //             method: 'POST',
    //             url: Routing.generate('ajax_guardar_categoria_producto'),
    //             data: data,
    //         }).done(function(response) {
    //             $('#myModal').modal('hide');
    //             $('#selectCat').html(response.listadoXcas);
    //             $('#form_nueva_categoria')[0].reset();
    //             toastr.success('Datos Guardados');
    //         });
    //     } else {
    //         toastr.warning('Complete los campos');
    //     }
    // });
    $('#btnGuardarCategoria').click(function(e) {
        e.preventDefault();
        var form = $('#form-nueva-categoria');
        form.validate({
            errorClass: "state-error",
            validClass: "state-success",
            errorElement: "em",
            rules: {
                cat_nombre: {
                    required: true
                }
            },
            messages: {
                cat_nombre: {
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
                $('#myModal').modal('hide');
                $('#selectCat').html(response.listadoXcas);
                $('#form_nueva_categoria')[0].reset();
                toastr.success('Datos Guardados');
            }).fail(function(json) {
                toastr.error('Error al guardar');
            });
        } else {
            toastr.warning('Complete todos los campos requeridos');
        }
    });

    /* $("#guardar_producto").click(function() {
         if ($("#form_nuevo_producto input[name='radio']:radio").is(':checked')) {
             //alert("Bien!!!, la edad seleccionada es: " + $('input:radio[name=edad]:checked').val());
             $("#form_nuevo_producto").submit();
         } else {
             toastr.error('Identifique el Ingreso');
         }
     });*/

});

function cargarOpciones() {
    var prod_id = $('#prod_id').val();
    var data = { prod_id: prod_id };
    $.ajax({ //cargarr todas las opciones de producto
        dataType: 'json',
        method: 'POST',
        url: Routing.generate('ajax_cargar_opciones'),
        data: data,
    }).done(function(response) {
        if (response.lista_opciones != "") {
            $('#opciones_accesibles').html(response.lista_opciones);
        } else {
            $('#opciones_accesibles').html("<li>No hay opciones ya que no se ha seleccionado categoria</li>");
        }
        $('#opciones').html(response.lista_all_opciones);
    });
}

function cargar() {
    var check = $("#check").val();
    if (check != "") {
        if (check == 1) {
            $("#radio1").attr('checked', true);
        } else {
            $("#radio2").attr('checked', true);
        }
    }
}
// funcion unir cateforia-producto
function cli_cat() {
    var data_cont = $('#prod_id').val();
    if (data_cont == null) { //consulta valor de la id, por si es un producto creado en la misma ventana 
        data_cont = idproducto //id producto es una variable global en el script
    }
    $('.ele span').on('click', function() {
        var span = $(this);
        var idcat = span.data('id');
        var nempre = span.data('name');
        var data = { idcat: idcat, id_cont: data_cont };
        //$('#cli-cat').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i><input type="text" class="form-control" name="namecat" value="' + idcat + '">' + nempre + '</div>');
        $.ajax({
            type: "POST",
            url: Routing.generate('ajax_guardar_categoria'),
            data: data,
            dataType: 'json',
        }).done(function(response) {
            $('#cli-cat').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i>' + nempre + '</div>');
            // $('#cli-cat').append('<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i><input type="text" class="form-control" name="namecat" value="' + idcat + '">' + nempre + '</div>');

            cargarOpciones();
            toastr.success('Datos Guardados');

        }).fail(function(response) {
            toastr.error('Error al cargar el dato');
        });

    });
}