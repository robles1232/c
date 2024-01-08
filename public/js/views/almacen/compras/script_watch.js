var total = 0.00;
var deuda_restante = 0.00;
var deuda_restante = 0.00;
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

    $(".article_total").html("<b><h5>Deuda Total: "+total+"</h5></b>")
}

function deuda_calcular (){
    data_form.detalle_compra.map((data, index) => {
        var subtotal_compra = (parseFloat(data.cantidad)*parseFloat(data.precio_unit)).toFixed(2);
        deuda_restante = (parseFloat(deuda_restante) + parseFloat(subtotal_compra)).toFixed(2)
    });

    if(data_form.igv == 2){
        deuda_restante = (parseFloat(deuda_restante) + parseFloat((deuda_restante*18)/100) ).toFixed(2)
    }

    if(data_form.hay_descuento == 2){
        deuda_restante = (parseFloat(deuda_restante) - data_form.descuento).toFixed(2)
    }

    data_form.compras_credito.map((cred, ind) => {
        deuda_restante = (parseFloat(deuda_restante) - parseFloat(cred.letra)).toFixed(2);
    });

    $(".article_deuda_restante").html("<b><h5>Deuda Total: "+deuda_restante+"</h5></b>")
}

