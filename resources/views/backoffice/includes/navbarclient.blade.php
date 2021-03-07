<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">


        <a class="nav-link" href="#">
        @if(!empty(Base::logo_backoffice()->url))
                    <img style="max-height: 40px;" id="img_logo" src="{{ url( Base::logo_backoffice()->url  . Base::logo_backoffice()->file) }}" />
        @endif
            </a>
        <?php

        use App\Client; ?>
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }} <i class="fas fa-user navbar-icon"></i>
        </a>
        
        
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" data-parent="#sidebar" href="{{ route('backoffice.myprofile.index') }}">{{ __('Perfil') }}</a>
            
            <a href="#" class="dropdown-item" data-parent="#sidebar">
            <div class="dropdown-divider"></div>
                    <span class="hidden-sm-down">{{ __('Last Access:') }}</span><br>
                    <span class="hidden-sm-down"> {{ Auth::user()->last_login }} </span>
                </a>
                <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="collapsed" data-parent="#sidebar">
            <i class="fas fa-sign-out-alt"></i><span class="hidden-sm-down"> {{ __('Sair') }}</span>
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
</nav>