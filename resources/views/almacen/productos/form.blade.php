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
						<div class="col-md-4">
							<label for="{{$prefix}}_idtipo_producto" class="col-form-label">Tipo de Producto</label>

							<div class="select2-{{$prefix}}_idtipo_producto">
								<select name="idtipo_producto" id="{{$prefix}}_idtipo_producto" class="form-control select2">
									<option label="Seleccione el tipo de producto"></option>
									@foreach($tipos_producto as $tp)
									<option value="{{$tp->id}}">{{$tp->descripcion}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<label for="{{$prefix}}_idcategoria" class="col-form-label">Categoría</label>

							<div class="select2-{{$prefix}}_idcategoria">
								<select name="idcategoria" id="{{$prefix}}_idcategoria" class="form-control select2">
									<option label="Seleccione la categoría"></option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<label for="{{$prefix}}_idmarca" class="col-form-label">Marcas</label>

							<div class="select2-{{$prefix}}_idmarca">
								<select name="idmarca" id="{{$prefix}}_idmarca" class="form-control select2">
									<option label="Seleccione la marca"></option>
									@foreach($marcas as $marca)
									<option value="{{$marca->id}}">{{$marca->descripcion}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-4">
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
						<div class="col-md-8">
							<label for="{{$prefix}}_descripcion" class="col-form-label">Producto</label>
							<input class="form-control form-control-sm" type="text" placeholder="Nombre del Producto" id="{{$prefix}}_descripcion" name="descripcion">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_venta_directa" class="col-form-label">¿Venta Directa?</label>

							<div class="select2-{{$prefix}}_venta_directa">
								<select name="venta_directa" id="{{$prefix}}_venta_directa" class="form-control select2">
									<option label="Seleccione"></option>
									<option value="1">No</option>
									<option value="2">Si</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<label for="{{$prefix}}_precio_venta" class="col-form-label">Previo de Venta</label>
							<input class="form-control form-control-sm" type="text" placeholder="Precio de Venta" id="{{$prefix}}_precio_venta" name="precio_venta" disabled>
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