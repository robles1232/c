let msj_modulo = "Mesas"
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_local_mesas).DataTable({
        ajax: route(_dir_submodulo_local_mesas + ".grilla"),
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
                data: 'sitios',
                orderable: true,
                searchable: true,
                className: "text-center"
            },
            {
                data: 'estado',
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
    form.get(_dir_submodulo_local_mesas).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_local_mesas)
    if (id != null) {
        form.get(_dir_submodulo_local_mesas).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_local_mesas)
    if (id != null) {
        form.get(_dir_submodulo_local_mesas).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

