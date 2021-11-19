<?php

namespace App\Http\Controllers;
use App\Helpers\common;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    //Show setting form in admin panel
    public function show_setting() {
        $setting = new Setting();
        return view('admin.settings',compact('setting'));
    }

    //Admin can saved or update site setting
    public function create_or_update(Request $request) {
        DB::beginTransaction();
        try{
            foreach ($request->except('_token','_method','image','remove_banner','deleted_media') as $key=>$value){
                if($value){
                    Setting::updateOrCreate(['key' => $key],['value' => $value,]);
                }else{
                    Setting::where('key',$key)->delete();
                }
            }
            if($request->file('image')){
                $about_us_image = Setting::updateOrCreate(['key' => 'about_us_image'],['value' => 'exist',]);
                common::update_media($request->image,$about_us_image->id,Setting::class,'about_us_image',((new Setting())->about_us_image_size()),true);
            }else{
                if(!$request->file('image') && $request->deleted_media){
                    $about_us_image = Setting::where('key','about_us_image')->where('value','exist')->first();
                    if($about_us_image){
                        common::delete_media($about_us_image->id,Setting::class,'about_us_image');
                        $about_us_image->delete();
                    }
                }
            }

            DB::commit();
            flash('Setting has been updated successfully.')->success()->important();
            return back();
        }catch (\Exception $e){
            DB::rollback();
            flash('Something went wrong.')->error()->important();
            return back()->withInput();
        }
    }
}
