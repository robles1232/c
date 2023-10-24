@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <!--STAR ACTUALIZAR -->
                <h3 class="card-title">
                    Lista de {{$submodulo}}<span onclick="" class="btn-actualizar">
                        <!--<span class="right badge badge-primary">
                            Actualizar <i class="mdi mdi-atom"></i>
                        </span>-->
                    </span>
                </h3>
            </div>
            <div class="card-body pdd_card_body row">
                <div class="col-md-6 col-lg-6">
                    <div class="card-header">
                        <div class="card-title">Rol</div>
                    </div>
                    <form id="form-{{$dir_submodulo}}" onsubmit="guardar_accesos(event)">
                    <div class="card-body">
                        <div class="col-md-12 col-lg-12">
                            <label for="{{$prefix}}_idrol" class="col-form-label">Rol</label>

                            <div class="select2-{{$prefix}}_idrol">
                                <select name="idrol" id="{{$prefix}}_idrol" class="form-control select2">
                                    <option label="Seleccionar el rol"></option>
                                    @foreach($roles as $rol)
                                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 pt-0">
                        <button type="submit" id="btn-save" onclick="guardar_accesos(event)" class="btn btn-primary w-100" data-acciones="guardar-{{$dir_submodulo}}">Guardar</button>
                    </div>
                    </form>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card-header">
                        <div class="card-title">Lista de Accesos y permisos</div>
                        <div class="card-body">
                            <div id="{{$prefix}}_jstree"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="div_md-{{$dir_submodulo}}"></div>
@section('script')
<script type="text/javascript">
    let _path_controller_{{$path_controller}}   = "{{$path_controller}}"
    let _modulo_{{$path_controller}}            = "{{$modulo}}"
    let _submodulo_{{$path_controller}}         = "{{$submodulo}}"
    let _dir_modulo_{{$path_controller}}        = "{{$dir_modulo}}"
    let _dir_submodulo_{{$path_controller}}     = "{{$dir_submodulo}}"
    let _table_{{$path_controller}}             = "{{$table}}"   
    let _prefix_{{$path_controller}}            = "{{$prefix}}"
</script>

<script src="{{asset('js/form-elements.js')}}"></script>
<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/index.js")}}'></script>
<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/form.js")}}'></script>
@endsection
@endsection