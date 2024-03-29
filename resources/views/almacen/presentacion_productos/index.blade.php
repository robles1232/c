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
                <!--END ACTUALIZAR -->
                <div class="card-options card_options">
                    <div class="btn-list">
                        @include('layouts.botones',['$dir_submodulo' => "$dir_submodulo"])
                    </div>
                </div>
            </div>
			<div class="card-body pdd_card_body">
				<div class="table-responsive">
					<table id="dt-{{$dir_submodulo}}" realid="{{$dir_submodulo}}" class="table table-striped databale table-bordered text-nowrap w-100">
						<thead>
							<tr>
								<th width="05%">#</th>
								<th width="70%">Presentación de productos</th>
								<th width="20%"></th>
								<th width="05%">Estado</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
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

<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/index.js")}}'></script>
<script src='{{asset("js/views/$dir_modulo/$dir_submodulo/form.js")}}'></script>
@endsection
@endsection
