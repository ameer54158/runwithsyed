<?php

namespace App\Helpers;

use App\Models\AmbassadorPayment;
use App\User;
use Exception;
use Carbon\Carbon;
use App\Models\Media;
use App\Models\Setting;
use Illuminate\Support\Str;
use \Illuminate\Http\Request;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Builder;
use Intervention\Image\ImageManagerStatic as Image;

class common
{
    //Get media path full URL
    public static function getMediaPath($obj, $size = 'full')
    {
        $file_name = $obj->name_unique;
        $path = 'public/uploads/' . date('Y', strtotime($obj->created_at)) . '/' . date('m', strtotime($obj->created_at)) . '/';
        $return_able = '';
        if ($size != 'full') {
            $arr = explode('.', $obj->name_unique);
            $sz = explode('x', $size);
            if (is_array($arr) && count($arr) == 2) {
                $file = $path . $arr[0] . '-' . $size . '.' . $arr[1];
                if (!file_exists($path . $arr[0] . '.' . $arr[1])) {
                    $return_able = null;
                }
                if (!file_exists($file) && file_exists($path . $file_name)) {
                    Image::make($path . $obj->name_unique)->widen($sz[0])->heighten($sz[1])->save($path . $arr[0] . '-' . $size . '.' . $arr[1]);
                }
                $return_able = url('/') . '/' . $file;
            }
        }
        if (!$return_able) {
            $return_able = url('/') . '/' . $path . $file_name;
        }
        return $return_able;
    }

    //Create unique slug
    public static function slug_unique($name, $num = 0, $Model, $collumn)
    {
        $slug_to_check = $num != 0 ? $name . '-' . $num : $name;
        $slug_to_check = Str::slug($slug_to_check);

        $media = $Model::where($collumn, $slug_to_check)->withTrashed()->first();
        if ($media != null) {
            $num++;
            return common::slug_unique($name, $num, $Model, $collumn);
        } else {
            return $slug_to_check;
        }
    }

    //Create slug
    public static function name_unique($name, $num = 0, $Model, $collumn)
    {
        $slug_to_check = $num != 0 ? $name . '-' . $num : $name;

        $media = $Model::where($collumn, $slug_to_check)->first();
        if ($media != null) {
            $num++;
            return common::slug_unique($name, $num, $Model, $collumn);
        } else {
            return $slug_to_check;
        }
    }

    //Store the media and create thumbnail
    public static function update_media($files, $mediable_id, $mediable_type, $type, $size = '', $delete_old = 'false', $banner = 'false')
    {
        $max_old_media_order = Media::where('mediable_type', $mediable_type)->where('mediable_id', $mediable_id)->where('type', $type)->orderBy('order', 'DESC')->first();
        if ($delete_old == 'true') {
            self::delete_media($mediable_id, $mediable_type, $type);
        }
        $order = 0;
        if ($max_old_media_order) {
            $order = $max_old_media_order->order;
        }

        if (!is_array($files)) {
            $files = array($files);
        }
        $names_files = array();
        $org_file_names = array();
        $file_names_encoded = array();
        $file_ids = array();
        $org_size = $size;
        foreach ($files as $key => $file) {
            $explode_size = array();
            $unique_name = date('ymd') . '-' . time() . '-' . mt_rand(1000000, 9999999);
            $name = $file->getClientOriginalName();
            $name_unique = $unique_name . '.' . $file->getClientOriginalExtension();
            $path = 'public/uploads/' . date('Y') . '/' . date('m');
            $file->move($path, $name_unique);
            if ($mediable_type != 'temp_news_media' && (strtolower($file->getClientOriginalExtension()) == 'jpg' ||
                strtolower($file->getClientOriginalExtension()) == 'jpeg' ||
                strtolower($file->getClientOriginalExtension()) == 'png')
            ) {
                if ($org_size && $banner === 'false') {
                    $explode_size = explode('x', $org_size);
                    if (isset($explode_size[0]) && isset($explode_size[1])) {
                        $resize_width = (int)$explode_size[0];
                        $resize_height = (int)$explode_size[1];
                        $img = Image::make(asset($path . '/' . $name_unique))->save($path . '/' . $unique_name . '-' . $explode_size[0] . 'x' . $explode_size[1] . '.' . $file->getClientOriginalExtension());


                        if($img->width() < $resize_width || $img->height() < $resize_height){
                            if ($img->width() > $resize_width) {
                                $img->resize($resize_width, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }

                            if ($img->height() > $resize_height) {
                                $img->resize(null, $resize_height, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }

                            $img->resizeCanvas($resize_width, $resize_height, 'center', false, '#FFFFFF');
                            $img->save($path . '/' . $unique_name . '-'.$explode_size[0].'x'.$explode_size[1].'.' . $file->getClientOriginalExtension());
                        }else{
                            Image::make(asset($path . '/' . $name_unique))->resize($resize_width, $resize_height)->save($path . '/' . $unique_name . '-'.$resize_width.'x'.$resize_height.'.' . $file->getClientOriginalExtension());
                        }
                    }
                }
                Image::make(asset($path . '/' . $name_unique))->heighten(66)->widen(66)->save($path . '/' . $unique_name . '-66x66.' . $file->getClientOriginalExtension());
                Image::make(asset($path . '/' . $name_unique))->heighten(150)->widen(150)->save($path . '/' . $unique_name . '-150x150.' . $file->getClientOriginalExtension());
                Image::make(asset($path . '/' . $name_unique))->heighten(250)->widen(250)->save($path . '/' . $unique_name . '-250x250.' . $file->getClientOriginalExtension());
                Image::make(asset($path . '/' . $name_unique))->heighten(360)->widen(360)->save($path . '/' . $unique_name . '-360x360.' . $file->getClientOriginalExtension());
                Image::make(asset($path . '/' . $name_unique))->heighten(570)->widen(570)->save($path . '/' . $unique_name . '-570x570.' . $file->getClientOriginalExtension());
                Image::make(asset($path . '/' . $name_unique))->heighten(768)->widen(768)->save($path . '/' . $unique_name . '-768x768.' . $file->getClientOriginalExtension());
                Image::make(asset($path . '/' . $name_unique))->heighten(1024)->widen(1024)->save($path . '/' . $unique_name . '-1024x1024.' . $file->getClientOriginalExtension());

//                Image::make(asset($path . '/' . $name_unique))->fit(420, 300, function ($constraint) {
//                 $constraint->upsize();
//                 })->save($path . '/' . $unique_name . '-420x300.' . $file->getClientOriginalExtension());
            }

            $media = new Media(['mediable_id' => $mediable_id, 'mediable_type' => $mediable_type, 'name' => $name, 'name_unique' => $name_unique, 'type' => $type,]);
            $media->order = $order + 1;
            $media->save();
            $names_files[] = $media->name_unique;
            $org_file_names[] = $media->name;
            $file_names_encoded[] = base64_encode($media->name_unique);
            $file_ids[] = $media->id;
            $order++;
//            if($mediable_type == 'temp_partner_img' || $mediable_type == 'temp_info_page_img'){
//                return $media;
//            }
        }
        return [
            'file_names' => $names_files,
            'org_file_names' => $org_file_names,
            'file_names_encoded' => $file_names_encoded,
            'file_ids' => $file_ids,
        ];

    }

    //Delete the multiple media using mediable_id, mediable_type and type
    public static function delete_media($mediable_id='', $mediable_type, $type)
    {
        if($mediable_id){
            $obj_old_media = Media::where('mediable_id', $mediable_id)
                ->where('mediable_type', $mediable_type)
                ->where('type', $type);
        }else{
            $obj_old_media = Media::where('mediable_type', $mediable_type)
                ->where('type', $type);
        }

        $old_media = $obj_old_media->get();
        if ($old_media) {
            foreach ($old_media as $obj) {
                $path = 'public/uploads/' . date('Y', strtotime($obj->created_at)) . '/' . date('m', strtotime($obj->created_at)) . '/';
                $arr = explode('.', $obj->name_unique);

                foreach (glob($path . $arr[0] . '*.*') as $file) {
                    unlink($file);
                }
            }
            $obj_old_media->delete();
        }
    }

    //delete single image and unattach
    public static function delete_single_media($file_unique_name)
    {
        $media = Media::where('name_unique', $file_unique_name)->first();

        if ($media) {
            $path = 'public/uploads/' . date('Y', strtotime($media->created_at)) . '/' . date('m', strtotime($media->created_at)) . '/';
            $arr = explode('.', $media->name_unique);

            foreach (glob($path . $arr[0] . '*.*') as $file) {
                unlink($file);
            }
            $media->delete();
        }
    }

    //Get highest order of any table
    public static function get_highest_order($class)
    {
        $order = $class::orderBy('order', 'DESC')->first() ? $class::orderBy('order', 'DESC')->first()->order + 1 : 1;
        return $order;
    }

    //Get temporary images collection
    public static function user_temp_images($mediable_type,$mediable_id,$type){
        $temp_images = Media::where('mediable_id',$mediable_id)->where('mediable_type',$mediable_type)->where('type',$type)->get();
        return $temp_images;
    }

    //delete image that is uploaded from file input
    public static function delete_single_uploaded_image($deleted_media_arr)
    {
        if (isset($deleted_media_arr)) {
            $deleted_media = json_decode($deleted_media_arr);
            if (count($deleted_media)) {
                foreach ($deleted_media as $media) {
                    common::delete_single_media($media);
                }
            }
        }
    }

    // Supported images
    public static function SupportedImagesFormat()
    {
        return "Only Supoprt PNG, JPG Or JPEG";
    }

    //Convert date in norwegian language
    public static function data_in_norwegian($date){
        $formatted_date = new \DateTime( $date );

        $date_timestamp = $formatted_date->getTimestamp();

        $date =  $formatted_date->format( 'l d F Y' );
        setlocale(LC_ALL, array('nb_NO.UTF-8','nb_NO@norw','nb_NO','norwegian'));//setlocale(LC_ALL, 'nb'); //strftime("%A %e %B %Y")
        $new_date = ucwords(strftime("%e %b, %Y",strtotime($date)));
        return $new_date;
    }

    //Show date according to user locale like English or Norwegian
    public static function date_in_locale_lang($date, $format,$locale_type=''){
        if($date){
            if(!$locale_type){
                $locale_type = app()->getLocale() ? app()->getLocale() : '';
            }
            if($locale_type == 'nb'){
                $formatted_date = new \DateTime( $date );
                $date_timestamp = $formatted_date->getTimestamp();

                $date =  $formatted_date->format( $format );
                setlocale(LC_ALL, array('nb_NO.UTF-8','nb_NO@norw','nb_NO','norwegian'));
                $updated_format = "%e %b, %Y";
                if($format == 'F Y'){
                    $updated_format = '%B %Y';
                }
                if($format == 'M Y'){
                    $updated_format = '%B %Y';
                }
                if($format == 'M d, Y'){
                    $updated_format = '%B %e, %Y';
                }
                $new_date = ucwords(strftime($updated_format,strtotime($date)));
                return $new_date;
            }else if(app()->getLocale() && app()->getLocale() == 'en'){
                return date($format, strtotime($date));
            }
        }
    }

    //Site setting
    public static function site_setting($key) {
        return Setting::where('key',$key)->pluck('value')->first() ?? '';
    }

    //Get ambassador not paying amount months
    public static function ambassador_not_paying_month($user=''){
        $paying_month = array();

        if(!$user){
            $user = Auth::user();
        }

        if($user->ambassador_payments->count()){
            $paying_month = $user->ambassador_payments->pluck('month_year')->toArray();
        }
         $paying_month_year = \App\Models\AmbassadorRun::where('user_id',$user->id)
             ->whereNotIn(DB::raw('MONTH(date)'), $paying_month)
             ->whereNotBetween('date',[date('Y-m-01'),date('Y-m-t')])->get()->groupBy(function($val) {
             return \Illuminate\Support\Carbon::parse($val->date)->format('Y-m');
         });

        return $paying_month_year;
    }

    //Get sponsor not paying amount months
    public static function sponsor_not_paying_month($ambassador,$user_id=''){
        $paying_month = array();
        if($user_id){
            $user = \App\Models\User::where('id',$user_id)->first();
        }else{
            $user = Auth::user();
        }
        $ambassador_user = $user->ambassadors->count() && $user->ambassadors->where('ambassador_user_id',$ambassador->id)->first() ? $user->ambassadors->where('ambassador_user_id',$ambassador->id)->first() : '';
        if($ambassador_user && $ambassador_user->payments){
            $paying_month = $ambassador_user->payments->pluck('month_year')->toArray();
        }
        $paying_month_year = \App\Models\AmbassadorRun::where('user_id',$ambassador->id)->whereHas('user.sponsors', function (Builder $query) use ($user) {
                $query->where('sponsor_ambassadors.sponsor_user_id', '=', $user->id);
            })
            ->whereDate('date','>=',date('Y-m-01',strtotime(date($ambassador_user->created_at->format('d-m-Y')))))
            ->whereNotIn(DB::raw("DATE_FORMAT(date, '%m-%Y')"), $paying_month)
            ->whereNotBetween('date',[date('Y-m-01'),date('Y-m-t')])
            ->orderBy('date','DESC')
            ->get()->groupBy(function($val) {
                return \Illuminate\Support\Carbon::parse($val->date)->format('Y-m');
            });

        return $paying_month_year;
    }

    //Get all month between selected ranges and get messages if range is not valid
    public static function get_month_between_range($request){
        $start_month = '2000-01';
        $end_month = date('Y-m');
        $month_range_filter = false; $show_message = false;
        $month_range_arr = array();
        if(isset($request['payment_start_month']) && $request['payment_start_month']){
            $start_month = $request['payment_start_month'];
            $month_range_filter = true;
        }
        if(isset($request['payment_end_month']) && $request['payment_end_month']){
            $end_month = $request['payment_end_month'];
            $month_range_filter = true;
        }
        if((isset($request['payment_end_month']) && $request['payment_end_month']) || (isset($request['payment_start_month']) && $request['payment_start_month'])){
            if(strtotime($start_month) <= strtotime($end_month)){
            }else{
                $month_range_filter = false;
                $show_message = true;
            }
        }else{
            $month_range_filter = false;
        }
        $period = \Carbon\CarbonPeriod::create($start_month.'-01', '1 month', $end_month.'-01');

        foreach ($period as $dt) {
            array_push($month_range_arr,$dt->format("m-Y"));
        }
        $return_arr = array('month_range_arr'=>$month_range_arr,'show_message'=>$show_message,'month_range_filter'=>$month_range_filter);
        return $return_arr;
    }

    //Remove extra tag from media string
    public static function remove_media_tag_from_string($str, $replacement){
        $needle_start_arr = array('<iframe','<video','<img');
        $needle_end_arr = array('</iframe>','</video>','/>');
        $flag = true;
        do{
            if(strpos($str,'<iframe') || strpos($str,'<video') || strpos($str,'<img')){
                foreach ($needle_start_arr as $key=>$needle_start){
                    if(strpos($str,$needle_start)){
                        $pos = strpos($str, $needle_start);
                        $needle_start_length = strlen($needle_start);
                        $needle_end_length = strlen($needle_end_arr[$key]);
                        $pos = $pos - $needle_start_length;
                        $start = $pos === false ? 0 : $pos + strlen($needle_start);

                        $pos = strpos($str, $needle_end_arr[$key], $start);
                        $pos = $pos + $needle_end_length;

                        $end = $pos === false ? strlen($str) : $pos;

                        $str = substr_replace($str, $replacement, $start, $end - $start);
                    }
                }
            }else{
                $flag = false;
            }
        }while($flag);
        return $str;
    }

}
