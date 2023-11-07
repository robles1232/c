var array_productos = []
var array_productos_eliminados = []
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

        getResultValue: result => result.ruc+" - "+result.descripcion,
        onSubmit: result => {
            var evento = window.event || event
            evento.preventDefault()
            $("#"+_prefix_almacen_compras+"_idproveedor").val(result.id)
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
        }
    })
}

function cambiar_total(){
    $(".article_total").html("<b><h5>Total: "+total+"</h5></b>")
}
// ---------------------------- TABLA PRODUCTO 
function agregar_producto(e) {
    e.preventDefault();
    var data = []
    var index_repetido = ""
    const producto_edit = $("#"+_prefix_almacen_compras+"_idproducto_edit").val()
    const idproducto = $("#"+_prefix_almacen_compras+"_idproducto").val()
    const descripcion_producto = $("#"+_prefix_almacen_compras+"_descripcion_producto").val()
    const cantidad = $("#"+_prefix_almacen_compras+"_cantidad").val()
    const precio_unit = $("#"+_prefix_almacen_compras+"_precio_unit").val()
    const sub_total = parseFloat(cantidad*precio_unit).toFixed(2)
    
    if (idproducto.length == 0) {
        $("#form-" + _dir_submodulo_almacen_compras + " #"+_prefix_almacen_compras+ "_buscar_producto").focus();
        toastr.warning("Debes seleccionar el producto", msj_modulo)
        return false
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
            if (index_repetido.length == 0) {
                index_repetido = index
            } else {
                if (index != index_repetido)
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
        data = { id: "", idproducto: idproducto, descripcion_producto: descripcion_producto, cantidad: cantidad, precio_unit: precio_unit, sub_total: sub_total, editar: 1}
        array_productos.push(data)
    } else {
        array_productos[producto_edit].editar = 1
        array_productos[producto_edit].idproducto = idproducto
        array_productos[producto_edit].descripcion_producto = descripcion_producto
        array_productos[producto_edit].cantidad = cantidad
        array_productos[producto_edit].precio_unit = precio_unit
        array_productos[producto_edit].sub_total = sub_total
    }
    $("#"+_prefix_almacen_compras+"_idproducto_edit").val("")
    $("#"+_prefix_almacen_compras+"_idproducto").val("")
    $("#"+_prefix_almacen_compras+"_descripcion_producto").val("")
    $("#"+_prefix_almacen_compras+"_buscar_producto").val("")
    $("#"+_prefix_almacen_compras+"_cantidad").val("")
    $("#"+_prefix_almacen_compras+"_precio_unit").val("")
    
    $("#id_table_productos" + producto_edit).removeClass("selected")
    document.getElementById("table_productos").innerHTML = ""
    create_table_productos()
    total = (parseFloat(total) + parseFloat(sub_total)).toFixed(2)
    cambiar_total()
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
        template.querySelector('.producto').innerHTML = data.descripcion_producto
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
    $("#" + _prefix_almacen_compras+'_buscar_producto').val(array_productos[index].descripcion_producto)
    $("#" + _prefix_almacen_compras+'_cantidad').val(array_productos[index].cantidad)
    $("#" + _prefix_almacen_compras+'_precio_unit').val(array_productos[index].precio_unit)
    $("#id_tr_producto" + index).addClass("selected")
    $("#form-" + _dir_submodulo_almacen_compras + " #" + _prefix_almacen_compras + "_buscar_producto").focus()
}

function llenar_proveedor(id, ruc, descripcion){
    $("#"+_prefix_almacen_compras+"_descripcion_proveedor").val(ruc+" - "+descripcion)
    $("#"+_prefix_almacen_compras+"_idproveedor").val(id)
}

function init(){
    if (data_form.detalle_compra.length != 0) {
        llenar_proveedor(data_form.idproveedor, data_form.proveedor.ruc, data_form.proveedor.descripcion)
        data_form.detalle_compra.forEach((data, index) => {
            var datos = []
            datos = { id: data.id, idproducto: data.idproducto, descripcion_producto: data.producto.descripcion, cantidad: data.cantidad, precio_unit: data.precio_unit, sub_total: (parseFloat(data.cantidad)*parseFloat(data.precio_unit)).toFixed(2), editar: 1 }
            array_productos.push(datos)
            total = (parseFloat(total) + parseFloat(datos.sub_total)).toFixed(2)
        })
        cambiar_total()
        document.getElementById("table_productos").innerHTML = ""
        create_table_productos()
    }
}