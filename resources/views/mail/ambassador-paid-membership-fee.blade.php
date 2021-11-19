<main class="dme-wrapper">
    <div class="container">
        <div style="min-height: 350px;" class="row">
            <div class="col-md-6 offset-md-3 text-center align-self-center">
                <div class="">
                    <h3 class="u-t3 pt-3">
                        Hei,
                    </h3>
                    <p>Vi vil informere deg om at du har betalt <strong>{{number_format($amount,'2',',','.')}}kr</strong> medlemsavgift for T-skjorte.</p>
                    @include('mail.regards-section')
                </div>
            </div>
        </div>
    </div>
</main>