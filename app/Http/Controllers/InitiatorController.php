<?php

namespace App\Http\Controllers;

use App\Helpers\common;
use App\Models\Initiator;
use Illuminate\Http\Request;
use DB;

class InitiatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $initiators = Initiator::orderBy('order','ASC')->get();
        return view('admin.initiators.list-initiators',compact('initiators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $initiator = new Initiator();
        return view('admin.initiators.create-or-update-initiator',compact('initiator'));
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
            'name' => 'required',
            'description_en' => 'required',
            'description_no' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $last_initiator = Initiator::orderBy('order','DESC')->first();
            $order = $last_initiator && $last_initiator->order ? $last_initiator->order : 0;
            $request->merge(['order'=>++$order]);
            $initiator = new Initiator($request->except('_token','image','deleted_media'));
            $initiator->save();

            //saved initiator image
            if($request->image){
                common::update_media($request->image,$initiator->id,Initiator::class,'image',$initiator->image_size());
            }

            DB::commit();
            flash('Initiator has been created successfully.')->success()->important();
            return redirect()->route('admin.initiators.index');
        }catch (\Exception $e){
            DB::rollback();
            flash('Something went wrong.')->error()->important();
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
        $initiator = Initiator::find($id);
        if($initiator){
            return view('admin.initiators.create-or-update-initiator',compact('initiator'));
        }else{
            flash('Record not found.')->error()->important();
            return back();
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
        $initiator = Initiator::find($id);
        if($initiator){
            $validatedData = $request->validate([
                'name' => 'required',
                'description_en' => 'required',
                'description_no' => 'required',
            ]);
            DB::beginTransaction();
            try{
                $initiator->update($request->except('_token','image','deleted_media'));
                //saved initiator image
                if($request->image){
                    common::update_media($request->image,$initiator->id,Initiator::class,'image',$initiator->image_size(),true);
                }
                //delete media
                if($request->deleted_media){
                    common::delete_single_uploaded_image($request->deleted_media);
                }

                DB::commit();
                flash('Initiator has been updated successfully.')->success()->important();
                return redirect()->route('admin.initiators.index');
            }catch (\Exception $e){
                DB::rollback();
                flash('Something went wrong.')->error()->important();
                return back()->withInput();
            }
        }else{
            flash('Record not found.')->error()->important();
            return back();
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
        $initiator = Initiator::find($id);
        if($initiator){
            DB::beginTransaction();
            try{
                //delete media
                common::delete_media($initiator->id,Initiator::class,'image');
                $initiator->delete();
                DB::commit();
                flash('Initiator has been deleted successfully.')->success()->important();
                return redirect()->route('admin.initiators.index');
            }catch (\Exception $e){
                DB::rollback();
                flash('Something went wrong.')->error()->important();
                return back()->withInput();
            }
        }else{
            abort(404);
        }
    }

    //Update the order of initiators
    public function update_order(Request $request){
        $response = array();
        $response['flag'] = 'failure';
        $array = json_decode($request->dataArr);

        if(count($array)){
            foreach ($array as $key=>$obj){
                if($obj){
                    $response['flag'] = 'success';
                    $initiator_id = $obj[0]->initiator_id;
                    $initiator_order = $obj[1]->order;
                    $initiator = Initiator::find($initiator_id);
                    if($initiator){
                        $initiator->order = $initiator_order;
                        $initiator->save();
                    }
                }
            }
        }
        return json_encode($response);
    }

    //Show list initiators at front end
    public function list_initiators(){
        $initiators = Initiator::orderBy('order','ASC')->whereStatus(1)->get();
        return view('meet-initiators',compact('initiators'));
    }
}
