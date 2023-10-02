@foreach ($funcion as $key => $row)
    @can($row["funcion"].'-'.$dir_submodulo)
        <a href="#" id="btn-{{$row['funcion']}}" data-controller="{{$dir_submodulo}}" 
        @if($row['clase'] == null)
            class="btn btn-outline-default"
        @else
            class="{{$row['clase']}}"
        @endif
        >{{$row['descripcion']}}</a>
    @endcan
@endforeach