<nav class="sidebar">
    <ul class="list-unstyled components">
        <li class="{{Route::current()->getName() == 'admin.dashboard' ? 'active' : ''}}">
            <a href="{{route('admin.dashboard')}}"><i class="fa fa-tachometer-alt fa-fw"></i> Dashboard</a>
        </li>

        <li class="{{Route::current()->getName() == 'admin.payments' ? 'active' : ''}}">
            <a href="{{route('admin.payments')}}"><span style="font-size: 16px;font-weight: 500;padding-right: 5px;">kr</span> Payments</a>
        </li>
        <!--  <li>
             <a href="profile.html"><i class="far fa-user"></i> Profile</a>
         </li> -->
        {{--{{dd(Route::current()->getName())}}--}}
        <li class="{{Route::current()->getName() == 'admin.users.index' ? 'active' : ''}}">
            <a href="{{route('admin.users.index')}}"><i class="fas fa-users fa-fw"></i> Users</a>
        </li>

        <li class="{{Route::current()->getName() == 'admin.donations.index' ? 'active' : ''}}">
            <a href="{{route('admin.donations.index')}}"><span style="font-size: 16px;font-weight: 500;padding-right: 5px;">kr</span> Donations</a>
        </li>

        <li class="{{Route::current()->getName() == 'admin.initiators.index' || Route::current()->getName() == 'admin.initiators.create' ? 'active' : ''}}">
            <a href="{{route('admin.initiators.index')}}"><i class="fas fa-info fa-fw"></i> Initiators</a>
        </li>

        <li class="{{Route::current()->getName() == 'admin.news.index' || Route::current()->getName() == 'admin.news.create' ? 'active' : ''}}">
            <a href="{{route('admin.news.index')}}"><i class="fab fa-neos fa-fw"></i> News</a>
        </li>
        <li class="{{Route::current()->getName() == 'admin.settings' ? 'active' : ''}}">
            <a href="{{route('admin.settings')}}"><i class="fas fa-cog fa-fw"></i> Settings</a>
        </li>
        <li class="{{Route::current()->getName() == 'admin.contact-us.index' ? 'active' : ''}}">
            <a href="{{route('admin.contact-us.index')}}"><i class="far fa-paper-plane fa-fw"></i> Contact us</a>
        </li>
    </ul>
</nav>