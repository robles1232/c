let msj_modulo = "Marcas"
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_almacen_presentacion_productos).DataTable({
        ajax: route(_dir_submodulo_almacen_presentacion_productos + ".grilla"),
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
                data: 'cantidad',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {
                data: 'activo',
                orderable: false,
                searchable: false,
                className: "text-center"
            },

        ],
        order: [
            [1, 'ASC']
        ]
    })
}


$("#btn-create").on("click", function(e) {
    e.preventDefault();
    form.get(_dir_submodulo_almacen_presentacion_productos).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_almacen_presentacion_productos)
    if (id != null) {
        form.get(_dir_submodulo_almacen_presentacion_productos).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_almacen_presentacion_productos)
    if (id != null) {
        form.get(_dir_submodulo_almacen_presentacion_productos).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

