form.register(_dir_submodulo_local_cartas,{
    nuevo: function(){
        get_modal(_dir_submodulo_local_cartas, _prefix_local_cartas)
    },
    editar: function(id){
        get_modal(_dir_submodulo_local_cartas, _prefix_local_cartas, "edit", id)
    },
    eliminar_restaurar: function(id, obj){
        var $self = this
        let accion__ = obj.getAttribute('data-action')
        let textaccion__ = (accion__.substring(0, 7)) + 'ado'

        swal({ title: "Confirmar", text: "¿Desea " + accion__ + " el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

            $.ajax({
                url: route(_dir_submodulo_local_cartas + '.destroy', 'delete'),
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
        let _form = "#form-" + _dir_submodulo_local_cartas
        let post_data = new FormData($(_form)[0])

        array_secciones_carta.forEach((datos, index) => {
            post_data.append("secciones_carta[" + index + "][index]", index)
            post_data.append("secciones_carta[" + index + "][id]", datos.id)
            post_data.append("secciones_carta[" + index + "][idseccion_carta]", datos.idseccion_carta)
            datos.plato_productos.forEach((p_pr, e) => {
                post_data.append("secciones_carta["+index+"][plato_producto]["+e+"][id]", p_pr.id)
                post_data.append("secciones_carta["+index+"][plato_producto]["+e+"][tipo]", p_pr.tipo)
                post_data.append("secciones_carta["+index+"][plato_producto]["+e+"][idplato_producto]", p_pr.idplato_producto)
            })

        })
        
        $.ajax({
            url: route(_dir_submodulo_local_cartas + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {},
            success: function(response) {
                toastr.success('Datos grabados correctamente', msj_modulo)
                $self.callback(response)
                close_modal(_dir_submodulo_local_cartas)
            },
            complete: function() {},
            error: function(e) {
                if (e.status == 422) { //Errores de Validacion
                    toastr.remove();
                    limpieza(_dir_submodulo_local_cartas)
                    $.each(e.responseJSON.errors, function(i, item) {
                        if(i == "secciones_carta"){
                            toastr.warning(item, msj_modulo)
                        }

                        $('#'+ _prefix_local_cartas+ "_" + i ).addClass('is_invalid')
                        $('#'+ _prefix_local_cartas+ "_" + i ).attr('data-invalid', item)

                        $('.select2-' + _prefix_local_cartas + "_" + i).addClass('select2-is_invalid');
                        $('.select2-' + _prefix_local_cartas + "_" + i).attr('data-invalid', item);

                    })
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) {
        grilla.reload(_dir_submodulo_local_cartas)
    }
})