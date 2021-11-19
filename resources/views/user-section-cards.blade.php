<div class="col-lg-4 col-md-6 col-sm-12 col-12">
    <img src="{{asset('public/images/ambassador.jpg')}}" style="width: 100%; height: 220px;">
    <div class="ambassador-section">
        <p class="title mb-0">{{app()->getLocale() == 'nb' ? Str::limit($setting->get_value('ambassador_section_title_no'),20) : Str::limit($setting->get_value('ambassador_section_title_en'),20)}}</p>
        <p class="description">
            {{app()->getLocale() == 'nb' ? Str::limit($setting->get_value('ambassador_section_description_no'),240) : Str::limit($setting->get_value('ambassador_section_description_en'),240)}}
        </p>
        <div class="btn-section">
            <a class="btn" @if(!Auth::check()) href="javascript:void(0);" data-toggle="modal" data-target="#registerambassadormodal" @endif>{{Auth::check() ? __('general.logged in become ambassador',['role' => Auth::user()->roles()->first()->slug]) :  __('general.become ambassador')}}</a>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-12 col-12">
    <img src="{{asset('public/images/sponsor.jpg')}}" style="width: 100%; height: 220px;">
    <div class="sponsor-section">
        <p class="title mb-0">{{app()->getLocale() == 'nb' ? Str::limit($setting->get_value('sponsor_section_title_no'),20) : Str::limit($setting->get_value('sponsor_section_title_en'),20)}}</p>
        <p class="description">
            {{app()->getLocale() == 'nb' ? Str::limit($setting->get_value('sponsor_section_description_no'),240) : Str::limit($setting->get_value('sponsor_section_description_en'),240)}}
        </p>
        <div class="btn-section">
            <a class="btn" @if(!Auth::check()) href="javascript:void(0);" data-toggle="modal" data-target="#registersponsormodal" @endif>{{Auth::check() ? __('general.logged in become sponsor',['role' => Auth::user()->roles()->first()->slug]) : __('general.become sponsor')}}</a>
        </div>
    </div>
</div>
<div class="col-lg-4 col-md-6 col-sm-12 col-12">
    <img src="{{asset('public/images/contribute.jpg')}}" style="width: 100%; height: 220px;">
    <div class="contribute-section">
        <p class="title mb-0">{{app()->getLocale() == 'nb' ? Str::limit($setting->get_value('contributor_section_title_no'),20) : Str::limit($setting->get_value('contributor_section_title_en'),20)}}</p>
        <p class="description">
            {{app()->getLocale() == 'nb' ? Str::limit($setting->get_value('contributor_section_description_no'),240) : Str::limit($setting->get_value('contributor_section_description_en'),240)}}
        </p>
        <div class="btn-section">
            <button class="btn" href="javascript:void(0);" data-toggle="modal" data-target="#donationmodal">{{__('general.donate now')}}</button>
        </div>
    </div>
</div>