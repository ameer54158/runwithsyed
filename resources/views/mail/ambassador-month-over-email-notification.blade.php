<main class="dme-wrapper">
    <div class="container">
        <div style="min-height: 350px;" class="row">
            <div class="col-md-6 offset-md-3 text-center align-self-center">
                <div class="">
                    <h3 class="u-t3 pt-3">
                        Hei,
                    </h3>
                    <p>Vi ønsker med dette informere deg om at du nå kan betale for <strong>{{\App\Helpers\common::date_in_locale_lang(('01-'.$month_name),'M Y','nb')}}</strong> månedlig betaling.</p>
                    <p>Vennligst logg inn med din bruker og betal ved å klikke her: <a href="{{route('login')}}" target="_blank">{{route('login')}}</a></p>
                    <p>Runwithsyed takker for din støtte.</p>
                    @include('mail.regards-section')
                </div>
            </div>
        </div>
    </div>
</main>