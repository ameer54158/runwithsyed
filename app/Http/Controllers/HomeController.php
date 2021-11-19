<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Setting;
use Dymantic\InstagramFeed\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $feed = $all_feeds = array();
        try{
            $all_feeds = \Dymantic\InstagramFeed\Profile::where('username', 'runwithsyed')->first()->refreshFeed();
            if(count($all_feeds)){
                $feed = array_slice($all_feeds->toArray(), 0, 12);
            }
        }catch (\Exception $e){
            $feed = array();
        }
        $setting = new Setting();
        $news = News::orderBy('id','DESC')->whereStatus(1)->take(3)->get();
        return view('home',compact('setting','news','feed','all_feeds'));
    }

    //Show more instagram feed
    public function show_more_instagram_feed(Request $request){

        if(isset($request->page_value) && $request->page_value){
            $all_feeds = \Dymantic\InstagramFeed\Profile::where('username', 'ameer_hamza54158')->first()->refreshFeed();
            if($all_feeds->count()){
                $feed = array_slice($all_feeds->toArray(), ($request->page_value*12), 12);
                $data = View::make('instagram-feed-inner',compact('feed'))->render();
                $response = array();
                $more_feed_available = array_slice($all_feeds->toArray(), (($request->page_value+1)*12), 12);
                $more_feed_available_flag = 0;
                if(count($more_feed_available)){
                    $more_feed_available_flag = 1;
                }
                $response['data'] = $data;
                $response['more_feed_available_flag'] = $more_feed_available_flag;
                return json_encode($response);
                exit();
            }
        }
    }

    //About us
    public function about_us(){
        $setting = new Setting();
        return view('about-us', compact('setting'));
    }

    //Privacy page
    public function privacy(){
        return view('privacy');
    }

    //Terms of sale page
    public function terms_of_sale(){
        return view('terms-of-sale');
    }

    //Engage yourself page
    public function engage_yourself(){
        $setting = new Setting();
        return view('engage-yourself',compact('setting'));
    }

}
