<style>
body {
	font-family: 'Varela Round', sans-serif;
}
.modal-confirm {		
	color: #434e65;
	width: 525px;
}
.modal-confirm .modal-content {
	padding: 20px;
	font-size: 16px;
	border-radius: 5px;
	border: none;
}
.modal-confirm .modal-header {
	background: #47c9a2;
	border-bottom: none;   
	position: relative;
	text-align: center;
	margin: -20px -20px 0;
	border-radius: 5px 5px 0 0;
	padding: 35px;
}
.modal-confirm h4 {
	text-align: center;
	font-size: 36px;
	margin: 10px 0;
}
.modal-confirm .form-control, .modal-confirm .btn {
	min-height: 40px;
	border-radius: 3px; 
}
.modal-confirm .close {
	position: absolute;
	top: 15px;
	right: 15px;
	color: #fff;
	text-shadow: none;
	opacity: 0.5;
}
.modal-confirm .close:hover {
	opacity: 0.8;
}
.modal-confirm .icon-box {
	color: #fff;		
	width: 95px;
	height: 95px;
	display: inline-block;
	border-radius: 50%;
	z-index: 9;
	border: 5px solid #fff;
	padding: 15px;
	text-align: center;
}
.modal-confirm .icon-box i {
	font-size: 64px;
	margin: -4px 0 0 -4px;
}
.modal-confirm.modal-dialog {
	margin-top: 80px;
}
.modal-confirm .btn, .modal-confirm .btn:active {
	color: #fff;
	border-radius: 4px;
	background: #eeb711 !important;
	text-decoration: none;
	transition: all 0.4s;
	line-height: normal;
	border-radius: 30px;
	margin-top: 10px;
	padding: 6px 20px;
	border: none;
}
.modal-confirm .btn:hover, .modal-confirm .btn:focus {
	background: #eda645 !important;
	outline: none;
}
.modal-confirm .btn span {
	margin: 1px 3px 0;
	float: left;
}
.modal-confirm .btn i {
	margin-left: 1px;
	font-size: 20px;
	float: right;
}
.trigger-btn {
	display: inline-block;
	margin: 100px auto;
}
.fa-check-circle {
    color:#fff;
    font-size:5rem;
}
	button[aria-label="Close"]:focus{
		outline: none;
	}
</style>
<!-- Modal HTML -->
<div id="user_registration_success_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content pt-0">
			<div class="modal-header border-0 pt-2 pb-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@php
				$setting_obj = new \App\Models\Setting();
				$description = '';
				if(app()->getLocale() == 'nb'){
					$description = str_replace('t_skjorte_avgift',($setting_obj->get_value('ambassador_membership_fee') ? $setting_obj->get_value('ambassador_membership_fee') : 200),$setting_obj->get_value('register_success_description_no'));
					$description = str_replace('salgsvilkar_link','<a href="'.localized_route('terms-of-sale').'" class="register-privacy-link"  target="_blank">salgsvilkår</a>',$description);
					$description = str_replace('personvern_link','<a href="'.localized_route('privacy').'" class="register-privacy-link"  target="_blank">personvernerklæring</a>',$description);
				}else{
					$description = str_replace('t_shirt_fee',($setting_obj->get_value('ambassador_membership_fee') ? $setting_obj->get_value('ambassador_membership_fee') : 200),$setting_obj->get_value('register_success_description_en'));
					$description = str_replace('privacy_link','<a href="'.localized_route('privacy').'" class="register-privacy-link"  target="_blank">privacy</a>',$description);
					$description = str_replace('terms_of_sale_link','<a href="'.localized_route('terms-of-sale').'" class="register-privacy-link"  target="_blank">terms of sale</a>',$description);
				}

			@endphp
			<div class="modal-body">
				<h3 class="text-success text-center">
					{{app()->getLocale() == 'nb' ? $setting_obj->get_value('register_success_title_no') : $setting_obj->get_value('register_success_title_en')}}
				</h3>
				<hr>
				<div>
					{!! $description !!}
				</div>
				@if(Auth::user() && Auth::user()->hasRole('sponsor'))
					<div class="text-center">
						<a class="select-ambassador-btn btn" href="{{localized_route('our-ambassadors')}}">{{ __('register.select your ambassador')  }}</a>
					</div>
				@endif
			</div>
		</div>
	</div>
</div> 