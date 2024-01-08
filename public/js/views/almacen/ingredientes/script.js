var array_presentaciones_producto = [];

$("#form-"+_dir_submodulo_almacen_ingredientes).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_almacen_ingredientes).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

/*------------------------------PRESENTACIONES------------------------------------*/
if(data_form.idunidad_medida != null){//GET DIMENSIÓN
    getPresentaciones_prodcuto(data_form.idunidad_medida)
}

$("#"+_prefix_almacen_ingredientes+"_idunidad_medida").change(function(e){// GET DIMENSIÓN
    e.preventDefault();
    getPresentaciones_prodcuto($(this).val());
})

function getPresentaciones_prodcuto(idunidad_medida){
    $.ajax({
        url: route('presentacion_productos.getPresentacion_producto', encodeURI(idunidad_medida)),
        beforeSend: function(){
            //loading('star', ".select2-iddimension_")
        },
        success: function(response) {
            //loading('end', ".select2-iddimension_")
            $("#"+_prefix_almacen_ingredientes+"_idpresentacion_producto").attr("disabled", false);
            $("#"+_prefix_almacen_ingredientes+"_idpresentacion_producto").html('');
            var select = document.getElementById(_prefix_almacen_ingredientes+"_idpresentacion_producto");

            let opt_lab = document.createElement('option');
                opt_lab.setAttribute('label', 'Seleccione');
                select.appendChild(opt_lab);

            response.map( (e, index) => {
                let opt = document.createElement('option');
                opt.value = e.id;
                opt.innerHTML = e.descripcion;
                select.appendChild(opt);
            })
        },
        error: function(e) {

            //Msj($("#descripcion"), "Ingrese Descripcion ","","above",false)
            if (e.status == 422) { //Errores de Validacion
                limpieza(_path_controller_proceso_uno);
                $.each(e.responseJSON.errors, function(i, item) {
                    if (i == 'referencias') {
                        toastr.warning(item, 'Notificación de Módulo Factor')
                    }

                });
            }
        }
    })
}

/*------------------------------PRESENTACIONES------------------------------------*/


function agregar_presentacion_producto(e) {
    e.preventDefault();
    var data = []
    var index_repetido = ""

    const idunidad_medida = $("#"+_prefix_almacen_ingredientes+"_idunidad_medida").val()
    const idpresentacion_producto = $("#"+_prefix_almacen_ingredientes+"_idpresentacion_producto").val()
    const descripcion = $("#"+_prefix_almacen_ingredientes+"_idpresentacion_producto").find(":selected").text();

    if(idunidad_medida.length == 0){
        $("#form-" + _dir_submodulo_almacen_ingredientes + " #"+_prefix_almacen_ingredientes+ "_idunidad_medida").focus();
        toastr.warning("Primero debes seleccionar la unidad de medida", msj_modulo)
        return false
    }

    if(idpresentacion_producto.length == 0){
        $("#form-" + _dir_submodulo_almacen_ingredientes + " #"+_prefix_almacen_ingredientes+ "_idpresentacion_producto").focus();
        toastr.warning("Debes seleccionar la presentacion del producto", msj_modulo)
        return false
    }

    array_presentaciones_producto.forEach((element, index) => {
        if ((element.idpresentacion_producto == idpresentacion_producto)) {
            index_repetido = index
        }
    })

    if (index_repetido.length != 0) {
        $("#form-" + _dir_submodulo_almacen_ingredientes + " #"+_prefix_almacen_ingredientes+ "_idpresentacion_producto").focus();
        toastr.warning("Presentación de producto ya registrado", msj_modulo)
        $("#id_tr_presentacion_producto" + index_repetido).addClass("selected_red")
        return false
    }


    data = { id: "", idpresentacion_producto: idpresentacion_producto, descripcion: descripcion, editar: 1}
    array_presentaciones_producto.push(data)
    $("#"+_prefix_almacen_ingredientes+"_idpresentacion_producto").val("").trigger("change")
    
    document.getElementById("table_presentaciones_producto").innerHTML = ""
    create_table_presentaciones_producto()
}

function create_table_presentaciones_producto() {
    var select_tr = ""
    const lista = document.querySelector('#table_presentaciones_producto')
    const template = document.querySelector('#template_presentaciones_producto').content
    const fragment = document.createDocumentFragment()
    array_presentaciones_producto.forEach((data, index) => {
        template.querySelector('tr').id = "id_tr_presentacion_producto" + index
        if (data.editar == 2)
            select_tr = index
        template.querySelector('.nro').textContent = index + 1
        template.querySelector('.descripcion').innerHTML = data.descripcion
        template.querySelector('.btns').innerHTML = `<button type="button" class="btn_eliminar btn btn-icon btn-danger mw-2em btn_ptb" onclick= "eliminar_producto(event,${index}, ${data.id})"><i class="fe fe-trash"></i></button>`

        const clone = template.cloneNode(true)
        fragment.appendChild(clone)
        lista.appendChild(fragment)
    })

    if (select_tr.length != 0)
        $("#id_tr_producto" + select_tr).addClass("selected")
}


function eliminar_producto(e, index) {
    e.preventDefault()
    swal({ title: "Confirmar", text: "¿Desea eliminar el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {
        array_presentaciones_producto.splice(index, 1)
        document.getElementById("table_presentaciones_producto").innerHTML = ""
        create_table_presentaciones_producto()
    })
}

function init(){
    if (data_form.presentaciones_producto.length != 0) {
        
        data_form.presentaciones_producto.forEach((data, index) => {
            var datos = []
            datos = { id: data.id, idpresentacion_producto: data.idpresentacion_producto, descripcion: data.presentacion.descripcion, editar: 1 }
            array_presentaciones_producto.push(datos)
        })
        document.getElementById("table_presentaciones_producto").innerHTML = ""
        create_table_presentaciones_producto()
    }

}