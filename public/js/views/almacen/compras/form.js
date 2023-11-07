form.register(_dir_submodulo_almacen_compras,{
    nuevo: function(){
        get_modal(_dir_submodulo_almacen_compras, _prefix_almacen_compras)
    },
    editar: function(id){
        get_modal(_dir_submodulo_almacen_compras, _prefix_almacen_compras, "edit", id)
    },
    eliminar_restaurar: function(id, obj){
        var $self = this
        let accion__ = obj.getAttribute('data-action')
        let textaccion__ = (accion__.substring(0, 7)) + 'ado'

        swal({ title: "Confirmar", text: "¿Desea " + accion__ + " el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

            $.ajax({
                url: route(_dir_submodulo_almacen_compras + '.destroy', 'delete'),
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
        let _form = "#form-" + _dir_submodulo_almacen_compras
        let post_data = new FormData($(_form)[0])

        array_productos.forEach((datos, index) => {
            post_data.append("productos[" + index + "][index]", index)
            post_data.append("productos[" + index + "][id]", datos.id)
            post_data.append("productos[" + index + "][idproducto]", datos.idproducto)
            post_data.append("productos[" + index + "][cantidad]", datos.cantidad)
            post_data.append("productos[" + index + "][precio_unit]", datos.precio_unit)
        })

        array_productos_eliminados.forEach((datos, index) => {
            post_data.append("productos_eliminados[" + index + "][index]", index)
            post_data.append("productos_eliminados[" + index + "][id]", datos.id)
        })
        

        $.ajax({
            url: route(_dir_submodulo_almacen_compras + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {},
            success: function(response) {
                toastr.success('Datos grabados correctamente', msj_modulo)
                $self.callback(response)
                close_modal(_dir_submodulo_almacen_compras)
            },
            complete: function() {},
            error: function(e) {
                if (e.status == 422) { //Errores de Validacion
                    toastr.remove();
                    limpieza(_dir_submodulo_almacen_compras)
                    $.each(e.responseJSON.errors, function(i, item) {
                        if(i == "productos"){
                            toastr.warning(item, msj_modulo)
                        }

                        if(i == "idproveedor"){
                            toastr.warning(item, msj_modulo)
                        }
                        $('#'+ _prefix_almacen_compras+ "_" + i ).addClass('is_invalid')
                        $('#'+ _prefix_almacen_compras+ "_" + i ).attr('data-invalid', item)

                        $('.select2-' + _prefix_almacen_compras + "_" + i).addClass('select2-is_invalid');
                        $('.select2-' + _prefix_almacen_compras + "_" + i).attr('data-invalid', item);

                    })
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) {
        grilla.reload(_dir_submodulo_almacen_compras)
    }
})