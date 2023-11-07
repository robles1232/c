let msj_modulo = "Compras"
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_almacen_compras).DataTable({
        ajax: route(_dir_submodulo_almacen_compras + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {
                data: 'serie_comprobante',
                orderable: true,
                searchable: true,
                className: "text-center"
            },
            {
                data: 'numero_comprobante',
                orderable: true,
                searchable: true,
                className: "text-center"

            },
            {
                data: 'proveedor',
                orderable: true,
                searchable: true,
            },
            {
                data: 'total',
                orderable: true,
                searchable: true,
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
    form.get(_dir_submodulo_almacen_compras).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_almacen_compras)
    if (id != null) {
        form.get(_dir_submodulo_almacen_compras).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_almacen_compras)
    if (id != null) {
        form.get(_dir_submodulo_almacen_compras).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

