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
							<label for="{{$prefix}}_descripcion" class="col-form-label">Nombre</label>
							<input class="form-control form-control-sm" type="text" placeholder="Nombre del Tipo de Producto" id="{{$prefix}}_descripcion" name="descripcion">
						</div>

						<div class="col-md-12 d-flex mt-3">
							<div  style="width: 85%;">
								<input class="form-control form-control-sm" type="text" placeholder="Categoría" id="{{$prefix}}_categoria" name="categoria">
							</div>

							<div style="width: 15%;" id="btn_add_categoria" class="btn_add">
								<button class="btn btn-icon btn-outline-primary borderrad_left0 hover_primary" onclick="agregar_categoria(event)">
									<i class="fe fe-plus-circle"></i>
								</button>
								<button class="btn btn-icon btn-outline-warning borderrad_left0 hover_primary d-none" onclick="agregar_categoria(event)">
									<i class="fa fa-refresh"></i>
								</button>
							</div>
						</div>

						<div class="col-md-12">
							<div class="mt-10px">
								<div class="grid-margin">
									<div class="">
										<!-- Template actividades ---->
										<template id="template_categorias">
											<tr>
												<td class="nro text-center"></td>
												<td class="categoria text-center"></td>
												<td class="btns text-center"></td>
											</tr>
										</template>
										<div class="table-responsive">
											<table class="table table_form card-table table-vcenter text-nowrap table-writhe align-items-center mb-0">
												<thead class="bg-primary text-white">
													<tr>
														<th width="05%" class="text-center text-white">Nro</th>
														<th width="80%" class="text-center text-white">Categorías</th>
														<th width="15%" class="text-center text-white"></th>
													</tr>
												</thead>
												<tbody id="table_categorias">
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