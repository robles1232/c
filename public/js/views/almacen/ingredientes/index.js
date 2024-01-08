let msj_modulo = "Productos"
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_almacen_ingredientes).DataTable({
        ajax: route(_dir_submodulo_almacen_ingredientes + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {
                data: 'descripcion',
                orderable: true,
                searchable: true,
            },
            {
                data: 'stock_',
                orderable: true,
                searchable: false,
                className: 'text-center',
            },
            {
                data: 'activo',
                orderable: false,
                searchable: false,
                className: "text-center"
            },

        ],
        order: [
            [0, 'ASC']
        ]
    })
}


$("#btn-create").on("click", function(e) {
    e.preventDefault();
    form.get(_dir_submodulo_almacen_ingredientes).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_almacen_ingredientes)
    if (id != null) {
        form.get(_dir_submodulo_almacen_ingredientes).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_almacen_ingredientes)
    if (id != null) {
        form.get(_dir_submodulo_almacen_ingredientes).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

