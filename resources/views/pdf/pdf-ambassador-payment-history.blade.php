<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Runwithsyed</title>

    <style type="text/css">
        * {
            font-family: 'Ubuntu', sans-serif;
        }

        table {
            font-size: x-small;
            border-collapse: collapse;
        }
        .runs-table table, .runs-table td, .runs-table th {
            border: 1px solid black;
            padding: 8px 0;
            font-size: 12px;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
        .completed{
            color: darkgreen;
            font-weight: 500;
            font-size: 14px;
        }
        .Pending{
            color: gray;
            font-weight: 500;
            font-size: 14px;
        }

    </style>

</head>
<body>

<table width="100%">
    <tr>
        <td valign="top"><img src="{{asset('public/images/logo.png')}}" alt="Logo" width="150"/></td>
    </tr>

</table>
<br/>
<table width="100%">
    <tr>
        <td><strong>{{__('profile.name')}}:</strong> {{ $user->first_name." ".$user->last_name }}</td>
        <td><strong>{{ __('profile.email') }}:</strong> {{ $user->email }}</td>
        <td><strong>{{__('profile.mobile no')}}:</strong> {{ $user->mobile_no }}</td>
    </tr>

    <tr>
        <td><strong>{{__('profile.gender')}}:</strong> {{$user->detail->gender === 'male' ? (__('register.male')) : (__('register.female'))}}</td>
        @if($user->detail && $user->detail->zip_city)
            <td><strong>{{ __('profile.city') }}:</strong> {{$user->detail->zip_code.' '.$user->detail->zip_city}}</td>
        @endif
        @if($user->detail && $user->detail->zip_code)
            <td><strong>{{ __('profile.postnummer') }}:</strong> {{$user->detail->zip_code.' '.$user->detail->zip_city}}</td>
        @endif
    </tr>

    @if($user->detail && $user->detail->address)
        <tr>
            <td><strong>{{ __('profile.address') }}:</strong> {{$user->detail->address}}</td>
        </tr>
    @endif

</table>

<br/>

<table width="100%" class="runs-table">
    <thead style="background-color: lightgray;">
    <tr>
        <th>#</th>
        <th>{{__('profile.order id')}}</th>
        <th>{{__('profile.transaction id')}}</th>
        <th>{{__('profile.paying date')}}</th>
        <th>{{__('profile.pay amount')}}</th>
        <th>{{__('profile.paying month')}}</th>
        <th>{{__('profile.status')}}</th>
    </tr>
    </thead>
    <tbody>
    @if($ambassador_payments->count())
        @foreach($ambassador_payments as $ambassador_payment_key=>$ambassador_payment)
            <tr>
                <th scope="row">{{$ambassador_payment_key+1}}</th>
                <td align="center">{{$ambassador_payment->order_id}}</td>
                <td align="center">{{$ambassador_payment->transaction_id}}</td>
                <td align="center">{{\App\Helpers\common::date_in_locale_lang(($ambassador_payment->created_at->format('M d, Y')),'M d, Y')}}</td>
                <td align="center">{{$ambassador_payment ? number_format($ambassador_payment->amount,'2',',','.') : ''}}</td>
                <td align="center">
                    @if($ambassador_payment->ambassador_payment->count())
                        <ul>
                            @foreach($ambassador_payment->ambassador_payment as $ambassador_payment_obj)
                                <li>
                                    {{ \App\Helpers\common::date_in_locale_lang(('01-'.$ambassador_payment_obj->month_year),'M Y') }}
                                    {{Auth::user() && Auth::user()->runs ? '('.Auth::user()->runs->whereBetween('date',[(date('Y-m-d',strtotime('01-'.$ambassador_payment_obj->month_year))),(date('Y-m-t',strtotime('01-'.$ambassador_payment_obj->month_year)))])->sum('distance').' Km)' : ''}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td align="center">
                    <span class="{{$ambassador_payment ? $ambassador_payment->status : ''}}">{{$ambassador_payment ? (__('profile.'.$ambassador_payment->status)): ''}}</span>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7"><p style="text-align: center; color: white; background: #f86063; margin: 0 10px;height: 20px; padding: 10px 0; font-size: 16px; border-radius: 5px">{{__('general.no any record found')}}</p></td>
        </tr>
    @endif
    </tbody>
</table>

</body>
</html>