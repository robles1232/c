var array_categorias = [];
$("#form-"+_dir_submodulo_almacen_tipos_producto).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_almacen_tipos_producto).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

function quitarAcentos(cadena){
    const acentos = {'á':'a','é':'e','í':'i','ó':'o','ú':'u','Á':'A','É':'E','Í':'I','Ó':'O','Ú':'U'};
    return cadena.split('').map( letra => acentos[letra] || letra).join('').toString(); 
}

function agregar_categoria(e) {
    e.preventDefault();
    var data = []
    var index_repetido = ""
    const idcategoria = $("#idcategoria_edit").val()
    const descripcion_categoria = $("#"+_prefix_almacen_tipos_producto+"_categoria").val()

    if (descripcion_categoria == undefined || descripcion_categoria == "" || descripcion_categoria.replace(/\s+/g, '').length == 0) {
        $("#form-" + _dir_submodulo_almacen_tipos_producto + "#"+_prefix_almacen_tipos_producto+ "_categoria").focus();
        toastr.warning("Escriba la categoría", msj_modulo)
        return false
    }

    array_categorias.forEach((element, index) => {
        if (quitarAcentos(element.descripcion.replace(/\s+/g, '').replace(/\./g,'')).toUpperCase().replace(/[^0-9a-zA-Z. ]/g, '') == quitarAcentos(descripcion_categoria.replace(/\s+/g, '').replace(/\./g,'')).toUpperCase().replace(/[^0-9a-zA-Z. ]/g, '')) {
            if (index_repetido.length == 0) {
                index_repetido = index
            } else {
                if (index != index_repetido)
                    index_repetido = index
            }
        }
    })

    if (index_repetido.length != 0) {
        $("#form-" + _dir_submodulo_almacen_tipos_producto + "#"+_prefix_almacen_tipos_producto+ "_categoria").focus();
        toastr.warning("Categoría ya registrada", msj_modulo)
        $("#id_tr_categoria" + index_repetido).addClass("selected_red")
        return false
    }

    if (idcategoria.length == 0) {
        data = { id: "", descripcion: descripcion_categoria, editar: 1}
        array_categorias.push(data)
    } else {
        array_categorias[idcategoria].editar = 1
        array_categorias[idcategoria].descripcion = descripcion_categoria.trim()
    }
    $("#"+ _prefix_almacen_tipos_producto+"_categoria").val("")
    $("#idcategoria_edit").val("")
    $("#id_tablecategorias" + idcategoria).removeClass("selected")
    document.getElementById("table_categorias").innerHTML = ""
    create_tabla_categorias()
}

function create_tabla_categorias() {
    var select_tr = ""
    const lista = document.querySelector('#table_categorias')
    const template = document.querySelector('#template_categorias').content
    const fragment = document.createDocumentFragment()
    array_categorias.forEach((data, index) => {
        template.querySelector('tr').id = "id_tr_categoria" + index
        if (data.editar == 2)
            select_tr = index
        template.querySelector('.nro').textContent = index + 1
        template.querySelector('.categoria').innerHTML = data.descripcion
        template.querySelector('.btns').innerHTML = `<button type="button" class="btn_editar btn btn-icon btn-warning text-white mw-2em btn_ptb" onclick="editar_categoria(event,${index}, ${data.id})"><i class="fe fe-edit"></i></button> <button type="button" class="btn_eliminar btn btn-icon btn-danger mw-2em btn_ptb" onclick= "eliminar_categoria(event,${index}, ${data.id})"><i class="fe fe-trash"></i></button>`

        const clone = template.cloneNode(true)
        fragment.appendChild(clone)
        lista.appendChild(fragment)
    })

    if (select_tr.length != 0)
        $("#id_tr_categoria" + select_tr).addClass("selected")
}


function eliminar_categoria(e, id) {
    e.preventDefault()
    var categoria = $("#idcategoria_edit").val()
    
    if (categoria.length != 0) {
        $("#form-" + _dir_submodulo_almacen_tipos_producto + "#"+_prefix_almacen_tipos_producto+"_categoria").focus();
        toastr.warning("Primero terminé de editar la Categoría", msj_modulo)
        return false
    }

    swal({ title: "Confirmar", text: "¿Desea eliminar el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

        array_categorias.splice(id, 1)
        document.getElementById("table_categorias").innerHTML = ""
        create_tabla_categorias()
    })
}

function editar_categoria(e, id) {
    e.preventDefault()

    $("#tabl_ecategorias tr").removeClass("selected")
    $("#table_categorias tr").removeClass("selected_red")
    $("#idcategoria_edit").val(id)
    array_categorias.forEach((data, index) => {
        array_categorias[index].editar = 1
    })
    array_categorias[id].editar = 2
    $("#" + _prefix_almacen_tipos_producto+'_categoria').val(array_categorias[id].descripcion)
    $("#id_tr_categoria" + id).addClass("selected")
    $("#form-" + _dir_submodulo_almacen_tipos_producto + " #" + _prefix_almacen_tipos_producto + "_categoria").focus()
}


function init(){
    if (data_form.categorias.length != 0) {
        data_form.categorias.forEach((data, index) => {
            var datos = []
            datos = { id: data.id, descripcion: data.descripcion, editar: 1 }
            array_categorias.push(datos)
        })
        document.getElementById("table_categorias").innerHTML = ""
        create_tabla_categorias()
    }
}