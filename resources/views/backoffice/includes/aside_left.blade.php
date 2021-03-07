<nav id="sidebar">
    <div class="sidebar-header">
        <div id="sidebar-brand-mage" class="text-center">
            <a class="left-logo" href="#">
                @if(!empty(Base::logo_backoffice()->url))
                <img id="left-logo-img"
                    src="{{ url( Base::logo_backoffice()->url  . Base::logo_backoffice()->file) }}" />
                @endif
            </a>
        </div>

    </div>
    <ul class="list-unstyled components" id="menu-left">
        
        @if(Auth::user()->hasAnyPermissionsOrRole(['view_users','view_roles', 'view_loginactivity',
        'view_permissions']))
        <li>
            <a href="{{route('backoffice.index')}}">
                <i class="fas fa-utensils"></i>
                <span class="hidden-sm-down"> {{ __('I Can Eat...') }}</span>
            </a>
            <a href="#pageSubmenuUsers" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-tools"></i>
                <span class="hidden-sm-down"> {{ __('Settings') }}</span>
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenuUsers" data-parent="#menu-left">
                @if(Auth::user()->hasPermissionsOrRole(['view_users']))
                <li><a href="{{ route('backoffice.users.index') }}">{{ __('Users') }}</a></li>@endif
                @if(Auth::user()->hasPermissionsOrRole(['view_recipes']))
                <li><a href="{{ route('recipes.index') }}">{{ __('Recipes') }}</a></li>@endif
                @if(Auth::user()->hasPermissionsOrRole(['view_pathologies']))
                <li><a href="{{ route('pathologies.index') }}">{{ __('Pathologies') }}</a></li>@endif
            </ul>
        </li>
        @endif

        <hr>
        <li>
            <a href="#pageSubmenuProfile" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-user"></i>
                <span class="hidden-sm-down">{{ Auth::user()->name }}</span>
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenuProfile" data-parent="#menu-left">
                <a class="collapsed" data-parent="#sidebar"
                    href="{{ route('backoffice.profile.index') }}">{{ __('My Account') }}</a>
                <a class="collapsed" data-parent="#sidebar"
                    href="{{ route('user.health.show', auth()->user()->id) }}">{{ __('My Health') }}</a>
                <a href="#" class="collapsed" data-parent="#sidebar">
                    <span class="hidden-sm-down">{{ __('Last Access:') }}</span><br>
                    <span class="hidden-sm-down"> {{ Auth::user()->last_login }} </span>
                </a>
            </ul>
        </li>
        <li>
            <a href="{{ url('/logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="collapsed"
                data-parent="#sidebar">
                <i class="fas fa-sign-out-alt"></i><span class="hidden-sm-down"> {{ __('Sair') }}</span>
            </a>

        </li>
    </ul>
</nav>
