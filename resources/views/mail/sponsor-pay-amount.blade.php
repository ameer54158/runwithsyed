<main class="dme-wrapper">
    <div class="container">
        <div style="min-height: 350px;" class="row">
            <div class="col-md-6 offset-md-3 text-center align-self-center">
                <div class="">
                    <h3 class="u-t3 pt-3">
                        Hei,
                    </h3>
                    <p>
                        Vi vil informere deg om at du har sponset din ambassadør
                        <strong>
                            {{$sponsor_payment->sponsor_ambassador && $sponsor_payment->sponsor_ambassador->ambassador_user &&
                                    $sponsor_payment->sponsor_ambassador->ambassador_user->first_name ? $sponsor_payment->sponsor_ambassador->ambassador_user->first_name : '' }}
                            {{$sponsor_payment->sponsor_ambassador && $sponsor_payment->sponsor_ambassador->ambassador_user &&
                            $sponsor_payment->sponsor_ambassador->ambassador_user->last_name ? $sponsor_payment->sponsor_ambassador->ambassador_user->last_name : '' }}
                        </strong>
                        med
                        <strong>{{number_format($sponsor_payment->payment->amount,'2',',','.')}}kr</strong>

                        @if($payment->sponsor_payment->count() > 1)
                            for de neste månedene.
                            <ul style="padding-left: 10px;">
                                @foreach($payment->sponsor_payment as $sponsor_payment)
                                    <strong><li>{{\App\Helpers\common::date_in_locale_lang(('01-'.$sponsor_payment->month_year),'M Y','nb')}}</li></strong>
                                @endforeach
                            </ul>
                        @else
                            for <strong>{{\App\Helpers\common::date_in_locale_lang(('01-'.$payment->sponsor_payment->first()->month_year),'M Y','nb')}}</strong> måneden.
                        @endif
                        Runwithsyed takker for støtten.
                    </p>

                    @include('mail.regards-section')
                </div>
            </div>
        </div>
    </div>
</main>