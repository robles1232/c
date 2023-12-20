var array_productos = []

$("#form-"+_dir_submodulo_local_platos).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_local_platos).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})


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
            $("#"+_prefix_local_platos+"_idproducto").val(result.id)
            $("#"+_prefix_local_platos+"_descripcion_producto").val(result.descripcion)
        }
    })
}

// ---------------------------- TABLA PRODUCTO 
function agregar_producto(e) {
    e.preventDefault();
    var data = []
    var index_repetido = ""
    const producto_edit = $("#"+_prefix_local_platos+"_idproducto_edit").val()
    const idproducto = $("#"+_prefix_local_platos+"_idproducto").val()
    const descripcion_producto = $("#"+_prefix_local_platos+"_descripcion_producto").val()
    const cantidad = $("#"+_prefix_local_platos+"_cantidad").val()

    if (idproducto.length == 0) {
        $("#form-" + _dir_submodulo_local_platos + " #"+_prefix_local_platos+ "_buscar_producto").focus();
        toastr.warning("Debes seleccionar el producto", msj_modulo)
        return false
    }

    if (cantidad.length == 0) {
        $("#form-" + _dir_submodulo_local_platos + " #"+_prefix_local_platos+ "_cantidad").focus();
        toastr.warning("Debes escribir la cantidad del producto", msj_modulo)
        return false
    }

    array_productos.forEach((element, index) => {
        if (element.idproducto == idproducto) {
            if (producto_edit.length == 0) {
                index_repetido = index
            } else {
                if (index != producto_edit)
                    index_repetido = index
            }
        }
    })

    if (index_repetido.length != 0) {
        $("#form-" + _dir_submodulo_local_platos + " #"+_prefix_local_platos+ "_buscar_producto").focus();
        toastr.warning("Producto ya registrado", msj_modulo)
        $("#id_tr_producto" + index_repetido).addClass("selected_red")
        return false
    }

    if (producto_edit.length == 0) {
        data = { id: "", idproducto: idproducto, descripcion_producto: descripcion_producto, cantidad: cantidad, editar: 1}
        array_productos.push(data)
    } else {
        array_productos[producto_edit].editar = 1
        array_productos[producto_edit].idproducto = idproducto
        array_productos[producto_edit].descripcion_producto = descripcion_producto
        array_productos[producto_edit].cantidad = cantidad
    }
    $("#"+_prefix_local_platos+"_idproducto_edit").val("")
    $("#"+_prefix_local_platos+"_idproducto").val("")
    $("#"+_prefix_local_platos+"_descripcion_producto").val("")
    $("#"+_prefix_local_platos+"_buscar_producto").val("")
    $("#"+_prefix_local_platos+"_cantidad").val("")
    
    $("#id_table_productos" + producto_edit).removeClass("selected")
    document.getElementById("table_productos").innerHTML = ""
    create_table_productos()
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
    var producto = $("#"+_prefix_local_platos+"_idproducto_edit").val()
    
    if (producto.length != 0) {
        $("#form-" + _dir_submodulo_local_platos + " #"+_prefix_local_platos+"_buscar_producto").focus();
        toastr.warning("Primero terminé de editar el producto", msj_modulo)
        return false
    }
    swal({ title: "Confirmar", text: "¿Desea eliminar el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {
        array_productos.splice(index, 1)
        document.getElementById("table_productos").innerHTML = ""
        create_table_productos()
    })
}

function editar_producto(e, index) {
    e.preventDefault()

    $("#table_productos tr").removeClass("selected")
    $("#table_productos tr").removeClass("selected_red")
    $("#"+_prefix_local_platos+"_idproducto_edit").val(index)
    array_productos.forEach((data, index) => {
        array_productos[index].editar = 1
    })
    array_productos[index].editar = 2
    $("#" + _prefix_local_platos+'_idproducto').val(array_productos[index].idproducto)
    $("#" + _prefix_local_platos+'_descripcion_producto').val(array_productos[index].descripcion_producto)
    $("#" + _prefix_local_platos+'_buscar_producto').val(array_productos[index].descripcion_producto)
    $("#" + _prefix_local_platos+'_cantidad').val(array_productos[index].cantidad)
    $("#id_tr_producto" + index).addClass("selected")
    $("#form-" + _dir_submodulo_local_platos + " #" + _prefix_local_platos + "_buscar_producto").focus()
}


function init(){
    if (data_form.detalle.length != 0) {
        data_form.detalle.forEach((data, index) => {
            var datos = []
            datos = { id: data.id, idproducto: data.idproducto, descripcion_producto: data.producto.descripcion, cantidad: data.cantidad, editar: 1 }
            array_productos.push(datos)
        })
        document.getElementById("table_productos").innerHTML = ""
        create_table_productos()
    }
}