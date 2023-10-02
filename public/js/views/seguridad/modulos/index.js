$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_seguridad_modulos).DataTable({
        ajax: route(_dir_submodulo_seguridad_modulos + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {data: 'descripcion'},
            {data: 'abreviatura'},
            {data: 'icono'},
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
    form.get(_dir_submodulo_seguridad_modulos).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_modulos)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_modulos).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_modulos)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_modulos).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

