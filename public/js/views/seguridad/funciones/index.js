let msj_modulo = "Funciones"
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_seguridad_funciones).DataTable({
        ajax: route(_dir_submodulo_seguridad_funciones + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {data: 'descripcion'},
            {data: 'funcion'},
            {data: 'clase'},
            {data: 'icono'},
            {data: 'boton'},
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
    form.get(_dir_submodulo_seguridad_funciones).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_funciones)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_funciones).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_funciones)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_funciones).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

