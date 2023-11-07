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

console.log(data_form)
$("#"+_prefix_almacen_productos+"_idtipo_producto").change(function(e){
    e.preventDefault()
    getCategorias($(this).val())
});

if(data_form.idtipo_producto != null){
    getCategorias(data_form.idtipo_producto)
}

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

function getCategorias(idtipo_producto){
    $.ajax({
        url: route('tipos_producto.getCategoria', encodeURI(idtipo_producto)),
        beforeSend: function(){
            loading('star', ".select2-"+_prefix_almacen_productos+"_idcategoria")
        },
        success: function(response) {
            loading('end', ".select2-"+_prefix_almacen_productos+"_idcategoria")
            $("#"+_prefix_almacen_productos+"_idcategoria").html('');
            var select = document.getElementById(_prefix_almacen_productos+"_idcategoria");
            
            let opt_lab = document.createElement('option');
                opt_lab.setAttribute('label', 'Seleccione la Categoría');
                select.appendChild(opt_lab);
            
            response.map( (e, index) => {
                let opt = document.createElement('option');
                opt.value = e.id;
                opt.innerHTML = e.descripcion;
                select.appendChild(opt);
            })
            $("#"+_prefix_almacen_productos+"_idcategoria").val(data_form.idcategoria);
        },
        error: function(e) {

            //Msj($("#descripcion"), "Ingrese Descripcion ","","above",false)
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