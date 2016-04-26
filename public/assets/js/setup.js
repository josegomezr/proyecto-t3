(function($, window){
    if($.validator){
        
        $.validator.setDefaults({
            keyup: false,
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $.validator.messages = $.extend($.validator.messages, {
            required: "Este campo es obligatorio.",
            number: "Este campo solo admite numeros decimales.",
            digits: "Este campo solo admite digitos.",
            maxlength: $.validator.format( "Este campo solo admite {0} caracteres m&aacute;ximo." ),
            minlength: $.validator.format( "Este campo require {0} caracteres m&iacute;nimo." )
        });

        $.validator.addMethod('cedula', function(value, element, params){
            return /[VE]-[0-9]{7}/.test(value);
        }, "Formato de cedula incorrecto. Ejemplos: V-12345678 | E-12345678");

        $.validator.addMethod('placa', function(value, element, params){
            return /([a-z]{3}\s[a-z0-9]{3})|([a-z0-9]{7})/i.test(value);
        }, "Formato de placa incorrecto. Ejemplos: ABC A42 | ABC4A37");

        jQuery.validator.addMethod("distinto", function(value, element, param) {
          return this.optional(element) || value != param;
        }, "Ingrese un valor distinto de {0}");
    }

    if($.fn.datepicker)
        $.fn.datepicker.defaults.format = "dd/mm/yyyy";

    $(function () {
        $(".confirmar-eliminar").on('click', function (e) {
            if(!confirm("¿Está seguro que desea eliminar el registro?"))
                e.preventDefault();
        });
    })

    window.GPS = {
        enable:{
            routePath: true,
            routeMarkersArea: true,
            routeMarkers: false,
            routeOffRoad: true,
            routeStart: true,
            routeEnd: true
        }
    }
    
    var printingWidth = 1024;

    var mediaQueryList = window.matchMedia('print');
    var $width;
    
    $(function () {
        $width = $('body').trigger('resize').outerWidth(true);
        console.log($width);
    });

    mediaQueryList.addListener(function(mql) {
        if (mql.matches) {
            $('body').width(printingWidth);
            window.map && window.map.refresh();
        } else {
            $('body').width($width);
        }
    });

    

    window.onbeforeprint = function () {
        $('body').width(printingWidth);
        window.map && window.map.refresh();
        $('.hidden-print').hide();
    }

    window.onafterprint = function () {
        $('body').width($width);
        $('.hidden-print').show();
    }

    $(document).bind("keyup keydown", function(e){
        if(e.ctrlKey && e.keyCode == 80){
            $('body').width(printingWidth);
            window.map && window.map.refresh();
        }
    });

})(jQuery, window, undefined);
