<div class="modal fade" id="md-{{$dir_submodulo}}" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Registrar {{$submodulo}}</h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form id="form-{{$dir_submodulo}}" onsubmit="md_guardar(event,'btn-save')">

				<div class="modal-body modal_body">
					<input type="hidden" name="idcreador" value=" {{auth()->user()->empleado->id}}" id="idcreador_{{$prefix}}">
					<input type="hidden" name="idproducto_edit" id="{{$prefix}}_idproducto_edit">

					<input type="hidden" name="id" id="{{$prefix}}_id">

					<div class="form-group form-row">
						<div class="col-md-8">
							<input type="hidden" id="{{$prefix}}_idproveedor" name="idproveedor" >
							<label for="{{$prefix}}_descripcion_proveedor" class="col-form-label">Buscar Proveedor</label>
							<div id="autocomplete-proveedor" class="autocomplete">
								<input type="text" class="form-control form-control-sm" id="{{$prefix}}_descripcion_proveedor" name="descripcion_proveedor" placeholder="Buscar Proveedor*">
								<ul class="autocomplete-result-list"></ul>
							</div>
						</div>

						<div class="col-md-4">
							<label for="{{$prefix}}_fecha_compra" class="col-form-label">Fecha de Compra</label>
							<input type="date" class="form-control form-control-sm" id="{{$prefix}}_fecha_compra" name="fecha_compra">
						</div>

						<div class="col-md-2">
							<label for="{{$prefix}}_tipo_comprobante" class="col-form-label">Tipo Comprobante</label>

							<div class="select2-{{$prefix}}_tipo_comprobante">
								<select name="tipo_comprobante" id="{{$prefix}}_tipo_comprobante" class="form-control select2">
									<option label="Seleccione el tipo de comprobante"></option>
									<option value="1">Boleta de Venta</option>
									<option value="2">Factura</option>
								</select>
							</div>
						</div>

						<div class="col-md-5">
							<label for="{{$prefix}}_numero_serie" class="col-form-label">Serie</label>
							<input type="text" class="form-control form-control-sm" id="{{$prefix}}_serie_comprobante" name="serie_comprobante" placeholder="Número de Serie">
						</div>

						<div class="col-md-5">
							<label for="{{$prefix}}_numero_comprobante" class="col-form-label">Comprobante de Pago</label>
							<input type="text" class="form-control form-control-sm" id="{{$prefix}}_numero_comprobante" name="numero_comprobante" placeholder="Número de comprobante de pago">
						</div>

						<div class="col-md-12 form-row mt-3 mb-3">
							<input type="hidden" id="{{$prefix}}_idproducto">
							<input type="hidden" id="{{$prefix}}_descripcion_producto">
							
							<div class="col-md-6">
								<div id="autocomplete-producto" class="autocomplete">
									<input type="text" class="form-control form-control-sm" id="{{$prefix}}_buscar_producto" name="buscar_producto" placeholder="Buscar producto*">
									<ul class="autocomplete-result-list"></ul>
								</div>
							</div>

							<div class="col-md-2">
								<input type="text" class="form-control form-control-sm" id="{{$prefix}}_cantidad" name="cantidad" placeholder="Cantidad">
							</div>

							<div class="col-md-4 d-flex">
								<div style="width: 80%;">
									<input type="text" class="form-control form-control-sm" id="{{$prefix}}_precio_unit" name="precio_unit" placeholder="Precio Unitario">
								</div>

								<div style="width: 20%;" id="btn_producto" class="btn_add">
									<button class="btn btn-icon btn-outline-primary borderrad_left0 hover_primary" onclick="agregar_producto(event)">
										<i class="fe fe-plus-circle"></i>
									</button>
									<button class="btn btn-icon btn-outline-warning borderrad_left0 hover_primary d-none" onclick="agregar_producto(event)">
										<i class="fa fa-refresh"></i>
									</button>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="mt-10px">
								<div class="grid-margin">
									<div class="">
										<!-- Template actividades ---->
										<template id="template_productos">
											<tr>
												<td class="nro text-center"></td>
												<td class="producto text-center"></td>
												<td class="cantidad text-center"></td>
												<td class="precio_unit text-center"></td>
												<td class="sub_total text-center"></td>
												<td class="btns text-center"></td>
											</tr>
										</template>
										<div class="table-responsive">
											<table class="table table_form card-table table-vcenter text-nowrap table-writhe align-items-center mb-0">
												<thead class="bg-primary text-white">
													<tr>
														<th width="05%" class="text-center text-white">Nro</th>
														<th width="50%" class="text-center text-white">Productos</th>
														<th width="10%" class="text-center text-white">Cantidad</th>
														<th width="10%" class="text-center text-white">Precio Unit.</th>
														<th width="10%" class="text-center text-white">Sub. Total</th>
														<th width="15%" class="text-center text-white"></th>
													</tr>
												</thead>
												<tbody id="table_productos">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="div_total">
							<article class="article_total d-flex">
								<b><h5>Total: 0.00</h5></b> 
							</article>
						</div>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="submit" id="btn-save" onclick="md_guardar(event,'btn-save')" class="btn btn-primary" data-acciones="guardar-{{$dir_submodulo}}">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	data_form = @json($data);
</script>
<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/script.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>
<!--<script src='{{asset("js/custom.js")}}'></script>-->