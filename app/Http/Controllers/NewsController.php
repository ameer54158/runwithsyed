<?php

namespace App\Http\Controllers;

use App\Helpers\common;
use App\Models\Media;
use App\Models\News;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $news = News::when(($request->title_en), function($query) use ($request) {
            if($request->title_en){
                $query->where('title_en', 'LIKE', '%'.$request->title_en.'%');
            }
        })->when(($request->title_no), function($query) use ($request) {
            if($request->title_no){
                $query->where('title_no', 'LIKE', '%'.$request->title_no.'%');
            }
        })->when(($request->description_en), function($query) use ($request) {
            if($request->description_en){
                $query->where('description_en', 'LIKE', '%'.$request->description_en.'%');
            }
        })->when(($request->description_no), function($query) use ($request) {
            if($request->description_no){
                $query->where('description_no', 'LIKE', '%'.$request->description_no.'%');
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
        return view('admin.news.list-news',compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        common::delete_media(Auth::id(),'temp_news_media','gallery');
        $news = new News();
        return view('admin.news.create-or-update-news',compact('news'));
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
            'title_en' => 'required',
            'title_no' => 'required',
            'description_en' => 'required',
            'description_no' => 'required',
        ]);
        DB::beginTransaction();
        try{
            $request->merge(['slug_en'=>$this->create_slug($request->title_en,'slug_en'),'slug_no'=>$this->create_slug($request->title_no,'slug_no')]);
            $news = new News($request->except('_token','image','deleted_media'));
            $news->save();

            //saved news image
            if($request->image){
                common::update_media($request->image,$news->id,News::class,'image',$news->image_size());
            }

            $temp_images = common::user_temp_images('temp_news_media',Auth::id(),'gallery');
            if($temp_images->count()){
                $description_en = $this->replace_img_src($news->description_en,$temp_images,News::class,$news->id);
                $description_no = $this->replace_img_src($news->description_no,$temp_images,News::class,$news->id);
                $news->description_en = $description_en;
                $news->description_no = $description_no;
                $news->update();
            }

            DB::commit();
            flash('News has been created successfully.')->success()->important();
            return redirect()->route('admin.news.index');
        }catch (\Exception $e){
            DB::rollback();
            flash('Something went wrong.')->error()->important();
            return back()->withInput();
        }
    }

    //find and replace tex
    public function replace_img_src($text,$collection,$mediable_type,$mediable_id){
        if($collection->count()){
            foreach ($collection as $obj){
                if (str_contains($text, $obj->name_unique)) {
                    $obj->mediable_id = $mediable_id;
                    $obj->mediable_type = $mediable_type;
                    $obj->update();
                }
            }
        }

        $upload_folder_src  = asset('/');
        $upload_folder_src = 'src="'.$upload_folder_src.'public/uploads';
        $text = str_replace('src="../../public/uploads',trim($upload_folder_src),$text);
        $text = str_replace('src="../../../public/uploads',trim($upload_folder_src),$text);
        return $text;
    }


    public function save_media(Request $request){
        $img = common::update_media($request->file,Auth::id(),'temp_news_media','gallery');
        $media = Media::where('name_unique',$img['file_names'][0])->first();
        $src = asset(\App\helpers\common::getMediaPath($media));
        return json_encode(["location"=> $src]);
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
        common::delete_media(Auth::id(),'temp_news_media','gallery');
        $news = News::find($id);
        if($news){
            return view('admin.news.create-or-update-news',compact('news'));
        }else{
            flash('Record not found.')->error()->important();
            return back();
        }
    }

    //Delete text-editor images
    public function delete_editor_images($text, $collection){
        foreach ($collection as $obj){
            if (!str_contains($text, $obj->name_unique)) {
                common::delete_single_media($obj->name_unique);
            }
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
        $news = News::find($id);
        if($news){
            $validatedData = $request->validate([
                'title_en' => 'required',
                'title_no' => 'required',
                'description_en' => 'required',
                'description_no' => 'required',
            ]);
            DB::beginTransaction();
            try{
                $request->merge(['slug_en'=>$this->create_slug($request->title_en,'slug_en',$news->id),'slug_no'=>$this->create_slug($request->title_no,'slug_no',$news->id)]);
                $news->update($request->except('_token','image','deleted_media'));

                if($request->image){
                    common::update_media($request->image,$news->id,News::class,'image',$news->image_size(),true);
                }

                $temp_images = common::user_temp_images('temp_news_media',Auth::id(),'gallery');
                $description_en = $this->replace_img_src($news->description_en,$temp_images,News::class,$news->id);
                $description_no = $this->replace_img_src($news->description_no,$temp_images,News::class,$news->id);
                $news->description_en = $description_en;
                $news->description_no = $description_no;
                $news->update();

                $this->delete_editor_images($news->description_no.' '.$news->description_en,$news->gallery);
                //$this->delete_editor_images($news->description_no,$news->gallery);

                DB::commit();
                flash('News has been updated successfully.')->success()->important();
                return redirect()->route('admin.news.index');
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
        $news = News::find($id);
        if($news){
            DB::beginTransaction();
            try{
                //delete media
                common::delete_media($news->id,News::class,'image');
                common::delete_media($news->id,News::class,'gallery');
                $news->delete();
                DB::commit();
                flash('News has been deleted successfully.')->success()->important();
                return redirect()->route('admin.news.index');
            }catch (\Exception $e){
                DB::rollback();
                flash('Something went wrong.')->error()->important();
                return back()->withInput();
            }
        }else{
            abort(404);
        }
    }

    //Create slug
    public function create_slug($title,$column,$news_id = ''){
        $title = preg_replace('~[^\\pL\d.]+~u', ' ',strtolower($title));
        $new_slug = str_replace(" ","-",$title);
        if($news_id){
            $slug = News::where($column,$new_slug)->where('id','<>',$news_id)->first();
        }else{
            $slug = News::where($column,$new_slug)->first();
        }

        if($slug){
            $x = 1;
            do {
                $loop_run = 0;
                $slug = $updated_slug ='';
                $updated_slug = $new_slug.'-'.$x;
                $slug = News::where($column,$updated_slug)->first();
                if($slug){
                    $x++;
                    $loop_run++ ;
                }
            } while ($loop_run > 0);
        }else{
            $updated_slug = $new_slug;
        }
        return $updated_slug;
    }

    //List news page for the front end page
    public function list_news(){
        $news = News::orderBy('id','DESC')->whereStatus(1)->get();
        return view('news.list-news',compact('news'));
    }

    //Single news page for the front end page
    public function single_news($slug,Request $request){

        if(app()->getLocale() == 'nb'){
            $column = 'slug_no';
        }

        if(app()->getLocale() == 'en'){
            $column = 'slug_en';
        }

        if($request->route()->getname() == 'en.single-news' && app()->getLocale() == 'nb'){
            $column = 'slug_en';
        }

        if($request->route()->getname() == 'nb.single-news' && app()->getLocale() == 'en'){
            $column = 'slug_no';
        }
        $single_news = News::where($column,$slug)->first();
        if($single_news){
            $news = News::where('id','<>',$single_news->id)->orderBy('id','DESC')->whereStatus(1)->take(3)->get();
            return view('news.single-news',compact('news','single_news'));
        }else{
            abort(404);
        }
    }
}
