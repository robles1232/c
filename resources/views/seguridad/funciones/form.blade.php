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
							<label for="{{$prefix}}_descripcion" class="col-form-label">Nombre</label>
							<input class="form-control form-control-sm" type="text" placeholder="Nombre" id="{{$prefix}}_descripcion" name="descripcion">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_funcion" class="col-form-label">Función</label>
							<input class="form-control form-control-sm" type="text" placeholder="Función" id="{{$prefix}}_funcion" name="funcion">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_clase" class="col-form-label">Clase</label>
							<input class="form-control form-control-sm" type="text" placeholder="Clase" id="{{$prefix}}_clase" name="clase">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_icono" class="col-form-label">Ícono</label>
							<input class="form-control form-control-sm" type="text" placeholder="Ícono" id="{{$prefix}}_icono" name="icono">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_orden" class="col-form-label">Orden</label>
							<input class="form-control form-control-sm" type="text" placeholder="Orden" id="{{$prefix}}_orden" name="orden">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_boton" class="col-form-label">¿Es un Botón?</label><br>

							<div class="select2-{{$prefix}}_boton">
								<select class="form-control form-control-sm select2" id="{{$prefix}}_boton" name="boton">
									<option label="¿La función es un Botón?"></option>
									<option value="1">Si</option>
									<option value="2">No</option>
								</select>
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
<!--<script src='{{asset("js/custom.js")}}'></script>