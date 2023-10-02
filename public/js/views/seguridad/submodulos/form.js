form.register(_dir_submodulo_seguridad_submodulos,{
    nuevo: function(){
        get_modal(_dir_submodulo_seguridad_submodulos, _prefix_seguridad_submodulos)
    },
    editar: function(id){
        get_modal(_dir_submodulo_seguridad_submodulos, _prefix_seguridad_submodulos, "edit", id)
    },
    eliminar_restaurar: function(id, obj){
        var $self = this
        let accion__ = obj.getAttribute('data-action')
        let textaccion__ = (accion__.substring(0, 7)) + 'ado'

        //swal({ title: "Confirmar", text: "¿Desea " + accion__ + " el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

            $.ajax({
                url: route(_dir_submodulo_seguridad_submodulos + '.destroy', 'delete'),
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
        let _form = "#form-" + _dir_submodulo_seguridad_submodulos
        let post_data = new FormData($(_form)[0])
        
        array_funciones.forEach((datos, index) => {
            post_data.append("funciones[" + index + "][index]", index)
            post_data.append("funciones[" + index + "][id]", datos.item.id)
            post_data.append("funciones[" + index + "][idfuncion]", datos.item.idfuncion)
        })
        $.ajax({
            url: route(_dir_submodulo_seguridad_submodulos + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {},
            success: function(response) {
                //toastr.success('Datos grabados correctamente', msj_modulo)
                $self.callback(response)
                close_modal(_dir_submodulo_seguridad_submodulos)
            },
            complete: function() {},
            error: function(e) {
                if (e.status == 422) { //Errores de Validacion
                    limpieza(_dir_submodulo_seguridad_submodulos)
                    $.each(e.responseJSON.errors, function(i, item) {
                        $('#' + i + "_" + _prefix_cargo).addClass('is_invalid')
                        $('.' + i + "_" + _prefix_cargo).removeClass('d-none')
                        $('.' + i + "_" + _prefix_cargo).attr('data-content', item)
                        $('.' + i + "_" + _prefix_cargo).addClass('msj_error_exist')
                    })
                    $("#form-" + _dir_submodulo_seguridad_submodulos + " .msj_error_exist").first().popover('show')

                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) {
        grilla.reload(_dir_submodulo_seguridad_submodulos)
    }
})