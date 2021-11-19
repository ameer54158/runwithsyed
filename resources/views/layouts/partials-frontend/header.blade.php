<div class="header-container">
    <div class="container">
        <header class="blog-header py-3">
            <div class="row ">
                <!--        <div class="row flex-nowrap justify-content-between align-items-center">-->
                <!--            <div class="col-4 pt-1">-->
                <!---->
                <!--            </div>-->
                <div class="offset-lg-4 col-lg-4 col-md-6 col-sm-6 text-center d-flex justify-content-center d-flex align-content-center flex-wrap head-left">
                    <a class="blog-header-logo text-dark" href="{{url('/')}}"><img src="{{asset('public/images/logo-svg.svg')}}" alt="logo"></a>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 d-flex align-content-end flex-wrap d-flex justify-content-end head-right">
                    <span class="float-right lang-section {{!Auth::check() ? (app()->getLocale() == 'nb' ? 'not_login_nb_lang_section' : 'not_login_en_lang_section') : ''}}"><span class="select-lan-label ">{{ __('header.select-language') }}:</span>
                        <a class="btn btn-sm lang-norsk {{app()->getLocale() == 'nb' ? 'active_lang' : ''}}" href="{{route('change-lang','nb')}}">{{ __('header.norwegian') }}</a>
                        {{--<a class="btn btn-sm lang-norsk {{app()->getLocale() == 'nb' ? 'active_lang' : ''}}" data-value="nb" data-url="{{route('change-lang')}}" href="javascript:void(0);">{{ __('header.norwegian') }}</a>--}}
                        <a class="btn btn-sm lang_en {{app()->getLocale() == 'en' ? 'active_lang' : ''}}"    href="{{route('change-lang','en')}}">{{ __('header.english') }}</a>
                        {{--<a class="btn btn-sm lang_en {{app()->getLocale() == 'en' ? 'active_lang' : ''}}" data-value="en" data-url="{{route('change-lang')}}" href="javascript:void(0);">{{ __('header.english') }}</a>--}}
                    </span>
                    @if(Auth::check())
                        <div class="auth_user_btn_section">

                            <a class="btn btn-sm log-btn float-right" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> &emsp;<i class="fas fa-sign-out-alt icon"></i><span class="login-text">Logg ut</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm log-btn float-right">&emsp;
                                    <i class="fa fa-tachometer-alt icon"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ localized_route('profile') }}" class="btn btn-sm log-btn float-right">&emsp;
                                    <i class="far fa-user icon"></i> Min profil
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="login_btn_section">
                            <a class="btn btn-sm log-btn pr-0 float-right" href="{{route('login')}}"> &emsp;<i class="far fa-user icon"></i><span class="login-text">Logg inn</span></a>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </header>

        <div class="nav-scroller py-1 mb-2">
            <nav class="navbar navbar-expand-lg">
                {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button> --}}
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link {{Route::current()->getName() == 'home' ? 'active' : ''}}" href="{{url('/')}}">{{ __('header.home') }}</a>
                        <a class="nav-item nav-link {{Route::current()->getName() == 'nb.about-us' || Route::current()->getName() == 'en.about-us' ? 'active' : ''}}" href="{{localized_route('about-us')}}">{{ __('header.about-us') }}</a>
                        <a class="nav-item nav-link {{Route::current()->getName() == 'nb.engage-yourself' || Route::current()->getName() == 'en.engage-yourself' ? 'active' : ''}}" href="{{localized_route('engage-yourself')}}">{{ __('header.engage-yourself') }}</a>
                        <a class="nav-item nav-link {{Route::current()->getName() == 'nb.list-news' || Route::current()->getName() == 'en.list-news' ? 'active' : ''}} {{Route::current()->getName() == 'nb.single-news' || Route::current()->getName() == 'en.single-news' ? 'active' : ''}}" href="{{localized_route('list-news')}}">{{ __('header.news') }}</a>
                        <a class="nav-item nav-link {{Route::current()->getName() == 'nb.our-ambassadors' || Route::current()->getName() == 'en.our-ambassadors' ? 'active' : ''}}" href="{{localized_route('our-ambassadors')}}">{{ __('header.our-ambassadors') }}</a>
                        <a class="nav-item nav-link {{Route::current()->getName() == 'nb.meet-initiators' || Route::current()->getName() == 'en.meet-initiators' ? 'active' : ''}}" href="{{localized_route('meet-initiators')}}">{{ __('header.meet-initiators') }}</a>
                        <a class="nav-item nav-link {{Route::current()->getName() == 'nb.contact-us' || Route::current()->getName() == 'en.contact-us' ? 'active' : ''}}" href="{{localized_route('contact-us')}}">{{ __('header.contact') }}</a>

                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>