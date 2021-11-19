<script type="text/javascript">
    if (typeof(Storage) !== "undefined" && localStorage.getItem("collapse-sidebar") != null) {
        document.body.classList.add('collapse-sidebar');
    }
</script>
<header>
    <nav class="navbar navbar-expand fixed-top">
        <a href="{{url('/')}}" class="float-left text-white">
            <h5 class="brand-lg m-0">Runwithsyed</h5>
            <strong class="brand-sm">RWS</strong>
        </a>
        <a href="javascript:;" class="text-white ml-4" id="sidebarCollapse">
            <i class="fa fa-align-left text-muted"></i>
            <!-- <span>Toggle Sidebar</span> -->
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown mx-1">
                <span id="generic-loader" class="text-white nav-link" style="display: none"><i class="fa fa-spinner fa-spin fa-lg"></i></span>
            </li>
            <li class="nav-item dropdown mx-1">
                <a href="{{url('/')}}" class="nav-link"><i class="fa fa-home fa-lg"></i></a>
            </li>
            <li class="nav-item dropdown mx-1">
                <a href="javascript:;" class="nav-link dropdown-toggle collapsed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle fa-lg"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('edit-profile',Auth::id())}}"><i class="fa fa-user mr-2"></i> Profile</a>
                    <a class="dropdown-item" href="{{route('admin.settings')}}"><i class="fa fa-cog mr-2"></i> Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-unlock-alt mr-2"></i>
                        {{ __('Logg ut') }}</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </nav>
</header>