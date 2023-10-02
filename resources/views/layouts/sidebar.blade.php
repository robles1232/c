<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="index.html"><img src="assets/images/icon/logo.png" alt="logo"></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                
                <ul class="metismenu" id="menu">
                    @foreach($menu as $key => $row)
                        <li>
                            @if(count($row["submenu"]) > 0)
                                <a href="javascript:void(0)">
                                    <i class="{{$row['icono']}}"></i>
                                    <span>{{$row['text']}}</span>
                                </a>
                                @include('layouts.submenu', ["submenu" => $row["submenu"]])
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</div>