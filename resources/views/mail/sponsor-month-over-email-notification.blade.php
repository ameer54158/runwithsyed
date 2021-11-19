<main class="dme-wrapper">
    <div class="container">
        <div style="min-height: 350px;" class="row">
            <div class="col-md-6 offset-md-3 text-center align-self-center">
                <div class="">
                    <h3 class="u-t3 pt-3">
                        Hei,
                    </h3>
                    <p>
                        Vi vil med dette informere deg om at du nå kan logge inn og betale for <strong>{{\App\Helpers\common::date_in_locale_lang(('01-'.$month_name),'M Y','nb')}}</strong>. Dette gjelder ambassadøren
                        <strong>{{$ambassador_user->first_name ? $ambassador_user->first_name : ''}} {{$ambassador_user->last_name ? $ambassador_user->last_name : ''}}</strong>
                        som du sponser.
                    </p>
                    <p>Vennligst betal gjerne i dag!</p>
                    <p><strong><a href="{{route('login')}}" target="_blank">Klikk her for å logge inn</a></strong></p>
                    <p>Runwithsyed takker for din støtte.</p>
                    @include('mail.regards-section')
                </div>
            </div>
        </div>
    </div>
</main>