//------------------------------------------------------------- Variables globales
//let selected = ""
let data_form = ""
let btn_el_rest = "#btn-destroy"
let msj_sesion = "La sesión ya expiró, por favor cierre sesión y vuelva a ingresar."
let msj_soporte = "Hubo problemas internos, por favor comunicate de inmediato con SOPORTE."
let msj_accesos = "Lo sentimos, usted no tiene los permisos para realizar dicha acción."
let msj_denegada = "El registro actual no tiene las opciones de editar y eliminar."
csrf_token($('meta[name="csrf-token"]').attr('content'))

//------------------------------------------------------------- configuracion datatable
$(document).ready(function() {
    if (document.getElementById("md-password_change"))
        $('#md-password_change').modal('toggle')

    //------------------------------------------------------------- Localstore
    if (localStorage.getItem("mensaje")) {
        toastr.success(localStorage.getItem("mensaje"), 'Notificación')
        setTimeout(deletemsj_localstore("mensaje"), 100);
    }

    if ($('.databale').length) {
        $.extend($.fn.dataTable.defaults, {
            pageLength: 10,
            processing: true,
            serverSide: true,
            destroy: true,
            responsive: false,
            autoWidth: false,
            ordering: true,
            rowId: "id",
            bJQueryUI: true,
        })
    }
})

function reload() {
    location.reload()
}

//------------------------------------------------------------- Solo numeros
$('.solo_numeros').on('input', function(event) {
    const soloNumeros = /^[0-9]+$/.test(event.target.value)
    if (!soloNumeros)
        $(this).val(function(i, oldValue) { return oldValue.replace(/\D/g, '') })
})

//------------------------------------------------------------- Inframe
const traer_contenido_html = (id, url_web, data) => {
    var url = route(url_web, data)
    $("#" + id).attr('src', url)
}

//------------------------------------------------------------- Cambiar password
function cambiar_password(e) {
    e.preventDefault();

    var $self = this;
    let _form = "#form-password_change"
    let post_data = $(_form).serialize()

    $.ajax({
        url: route('home' + '.password_change'),
        type: 'POST',
        data: post_data,
        cache: false,
        processData: false,
        beforeSend: function() {
            //loading();
        },
        success: function(response) {
            swal({ title: "Todo correcto", text: "Se han cambiado la contraseña. Redirigiendo al login...", timer: 3000, showConfirmButton: !1, type: "success" })
            setTimeout(reload, 3000)
        },
        complete: function() {
            //loading("complete");
        },
        error: function(e) {

            //Msj($("#descripcion"), "Ingrese Descripcion ","","above",false)
            if (e.status == 422) { //Errores de Validacion
                limpieza('password_change');
                $.each(e.responseJSON.errors, function(i, item) {
                    if (i == 'referencias') {
                        toastr.warning(item, 'Notificación de Módulo Inicio')
                    }

                    $('#' + i + "_home").addClass('is_invalid');
                    $('.select2-' + i + "_home").addClass('select2-is_invalid');
                    $('.' + i + "_home").removeClass('d-none');
                    $('.' + i + "_home").attr('data-content', item);
                    $('.' + i + "_home").addClass('msj_error_exist');

                });
                $("#form-password_change" + " .msj_error_exist").first().popover('show');


            } else if (e.status == 419) {
                console.log(msj_sesion);
            } else if (e.status == 500) {
                console.log((e.responseJSON.message) ? msj_soporte : ' ');
            }
        }
    })
}

//------------------------------------------------------------- Actualizar datatable
function actualizar_datatable(e) {
    e.preventDefault();
    load_datatable();
}

//------------------------------------------------------------- Csrf token
function csrf_token(csrf_token) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrf_token
        }
    });
}

//------------------------------------------------------------- Borrar localStore
const deletemsj_localstore = (id) => {
    localStorage.removeItem(id);
}

//------------------------------------------------------------- Select tr
$(".databale").on('click', 'tr', function(e) {
    selected = table.row(this).data();

    if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');

        if (document.querySelectorAll(btn_el_rest).length && table.row(this).data() != undefined)
            init_btndelete()
    } else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');

        //selecionar el estado
        if (document.querySelectorAll(btn_el_rest).length && table.row(this).data() != undefined) {
            $(btn_el_rest).attr("class", "")
            if (table.row(this).data()["editable"] != undefined) {
                if (!table.row(this).data()["editable"]) {
                    setTimeout(function() { table.$('tr.selected').removeClass('selected') }, 600)
                    init_btndelete()
                    return alertas.warning("Acción denegada!", msj_denegada);
                }
            }
            if (table.row(this).data()["deleted_at"] == null) {
                $(btn_el_rest).html("<i class='fe fe-trash bt_grilla text-primary-shadow'></i> &nbsp;Eliminar&nbsp;")
                $(btn_el_rest).attr("data-action", " eliminar")
                $(btn_el_rest).addClass("btn btn-outline-danger")
            } else {
                $(btn_el_rest).html('<i class="fe fe-rotate-ccw bt_grilla text-primary-shadow"></i>Restaurar')
                $(btn_el_rest).attr("data-action", "restaurar")
                $(btn_el_rest).addClass("btn btn-outline-success")

            }
        }
    }

})

//------------------------------------------------------------- Alertas
var alertas = function() {

    function warning(titulo = '', texto = 'Seleccione un registro.', tipo = 'warning', texto_bnt = 'Entendido') {
        swal({
            title: titulo,
            text: texto,
            type: tipo,
            confirmButtonText: texto_bnt
        })
    }
    return { warning: warning };

}();

//------------------------------------------------------------- Grilla
var grilla = function() {

    function _get_real_id(idobject) {
        if ($("table[realid='" + idobject + "']").length == 1) {
            var table = "dt-" + idobject;

            var realId = "#" + table;

            if ($.fn.DataTable.isDataTable(realId)) {
                return table;
            } else {
                console.log(idobject + " podria no ser una instancia de DataTables");
            }
        } else {
            console.log("El objeto DOM no existe o existe mas de una instancia para " + idobject);
        }

        return false;
    }

    function get_data(idobject, iRow) {
        var table = _get_real_id(idobject);

        if (table !== false) {
            var api = $("#" + table).DataTable();

            if (iRow === undefined) {
                //console.log(api);
                if (api.$("tr.selected").length) {
                    iRow = api.$("tr.selected");
                } else if (api.$("tr.DTTT_selected[role='row']").length) {
                    iRow = api.$("tr.DTTT_selected[role='row']");
                }
            }

            if (iRow !== undefined) {
                return api.row(iRow).id() || null;
            }
        }
        return null;
    }

    function get_id(idobject, iRow) {
        var row = get_data(idobject, iRow);

        if (row != null) {
            return row;
        }
        return null;
    }

    function reload(idobject, bool) {
        var table = _get_real_id(idobject);
        if (typeof bool != 'boolean')
            bool = true;

        if (table !== false) {
            $("#" + table).DataTable().draw(bool);
        }
    }

    return { get_id: get_id, get_data: get_data, reload: reload };

}();

//------------------------------------------------------------- Modal
var form = function() {
    var aControllers = [];

    function clearfix(keyvar) {
        keyvar = $.trim(keyvar);
        keyvar = keyvar.replace(/\W+/g, "");
        keyvar = keyvar.replace(/\s+/g, "");
        return keyvar;
    }

    function register(key, val, replace) {
        key = clearfix(key);

        if (typeof replace != "boolean")
            replace = false;

        if (key != "") {
            if (replace === true) { // nueva asignacion
                aControllers[key] = val;
            } else if (!(key in aControllers)) { // no existe el registro
                aControllers[key] = val;
            } else if (!$.isPlainObject(val)) { // no es un objeto
                aControllers[key] = val;
            } else if ($.isEmptyObject(val)) { // objeto esta vacio
                aControllers[key] = val;
            } else { // extendemos nomas
                var object = $.extend({}, get(key), val);
                aControllers[key] = object;
            }
        }
    }

    function get(key) {
        key = clearfix(key);
        if (!(key in aControllers)) {
            console.log("key " + key + " not found");
            return {};
        }

        return aControllers[key];
    }

    return { register: register, get: get }
}();


//------------------------------------------------------------- Abrir modal
const get_modal = (_paht, _prefix, funcion = "create", id = null, extra = null) => {
    var _ruta = _paht
    _paht = (extra == null) ? _paht : _paht + extra

    $.ajax({
        url: route(_ruta + "." + funcion, id),
        type: 'GET',
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            $("#div_md-" + _paht).html(response)
            //console.log(data_form)
            if (data_form.length != 0) {
                $.each(data_form, function(key, val) {

                    if (key == "documento" || key == "logo") {
                        // aca falta
                    } else {
                        if( val != null){
                            $("#form-" + _paht+" #" + _prefix + "_" + key).val(val).trigger("change")
                        }
                        if (key == "icono" | key == "icon")
                            set_icono(key, val, _paht)
                    }
                })
                if (typeof init === 'function')
                    init()
            }
        },
        complete: function() {
            $("#md-" + _paht).modal('toggle')
        },
        error: function(e) {
            $("#div_md-" + _paht).html('')

            if (e.status == 419) {
                console.log(msj_sesion);
            } else if (e.status == 500) {
                console.log((e.responseJSON.message) ? msj_soporte : ' ');
            } else if (e.status == 403) {
                toastr.warning(msj_accesos, 'Notificación accesos')
            } else if (e.status == 400) {
                toastr.warning('No se puede actualizar la versión de un sistema eliminado', 'Notificación de módulo sistema')
            }
        }
    });
}

//------------------------------------------------------------- Cerrar modal
const close_modal = (_paht) => {
    $("#md-" + _paht).modal("hide")
}

//------------------------------------------------------------- Acciones modal
const md_guardar = (e, obj) => {
    e.preventDefault()
    let accion = ($("#" + obj).attr('data-acciones')).split('-')
    switch (accion[0]) {
        case "guardar_reset":
            form.get(accion[1]).guardar_reset()
            break

        case "guardar_activities":
            form.get(accion[1]).guardar_activities()
            break

        case "import":
            form.get(accion[1]).import()
            break

        case "guardar_update":
            form.get(accion[1]).guardar_update()
            break

        default:
            form.get(accion[1]).guardar()
            break
    }
}

const md_reporte = (e, obj) => {
    e.preventDefault()
    let accion = ($("#" + obj).attr('data-acciones'))
    switch (obj) {
        case "ver":
            form.get(accion).ver()
            break

        case "pdf":
            form.get(accion).pdf()
            break
    }
}

//------------------------------------------------------------- Selec icono
const selecionar_icono = (e, obj, __key, __paht, id_icono, __prefix) => {
    let class_icono = obj.getElementsByTagName("i")[0].getAttribute('class')
    set_icono(__key, class_icono, __paht)
    $("#" + id_icono + "_" + __prefix).val(class_icono)
}

//------------------------------------------------------------- Ver icono
const set_icono = (_key, _icono, _paht) => {
    $("#form-" + _key + "-" + _paht).attr('class', '')
    $("#form-" + _key + "-" + _paht).addClass(_icono)
}

//------------------------------------------------------------- Limpieza
const limpieza = (_paht) => {
    id = "#form-" + _paht


    $(id + " input").removeClass("is_invalid");
    $(id + " input").removeData();
    $(id + " textarea").removeClass("is_invalid");
    $(id + " textarea").removeData();
    $(id + ' .select2-is_invalid').removeClass('select2-is_invalid');
    $(id + ' .select2-is_invalid').removeData('select2-is_invalid');

}

const init_btndelete = () => {
    if (document.querySelectorAll(btn_el_rest).length) {
        $(btn_el_rest).attr("class", "")
        $(btn_el_rest).html("<i class='fe fe-circle bt_grilla text-primary-shadow'></i> Elim/Rest")
        $(btn_el_rest).attr("data-action", "")
        $(btn_el_rest).addClass("btn btn-outline-default")
    }
}

const mostrar_errores_externos = (e) => {
    if (e.status == 419) {
        console.log(msj_sesion);
    } else if (e.status == 500) {
        console.log((e.responseJSON.message) ? msj_soporte : ' ');
    } else if (e.status == 403) {
        toastr.warning(msj_accesos, 'Notificación accesos')
    }
}

const loading = (accion, element, efecto, texto) => {
    efecto = (efecto === undefined) ? 'bounce' : efecto
    texto = (efecto === undefined) ? '' : texto
    if (accion == 'star')
        return $(element).waitMe({ effect: efecto, text: texto })
    return $(element).waitMe('hide')

}

const loading2 = (accion, element, efecto) => {
    efecto = (efecto === undefined) ? 'loader_principal' : efecto
    if (accion == 'star')
        return $(element).addClass(efecto)
    return $(element).removeClass(efecto)

}


const volvio_inter = () => {
    toastr.con_inter('Se ha restaurado la conexión a internet.', '', {
        "closeButton": true,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": 10000,
        "extendedTimeOut": "false",
        "hideMethod": "hide"
    })
}

function updateIndicator() {
    if (window.navigator.onLine) {
        $(".toast-close-button").click()
        setTimeout(volvio_inter, 500)
    } else {
        toastr.sin_inter('En este momento no tienes conexión.', '', {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "false",
            "extendedTimeOut": "false",
        })
    }
}


window.addEventListener('online', updateIndicator)
window.addEventListener('offline', updateIndicator)