<div class="modal fade" id="md-{{$dir_submodulo}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Pagar compra</h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$dir_submodulo}}" onsubmit="md_guardar(event,'btn-save')">
				
				<div class="modal-body modal_body">
					<input type="hidden" name="idcreador" value=" {{auth()->user()->empleado->id}}" id="idcreador_{{$prefix}}">
					<input type="hidden" name="id" id="{{$prefix}}_id">

					<div class="form-group form-row">
						<div class="col-md-12">
							<label for="{{$prefix}}_prov" class="col-form-label">Proveedor</label>
							<input class="form-control form-control-sm" type="text"  id="{{$prefix}}_prov" name="prov" disabled>
						</div>

						<div class="col-md-3">
							<label for="{{$prefix}}_tipo_comprobante" class="col-form-label">Tipo Comprobante</label>

							<div class="select2-{{$prefix}}_tipo_comprobante">
								<select name="tipo_comprobante" id="{{$prefix}}_tipo_comprobante" class="form-control select2" disabled>
									<option label="Seleccione el tipo de comprobante"></option>
									<option value="1">Boleta de Venta</option>
									<option value="2">Factura</option>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<label for="{{$prefix}}_numero_serie" class="col-form-label">Serie</label>
							<input type="text" class="form-control form-control-sm" id="{{$prefix}}_serie_comprobante" name="serie_comprobante" placeholder="Número de Serie" disabled>
						</div>

						<div class="col-md-3">
							<label for="{{$prefix}}_numero_comprobante" class="col-form-label">Comprobante de Pago</label>
							<input type="text" class="form-control form-control-sm" id="{{$prefix}}_numero_comprobante" name="numero_comprobante" placeholder="Número de comprobante de pago" disabled>
						</div>

						<div class="col-md-3">
							<label for="{{$prefix}}_fecha_compra" class="col-form-label">Fecha de Compra</label>
							<input type="date" class="form-control form-control-sm" id="{{$prefix}}_fecha_compra" name="fecha_compra" disabled>
						</div>

						<div class="div_total mt-2">
							<article class="article_total d-flex">
								<b><h5>Total: 0.00</h5></b> 
							</article>
						</div>

						<div class="div_total mt-2">
							<article class="article_deuda_total d-flex">
								<b><h5>Deuda Total: 0.00</h5></b> 
							</article>
						</div>
						<div class="col-md-3 offset-md-6">
							<label for="{{$prefix}}_fecha_pago" class="col-form-label">Fecha de pago</label>
							<input type="date" class="form-control form-control-sm" id="{{$prefix}}_fecha_pago" name="fecha_pago" max="{{date('Y-m-d')}}" >
						</div>

						<div class="col-md-3 ">
							<label for="{{$prefix}}_letra" class="col-form-label">Pago</label>
							<input type="number" class="form-control form-control-sm" id="{{$prefix}}_letra" name="letra" placeholder="0.00">
						</div>


						<div class="div_total mt-2">
							<article class="article_deuda_restante d-flex">
								<b><h5>Deuda Restante: 0.00</h5></b> 
							</article>
						</div>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="submit" id="btn-save" onclick="md_guardar(event,'btn-save')" class="btn btn-primary" data-acciones="guardar_pay-{{$dir_submodulo}}">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	data_form = @json($data);
</script>
<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/script_pay.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>
<!--<script src='{{asset("js/custom.js")}}'></script>-->