form.register(_dir_submodulo_seguridad_funciones,{
    nuevo: function(){
        get_modal(_dir_submodulo_seguridad_funciones, _prefix_seguridad_funciones)
    },
    editar: function(id){
        get_modal(_dir_submodulo_seguridad_funciones, _prefix_seguridad_funciones, "edit", id)
    },
    eliminar_restaurar: function(id, obj){
        var $self = this
        let accion__ = obj.getAttribute('data-action')
        let textaccion__ = (accion__.substring(0, 7)) + 'ado'

        //swal({ title: "Confirmar", text: "¿Desea " + accion__ + " el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

            $.ajax({
                url: route(_dir_submodulo_seguridad_funciones + '.destroy', 'delete'),
                data: { id: id, accion: accion__ },
                type: 'DELETE',
                beforeSend: function() {},
                success: function(response) {
                    //toastr.success('Registro ' + textaccion__ + ' correctamente', msj_modulo)
                    $self.callback(response)
                    init_btndelete()
                },
                complete: function() {},
                error: function(e) {
                    if (e.status == 422) { //Errores de Validacion
                        $.each(e.responseJSON.errors, function(i, item) {
                            if (i == 'error_persona')
                                return toastr.warning(item, msj_modulo)
                        })
                    }else {
                        mostrar_errores_externos(e)
                    }
                }
            })
        //})
    },
    guardar: function() {
        var $self = this
        let _form = "#form-" + _dir_submodulo_seguridad_funciones
        let post_data = $(_form).serialize()

        $.ajax({
            url: route(_dir_submodulo_seguridad_funciones + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            processData: false,
            beforeSend: function() {},
            success: function(response) {
                //toastr.success('Datos grabados correctamente', msj_modulo)
                $self.callback(response)
                close_modal(_dir_submodulo_seguridad_funciones)
            },
            complete: function() {},
            error: function(e) {
                if (e.status == 422) { //Errores de Validacion
                    limpieza(_dir_submodulo_seguridad_funciones)
                    $.each(e.responseJSON.errors, function(i, item) {
                        $('#' + i + "_" + _prefix_cargo).addClass('is_invalid')
                        $('.' + i + "_" + _prefix_cargo).removeClass('d-none')
                        $('.' + i + "_" + _prefix_cargo).attr('data-content', item)
                        $('.' + i + "_" + _prefix_cargo).addClass('msj_error_exist')
                    })
                    $("#form-" + _dir_submodulo_seguridad_funciones + " .msj_error_exist").first().popover('show')

                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) {
        grilla.reload(_dir_submodulo_seguridad_funciones)
    }
})