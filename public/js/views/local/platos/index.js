let msj_modulo = "Platos"
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_local_platos).DataTable({
        ajax: route(_dir_submodulo_local_platos + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {
                data: 'nombre',
                orderable: true,
                searchable: true,
                className: "text-center"
            },
            {
                data: 'descripcion',
                orderable: true,
                searchable: true,
                className: "text-center"

            },
            {
                data: 'precio_venta',
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
    form.get(_dir_submodulo_local_platos).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_local_platos)
    if (id != null) {
        form.get(_dir_submodulo_local_platos).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_local_platos)
    if (id != null) {
        form.get(_dir_submodulo_local_platos).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

