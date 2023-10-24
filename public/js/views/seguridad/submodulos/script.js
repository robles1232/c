$("#form-"+_dir_submodulo_seguridad_submodulos).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_seguridad_submodulos).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

var array_funciones = [];
/*tippy('#btn_add_funcion button:nth-child(1)', {
    content: "Agregar"
  })
  
tippy('#btn_add_funcion button:nth-child(2)', {
    content: "Actualizar"
})*/

function agregar_funcion(e) {
    e.preventDefault();
    var data = []
    var index_repetido = ""
    const idfuncion = $("#"+_prefix_seguridad_submodulos+"_idfuncion").val()
    const descripcion_funcion = $("#"+_prefix_seguridad_submodulos+"_idfuncion option:selected").html()

    if (idfuncion.length == 0) {
        $("#form-" + _dir_submodulo_seguridad_submodulos + "#"+_prefix_seguridad_submodulos+ "_idfuncion").focus();
        //toastr.warning("Seleccione la función", msj_modulo_)
        return false
    }

    array_funciones.forEach((element, index) => {
        if (idfuncion == element.id) {
            index_repetido = index
        }
    })

    if (index_repetido.length != 0) {
        $("#form-" + _dir_submodulo_seguridad_submodulos + "#"+_prefix_seguridad_submodulos+ "_idfuncion").focus();
        //toastr.warning("Función ya registrada", msj_modulo_)
        $("#id_tr_funcion" + index_repetido).addClass("selected_red")
        return false
    }

    data["item"] = { id: "", idfuncion: idfuncion, descripcion: descripcion_funcion , editar: 1 }
    array_funciones.push(data)
    document.getElementById("table_funciones").innerHTML = ""
    create_tabla_funciones()
    $("#" + _prefix_seguridad_submodulos+"_idfuncion").val("").trigger("change")

}

function create_tabla_funciones() {
    var select_tr = ""
    const lista = document.querySelector('#table_funciones')
    const template = document.querySelector('#template_funciones').content
    const fragment = document.createDocumentFragment()
    array_funciones.forEach((data, index) => {
        template.querySelector('tr').id = "id_tr_funcion" + index
        if (data.item.editar == 2)
            select_tr = index
        template.querySelector('.nro_funcion').textContent = index + 1
        template.querySelector('.funcion').innerHTML = data.item.descripcion
        
        template.querySelector('.btn_table_funcion').innerHTML = `<button type="button" class="btn_eliminar btn btn-icon btn-danger mw-2em btn_ptb" onclick= "eliminar_funcion(event,${index}, ${data.item.id})"><i class="fe fe-trash"></i></button>`

        const clone = template.cloneNode(true)
        fragment.appendChild(clone)
        lista.appendChild(fragment)
    })

    if (select_tr.length != 0)
        $("#id_tr_funcion" + select_tr).addClass("selected")
}


function eliminar_funcion(e, id) {
    e.preventDefault()
    //var idfuncion = $("#"+_prefix_seguridad_submodulos+"_idfuncion").val()
    
    /*if (idfuncion.length != 0) {
        $("#form-" + _path_controller_plan_trabajo_docente + "#"+_prefix_seguridad_submodulos+"_idfuncion").focus();
        //toastr.warning("Primero terminé de editar el proyecto", msj_modulo_)
        return false
    }*/

    //swal({ title: "Confirmar", text: "¿Desea eliminar el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {

        array_funciones.splice(id, 1)
        document.getElementById("table_funciones").innerHTML = ""
        create_tabla_funciones()
    //})
}

function init(){
    if (data_form.funciones.length != 0) {
        data_form.funciones.forEach((data, index) => {
            var datos = []
            datos["item"] = { id: data.id, idfuncion: data.idfuncion, descripcion: data.funcion.descripcion, editar: 1 }
            array_funciones.push(datos)
        })
        document.getElementById("table_funciones").innerHTML = ""
        create_tabla_funciones()
    }
}