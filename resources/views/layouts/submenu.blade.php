<ul>
    @foreach($submenu as $key => $submodulo)
        <li>
            <a href="{{$submodulo['url']}}">{{$submodulo['text']}}</a>
        </li>
    @endforeach
</ul>