@extends('layouts.backend-master')

@section('title', 'Settings')

@section('page-content')
    <style>
        .fileinput-preview img{
            width: 100% !important;
        }
    </style>
    <!-- Page Content  -->
    <main class="content">
        <h4>Settings</h4>
        <hr>
        <div class="flash-message">
            @include('flash::message')
        </div>
        <form method="POST" action="{{route('admin.update-settings')}}" enctype="multipart/form-data">
            @csrf

            <div class="home-page" style="background: #f8ebfa; padding: 10px; border-radius: 10px; margin: 20px 0">
                <h5>Membership fee</h5>
                <hr>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Ambassador membership fee</label>
                        <input type="number" class="form-control" name="ambassador_membership_fee" value="{{old('ambassador_membership_fee',$setting->get_value('ambassador_membership_fee'))}}" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}">
                    </div>
                </div>
            </div>

            <div class="user-resgitration-success-message" style="background: #fff0f6; padding: 10px; border-radius: 10px; margin-bottom: 20px">
                <h5>New user registration success message</h5>
                <hr>

                <div class="form-row">
                    <div class="form-group col-md-6 mb-0">
                        <h6>English</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <h6>Norwegian</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Title</label>
                        <input class="form-control" name="register_success_title_en" value="{{old('register_success_title_en',$setting->get_value('register_success_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Title</label>
                        <input class="form-control" name="register_success_title_no" value="{{old('register_success_title_no',$setting->get_value('register_success_title_no'))}}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Description</label>
                        <textarea class="form-control text-editor" name="register_success_description_en">{{old('register_success_description_en',$setting->get_value('register_success_description_en'))}}</textarea>
                        <small>
                            Don't change the following keyword, that will be used for dynamic version.
                            <ul class="pl-4">
                                <li>t_shirt_fee</li>
                                <li>privacy_link</li>
                                <li>terms_of_sale_link</li>
                            </ul>
                        </small>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Description</label>
                        <textarea class="form-control text-editor" name="register_success_description_no">{{old('register_success_description_no',$setting->get_value('register_success_description_no'))}}</textarea>
                        <small>
                            Don't change the following keyword, that will be used for dynamic version.
                            <ul class="pl-4">
                                <li>t_skjorte_avgift</li>
                                <li>personvern_link</li>
                                <li>salgsvilkar_link</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>


            <div class="about-us" style="background: #e7fbd3; padding: 10px; border-radius: 10px; margin-bottom: 20px">
                <div class="form-row">
                    <div class="col-12">
                        <h5>About us</h5>
                        <hr>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <h6>English</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <h6>Norwegian</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Main Description</label>
                        <textarea class="form-control" name="about_us_description_en" rows="6">{{old('about_us_description_en',$setting->get_value('about_us_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Main Description</label>
                        <textarea class="form-control" name="about_us_description_no" rows="6">{{old('about_us_description_no',$setting->get_value('about_us_description_no'))}}</textarea>
                    </div>
                        <div class="form-group col-md-6">
                        <label>VISION AND GOALS Title</label>
                        <input class="form-control" name="vision_and_goal_title_en" value="{{old('vision_and_goal_title_en',$setting->get_value('vision_and_goal_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>VISION AND GOALS Title</label>
                        <input class="form-control" name="vision_and_goal_title_no" value="{{old('vision_and_goal_title_no',$setting->get_value('vision_and_goal_title_no'))}}"/>
                    </div>
                       <div class="form-group col-md-6">
                        <label>VISION AND GOALS Description</label>
                        <textarea class="form-control" name="vision_and_goal_description_en" rows="6">{{old('vision_and_goal_description_en',$setting->get_value('vision_and_goal_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>VISION AND GOALS Description</label>
                        <textarea class="form-control" name="vision_and_goal_description_no" rows="6">{{old('vision_and_goal_description_no',$setting->get_value('vision_and_goal_description_no'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>How We Help Title</label>
                        <input class="form-control" name="how_we_help_title_en" value="{{old('how_we_help_title_en',$setting->get_value('how_we_help_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>How We Help Title</label>
                        <input class="form-control" name="how_we_help_title_no" value="{{old('how_we_help_title_no',$setting->get_value('how_we_help_title_no'))}}"/>
                    </div>
                       <div class="form-group col-md-6">
                        <label>How We Help Description</label>
                        <textarea class="form-control" name="how_we_help_description_en" rows="6">{{old('how_we_help_description_en',$setting->get_value('how_we_help_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>How We Help Description</label>
                        <textarea class="form-control" name="how_we_help_description_no" rows="6">{{old('how_we_help_description_no',$setting->get_value('how_we_help_description_no'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>About us last Title</label>
                        <input class="form-control" name="about_us_last_title_en" value="{{old('about_us_last_title_en',$setting->get_value('about_us_last_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>About us last Title</label>
                        <input class="form-control" name="about_us_last_title_no" value="{{old('about_us_last_title_no',$setting->get_value('about_us_last_title_no'))}}"/>
                    </div>
                       <div class="form-group col-md-6">
                        <label>About us last Description</label>
                        <textarea class="form-control" name="about_us_last_description_en" rows="6">{{old('about_us_last_description_en',$setting->get_value('about_us_last_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>About us last Description</label>
                        <textarea class="form-control" name="about_us_last_description_no" rows="6">{{old('about_us_last_description_no',$setting->get_value('about_us_last_description_no'))}}</textarea>
                    </div>

                    <div class="col-md-8">
                    <div class="form-row">
                          @php
                             $setting_obj = \App\Models\Setting::where('key','about_us_image')->where('value','exist')->first();
                                $src = $required_attr = $file_unique_name = '';
                                $file_name = 'image';
                                if($setting_obj && $setting_obj->id){
                                    $src = $setting_obj->about_us_image ? asset(\App\Helpers\common::getMediaPath($setting_obj->about_us_image)) : '';
                                    $file_unique_name = $setting_obj->about_us_image ? $setting_obj->about_us_image->name_unique : '';
                                }
                            @endphp
                        <div class="form-group">
                            <label for="title">Image  <span class="font-weight-bold image-size" data-size="{{ (new \App\Models\Setting())->about_us_image_size() }}">{{ \App\Helpers\common::SupportedImagesFormat() }} ({{ (new \App\Models\Setting())->about_us_image_size() }})</span></label>
                            <div class="clearfix"></div>
                      
                            @include('admin.partials.upload-single-image')
                        </div>
                    </div>
                </div>

                </div>
            </div>

            <div class="home-page" style="background: lightgoldenrodyellow; padding: 10px; border-radius: 10px; margin-bottom: 20px">
                <h5>Home Page</h5>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-6 mb-0">
                        <h6>English</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <h6>Norwegian</h6>
                        <hr>
                    </div>
                     <div class="col-12">
                        <h6>Banner section title</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" name="home_banner_section_title_en" value="{{old('home_banner_section_title_en',$setting->get_value('home_banner_section_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" name="home_banner_section_title_no" value="{{old('home_banner_section_title_no',$setting->get_value('home_banner_section_title_no'))}}"/>
                    </div>
                      <div class="col-12">
                        <h6>Banner section description</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="banner_section_description_en">{{old('banner_section_description_en',$setting->get_value('banner_section_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="banner_section_description_no">{{old('banner_section_description_no',$setting->get_value('banner_section_description_no'))}}</textarea>
                    </div>
                    <div class="col-12">
                        <h6>Ambassador section title</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" name="ambassador_section_title_en" value="{{old('ambassador_section_title_en',$setting->get_value('ambassador_section_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" name="ambassador_section_title_no" value="{{old('ambassador_section_title_no',$setting->get_value('ambassador_section_title_no'))}}"/>
                    </div>
                    <div class="col-12">
                        <h6>Ambassador section description</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="ambassador_section_description_en">{{old('ambassador_section_description_en',$setting->get_value('ambassador_section_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="ambassador_section_description_no">{{old('ambassador_section_description_no',$setting->get_value('ambassador_section_description_no'))}}</textarea>
                    </div>
                    <div class="col-12">
                        <h6>Sponsor section title</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" name="sponsor_section_title_en" value="{{old('sponsor_section_title_en',$setting->get_value('sponsor_section_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" name="sponsor_section_title_no" value="{{old('sponsor_section_title_no',$setting->get_value('sponsor_section_title_no'))}}"/>
                    </div>
                    <div class="col-12">
                        <h6>Sponsor section description</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="sponsor_section_description_en">{{old('sponsor_section_description_en',$setting->get_value('sponsor_section_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="sponsor_section_description_no">{{old('sponsor_section_description_no',$setting->get_value('sponsor_section_description_no'))}}</textarea>
                    </div>
                    <div class="col-12">
                        <h6>Contributor section title</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" name="contributor_section_title_en" value="{{old('contributor_section_title_en',$setting->get_value('contributor_section_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" name="contributor_section_title_no" value="{{old('contributor_section_title_no',$setting->get_value('contributor_section_title_no'))}}"/>
                    </div>
                    <div class="col-12">
                        <h6>Contributor section description</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="contributor_section_description_en">{{old('contributor_section_description_en',$setting->get_value('contributor_section_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="contributor_section_description_no">{{old('contributor_section_description_no',$setting->get_value('contributor_section_description_no'))}}</textarea>
                    </div>
                </div>
            </div>
        
              <div class="contact-page" style="background: #e6f4f9; padding: 10px; border-radius: 10px; margin-bottom: 20px">
                <h5>Contact Page & footer</h5>
                <hr>
                <div class="form-row">
                    <div class="col-md-4">
                        <h6>Phone</h6>
                        <hr>
                    </div>
                    <div class="col-md-4">
                        <h6>Email</h6>
                        <hr>
                    </div>
                    <div class="col-md-4">
                        <h6>Org. no</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" name="contact_us_phone" value="{{old('contact_us_phone',$setting->get_value('contact_us_phone'))}}"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="email" class="form-control" name="contact_us_email" value="{{old('contact_us_email',$setting->get_value('contact_us_email'))}}"/>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" name="organization_no" value="{{old('organization_no',$setting->get_value('organization_no'))}}"/>
                    </div>
                     <div class="col-md-12">
                        <h6>Website</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="contact_us_website" value="{{old('contact_us_website',$setting->get_value('contact_us_website'))}}"/>
                    </div>
                    <div class="col-md-6">
                        <h6>Description en</h6>
                        <hr>
                    </div>
                      <div class="col-md-6">
                        <h6>Description no</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="contact_us_description_en">{{old('contact_us_description_en',$setting->get_value('contact_us_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="form-control" rows="5" name="contact_us_description_no">{{old('contact_us_description_no',$setting->get_value('contact_us_description_no'))}}</textarea>
                    </div>
                </div>
            </div>

              <div class="privacy-page" style="background: #f2fbdd; padding: 10px; border-radius: 10px; margin-bottom: 20px">
                <h5>Privacy page</h5>
                <hr>
                <div class="form-row">
                    <div class="col-md-6">
                        <h6>Privacy title en</h6>
                        <hr>
                    </div>
                      <div class="col-md-6">
                        <h6>Privacy title no</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="privacy_title_en" value="{{old('privacy_title_en',$setting->get_value('privacy_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="privacy_title_no" value="{{old('privacy_title_no',$setting->get_value('privacy_title_no'))}}"/>
                    </div>
                    <div class="col-md-6">
                        <h6>Description en</h6>
                        <hr>
                    </div>
                      <div class="col-md-6">
                        <h6>Description no</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="text-editor form-control" rows="5" name="privacy_description_en">{{old('privacy_description_en',$setting->get_value('privacy_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="text-editor form-control" rows="5" name="privacy_description_no">{{old('privacy_description_no',$setting->get_value('privacy_description_no'))}}</textarea>
                    </div>
                </div>
            </div>

            <div class="terms-of-sale-page" style="background: #fbf4c5; padding: 10px; border-radius: 10px; margin-bottom: 20px">
                <h5>Terms of sale</h5>
                <hr>
                <div class="form-row">
                    <div class="col-md-6">
                        <h6>Terms of sale title en</h6>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <h6>Terms of sale title no</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="sales_terms_title_en" value="{{old('sales_terms_title_en',$setting->get_value('sales_terms_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="sales_terms_title_no" value="{{old('sales_terms_title_no',$setting->get_value('sales_terms_title_no'))}}"/>
                    </div>
                    <div class="col-md-6">
                        <h6>Description en</h6>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <h6>Description no</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="text-editor form-control" rows="5" name="sales_terms_description_en">{{old('sales_terms_description_en',$setting->get_value('sales_terms_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="text-editor form-control" rows="5" name="sales_terms_description_no">{{old('sales_terms_description_no',$setting->get_value('sales_terms_description_no'))}}</textarea>
                    </div>
                </div>
            </div>

            <div class="terms-of-sale-page" style="background: #f2fbea; padding: 10px; border-radius: 10px; margin-bottom: 20px">
                <h5>Become sponsor success message</h5>
                <hr>
                <div class="form-row">
                    <div class="col-md-6">
                        <h6>Description en</h6>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <h6>Description no</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="text-editor form-control" rows="5" name="become_sponsor_success_description_en">{{old('become_sponsor_success_description_en',$setting->get_value('become_sponsor_success_description_en'))}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <textarea class="text-editor form-control" rows="5" name="become_sponsor_success_description_no">{{old('become_sponsor_success_description_no',$setting->get_value('become_sponsor_success_description_no'))}}</textarea>
                    </div>
                </div>
            </div>

            <div class="about-us" style="background: #effbfb; padding: 10px; border-radius: 10px; margin-bottom: 20px">
                <h5>SEO</h5>
                <hr>

                <div class="form-row">
                    <div class="form-group col-md-6 mb-0">
                        <h6>English</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <h6>Norwegian</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Meta Title</label>
                        <input class="form-control" name="site_seo_title_en" value="{{old('site_seo_title_en',$setting->get_value('site_seo_title_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Meta Title</label>
                        <input class="form-control" name="site_seo_title_no" value="{{old('site_seo_title_no',$setting->get_value('site_seo_title_no'))}}"/>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Meta Keywords</label>
                        <input class="form-control" name="site_seo_keywords_en" value="{{old('site_seo_keywords_en',$setting->get_value('site_seo_keywords_en'))}}"/>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Meta Keywords</label>
                        <input class="form-control" name="site_seo_keywords_no" value="{{old('site_seo_keywords_no',$setting->get_value('site_seo_keywords_no'))}}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Meta Description</label>
                        <textarea class="form-control" rows="5" name="site_seo_description_en" maxlength="160">{{old('site_seo_description_en',$setting->get_value('site_seo_description_en'))}}</textarea>
                        <p style="font-size:12px;">Maximum 160 Character</p>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Meta Description</label>
                        <textarea class="form-control" rows="5" name="site_seo_description_no" maxlength="160">{{old('site_seo_description_no',$setting->get_value('site_seo_description_no'))}}</textarea>
                        <p style="font-size:12px;">Maximum 160 Character</p>
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary">Update Settings</button>
        </form>

    </main>
@endsection

@section('script')
<script src="{{ asset('public/admin/js/bootstrap-fileinput.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/pyzh8nk5zts8kmnwuypdooa95t19aknwf2lnw5xg1pr8sjqc/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script>
        $(document).ready(function () {
            //
            tinymce.init({
                menubar: false, // remove menubar if you want to show the menubar
                statusbar: false,
                selector: 'textarea.text-editor',

                height: 300,
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table paste imagetools wordcount"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
                // toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image", orignal
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tiny.cloud/css/codepen.min.css'
                ]
            });

        });
    </script>
@endsection
