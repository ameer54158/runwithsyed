<footer>
    <section class="footer container">
        <div class="d-flex justify-content-between">

            @if(App\Helpers\common::site_setting('organization_no'))
                <div class="">
                    <span><i class="fas fa-university fa-lg"></i></span>
                    <span class="link"><span style="color: black">Org.nr. </span>{{ App\Helpers\common::site_setting('organization_no') }}</span>
                </div>
            @endif

            @if(App\Helpers\common::site_setting('contact_us_phone'))
            <div class="">
                <a href="tel:{{ App\Helpers\common::site_setting('contact_us_phone') }}">
                    <span><i class="fas fa-phone fa-lg"></i></span>
                    <span class="link">{{ App\Helpers\common::site_setting('contact_us_phone') }}</span>
                </a>
            </div>
            @endif
            @if(App\Helpers\common::site_setting('contact_us_email'))
            <div class="">
                <a href="mailto:{{ App\Helpers\common::site_setting('contact_us_email') }}">
                    <span><i class="fas fa-envelope fa-lg"></i></span>
                    <span class="link">{{ App\Helpers\common::site_setting('contact_us_email') }}</span>
                </a>
            </div>
            @endif
            @if(App\Helpers\common::site_setting('contact_us_website'))
                <div class="">
                    <a href="{{url('/')}}">
                        <span><i class="fas fa-globe fa-lg"></i></span>
                        <span class="link">{{ App\Helpers\common::site_setting('contact_us_website') }}</span>
                    </a>
                </div>
            @endif
            <div class="privacy  line w-auto">
                <span class="link border_bottom"><a href="{{localized_route('privacy')}}" style="color: #668f6b;">{{__('general.privacy')}}</a></span>
            </div>

            <div class="">
                <span class="link border_bottom"><a href="{{localized_route('terms-of-sale')}}" style="color: #668f6b;">{{__('general.terms of sale')}}</a></span>
            </div>
        </div>
        <div class="copy-right">
            <i class="far fa-copyright"></i> <span class="site-title">RunWithSyed</span> <span class="company-detail" style="padding-left: 10px;">Utviklet av <a class="text-decoration-none" target="_blank" href="https://digitalmx.no/">Digital MedieXpert</a></span>
        </div>
    </section>
</footer>