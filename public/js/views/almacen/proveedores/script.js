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