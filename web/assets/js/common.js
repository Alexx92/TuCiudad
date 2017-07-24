$( document ).ready(function() {

    // slider superior
    $('#banner').slider({
        indicators: false
    });

    // boton menu movil
    $(".button-collapse").sideNav({
        closeOnClick: true, // Closes side-nav on <a> clicks
        draggable: false // Choose whether you can drag to open on touch screens
    }); 
    
    //scroll fixed menu
    $(function () {
        $(window).on('scroll', function(){
            if ($(this).scrollTop() > 0) {
                $('#menu-barr').addClass("menu-top-scroll");
            } else {
                $('#menu-barr').removeClass("menu-top-scroll");
            }
        });
    });

    // carga dinamica
    loadPage(function(){
        galeria();
        mapa();
        enviarFormulario();
        parallax();
    });
    menuActive();

    $(window).on('hashchange', function(){
        $('#contenido').hide();
        $('#contenido').fadeIn("slow");
        menuActive();
        loadPage(function(){
            galeria();
            mapa();
            enviarFormulario();
            parallax();
        });
        
    });


    // back to top
    // hide #back-top first
    $("#back-top").hide();
    // fade in #back-top
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('#back-top').fadeIn();
                $('#back-top').addClass("show");
            } else {
                $('#back-top').fadeIn();
                $('#back-top').removeClass("show");
            }
        });
        // scroll body to 0px on click
        $('#back-top').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

});




// funciones
// cargar paginas
    function loadPage(fn){
        var url_activa = window.location.href;
        var lista_hash = url_activa.split('#');
        fn = fn || function(){};        
        if(lista_hash[1])
        {
            $('#contenido').load("content/"+lista_hash[1]+".php", fn);
        }else{
            $('#contenido').load("content/inicio.php", fn);
        }
    }

// agregar clase active a los items del menu
    function menuActive()
    {
        $('#menu-barr').find('a').removeClass('active-link');
        $('#menu-barr').find('.btn-box').removeClass('active-back');

        var url_activa = window.location.href;
        var lista_hash = url_activa.split('#');
        
        // agregar clase active-link a los 'a' del menu, cuando se seleccionan
        if(lista_hash[1])
        {
            $('#menu-barr').find('a[href="#'+lista_hash[1]+'"]').addClass('active-link');

        }else{
            $('#menu-barr').find('a[href="#inicio"]').addClass('active-link');
        }

        // agregar clase active-back a los contenedores de los a del menu, cuando se seleccionan
        if ($('#menu-barr').find('a').hasClass('active-link'))
        {
            $('.'+lista_hash[1]+'').addClass('active-back');
        } else {
            $('.'+lista_hash[1]+'').removeClass('active-back');
        }

    }

// script galeria
    function galeria() {
        $('#galeria').lightGallery({
            selector: ".gall",               // Cargara todos los elementos hijos del div que se mostraran en la galeria.        
            subHtmlSelectorRelative: true,   // Habilita la carga del texto 'caption' al abrir un item de la galeria.        
            download: false                  // Deshabilita el boton de descarga para las imagenes que se estan visualizando.
        });
    }

//script mapa
    function mapa(){
        var url_activa = window.location.href;
        var lista_hash = url_activa.split('#');
        if(lista_hash[1] == 'contacto')
        {
            var map = new GMaps({
                div: '#map',
                lat: -37.4707771,
                lng: -72.351543,
                zoom: 15,
                mapTypeControl: false,
                scrollwheel: false,
                draggable: false
            });
            map.addMarker({
                lat: -37.4707771,
                lng: -72.351543,
                title: "Los Angeles"
            });
            
        }
    }

//script parallax
    function parallax(){
        $('.parallax').parallax();
    }

// Evio de forumulario con ajax
    function enviarFormulario(){
        $('.vald').keypress(function(e){
            var tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 8) return true;
                patron = /\d/; te = String.fromCharCode(tecla);
            return patron.test(te);
        });
        $('#btn_enviar').click(function(e) {
            var form = $('#form_contact');
            form.validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 3
                    },
                    correo: {
                        required: true,
                        email: true
                    },
                    fono: {
                        number: true,
                        required: true
                    },
                    msj: {
                        required: true,
                        minlength: 10
                    }
                },
                messages: {
                    nombre: {
                        required: 'Ingrese su nombre',
                        minlength: 'Debe ingresar almenos 3 caracteres'
                    },
                    
                    correo: {
                        required: 'Debe ingresar un correo electronico valido',
                        email: 'Debe ingresar un correo electronico valido'
                    },
                    fono: {
                        required: 'Debe ingresar un telefono valido',
                        number: 'Debe ingresar un telefono valido'
                    },
                    msj: {
                        required: 'Campo requerido',
                        minlength: 'Debe ingresar almenos 10 caracteres'
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.is(":radio") || element.is(":checkbox")) {
                        element.closest('.option-group').after(error);
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });
            e.preventDefault();
            if(form.valid())
            {
                var data = form.serialize();
                var method = form.attr('method');
                var action = form.attr('action');
                $.ajax({
                  url: action,
                  data: form.serialize(),
                  method: 'post',
                  dataType: 'json'
                }).done(function(data){
                    if(data.result)
                    {
                        form[0].reset();
                        Materialize.toast('Correo enviado', 8000)
                    }else{
                        Materialize.toast('Error al enviar el correo', 8000)
                    }
                });
            }
        });
    }
    