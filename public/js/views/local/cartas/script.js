var array_secciones_carta = []
var array_plato_productos = []

$("#form-"+_dir_submodulo_local_cartas).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_local_cartas).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})


if ($("#autocomplete-seccion_carta").length) {
    new Autocomplete("#autocomplete-seccion_carta", {
        search: input => {
            return new Promise(resolve => {
                if (input.length < 2) {
                    return resolve([]) 
                }
                fetch(route("seccion_carta.buscar", encodeURI(input)))
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
            $("#"+_prefix_local_cartas+"_idseccion_carta").val(result.id)
            $("#"+_prefix_local_cartas+"_descripcion_seccion_carta").val(result.descripcion)
        }
    })
}

// ---------------------------- TABLA PRODUCTO 
function agregar_seccion_carta(e) {
    e.preventDefault();
    var data = []
    var index_repetido = ""
    const seccion_carta_edit = $("#"+_prefix_local_cartas+"_idseccion_carta_edit").val()
    const idseccion_carta = $("#"+_prefix_local_cartas+"_idseccion_carta").val()
    const descripcion_seccion_carta = $("#"+_prefix_local_cartas+"_descripcion_seccion_carta").val()

    if (idseccion_carta.length == 0) {
        $("#form-" + _dir_submodulo_local_cartas + " #"+_prefix_local_cartas+ "_buscar_seccion_carta").focus();
        toastr.warning("Debes agregar la sección de la carta", msj_modulo)
        return false
    }

    array_secciones_carta.forEach((element, index) => {
        if (element.idseccion_carta == idseccion_carta) {
            if (seccion_carta_edit.length == 0) {
                index_repetido = index
            } else {
                if (index != seccion_carta_edit)
                    index_repetido = index
            }
        }
    })

    if (index_repetido.length != 0) {
        $("#form-" + _dir_submodulo_local_cartas + " #"+_prefix_local_cartas+ "_buscar_seccion_carta").focus();
        toastr.warning("Sección de carta ya registrada", msj_modulo)
        $("#id_tr_seccion_carta" + index_repetido).addClass("selected_red")
        return false
    }

    if (seccion_carta_edit.length == 0) {
        data = { id: "", idseccion_carta: idseccion_carta, descripcion_seccion_carta: descripcion_seccion_carta, plato_productos: [], editar: 1}
        array_secciones_carta.push(data)
    } else {
        array_secciones_carta[seccion_carta_edit].editar = 1
        array_secciones_carta[seccion_carta_edit].idseccion_carta = idseccion_carta
        array_secciones_carta[seccion_carta_edit].descripcion_seccion_carta = descripcion_seccion_carta
    }
    $("#"+_prefix_local_cartas+"_idseccion_carta_edit").val("")
    $("#"+_prefix_local_cartas+"_idseccion_carta").val("")
    $("#"+_prefix_local_cartas+"_descripcion_seccion_carta").val("")
    $("#"+_prefix_local_cartas+"_buscar_seccion_carta").val("")
    
    $("#id_table_secciones_carta" + seccion_carta_edit).removeClass("selected")
    document.getElementById("table_secciones_carta").innerHTML = ""
    create_table_secciones_carta()
}

function create_table_secciones_carta() {
    var select_tr = ""
    const lista = document.querySelector('#table_secciones_carta')
    const template = document.querySelector('#template_secciones_carta').content
    const fragment = document.createDocumentFragment()
    array_secciones_carta.forEach((data, index) => {
        template.querySelector('tr').id = "id_tr_seccion_carta" + index
        if (data.editar == 2)
            select_tr = index
        template.querySelector('.nro').textContent = index + 1
        template.querySelector('.seccion_carta').innerHTML = data.descripcion_seccion_carta
        //template.querySelector('.platos').innerHTML = "<span class='btn_asignar badge badge-secondary cursor_pointer pdd_asignar-modal'>Platos</span> <div class='table_asignar_modal'><section><label>Inicio : </label><p> 21-11-2023 </p></section></div>"
        if(data.plato_productos.length == 0){
            template.querySelector('.platos').innerHTML = "<span class='btn_asignar badge badge-secondary cursor_pointer pdd_asignar-modal'>Productos</span>"

        }else{
            let html ="<span class='btn_asignar badge badge-secondary cursor_pointer pdd_asignar-modal'>Productos</span>"
            html+= "<div class='table_asignar_modal_producto'>";
            data.plato_productos.forEach((p_pr, e) => {
                html+= "<section><label>"+p_pr.descripcion+" : </label><p> S/. "+p_pr.precio_venta+" </p></section>"
            })
            
            html+= "</div>"
            template.querySelector('.platos').innerHTML = html;

        }
        template.querySelector('.btn_asignar').setAttribute("onclick", "open_modal_productos(event," + index + ")");

        template.querySelector('.btns').innerHTML = `<button type="button" class="btn_editar btn btn-icon btn-warning text-white mw-2em btn_ptb" onclick="editar_seccion_carta(event,${index}, ${data.id})"><i class="fe fe-edit"></i></button> <button type="button" class="btn_eliminar btn btn-icon btn-danger mw-2em btn_ptb" onclick= "eliminar_seccion_carta(event,${index}, ${data.id})"><i class="fe fe-trash"></i></button>`

        const clone = template.cloneNode(true)
        fragment.appendChild(clone)
        lista.appendChild(fragment)
    })

    if (select_tr.length != 0)
        $("#id_tr_seccion_carta" + select_tr).addClass("selected")
}


function eliminar_seccion_carta(e, index) {
    e.preventDefault()
    var producto = $("#"+_prefix_local_cartas+"_idseccion_carta_edit").val()
    
    if (producto.length != 0) {
        $("#form-" + _dir_submodulo_local_cartas + " #"+_prefix_local_cartas+"_buscar_seccion_carta").focus();
        toastr.warning("Primero terminé de editar el producto", msj_modulo)
        return false
    }
    swal({ title: "Confirmar", text: "¿Desea eliminar el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {
        array_secciones_carta.splice(index, 1)
        document.getElementById("table_secciones_carta").innerHTML = ""
        create_table_secciones_carta()
    })
}

function editar_seccion_carta(e, index) {
    e.preventDefault()

    $("#table_secciones_carta tr").removeClass("selected")
    $("#table_secciones_carta tr").removeClass("selected_red")
    $("#"+_prefix_local_cartas+"_idseccion_carta_edit").val(index)
    array_secciones_carta.forEach((data, index) => {
        array_secciones_carta[index].editar = 1
    })
    array_secciones_carta[index].editar = 2
    $("#" + _prefix_local_cartas+'_idseccion_carta').val(array_secciones_carta[index].idseccion_carta)
    $("#" + _prefix_local_cartas+'_descripcion_seccion_carta').val(array_secciones_carta[index].descripcion_seccion_carta)
    $("#" + _prefix_local_cartas+'_buscar_seccion_carta').val(array_secciones_carta[index].descripcion_seccion_carta)
    $("#id_tr_seccion_carta" + index).addClass("selected")
    $("#form-" + _dir_submodulo_local_cartas + " #" + _prefix_local_cartas + "_buscar_seccion_carta").focus()
}


function init(){
    console.log(data_form)
    if (data_form.secciones.length != 0) {
        data_form.secciones.forEach((data, index) => {
            var datos = []
            var plato_productos = []
            data.carta_seccion_detalle.forEach((sec_det, ind_plato) => {
                let pl_pr = {id: sec_det.id, tipo: sec_det.tipo, idplato_producto: 0, descripcion: '', precio_venta: '' }
                if(sec_det.plato ){
                    pl_pr.idplato_producto = sec_det.idplato
                    pl_pr.descripcion = sec_det.plato.nombre
                    pl_pr.precio_venta = sec_det.plato.precio_venta
                }

                if(sec_det.producto ){
                    pl_pr.idplato_producto = sec_det.idproducto
                    pl_pr.descripcion = sec_det.producto.descripcion
                    pl_pr.precio_venta = sec_det.producto.precio_venta
                }
                plato_productos.push(pl_pr)
            });
            datos = { id: data.id, idseccion_carta: data.idseccion, descripcion_seccion_carta: data.seccion.descripcion,  plato_productos: plato_productos, editar: 1}

            
            array_secciones_carta.push(datos)
        })
        document.getElementById("table_secciones_carta").innerHTML = ""
        create_table_secciones_carta()
    }
}