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

					<input type="hidden" name="id" id="{{$prefix}}_id">

					<div class="form-group form-row">

						<div class="col-md-6">
							<label for="{{$prefix}}_idmodulo" class="col-form-label">Módulo</label>

							<div class="select2-{{$prefix}}_idmodulo">
								<select name="idmodulo" id="{{$prefix}}_idmodulo" class="form-control select2">
									<option label="Seleccione el módulo"></option>
									@foreach($modulos as $modulo)
									<option value="{{$modulo->id}}">{{$modulo->descripcion}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_descripcion" class="col-form-label">Submódulo</label>
							<input class="form-control form-control-sm" type="text" placeholder="Submódulo" id="{{$prefix}}_descripcion" name="descripcion">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_abreviatura" class="col-form-label">Abreviatura</label>
							<input class="form-control form-control-sm" type="text" placeholder="Abreviatura" id="{{$prefix}}_abreviatura" name="abreviatura">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_url" class="col-form-label">URL</label>
							<input class="form-control form-control-sm" type="text" placeholder="URL" id="{{$prefix}}_url" name="url">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_icono" class="col-form-label">Ícono</label>
							<input class="form-control form-control-sm" type="text" placeholder="Ícono" id="{{$prefix}}_icono" name="icono">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_orden" class="col-form-label">Orden</label>
							<input class="form-control form-control-sm" type="text" placeholder="Orden" id="{{$prefix}}_orden" name="orden">
						</div>

						<div class="col-md-12 d-flex mt-2">
							<div class="select2-{{$prefix}}_idfuncion" style="width: 85%;">
								<select name="idfuncion" id="{{$prefix}}_idfuncion" class="form-control select2">
									<option label="Selecciona la Función"></option>
									@foreach($funciones as $funcion)
									<option value="{{$funcion->id}}">{{$funcion->descripcion}}</option>
									@endforeach
								</select>
							</div>

							<div style="width: 15%;" id="btn_add_funcion" class="btn_add">
								<button class="btn btn-icon btn-outline-primary borderrad_left0 hover_primary" onclick="agregar_funcion(event)">
									<i class="fe fe-plus-circle"></i>
								</button>
								<button class="btn btn-icon btn-outline-warning borderrad_left0 hover_primary d-none" onclick="agregar_funcion(event)">
									<i class="fa fa-refresh"></i>
								</button>
							</div>
						</div>

						<div class="col-md-12">
							<div class="mt-10px">
								<div class="grid-margin">
									<div class="">
										<!-- Template actividades ---->
										<template id="template_funciones">
											<tr>
												<td class="nro_funcion text-center"></td>
												<td class="funcion text-center"></td>
												<td></td>
												<td class="btn_table_funcion text-center"></td>
											</tr>
										</template>
										<div class="table-responsive">
											<table class="table table_form card-table table-vcenter text-nowrap table-writhe align-items-center mb-0">
												<thead class="bg-primary text-white">
													<tr>
														<th width="05%" class="text-center text-white">Nro</th>
														<th width="85%" class="text-center text-white">Función</th>
														<th width="10%" class="text-center text-white"></th>
													</tr>
												</thead>
												<tbody id="table_funciones">
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
<script src="{{asset('js/form-elements.js')}}"></script>-->
<!--<script src='{{asset("js/custom.js")}}'></script>