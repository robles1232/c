$(document).ready(function() {
    load_datatable()
})

let msj_modulo = "Empleados"
//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _dir_submodulo_seguridad_empleados).DataTable({
        ajax: route(_dir_submodulo_seguridad_empleados + ".grilla"),
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {data: 'nombre_completo'},
            {data: 'email'},
            {data: 'telefono'},
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
    form.get(_dir_submodulo_seguridad_empleados).nuevo();
});

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_empleados)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_empleados).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_dir_submodulo_seguridad_empleados)
    if (id != null) {
        form.get(_dir_submodulo_seguridad_empleados).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

