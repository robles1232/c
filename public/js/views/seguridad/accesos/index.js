let msj_modulo = "Accesos"
var __jstree = ""

$("#"+_prefix_seguridad_accesos+"_idrol").on("change", function(e){
    e.preventDefault()
    armar_jstree(e)
});

function armar_jstree(e) {
    e.preventDefault()
    
    limpieza(_dir_submodulo_seguridad_accesos)
    $('#jstree_' + _dir_submodulo_seguridad_accesos).jstree('destroy')
    __jstree = $('#'+_prefix_seguridad_accesos+'_jstree').jstree({
        'plugins': ["wholerow", "checkbox", "types"],
        'core': {
            "themes": {
                "responsive": false
            },
            'data': {
                'url': route(_dir_submodulo_seguridad_accesos + '.acceso', {
                    idrol: $("#"+_prefix_seguridad_accesos+"_idrol").val(),
                }),
                'data': function(node) {
                    //console.log(node)
                    return { 'id': node.id };
                }
            }
        },
        "types": {
            "default": {
                "icon": "ion-record"
            }
        },
    })
}

//------------------------------ Guardar
function guardar_accesos(e) {
    e.preventDefault()
    let post_data = new FormData($($("#form-" + _dir_submodulo_seguridad_accesos))[0])
    var cont_true = 0
    var cont_false = 0

    __jstree.find('li').each(function(i, element) {
        var link = $(element).find('a.jstree-anchor')
        var __id = this.id.split('-')
        if (__id[0] == 'f') {
            if ($(element).attr("aria-selected")) {
                if ($(element).attr("aria-selected").toString() == 'true') {
                    cont_true++
                    post_data.append("accesos_true[" + cont_true + "][id]", this.id)
                } else {
                    cont_false++
                    post_data.append("accesos_false[" + cont_false + "][id]", this.id)
                }
            } else if ($(link).attr("aria-selected").toString() == 'true') {
                cont_true++
                post_data.append("accesos_true[" + cont_true + "][id]", this.id)
            } else {
                cont_false++
                post_data.append("accesos_false[" + cont_false + "][id]", this.id)
            }
        }
    })

    //for (var pair of post_data.entries()) { console.log(pair[0] + ', ' + pair[1]); } return false
    $.ajax({
        url: route(_dir_submodulo_seguridad_accesos + '.store'),
        type: 'POST',
        data: post_data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            //loading();
        },
        success: function(response) {
            //localStorage.accesos = "Datos grabados correctamente-" + $("#idmodulo_padre_" + _prefix_seguridad_accesos).val() + "-" + $("#idperfil_" + _prefix_seguridad_accesos).val() + "-" + $("#idrol_" + _prefix_seguridad_accesos).val()
            //localStorage.accesos = "Datos grabados correctamente-" + $("#idmodulo_padre_" + _prefix_seguridad_accesos).val() + "-" + $("#idrol_" + _prefix_seguridad_accesos).val()+ "-" + $("#idfacultad_" + _prefix_seguridad_accesos).val()
            location.reload();
        },
        complete: function() {
            //loading("complete");
        },
        error: function(e) {
            console.log("error");
            if (e.status == 422) { //Errores de Validacion
                limpieza(_dir_submodulo_seguridad_accesos)
                $.each(e.responseJSON.errors, function(i, item) {
                    if (i == 'accesos')
                        toastr.warning(item, 'Notificación ' + _dir_submodulo_seguridad_accesos)

                    $('#' + i + "_" + _prefix_seguridad_accesos).addClass('is_invalid');
                    $('.select2-' + i + "_" + _prefix_seguridad_accesos).addClass('select2-is_invalid');
                    $('.' + i + "_" + _prefix_seguridad_accesos).removeClass('d-none');
                    $('.' + i + "_" + _prefix_seguridad_accesos).attr('data-content', item);
                    $('.' + i + "_" + _prefix_seguridad_accesos).addClass('msj_error_exist');

                });
                $("#form-" + _dir_submodulo_seguridad_accesos + " .msj_error_exist").first().popover('show');


            } else{
                mostrar_errores_externos(e)
            }
        }
    })
}