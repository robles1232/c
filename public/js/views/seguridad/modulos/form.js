form.register(_dir_submodulo_seguridad_modulos,{
    nuevo: function(){
        get_modal(_dir_submodulo_seguridad_modulos, _prefix_seguridad_modulos)
    },
    editar: function(id){
        get_modal(_dir_submodulo_seguridad_modulos, _prefix_seguridad_modulos, "edit", id)
    },
    eliminar_restaurar: function(id, obj){
        var $self = this
        let accion__ = obj.getAttribute('data-action')
        let textaccion__ = (accion__.substring(0, 7)) + 'ado'

        swal({ title: "Confirmar", text: "¿Desea " + accion__ + " el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

            $.ajax({
                url: route(_dir_submodulo_seguridad_modulos + '.destroy', 'delete'),
                data: { id: id, accion: accion__ },
                type: 'DELETE',
                beforeSend: function() {},
                success: function(response) {
                    toastr.success('Registro ' + textaccion__ + ' correctamente', msj_modulo)
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
        })
    },
    guardar: function() {
        var $self = this
        let _form = "#form-" + _dir_submodulo_seguridad_modulos
        let post_data = $(_form).serialize()

        $.ajax({
            url: route(_dir_submodulo_seguridad_modulos + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            processData: false,
            beforeSend: function() {},
            success: function(response) {
                toastr.success('Datos grabados correctamente', msj_modulo)
                $self.callback(response)
                close_modal(_dir_submodulo_seguridad_modulos)
            },
            complete: function() {},
            error: function(e) {
                if (e.status == 422) { //Errores de Validacion
                    toastr.remove();
                    limpieza(_dir_submodulo_seguridad_modulos)
                    $.each(e.responseJSON.errors, function(i, item) {
                        $('#'+ _prefix_seguridad_modulos+ "_" + i ).addClass('is_invalid')
                        $('#'+ _prefix_seguridad_modulos+ "_" + i ).attr('data-invalid', item)

                        $('.select2-' + _prefix_seguridad_modulos + "_" + i).addClass('select2-is_invalid');
                        $('.select2-' + _prefix_seguridad_modulos + "_" + i).attr('data-invalid', item);

                    })
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) {
        grilla.reload(_dir_submodulo_seguridad_modulos)
    }
})