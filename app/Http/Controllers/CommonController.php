<?php

namespace App\Http\Controllers;

use App\Models\Initiator;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class CommonController extends Controller
{
    //About us page
    public function about_us(){
        $setting = new Setting();
        return view('about-us', compact('setting'));
    }

    //Engage yourself page
    public function engage_yourself(){
        $setting = new Setting();
        return view('engage-yourself',compact('setting'));
    }

    //Admin dashboard
    public function admin_dashboard(Request $request){
        $users = User::when(($request->start_date), function($query) use ($request) {
            if($request->start_date){
                $query->whereDate('created_at','>=',$request->start_date);
            }
        })->when(($request->end_date), function($query) use ($request) {
            if($request->end_date){
                $query->whereDate('created_at','<=',$request->end_date);
            }
        })->orderBy('id','DESC')->get();

        $ambassadors = User::whereHas('roles',function ($query){
            $query->where('roles.slug','ambassador');
        })->when(($request->start_date), function($query) use ($request) {
            if($request->start_date){
                $query->whereDate('created_at','>=',$request->start_date);
            }
        })->when(($request->end_date), function($query) use ($request) {
            if($request->end_date){
                $query->whereDate('created_at','<=',$request->end_date);
            }
        })->orderBy('id','DESC')->get();

        $sponsors = User::whereHas('roles',function ($query){
            $query->where('roles.slug','sponsor');
        })->when(($request->start_date), function($query) use ($request) {
            if($request->start_date){
                $query->whereDate('created_at','>=',$request->start_date);
            }
        })->when(($request->end_date), function($query) use ($request) {
            if($request->end_date){
                $query->whereDate('created_at','<=',$request->end_date);
            }
        })->orderBy('id','DESC')->get();

        $initiators = Initiator::when(($request->start_date), function($query) use ($request) {
            if($request->start_date){
                $query->whereDate('created_at','>=',$request->start_date);
            }
        })->when(($request->end_date), function($query) use ($request) {
            if($request->end_date){
                $query->whereDate('created_at','<=',$request->end_date);
            }
        })->orderBy('id','DESC')->get();

        $total_sales = Payment::where('status','completed')->when(($request->start_date), function($query) use ($request) {
            if($request->start_date){
                $query->whereDate('created_at','>=',$request->start_date);
            }
        })->when(($request->end_date), function($query) use ($request) {
            if($request->end_date){
                $query->whereDate('created_at','<=',$request->end_date);
            }
        })->get();

        $start_date = isset($request->start_date) && $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = isset($request->end_date) && $request->end_date ? $request->end_date : date('Y-m-t');
        $current_month_sales = Payment::selectRaw(DB::raw("SUM(amount) as sum, date(created_at) date"))
            ->groupBy(DB::raw("date(created_at)"))->where('status','completed')
            ->whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date)
            ->orderBy("date",'ASC')->get();

        if(isset($request->export_users) && $request->export_users == 'yes'){
            return Excel::download(new \App\Exports\User($users), 'users.xlsx');
        }

        return view('admin.dashboard',compact('ambassadors','sponsors','initiators','total_sales','current_month_sales'));
    }
}
