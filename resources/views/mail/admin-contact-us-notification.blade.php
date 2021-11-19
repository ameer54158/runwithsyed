<main class="dme-wrapper">
    <div class="container">
        <div style="min-height: 350px;" class="row">
            <div class="col-md-6 offset-md-3 text-center align-self-center">
                <div class="">
                    <img src="{{ asset('public/images/logo.png')}}" alt="Bildelen" style="max-width: 200px;" class="light-logo img-fluid">
                    <h3 class="u-t3 pt-3">
                        Hei,
                    </h3>
                    <p>{{$contact_us->first_name ? $contact_us->first_name : ''}} {{$contact_us->last_name ? $contact_us->last_name : ''}} har sendt inn en henvendelse gjennom kontaktskjema på <a href="{{ url('/')}}">Runwithsyed</a>. Her er detaljene:</p>

                    <p><b>Navn:</b> {{$contact_us->first_name ? $contact_us->first_name : ''}} {{$contact_us->last_name ? $contact_us->last_name : ''}}</p>
                    <p><b>E-post:</b> {{$contact_us->email}}</p>
                    @if($contact_us->telephone)
                        <p><b>Telefon:</b> {{$contact_us->telephone}}</p>
                    @endif
                    <p><b>Emne:</b> {{$contact_us->subject}}</p>
                    @if($contact_us->message)
                        <p><b>Beskjed:</b></p>
                        <p>{{$contact_us->message}}</p>
                    @endif

                    @include('mail.regards-section')
                </div>
            </div>
        </div>
    </div>
</main>
