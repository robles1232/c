var total = 0.00;
var deuda_restante = 0.00;
var deuda_total = 0.00;
total_calcular()
deuda_calcular()

$("#form-"+_dir_submodulo_almacen_compras).on('focus', '.is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#form-"+_dir_submodulo_almacen_compras).on('click', '.select2-is_invalid', function(e){
    e.preventDefault()
    toastr.remove();
    toastr.error($(this).data('invalid'), msj_modulo)
})

$("#"+_prefix_almacen_compras+'_prov').val(data_form.proveedor.ruc+" - "+data_form.proveedor.descripcion)
$("#"+_prefix_almacen_compras+'_letra').change(function(){
    calcular_restante($(this).val());
})

function total_calcular (){
    data_form.detalle_compra.map((data, index) => {
        var subtotal_compra = (parseFloat(data.cantidad)*parseFloat(data.precio_unit)).toFixed(2);
        total = (parseFloat(total) + parseFloat(subtotal_compra)).toFixed(2)
    });

    if(data_form.igv == 2){
        total = (parseFloat(total) + parseFloat((total*18)/100) ).toFixed(2)
    }

    if(data_form.hay_descuento == 2){
        total = (parseFloat(total) - data_form.descuento).toFixed(2)
    }

    $(".article_total").html("<b><h5>Total: "+total+"</h5></b>")
}

function deuda_calcular (){
    data_form.detalle_compra.map((data, index) => {
        var subtotal_compra = (parseFloat(data.cantidad)*parseFloat(data.precio_unit)).toFixed(2);
        deuda_total = (parseFloat(deuda_total) + parseFloat(subtotal_compra)).toFixed(2)
    });

    if(data_form.igv == 2){
        deuda_total = (parseFloat(deuda_total) + parseFloat((deuda_total*18)/100) ).toFixed(2)
    }

    if(data_form.hay_descuento == 2){
        deuda_total = (parseFloat(deuda_total) - data_form.descuento).toFixed(2)
    }

    data_form.compras_credito.map((cred, ind) => {
        deuda_total = (parseFloat(deuda_total) - parseFloat(cred.letra)).toFixed(2);
    });

    $(".article_deuda_total").html("<b><h5>Deuda Total: "+deuda_total+"</h5></b>")
}


function calcular_restante(letra){
    if(letra > deuda_total){
        toastr.warning("El monto a pagar no puede ser mayor al de la deuda total", msj_modulo)
        $("#"+_prefix_almacen_compras+'_letra').val(0)
        return false
    }
    deuda_restante = (parseFloat(deuda_total) - parseFloat(letra)).toFixed(2);
    $(".article_deuda_restante").html("<b><h5>Deuda Restante: "+deuda_restante+"</h5></b>")

}