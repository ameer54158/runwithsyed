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
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
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

    <tr>
        <td><strong>{{__('profile.num of km of this month')}}:</strong> {{$user->current_month_runs->count() ? $user->current_month_runs->sum('distance') : 0}} km</td>
    </tr>
</table>

<br/>

<table width="100%" class="runs-table">
    <thead style="background-color: lightgray;">
    <tr>
        <th>#</th>
        <th>{{__('general.proof')}}</th>
        <th>{{__('general.num of km')}}</th>
        <th>{{__('general.date')}}</th>
    </tr>
    </thead>
    <tbody>
    @if($user_runs->count())
        @foreach($user_runs as $key=>$user_run)
            <tr>
                <th>{{$key+1}}</th>
                <td align="center">
                    <img style="height: 50px; width: 50px" src="{{$user_run->proof ? asset(\App\Helpers\common::getMediaPath($user_run->proof)) : asset('public/images/no-image.png')}}">
                </td>
                <td align="center">{{$user_run->distance}}</td>
                <td align="center">{{\App\Helpers\common::date_in_locale_lang(($user_run->date),'M d, Y')}}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4"><p style="text-align: center; color: white; background: #f86063; margin: 0 10px;height: 20px; padding: 10px 0; font-size: 16px; border-radius: 5px">{{__('general.no any record found')}}</p></td>
        </tr>
    @endif
    </tbody>
    <tfoot>

    </br>
    <tr>
        <td colspan="1"></td>
        <td align="center">{{__('profile.total km')}}</td>
        <td align="center">{{$user_runs->count() ? $user_runs->sum('distance') : 0}} km</td>
        <td></td>
    </tr>
    </tfoot>
</table>

</body>
</html>