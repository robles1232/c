let msj_modulo = "Proveedores"
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_almacen_proveedores).DataTable({
        ajax: route(_dir_submodulo_almacen_proveedores + ".grilla"),
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
                data: 'ruc',
                orderable: true,
                searchable: true,
            },
            {
                data: 'direccion',
                orderable: true,
                searchable: true,
            },
            {
                data: 'telefono',
                orderable: true,
                searchable: true,
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
    form.get(_dir_submodulo_almacen_proveedores).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_almacen_proveedores)
    if (id != null) {
        form.get(_dir_submodulo_almacen_proveedores).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_almacen_proveedores)
    if (id != null) {
        form.get(_dir_submodulo_almacen_proveedores).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

