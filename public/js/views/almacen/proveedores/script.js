var ruc_ = "";
var descripcion = "";
var direccion = "";

$("#form-"+_dir_submodulo_almacen_proveedores).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_almacen_proveedores).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})


function search_proveedor(e) {

    e.preventDefault();
    const ruc = $("#"+_prefix_almacen_proveedores+"_ruc").val();
    if(ruc.length == 0){
        toastr.warning("Debes escribir el número de RUC.", msj_modulo)
        return false;
    }

    $.ajax({
        url: route('proveedores.consulta_ruc', encodeURI(ruc)),
        success: function(response) {
            if(Object.keys(response).length == 0){
                toastr.warning("No se ha encontrado registro con este número de RUC", msj_modulo)
                return false;
            }
            ruc_ = response.ruc;
            descripcion = response.razonSocial;
            direccion = response.direccion;
            $("#"+_prefix_almacen_proveedores+"_descripcion").val(response.razonSocial);
            $("#"+_prefix_almacen_proveedores+"_direccion").val(response.direccion);
            $("#"+_prefix_almacen_proveedores+"_telefono").val(response.telefonos[0]);
        },
        error: function(e) {

            if (e.status == 422) { //Errores de Validacion
                limpieza(_path_controller_proceso_uno);
                $.each(e.responseJSON.errors, function(i, item) {
                    if (i == 'referencias') {
                        toastr.warning(item, msj_modulo)
                    }

                });
            }
        }
    })    
}