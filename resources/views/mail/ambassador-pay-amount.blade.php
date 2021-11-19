<main class="dme-wrapper">
    <div class="container">
        <div style="min-height: 350px;" class="row">
            <div class="col-md-6 offset-md-3 text-center align-self-center">
                <div class="">
                    <h3 class="u-t3 pt-3">
                        Hei,
                    </h3>
                    <p>
                        Vi vil informere deg om at du har betalt <strong>{{number_format($payment->amount,'2',',','.')}}kr</strong>
                        @if($payment->ambassador_payment->count() > 1)
                            for de neste månedene.
                            <ul style="padding-left: 10px;">
                                @foreach($payment->ambassador_payment as $ambassador_payment)
                                    <strong><li>{{\App\Helpers\common::date_in_locale_lang(('01-'.$ambassador_payment->month_year),'M Y','nb')}}</li></strong>
                                @endforeach

                            </ul>
                        @else
                            for <strong>{{\App\Helpers\common::date_in_locale_lang(('01-'.$payment->ambassador_payment->first()->month_year),'M Y','nb')}}</strong> måneden.
                        @endif
                        Runwithsyed takker for din støtte.
                    </p>

                    @include('mail.regards-section')
                </div>
            </div>
        </div>
    </div>
</main>