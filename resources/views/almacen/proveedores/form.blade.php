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

						<div class="col-sm-6">
							<label for="{{$prefix}}_descripcion" class="col-form-label">Proveedor</label>
							<input class="form-control form-control-sm" type="text" placeholder="Proveedor" id="{{$prefix}}_descripcion" name="descripcion">
						</div>

						<div class="col-sm-6">
							<label for="{{$prefix}}_ruc" class="col-form-label">Ruc</label>
							<input class="form-control form-control-sm" type="text" placeholder="Ruc" id="{{$prefix}}_ruc" name="ruc">
						</div>

						<div class="col-sm-6">
							<label for="{{$prefix}}_direccion" class="col-form-label">Dirección</label>
							<input class="form-control form-control-sm" type="text" placeholder="Dirección" id="{{$prefix}}_direccion" name="direccion">
						</div>

						<div class="col-sm-6">
							<label for="{{$prefix}}_telefono" class="col-form-label">Teléfono</label>
							<input class="form-control form-control-sm" type="text" placeholder="Teléfono" id="{{$prefix}}_telefono" name="telefono">
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
<!--<script src='{{asset("js/custom.js")}}'></script>
<script src="{{asset('js/form-elements.js')}}"></script>-->