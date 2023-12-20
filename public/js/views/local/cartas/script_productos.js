
function open_modal_productos(e, index){
    e.preventDefault();

    $("#"+_prefix_local_cartas+"_idseccion_plato_producto").val(index)
    array_plato_productos = array_secciones_carta[index].plato_productos;
    document.getElementById("table_plato_productos").innerHTML = ""
    create_table_plato_productos()
    $("#index_modal_requisitos_"+_prefix_local_cartas).val(index);
    $("#"+_prefix_local_cartas+"_modal_productos").modal('show');
}

function close_modal_productos(e){
    e.preventDefault();
    $('tr').removeClass();
    $("#"+_prefix_local_cartas+"_modal_productos").modal('hide');
}


$("#"+_prefix_local_cartas+"_tipo").change(function(e){
	e.preventDefault();
	$("#"+_prefix_local_cartas+"_buscar_plato_producto").val("")
	$("#"+_prefix_local_cartas+"_idplato_producto").val("")
	$("#"+_prefix_local_cartas+"_descripcion_plato_producto").val("")
	$("#"+_prefix_local_cartas+"_precio_venta_plato_producto").val("")
})

if ($("#autocomplete-plato_producto").length) {
    new Autocomplete("#autocomplete-plato_producto", {
        search: input => {
            return new Promise(resolve => {
            	if($("#"+_prefix_local_cartas+"_tipo").val().length == 0){
                    toastr.warning("Debes seleccionar el tipo", msj_modulo)
                    $("#"+_prefix_local_cartas+"_buscar_plato_producto").blur()
                    return resolve([]) 
            	}

                if (input.length < 2) {
                    return resolve([]) 
                }

                let ruta = ''
                if($("#"+_prefix_local_cartas+"_tipo").val() == 1){
                	ruta = 'platos.buscar_carta'
                }else{
                	ruta = 'productos.buscar_carta'
                }

                fetch(route(ruta, encodeURI(input)))
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
               ${result.descripcion} - S/.${result.precio_venta}
            </div>
            <div class="wiki-snippet">
               
            </div>
          </li>`
        },

        getResultValue: result => result.descripcion,
        onSubmit: result => {
            var evento = window.event || event
            evento.preventDefault()
            $("#"+_prefix_local_cartas+"_idplato_producto").val(result.id)
            $("#"+_prefix_local_cartas+"_descripcion_plato_producto").val(result.descripcion)
            $("#"+_prefix_local_cartas+"_precio_venta_plato_producto").val(result.precio_venta)
        }
    })
}

function agregar_plato_producto(e){
    e.preventDefault();
    var data = []
    var index_repetido = ""
    
    const tipo = $("#"+_prefix_local_cartas+"_tipo").val()
    const idplato_producto = $("#"+_prefix_local_cartas+"_idplato_producto").val()
    const descripcion_plato_producto = $("#"+_prefix_local_cartas+"_descripcion_plato_producto").val()
    const precio_venta_plato_producto = $("#"+_prefix_local_cartas+"_precio_venta_plato_producto").val()

    if (idplato_producto.length == 0) {
        $("#form-" + _dir_submodulo_local_cartas + " #"+_prefix_local_cartas+ "_buscar_plato_producto").focus();
        toastr.warning("Debes agregar la sección de la carta", msj_modulo)
        return false
    }

    array_plato_productos.forEach((element, index) => {
        if (element.idplato_producto == idplato_producto) {
            index_repetido = index
        }
    })

    if (index_repetido.length != 0) {
        $("#form-" + _dir_submodulo_local_cartas + " #"+_prefix_local_cartas+ "_buscar_plato_producto").focus();
        toastr.warning("Plato o Producto ya registrado", msj_modulo)
        $("#id_tr_plato_productos" + index_repetido).addClass("selected_red")
        return false
    }

    data = {id: "", tipo: tipo, idplato_producto: idplato_producto, descripcion: descripcion_plato_producto, precio_venta: precio_venta_plato_producto}
    array_plato_productos.push(data)

    $("#"+_prefix_local_cartas+"_buscar_plato_producto").val("")
    $("#"+_prefix_local_cartas+"_idplato_producto").val("")
    $("#"+_prefix_local_cartas+"_descripcion_plato_producto").val("")
    $("#"+_prefix_local_cartas+"_precio_venta_plato_producto").val("")
    $("#"+_prefix_local_cartas+"_tipo").val("").trigger("change")

    
    //$("#id_table_plato_productos" + plato_producto_edit).removeClass("selected")
    document.getElementById("table_plato_productos").innerHTML = ""
    create_table_plato_productos()
}

function create_table_plato_productos(){
    var select_tr = ""
    const lista = document.querySelector('#table_plato_productos')
    const template = document.querySelector('#template_plato_productos').content
    const fragment = document.createDocumentFragment()
    array_plato_productos.forEach((data, index) => {
        template.querySelector('tr').id = "id_tr_seccion_carta" + index

        template.querySelector('.nro').textContent = index + 1
        template.querySelector('.plato_producto').innerHTML = data.descripcion
        template.querySelector('.precio_venta').innerHTML = "S/."+data.precio_venta

        template.querySelector('.btns').innerHTML = `<button type="button" class="btn_eliminar btn btn-icon btn-danger mw-2em btn_ptb" onclick= "eliminar_plato_producto(event,${index}, ${data.id})"><i class="fe fe-trash"></i></button>`

        const clone = template.cloneNode(true)
        fragment.appendChild(clone)
        lista.appendChild(fragment)
    })

    if (select_tr.length != 0)
        $("#id_tr_plato_producto" + select_tr).addClass("selected")
}

function eliminar_plato_producto(e, index){
    e.preventDefault()
    swal({ title: "Confirmar", text: "¿Desea eliminar el registro seleccionado?", type: "warning", showCancelButton: !0, confirmButtonText: "Confirmar", cancelButtonText: "Cancelar" }, function() {
        array_plato_productos.splice(index, 1)
        document.getElementById("table_plato_productos").innerHTML = ""
        create_table_plato_productos()
    })
}

function save_data_productos(e) {
    e.preventDefault()
    if(array_plato_productos.length == 0){
        toastr.warning("Debes Registrar los platos o productos", msj_modulo_)
        return false
    }
    let index = $("#"+_prefix_local_cartas+"_idseccion_plato_producto").val()
    array_secciones_carta[index].plato_productos = array_plato_productos;
    $("#"+_prefix_local_cartas+"_modal_productos").modal('hide');
    document.getElementById("table_secciones_carta").innerHTML = "";
    create_table_secciones_carta()
}