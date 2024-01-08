var array_productos = []
var array_productos_eliminados = []
var sub_total_productos = 0.00;
var total = 0.00;

$("#form-"+_dir_submodulo_almacen_compras).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_almacen_compras).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})
/** ----------------- IGV ---------------------*/
if(data_form.igv == 2){
    $("#"+_prefix_almacen_compras+"_igv").val(2).trigger("change")
    $("#"+_prefix_almacen_compras+"_igv_numeric").attr("disabled", true)
}

if(data_form.igv == 1){
    $("#"+_prefix_almacen_compras+"_igv").val(1).trigger("change")
    $("#"+_prefix_almacen_compras+"_igv_numeric").attr("disabled", true)
}

$("#"+_prefix_almacen_compras+"_igv").change(function(e){
    calcular_total();
});

function calcular_igv(){
    if($("#"+_prefix_almacen_compras+"_igv").val() == 2){
        var igv = parseFloat( (total*18)/100 ).toFixed(2)
        $("#"+_prefix_almacen_compras+"_igv_numeric").val(igv)
    }else{
        $("#"+_prefix_almacen_compras+"_igv_numeric").val(0)
    }
}
/** ----------------- IGV ---------------------*/

/** -----------------DESCUENTO------------------ */
if(data_form.hay_descuento == 2){
    $("#"+_prefix_almacen_compras+"_hay_descuento").val(2)
    $("#"+_prefix_almacen_compras+"_descuento").attr("disabled", false)
}

if(data_form.hay_descuento == 1){
    $("#"+_prefix_almacen_compras+"_hay_descuento").val(1)
    $("#"+_prefix_almacen_compras+"_descuento").attr("disabled", true)
}

$("#"+_prefix_almacen_compras+"_hay_descuento").change(function(e){
    if($(this).val() == 1){
        $("#"+_prefix_almacen_compras+"_descuento").val(0)
        $("#"+_prefix_almacen_compras+"_descuento").attr("disabled", true)
    }

    if($(this).val() == 2){
        $("#"+_prefix_almacen_compras+"_descuento").attr("disabled", false)
    }
    calcular_total()
});
/**---------------- DESCUENTO------------------*/


/**----------------------- PRESENTACIONES--------------------*/
$("#"+_prefix_almacen_compras+"_tipo_presentacion").change(function(e){

    if($(this).val() == 1){
        $("#"+_prefix_almacen_compras+"_idpresentacion_producto").val(0).trigger("change")
        $("#"+_prefix_almacen_compras+"_idpresentacion_producto").attr("disabled", true)
    }

    if($(this).val() == 2){
        if($("#"+_prefix_almacen_compras+"_idproducto").val() == ""){
            toastr.warning("Debes seleccionar el producto", msj_modulo)
            $(this).val("").trigger("change")
            return false;
        }
        $("#"+_prefix_almacen_compras+"_idpresentacion_producto").attr("disabled", false)
    }
});

function getPresentacion_producto(idproducto){
    $.ajax({
        url: route('productos.getPresentaciones', encodeURI(idproducto)),
        beforeSend: function(){
            //loading('star', ".select2-iddimension_")
        },
        success: function(response) {
            //loading('end', ".select2-iddimension_")
            //PRESENTACIÓN SELECT
            $("#"+_prefix_almacen_compras+"_idpresentacion_producto").html('');
            var select = document.getElementById(_prefix_almacen_compras+"_idpresentacion_producto");
            let opt_lab = document.createElement('option');
                opt_lab.setAttribute('label', 'Seleccione');
                select.appendChild(opt_lab);
            
            response.map( (e, index) => {
                let opt = document.createElement('option');
                opt.value = e.presentacion.id;
                opt.innerHTML = e.presentacion.descripcion;
                select.appendChild(opt);
            })

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

/**----------------------- PRESENTACIONES--------------------*/

$("#"+_prefix_almacen_compras+"_descuento").change(function(e){
    calcular_total()
})
/*-----------------DESCUENTO--------------------------*/
if ($("#autocomplete-proveedor").length) {
    new Autocomplete("#autocomplete-proveedor", {
        search: input => {
            return new Promise(resolve => {
                if (input.length < 2) {
                    return resolve([]) 
                }
                fetch(route("proveedores.buscar", encodeURI(input)))
                    .then(response => response.json())
                    .then(data => {
                        const results = data.search.map((result, index) => {
                            return { ...result, index }
                        })
                        resolve(results)
                    })
            })
        },

        renderResult: (result, props) => {
            return `
          <li ${props}>
            <div class="wiki-title">
               ${result.descripcion}
            </div>
            <div class="wiki-snippet">
               RUC: ${result.ruc}
            </div>
          </li>`
        },

        getResultValue: result => result.ruc,
        onSubmit: result => {
            var evento = window.event || event
            evento.preventDefault()
            $("#"+_prefix_almacen_compras+"_idproveedor").val(result.id)
            $("#"+_prefix_almacen_compras+"_razon_social").val(result.descripcion)
            $("#"+_prefix_almacen_compras+"_direccion").val(result.direccion)
        }
    })
}

if ($("#autocomplete-producto").length) {
    new Autocomplete("#autocomplete-producto", {
        search: input => {
            return new Promise(resolve => {
                if (input.length < 2) {
                    return resolve([]) 
                }
                fetch(route("productos.buscar", encodeURI(input)))
                    .then(response => response.json())
                    .then(data => {
                        const results = data.search.map((result, index) => {
                            return { ...result, index }
                        })
                        resolve(results)
                    })
            })
        },

        renderResult: (result, props) => {
            return `
          <li ${props}>
            <div class="wiki-title">
               ${result.descripcion}
            </div>
            <div class="wiki-snippet">
               
            </div>
          </li>`
        },

        getResultValue: result => result.descripcion,
        onSubmit: result => {
            var evento = window.event || event
            evento.preventDefault()
            $("#"+_prefix_almacen_compras+"_idproducto").val(result.id)
            $("#"+_prefix_almacen_compras+"_descripcion_producto").val(result.descripcion)
            $("#"+_prefix_almacen_compras+"_precio_venta").val(result.precio_venta)
            $("#"+_prefix_almacen_compras+"_producto_um").val(result.idunidad_medida)

            $("#"+_prefix_almacen_compras+"_idpresentacion_producto").html('');
            var select = document.getElementById(_prefix_almacen_compras+"_idpresentacion_producto");
            let opt_lab = document.createElement('option');
                opt_lab.setAttribute('label', 'Seleccione');
                select.appendChild(opt_lab);
            
            result.presentaciones_producto.map( (e, index) => {
                let opt = document.createElement('option');
                opt.value = e.idpresentacion;
                opt.innerHTML = e.presentacion.descripcion;
                select.appendChild(opt);
            })
        }
    })
}

function calcular_total(){
    total = sub_total_productos;
    if($("#"+_prefix_almacen_compras+"_igv").val() == 2){
        $("#"+_prefix_almacen_compras+"_igv_numeric").val(parseFloat((total*18)/100).toFixed(2))
        total = (parseFloat(total) + parseFloat((total*18)/100) ).toFixed(2)

    }else{
        $("#"+_prefix_almacen_compras+"_igv_numeric").val(0)

    }

    if($("#"+_prefix_almacen_compras+"_hay_descuento").val() == 2){
        total = (parseFloat(total) - parseFloat($("#"+_prefix_almacen_compras+"_descuento").val()) ).toFixed(2)
    }
    cambiar_total();
}

function cambiar_total(){
    $(".article_total").html("<b><h5>Total: "+total+"</h5></b>")

}
function cambiar_sub_total_productos(){
    $(".article_sub_total_productos").html("<b><h5>Sub. Total: "+sub_total_productos+"</h5></b>")
}
// ---------------------------- TABLA PRODUCTO 

function agregar_producto(e) {
    e.preventDefault();
    var data = []
    var index_repetido = ""
    const producto_edit = $("#"+_prefix_almacen_compras+"_idproducto_edit").val()
    const idproducto = $("#"+_prefix_almacen_compras+"_idproducto").val()
    const descripcion_producto = $("#"+_prefix_almacen_compras+"_descripcion_producto").val()
    const precio_venta = $("#"+_prefix_almacen_compras+"_precio_venta").val()
    const producto_um = $("#"+_prefix_almacen_compras+"_producto_um").val()
    const tipo_presentacion = $("#"+_prefix_almacen_compras+"_tipo_presentacion").val()
    const idpresentacion_producto = $("#"+_prefix_almacen_compras+"_idpresentacion_producto").val()
    const presentacion_unidad_medida = $("#"+_prefix_almacen_compras+"_idpresentacion_producto").find(":selected").data('unidad_medida')
    const cantidad = $("#"+_prefix_almacen_compras+"_cantidad").val()
    const precio_unit = $("#"+_prefix_almacen_compras+"_precio_unit").val()
    const sub_total = parseFloat(cantidad*precio_unit).toFixed(2)
    

    if (idproducto.length == 0) {
        $("#form-" + _dir_submodulo_almacen_compras + " #"+_prefix_almacen_compras+ "_buscar_producto").focus();
        toastr.warning("Debes seleccionar el producto", msj_modulo)
        return false
    }

    if(tipo_presentacion.length == 0){
        $("#form-" + _dir_submodulo_almacen_compras + " #"+_prefix_almacen_compras+ "_tipo_presentacion").focus();
        toastr.warning("Debes seleccionar el tipo de presentación", msj_modulo)
        return false
    }else if(tipo_presentacion == 2){
        if(idpresentacion_producto.length == 0){
            $("#form-" + _dir_submodulo_almacen_compras + " #"+_prefix_almacen_compras+ "_idpresentacion").focus();
            toastr.warning("Debes seleccionar la presentación", msj_modulo)
            return false
        }
    }

    if (cantidad.length == 0) {
        $("#form-" + _dir_submodulo_almacen_compras + " #"+_prefix_almacen_compras+ "_cantidad").focus();
        toastr.warning("Debes escribir la cantidad del producto", msj_modulo)
        return false
    }

    if (precio_unit.length == 0) {
        $("#form-" + _dir_submodulo_almacen_compras + " #"+_prefix_almacen_compras+ "_precio_unit").focus();
        toastr.warning("Debes escribir el precio unitario", msj_modulo)
        return false
    }


    array_productos.forEach((element, index) => {
        if ((element.idproducto == idproducto) && (producto_edit != index)) {
            if (producto_edit.length == 0) {
                index_repetido = index
            } else {
                if (index != producto_edit)
                    index_repetido = index
            }
        }
    })

    if (index_repetido.length != 0) {
        $("#form-" + _dir_submodulo_almacen_compras + " #"+_prefix_almacen_compras+ "_buscar_producto").focus();
        toastr.warning("Producto ya registrado", msj_modulo)
        $("#id_tr_producto" + index_repetido).addClass("selected_red")
        return false
    }

    if (producto_edit.length == 0) {
        data = { id: "", idproducto: idproducto, descripcion_producto: descripcion_producto, precio_venta: precio_venta, producto_um: producto_um, tipo_presentacion: tipo_presentacion, idpresentacion_producto: idpresentacion_producto, cantidad: cantidad, precio_unit: precio_unit, sub_total: sub_total, editar: 1}
        array_productos.push(data)
    } else {
        array_productos[producto_edit].editar = 1
        array_productos[producto_edit].idproducto = idproducto
        array_productos[producto_edit].descripcion_producto = descripcion_producto
        array_productos[producto_edit].precio_venta = precio_venta
        array_productos[producto_edit].tipo_presentacion = tipo_presentacion
        array_productos[producto_edit].idpresentacion_producto = idpresentacion_producto
        array_productos[producto_edit].cantidad = cantidad
        array_productos[producto_edit].precio_unit = precio_unit
        array_productos[producto_edit].sub_total = sub_total
    }
    $("#"+_prefix_almacen_compras+"_idproducto_edit").val("")
    $("#"+_prefix_almacen_compras+"_idproducto").val("")
    $("#"+_prefix_almacen_compras+"_descripcion_producto").val("")
    $("#"+_prefix_almacen_compras+"_precio_venta").val("")
    $("#"+_prefix_almacen_compras+"_producto_um").val("")
    $("#"+_prefix_almacen_compras+"_buscar_producto").val("")
    $("#"+_prefix_almacen_compras+"_cantidad").val("")
    $("#"+_prefix_almacen_compras+"_precio_unit").val("")
    $("#"+_prefix_almacen_compras+"_tipo_presentacion").val("").trigger("change")
    $("#"+_prefix_almacen_compras+"_idpresentacion_producto").val("").trigger("change")
    
    $("#id_table_productos" + producto_edit).removeClass("selected")
    document.getElementById("table_productos").innerHTML = ""
    create_table_productos()
    sub_total_productos = (parseFloat(sub_total_productos) + parseFloat(sub_total)).toFixed(2)
    cambiar_sub_total_productos()
    calcular_total()
}

function create_table_productos() {
    var select_tr = ""
    const lista = document.querySelector('#table_productos')
    const template = document.querySelector('#template_productos').content
    const fragment = document.createDocumentFragment()
    array_productos.forEach((data, index) => {
        template.querySelector('tr').id = "id_tr_producto" + index
        if (data.editar == 2)
            select_tr = index
        template.querySelector('.nro').textContent = index + 1
        template.querySelector('.producto').innerHTML = data.descripcion_producto+'<br>'+`<a class="btn_precio" href="#" onclick="open_modal_pv(event, ${index}, ${data.id})" >PV: S/.${data.precio_venta}</a>`
        template.querySelector('.cantidad').innerHTML = data.cantidad
        template.querySelector('.precio_unit').innerHTML = data.precio_unit
        template.querySelector('.sub_total').innerHTML = data.sub_total
        template.querySelector('.btns').innerHTML = `<button type="button" class="btn_editar btn btn-icon btn-warning text-white mw-2em btn_ptb" onclick="editar_producto(event,${index}, ${data.id})"><i class="fe fe-edit"></i></button> <button type="button" class="btn_eliminar btn btn-icon btn-danger mw-2em btn_ptb" onclick= "eliminar_producto(event,${index}, ${data.id})"><i class="fe fe-trash"></i></button>`

        const clone = template.cloneNode(true)
        fragment.appendChild(clone)
        lista.appendChild(fragment)
    })

    if (select_tr.length != 0)
        $("#id_tr_producto" + select_tr).addClass("selected")
}


function eliminar_producto(e, index) {
    e.preventDefault()
    var producto = $("#"+_prefix_almacen_compras+"_idproducto_edit").val()
    
    if (producto.length != 0) {
        $("#form-" + _dir_submodulo_almacen_compras + " #"+_prefix_almacen_compras+"_buscar_producto").focus();
        toastr.warning("Primero terminé de editar el producto", msj_modulo)
        return false
    }
    swal({ title: "Confirmar", text: "¿Desea eliminar el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {
        
        if(array_productos[index].id){
            data = {idproducto: array_productos[index].idproducto, cantidad: array_productos[index].cantidad}
            array_productos_eliminados.push(data)
        }
        array_productos.splice(index, 1)
        document.getElementById("table_productos").innerHTML = ""
        create_table_productos()
    })
}

function editar_producto(e, index) {
    e.preventDefault()

    $("#table_productos tr").removeClass("selected")
    $("#table_productos tr").removeClass("selected_red")
    $("#"+_prefix_almacen_compras+"_idproducto_edit").val(index)
    array_productos.forEach((data, index) => {
        array_productos[index].editar = 1
    })
    array_productos[index].editar = 2
    $("#" + _prefix_almacen_compras+'_idproducto').val(array_productos[index].idproducto)
    $("#" + _prefix_almacen_compras+'_descripcion_producto').val(array_productos[index].descripcion_producto)
    $("#" + _prefix_almacen_compras+'_precio_venta').val(array_productos[index].precio_venta)
    $("#" + _prefix_almacen_compras+'_producto_um').val(array_productos[index].producto_um)
    $("#" + _prefix_almacen_compras+'_buscar_producto').val(array_productos[index].descripcion_producto)
    $("#" + _prefix_almacen_compras+'_tipo_presentacion').val(array_productos[index].tipo_presentacion).trigger("change")
    $("#" + _prefix_almacen_compras+'_idpresentacion_producto').val(array_productos[index].idpresentacion_producto).trigger("change")
    $("#" + _prefix_almacen_compras+'_cantidad').val(array_productos[index].cantidad)
    $("#" + _prefix_almacen_compras+'_precio_unit').val(array_productos[index].precio_unit)
    $("#id_tr_producto" + index).addClass("selected")
    $("#form-" + _dir_submodulo_almacen_compras + " #" + _prefix_almacen_compras + "_buscar_producto").focus()

    getPresentacion_producto(array_productos[index].idproducto)
}

function llenar_proveedor(id, ruc, descripcion){
    $("#"+_prefix_almacen_compras+"_descripcion_proveedor").val(ruc)
    $("#"+_prefix_almacen_compras+"_idproveedor").val(id)
}

function open_modal_pv(e, index){
    //array_productos[index].item.requisitos
    e.preventDefault();
    $("#"+_prefix_almacen_compras+"_index_producto").val(index)
    $("#"+_prefix_almacen_compras+"_pv").val(array_productos[index].precio_venta)
    $("#"+_prefix_almacen_compras+"_modal_pv").modal('show');
}

function close_modal_pv(e){
    $("#"+_prefix_almacen_compras+"_modal_pv").modal('hide');
    $("#"+_prefix_almacen_compras+"_pv").val("")
    $("#"+_prefix_almacen_compras+"_index_producto").val("")

}

function save_data_pv(e){
    e.preventDefault();
    if($("#"+_prefix_almacen_compras+"_pv").val().length == 0){
        toastr.warning("Debes escribir el precio de venta del producto", msj_modulo)
        return false
    }
    
    let pv = $("#"+_prefix_almacen_compras+"_pv").val()
    let index = $("#"+_prefix_almacen_compras+"_index_producto").val()
    array_productos[index].precio_venta = parseFloat(pv).toFixed(2);
    $("#"+_prefix_almacen_compras+"_modal_pv").modal('hide');
    document.getElementById("table_productos").innerHTML = ""
    create_table_productos()
}

function init(){
    if (data_form.detalle_compra.length != 0) {
        $("#"+_prefix_almacen_compras+"_tipo_compra").attr("disabled", true)
        llenar_proveedor(data_form.idproveedor, data_form.proveedor.ruc)
        data_form.detalle_compra.forEach((data, index) => {
            var datos = []
            datos = { id: data.id, idproducto: data.idproducto, descripcion_producto: data.producto.descripcion, precio_venta: data.producto.precio_venta, tipo_presentacion: data.tipo_presentacion, idpresentacion_producto: data.idpresentacion_producto, cantidad: data.cantidad, precio_unit: data.precio_unit, sub_total: (parseFloat(data.cantidad)*parseFloat(data.precio_unit)).toFixed(2), editar: 1 }
            array_productos.push(datos)
            sub_total_productos = (parseFloat(sub_total_productos) + parseFloat(datos.sub_total)).toFixed(2)
        })
        cambiar_sub_total_productos()
        document.getElementById("table_productos").innerHTML = ""
        create_table_productos()
    }

    calcular_total()

}