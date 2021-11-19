<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;
use Illuminate\Support\Facades\View;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contact_us = ContactUs::when(($request->first_name), function($query) use ($request) {
            if($request->first_name){
                $query->where('first_name', 'LIKE', '%'.$request->first_name.'%');
            }
        })->when(($request->last_name), function($query) use ($request) {
            if($request->last_name){
                $query->where('last_name', 'LIKE', '%'.$request->last_name.'%');
            }
        })->when(($request->email), function($query) use ($request) {
            if($request->email){
                $query->where('email', 'LIKE', '%'.$request->email.'%');
            }
        })->when(($request->telephone), function($query) use ($request) {
            if($request->telephone){
                $query->where('telephone', 'LIKE', '%'.$request->telephone.'%');
            }
        })->when(($request->date_start), function($query) use ($request) {
            if($request->date_start){
                $query->whereDate('created_at','>=',$request->date_start);
            }
        })->when(($request->date_end), function($query) use ($request) {
            if($request->date_end){
                $query->whereDate('created_at','<=',$request->date_end);
            }
        })->orderBy('id','DESC')->get();
        return view('admin.contact-us.list-contact-us',compact('contact_us'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "first_name" => "required",
            "last_name" => "required",
            "subject" => "required",
            "email" => "required|email",
            "message" => "required",
        ]);
        DB::beginTransaction();
        try{
            $contact_us = new ContactUs($request->except('_token'));
            $contact_us->save();

            Mail::send('mail.contact-us',compact('contact_us'), function ($message) use ($contact_us) {
                $message->to($contact_us->email, ($contact_us->first_name.' '.$contact_us->last_name))->subject('RunWithSyed - henvendelse mottatt');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });


            //Send email to info@rws.no
            $admin_email = 'info@rws.no';
            $admin_name = 'Runwithsyed';
            $admin_subject = 'RunWithSyed - '.$request->subject;
            Mail::send('mail.admin-contact-us-notification',compact('contact_us'), function ($message) use ($admin_email,$admin_name,$admin_subject) {
                $message->to($admin_email, $admin_name)->subject($admin_subject);
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            DB::commit();
            flash(__('flash-messages.Contact us form submitted'))->success()->important();
            return back();
        }catch (\Exception $e){
            DB::rollback();
            flash(__('flash-messages.Something went wrong.'))->error()->important();
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact_us_obj = ContactUs::find($id);
        if($contact_us_obj){
            $data = View::make('admin.contact-us.view-contact-us-detail',compact('contact_us_obj'))->render();
            $response = array();
            $response['data'] = $data;
            return json_encode($response);
            exit;
        }else{
            flash('Record not found.')->error()->important();
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact_us = ContactUs::find($id);
        if($contact_us){
            DB::beginTransaction();
            try{
                $contact_us->delete();
                DB::commit();
                flash('Record has been deleted successfully')->success()->important();
                return back();
            }catch (\Exception $e){
                DB::rollback();
                flash('Something went wrong')->error()->important();
                return back();
            }
        }else{
            abort(404);
        }
    }

    //View contact us page at front end site
    public function show_contact_us_page(){
        return view('contact-us');
    }
}
