let msj_modulo_ = "Módulo Funciones"
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_seguridad_submodulos).DataTable({
        ajax: route(_dir_submodulo_seguridad_submodulos + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {data: 'modulo.descripcion'},
            {data: 'descripcion'},
            {data: 'url'},
            {data: 'orden'},
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
    form.get(_dir_submodulo_seguridad_submodulos).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_submodulos)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_submodulos).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_submodulos)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_submodulos).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

