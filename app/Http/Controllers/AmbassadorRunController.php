<?php

namespace App\Http\Controllers;

use App\Helpers\common;
use App\Models\AmbassadorRun;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class AmbassadorRunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'distance' => 'required',
            'date' => 'required',
        ]);
        DB::beginTransaction();
        try{

            $request->merge(['user_id'=>Auth::id()]);
            $runs = new AmbassadorRun($request->except('_token','proof'));
            $runs->save();
            //saved ambassador runs proof image
            if($request->proof){
                common::update_media($request->proof,$runs->id,AmbassadorRun::class,'proof');
            }
            DB::commit();
            Session::flash('message', __('flash-messages.Runs saved'));
            Session::flash('alert-class', 'alert-success');
            $total_runs = Auth::user()->current_month_runs->count() ? Auth::user()->current_month_runs->sum('distance') : 0;
            $arr = array('status'=>true,'message'=>__('flash-messages.Runs saved'),'total_runs'=>$total_runs);

            return json_encode($arr);
        }catch (\Exception $e){
            DB::rollback();
            Session::flash('message', __('flash-messages.Something went wrong.'));

            Session::flash('alert-class', 'alert-danger');
            $arr = array('status'=>false,'message'=>__('flash-messages.Something went wrong.'));
            return json_encode($arr);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $runs = AmbassadorRun::find($id);
        if($runs){
            $data = View::make('ambassadors.edit-ambassador-runs',compact('runs'))->render();
            $response = array();
            $response['data'] = $data;
            return json_encode($response);
            exit;
        }else{
            abort(404);
        }
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
        $runs = AmbassadorRun::find($id);
        if($runs){
            $validatedData = $request->validate([
                'distance' => 'required',
                'date' => 'required',
            ]);
            DB::beginTransaction();
            try{
                if(date('m',strtotime($runs->date)) != date('m')){
                    $request->request->remove('date');
                }
                $runs->update($request->except('_token','proof'));

                //saved and update ambassador runs image proof
                if($request->proof){
                    common::update_media($request->proof,$runs->id,AmbassadorRun::class,'proof','',true);
                }

                DB::commit();
                flash(__('flash-messages.Runs updated'))->success()->important();
                return back()->with(['show_tab'=>'history']);
            }catch (\Exception $e){
                DB::rollback();
                flash(__('flash-messages.Something went wrong.'))->error()->important();
                return back()->with(['show_tab'=>'history']);
            }

        }else{
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $runs = AmbassadorRun::find($id);
        if($runs){
            DB::beginTransaction();
            try{
                //delete media
                common::delete_media($runs->id,AmbassadorRun::class,'proof');
                $runs->delete();
                DB::commit();
                flash(__('flash-messages.Runs deleted'))->success()->important();
                return back()->with(['show_tab'=>'history']);
            }catch (\Exception $e){
                DB::rollback();
                flash(__('flash-messages.Something went wrong.'))->error()->important();
                return back()->with(['show_tab'=>'history']);
            }
        }else{
            abort(404);
        }
    }
}
