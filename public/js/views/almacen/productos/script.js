$("#form-"+_dir_submodulo_almacen_productos).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_almacen_productos).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})


if(data_form.venta_directa == 2){
    $("#"+_prefix_almacen_productos+"_venta_directa").val(2)
    $("#"+_prefix_almacen_productos+"_precio_venta").attr("disabled", false)
}

if(data_form.venta_directa == 1){
    $("#"+_prefix_almacen_productos+"_venta_directa").val(1)
    $("#"+_prefix_almacen_productos+"_precio_venta").attr("disabled", true)
}

$("#"+_prefix_almacen_productos+"_venta_directa").change(function(e){
    if($(this).val() == 1){
        $("#"+_prefix_almacen_productos+"_precio_venta").val(0)
        $("#"+_prefix_almacen_productos+"_precio_venta").attr("disabled", true)
    }

    if($(this).val() == 2){
        $("#"+_prefix_almacen_productos+"_precio_venta").attr("disabled", false)
    }
});