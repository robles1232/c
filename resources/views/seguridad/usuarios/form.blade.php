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

						<div class="col-md-6 col-lg-6">
							<label for="{{$prefix}}_idempleado" class="col-form-label">Empleado</label>

							<div class="select2-{{$prefix}}_idempleado">
								<select name="idempleado" id="{{$prefix}}_idempleado" class="select2 form-control">
									<option label="Selecciona el Empleado">''''''''''''''''''''''''''''''''''</option>
									@foreach($empleados as $empleado)
										<option value="{{$empleado->id}}">{{$empleado->nombre_completo}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_idrol" class="col-form-label">Rol</label>
							<div class="select2-{{$prefix}}_idrol">
								<select name="idrol" id="{{$prefix}}_idrol" class="form-control select2" required>
									<option label="Selecciona el Rol"></option>
									@foreach($roles as $rol)
										<option value="{{$rol->id}}">{{$rol->name}}</option>
									@endforeach
								</select>
							</div>							
						</div>

						<div class="col-md-12">
							<label for="{{$prefix}}_user" class="col-form-label">Usuario</label>
							<input class="form-control form-control-sm" type="text" placeholder="Usuario" id="{{$prefix}}_user" name="user">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_password" class="col-form-label">Contraseña</label>
							<input class="form-control form-control-sm" type="password" placeholder="********" id="{{$prefix}}_password" name="password">
						</div>

						<div class="col-md-6">
							<label for="{{$prefix}}_password_confirm" class="col-form-label">Confirma la Contraseña</label>
							<input class="form-control form-control-sm" type="password" placeholder="********" id="{{$prefix}}_password_confirm" name="password_confirm">
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
<script src="{{asset('js/form-elements.js')}}"></script>
<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/script.js")}}'></script>
<!--<script src='{{asset("js/custom.js")}}'></script>-->