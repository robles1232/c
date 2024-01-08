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
					<input type="hidden" name="idcategoria_edit" id="idcategoria_edit">

					<input type="hidden" name="id" id="{{$prefix}}_id">

					<div class="form-group form-row">
						<div class="col-md-12">
							<label for="{{$prefix}}_descripcion" class="col-form-label">Ingrediente</label>
							<input class="form-control form-control-sm" type="text" placeholder="Nombre del Ingrediente" id="{{$prefix}}_descripcion" name="descripcion">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_idtipo_producto" class="col-form-label">Tipo de Ingrediente</label>

							<div class="select2-{{$prefix}}_idtipo_producto">
								<select name="idtipo_producto" id="{{$prefix}}_idtipo_producto" class="form-control select2">
									<option label="Seleccione el tipo de producto"></option>
									@foreach($tipos_producto as $tp)
									<option value="{{$tp->id}}">{{$tp->descripcion}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<label for="{{$prefix}}_idunidad_medida" class="col-form-label">Unidad de Medida</label>

							<div class="select2-{{$prefix}}_idunidad_medida">
								<select name="idunidad_medida" id="{{$prefix}}_idunidad_medida" class="form-control select2">
									<option label="Seleccione la Unidad de Medida"></option>
									@foreach($unidades_medida as $unidad_medida)
									<option value="{{$unidad_medida->id}}">{{$unidad_medida->descripcion.' - '.$unidad_medida->abreviatura}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-md-12 form-row d-flex">

							<div class="col-md-12 d-flex">
								<div style="width: 90%;">
									<label for="{{$prefix}}_idpresentacion_producto" class="col-form-label">Presentación de producto</label>

									<div class="select2-{{$prefix}}_idpresentacion_producto">
										<select name="idpresentacion_producto" id="{{$prefix}}_idpresentacion_producto" class="form-control select2" disabled>
											<option label="Seleccione"></option>
										</select>
									</div>
								</div>
								<div style="width: 10%;" id="btn_presentacion_producto" class="mt-4">
									<button class="btn btn-icon btn-outline-primary borderrad_left0 hover_primary" onclick="agregar_presentacion_producto(event)">
										<i class="fe fe-plus-circle"></i>
									</button>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="mt-10px">
								<div class="grid-margin">
									<div class="">
										<!-- Template actividades ---->
										<template id="template_presentaciones_producto">
											<tr>
												<td class="nro text-center"></td>
												<td class="descripcion text-center"></td>
												<td class="btns text-center"></td>
											</tr>
										</template>
										<div class="table-responsive">
											<table class="table table_form card-table table-vcenter text-nowrap table-writhe align-items-center mb-0">
												<thead class="bg-primary text-white">
													<tr>
														<th width="05%" class="text-center text-white">Nro</th>
														<th width="80%" class="text-center text-white">Presentacion de Producto</th>
														<th width="15%" class="text-center text-white"></th>
													</tr>
												</thead>
												<tbody id="table_presentaciones_producto">
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