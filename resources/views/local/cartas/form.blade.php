<form id="form-{{$dir_submodulo}}" onsubmit="md_guardar(event,'btn-save')">
	<div class="modal fade" id="md-{{$dir_submodulo}}" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: auto;" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Registrar {{$submodulo}}</h5>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="modal-body modal_body">
					<input type="hidden" name="idcreador" value=" {{auth()->user()->empleado->id}}" id="idcreador_{{$prefix}}">
					<input type="hidden" name="idseccion_carta_edit" id="{{$prefix}}_idseccion_carta_edit">

					<input type="hidden" name="id" id="{{$prefix}}_id">

					<div class="form-group form-row">
						<div class="col-md-10">
							<label for="{{$prefix}}_descripcion" class="col-form-label">Carta</label>
							<input type="text" class="form-control form-control-sm" id="{{$prefix}}_descripcion" name="descripcion" placeholder="Nombre de la Carta">
						</div>

						<div class="col-md-2">
							<label for="{{$prefix}}_estado" class="col-form-label">Estado</label>
							<div class="select2-{{$prefix}}_estado">
								<select name="estado" id="{{$prefix}}_estado" class="form-control select2">
									<option label="Seleccione el Estado"></option>
									<option value="1">Inactivo</option>
									<option value="2">Carta Actual</option>
								</select>
							</div>
						</div>

						<div class="col-md-12 form-row mt-3 mb-3">
							<input type="hidden" id="{{$prefix}}_idseccion_carta">
							<input type="hidden" id="{{$prefix}}_descripcion_seccion_carta">

							<div class="col-md-12 d-flex">
								<div id="autocomplete-seccion_carta" class="autocomplete" style="width: 85%;">
									<input type="text" class="form-control form-control-sm" id="{{$prefix}}_buscar_seccion_carta" name="buscar_seccion_carta" placeholder="Buscar sección de carta*">
									<ul class="autocomplete-result-list"></ul>
								</div>
								<div style="width: 15%;" id="btn_seccion_carta" class="btn_add">
									<button class="btn btn-icon btn-outline-primary borderrad_left0 hover_primary" onclick="agregar_seccion_carta(event)">
										<i class="fe fe-plus-circle"></i>
									</button>
									<button class="btn btn-icon btn-outline-warning borderrad_left0 hover_primary d-none" onclick="agregar_seccion_carta(event)">
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
										<template id="template_secciones_carta">
											<tr>
												<td class="nro text-center"></td>
												<td class="seccion_carta text-center"></td>
												<td class="platos text-center"></td>
												<td class="btns text-center"></td>
											</tr>
										</template>
										<div class="table-responsive">
											<table class="table table_form card-table table-vcenter text-nowrap table-writhe align-items-center mb-0">
												<thead class="bg-primary text-white">
													<tr>
														<th width="05%" class="text-center text-white">Nro</th>
														<th width="20%" class="text-center text-white">Sección de Carta</th>
														<th width="60%" class="text-center text-white">Platos</th>
														<th width="15%" class="text-center text-white"></th>
													</tr>
												</thead>
												<tbody id="table_secciones_carta">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="submit" id="btn-save" onclick="md_guardar(event,'btn-save')" class="btn btn-primary" data-acciones="guardar-{{$dir_submodulo}}">Guardar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade bg_modal_secundary" id="{{$prefix}}_modal_productos" tabindex="-1" role="dialog" data-backdrop="statict" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Asignar Productos</h5>
				</div>
				<div class="modal-body">
					<input type="hidden" id="{{$prefix}}_idseccion_plato_producto">
					<div class="form-group form-row">

						

						<div class="col-md-12 form-row mt-3 mb-3">
							<input type="hidden" id="{{$prefix}}_idplato_producto">
							<input type="hidden" id="{{$prefix}}_descripcion_plato_producto">
							<input type="hidden" id="{{$prefix}}_precio_venta_plato_producto">

							<div class="col-md-3">
								<div class="select2-{{$prefix}}_tipo">
									<select name="tipo" id="{{$prefix}}_tipo" class="form-control select2">
										<option label="Seleccione el Tipo"></option>
										<option value="1">Plato</option>
										<option value="2">Producto</option>
									</select>
								</div>
							</div>

							<div class="col-md-9 d-flex">
								<div id="autocomplete-plato_producto" class="autocomplete" style="width: 85%;">
									<input type="text" class="form-control form-control-sm" id="{{$prefix}}_buscar_plato_producto" name="buscar_plato_producto" placeholder="Buscar*">
									<ul class="autocomplete-result-list"></ul>
								</div>
								<div style="width: 15%;" id="btn_plato_producto" class="btn_add">
									<button class="btn btn-icon btn-outline-primary borderrad_left0 hover_primary" onclick="agregar_plato_producto(event)">
										<i class="fe fe-plus-circle"></i>
									</button>
									<button class="btn btn-icon btn-outline-warning borderrad_left0 hover_primary d-none" onclick="agregar_plato_producto(event)">
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
										<template id="template_plato_productos">
											<tr>
												<td class="nro text-center"></td>
												<td class="plato_producto text-center"></td>
												<td class="precio_venta text-center"></td>
												<td class="btns text-center"></td>
											</tr>
										</template>
										<div class="table-responsive">
											<table class="table table_form card-table table-vcenter text-nowrap table-writhe align-items-center mb-0">
												<thead class="bg-primary text-white">
													<tr>
														<th width="05%" class="text-center text-white">Nro</th>
														<th width="60%" class="text-center text-white">Producto</th>
														<th width="20%" class="text-center text-white">Precio de Venta</th>
														<th width="15%" class="text-center text-white"></th>
													</tr>
												</thead>
												<tbody id="table_plato_productos">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer border-0">
					<button type="button" class="btn btn-danger" onclick="close_modal_productos(event)">Cancelar</button>
					<button type="button" class="btn btn-primary" onclick="save_data_productos(event)">Guardar</button>

				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	data_form = @json($data);
</script>
<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/script.js")}}'></script>
<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/script_productos.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>
<!--<script src='{{asset("js/custom.js")}}'></script>-->