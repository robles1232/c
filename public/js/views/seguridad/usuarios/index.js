$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_seguridad_usuarios).DataTable({
        ajax: route(_dir_submodulo_seguridad_usuarios + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {data: 'user'},
            {data: 'empleado.nombre_completo'},
            {data: 'rol.name'},
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
    form.get(_dir_submodulo_seguridad_usuarios).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_usuarios)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_usuarios).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_usuarios)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_usuarios).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

