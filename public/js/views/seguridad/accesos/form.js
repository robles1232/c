form.register(_dir_submodulo_seguridad_accesos,{
    guardar: function() {
        var $self = this
        let _form = "#form-" + _dir_submodulo_seguridad_accesos
        let post_data = new FormData($(_form)[0])
        $.ajax({
            url: route(_dir_submodulo_seguridad_accesos + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {},
            success: function(response) {
                //toastr.success('Datos grabados correctamente', msj_modulo)
                $self.callback(response)
                close_modal(_dir_submodulo_seguridad_accesos)
            },
            complete: function() {},
            error: function(e) {
                if (e.status == 422) { //Errores de Validacion
                    limpieza(_dir_submodulo_seguridad_accesos)
                    $.each(e.responseJSON.errors, function(i, item) {
                        $('#' + i + "_" + _prefix_cargo).addClass('is_invalid')
                        $('.' + i + "_" + _prefix_cargo).removeClass('d-none')
                        $('.' + i + "_" + _prefix_cargo).attr('data-content', item)
                        $('.' + i + "_" + _prefix_cargo).addClass('msj_error_exist')
                    })
                    $("#form-" + _dir_submodulo_seguridad_accesos + " .msj_error_exist").first().popover('show')

                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) {
        grilla.reload(_dir_submodulo_seguridad_accesos)
    }
})