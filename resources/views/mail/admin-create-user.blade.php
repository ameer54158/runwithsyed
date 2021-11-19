<main class="dme-wrapper">
    <div class="container">
        <div style="min-height: 350px;" class="row">
            <div class="col-md-6 offset-md-3 text-center align-self-center">
                <div class="">
                    <h3 class="u-t3 pt-3">
                        Hei,
                    </h3>
                    <p>
                        Vi vil informere deg om at du er registrert på <strong><a style="text-decoration: none" href="{{ url('/')}}">runwithsyed</a></strong> som <strong>{{$user->hasRole('ambassador') ? 'ambassadør' : ($user->hasRole('sponsor') ? 'sponsor' : 'admin')}}</strong>.</p>
                    <p><b>Her er kontodetaljer</b><br>
                    E-post: {{$user->email}}<br>
                    Passord: {{$org_password}}
                    </p>
                    <p>Vi ønsker deg velkommen på <strong><a style="text-decoration: none" href="{{ url('/')}}">runwithsyed</a></strong>.</p>
                    <p>
                        Du mottar denne eposten fordi du har gjort et viktig valg. Beslutningen du har tatt vil være med på å hjelpe psykisk vanskeligstilte kvinner og barn i Pakistan. For dette er vi svært takknemlig.
                    </p>
                    <p>
                        RunWithSyed er en forening som ønsker at folk flest skal delta i jogge for å bekjempe psykisk lidelse. For hver kilometer som løpes vil det gjøres en donasjon på kr. 1,- Ditt bidrag vil fremme en problemstilling som er tabubelagt samt hjelpe kvinner bekjempe utfordringer i hverdagen med lidelsen.
                    </p>
                    <p>
                        For deg som ambassadør vil du være en frontfigurer for foreningen. Andre medlemmer vil ha muligheten til å gi donasjoner på bakgrunn av de kilometerne du har lagt bak deg. Vi er stolte å ha deg som medlem! Som ambassadør, vil det også komme et kontingent på kr {{$setting_obj->get_value('ambassador_membership_fee') ? $setting_obj->get_value('ambassador_membership_fee') : 200}}. Denne kontingenten vil utelukkende gå til
                        betaling av din RWS ambassadør t-skjorte. T-skjorten blir selvfølgelig din til odel og eie og vi håper du stolt vil bære denne på dine mange løpeturer. Etter at betaling er gjort vil vi ta kontakt med deg angående størrelse og levering av t-skjorten.
                    </p>
                    <p>
                        For deg som sponsor vil du ha muligheten til å velge mellom ulike ambassadører å sponse. De løper distansene og du velger hvem du vil sponse. Du er ikke bundet til samme ambassadør hver måned.
                    </p>
                    <p>
                        Vi tar godt hånd om dine persondata, og behandler de på en trygg måte. Her kan du lese mer om <a style="text-decoration: none" href="{{localized_route('privacy')}}">personvern</a>.
                    </p>
                    @include('mail.regards-section')
                </div>
            </div>
        </div>
    </div>
</main>