<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Módulo</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.html">Módulo</a></li>
                    <li><span>Submódulo</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            <div class="user-profile pull-right">
                <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                <h4 class="user-name dropdown-toggle" data-toggle="dropdown">Isaias Lopez<i class="fa fa-angle-down"></i></h4>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Perfil</a>
                    <a class="dropdown-item text-center" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();" role="button">
                    <i class="dropdown-icon ti-power-off"></i> Cerrar Sesi&oacute;n
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </div>
            </div>
        </div>
    </div>
</div>