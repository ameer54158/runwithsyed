@extends('layouts.backend-master')

@section('title', 'Donation detail')

@section('style')
    <style>
        .completed {
            padding: 5px 8px;
            background-color: green;
            color: white;
            font-size: 12px;
            border-radius: 5px;
            font-weight: 500;
        }

        .pending {
            padding: 5px 8px;
            background-color: #e74c3c;
            color: white;
            font-size: 12px;
            border-radius: 5px;
            font-weight: 500;
        }

        .label {
            font-size: 14px;
            font-weight: 500;
            margin: 0;
        }

        .value {
            font-size: 16px;
            font-weight: 500;
            margin: 0;
        }

        .row {
            margin: 6px 0;
            padding: 10px 0;
        }

        .row:nth-child(odd) {
            background: #f1f1f1;
        }

    </style>
@endsection

@section('page-content')
    <!-- Page Content  -->
    <main class="content">
        <div>
            <h4>Donation detail</h4>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            @if($donation->first_name || $donation->last_name)
                <div class="col-lg-2">
                    <label class="label">Name:</label>
                </div>
                <div class="col-lg-4">
                    <label class="value">
                        {{ $donation->first_name && $donation->last_name ? $donation->first_name.' '.$donation->last_name : '' }}
                    </label>
                </div>
            @endif
            <div class="col-lg-2">
                <label class="label">Mobile no:</label>
            </div>
            <div class="col-lg-4">
                <label class="value">
                    {{ $donation->phone ?? '' }}
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <label class="label">Email:</label>
            </div>
            <div class="col-lg-4">
                <label class="value">
                    {{ $donation->email ?? '' }}
                </label>
            </div>

            <div class="col-lg-2">
                <label class="label">Date:</label>
            </div>
            <div class="col-lg-4">
                <label class="value">{{$donation->created_at->format('M d, Y')}}</label>
            </div>
        </div>
        @if($donation->additional_notes || $donation->address)
            <div class="row">
                @if($donation->additional_notes)
                    <div class="col-lg-2">
                        <label class="label">Additional Note:</label>
                    </div>
                    <div class="col-lg-4">
                        <label class="value">
                            {{ $donation->additional_notes ?? '' }}
                        </label>
                    </div>
                @endif
                @if($donation->address)
                    <div class="col-lg-2">
                        <label class="label">Address:</label>
                    </div>
                    <div class="col-lg-4">
                        <label class="value"><span>{{ $donation->address ?? '' }}</span></label>
                    </div>
                @endif
            </div>
        @endif
        <div class="row">
            <div class="col-lg-2">
                <label class="label">Amount:</label>
            </div>
            <div class="col-lg-4">
                <label class="value">{{number_format($donation->amount,'2',',','.')}} kr</label>
            </div>
            <div class="col-lg-2">
                <label class="label">Status:</label>
            </div>
            <div class="col-lg-4">
                <label class="value"><span class="{{$donation->status}}">{{ucfirst($donation->status)}}</span></label>
            </div>
        </div>
    </main>
@endsection
