function profile_register_km_date_picker(this_obj=''){
    var minDate = 0;
    var currentTime = new Date();
    minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), +1);

    var new_this_obj = '';
    if(this_obj){
        new_this_obj = this_obj;
    }else{
        new_this_obj = '#datepicker';
    }
    $(new_this_obj).datepicker({
        startDate: minDate ? minDate : new Date(1999, 10 - 1, 25),
        endDate: '-0d',
        todayHighlight:'TRUE',
        autoclose: true,
        language: 'no',
        clearBtn: true,
        weekStart: 1,
    });
}
$(document).on('click','.calendar-btn',function (e) {
    $(this).closest('.form-row').find('#datepicker').focus().trigger('focusin');
    });

$(document).on("focusin","#datepicker", function () {
    profile_register_km_date_picker($(this));
});

$(document).on('click','[data-initiator="show-edit-modal"]',function (e) {
    e.preventDefault();
    var action = $(this).data('ajaxurl');
    var modal_id = $(this).data('target');
    //Change the modal size
    if($(this).data('modal_size')){
        $(modal_id).find('.modal-dialog').addClass($(this).data('modal_size'));
    }
    //Change the modal title
    if($(this).data('modal_title')){
        $(modal_id).find('.modal-title').html($(this).data('modal_title'));
    }
    $(modal_id).find('#ws-dynamic-content').hide();
    $(modal_id).find('#modal-loader').show();
    $.ajax({
        type: "GET",
        url: action,
        dataType :"Json",
        success:function(response){
            $(modal_id).find('#modal-loader').hide();
            $(modal_id).find('#ws-dynamic-content').show();
            $(modal_id).find('#ws-dynamic-content').html(response.data);
        },
        failure:function () {
            $(modal_id).find('#modal-loader').hide();
        }
    });
});

// attach the url to delete modal
$(document).on('click','[data-initiator="show-delete-modal"]',function (e) {
    var ajaxurl = $(this).data('action');
    $('#deleteForm').attr('action', ajaxurl);
    if($(this).data('message')){
        $('#deleteForm .extra-message').html($(this).data('message'));
    }
});

$(document).ready(function () {

    $( "#donationmodal input[type='radio']" ).change(function() {
        var val = $(this).val();
        $('#donationmodal .amount-input').addClass('d-none');
        $('#donationmodal .amount-input input').removeAttr('required');

        if(val === 'custom_amount'){
            $('#donationmodal .amount-input').removeClass('d-none');
            $('#donationmodal .amount-input input').attr('required','required');
        }
    });
});

$(document).on('change','[data-ajaxaction="get-user-ambassador-or-paying-month"]',function (e) {
    e.preventDefault();
    var element = $(this);
    var user_id = element.val();
    var url = element.data('ajaxurl');
    element.closest('form').find('.month-section').addClass('d-none').find('select').prop('required',false).find('option').remove();
    element.closest('form').find('.ambassador-section').addClass('d-none').find('select').prop('required',false).find('option').remove();
    $(this).closest('form').find('.amount').css({'background-color':'white','pointer-events':'auto'}).val('');

    if(user_id){
        $.ajax({
            type: "get",
            url: url,
            dataType :"Json",
            data: {'user_id':user_id},
            success:function(response){
                if(response.record_type == 'user ambassadors'){
                    element.closest('form').find('.ambassador-section').removeClass('d-none').find('select').prop('required',true).append(response.data);
                }

                if(response.record_type == 'paying month'){
                    element.closest('form').find('.month-section').removeClass('d-none').find('select').prop('required',true).append(response.data);
                }
            },
            failure:function () {

            }
        });
    }

});

$(document).on('change','[data-ajaxaction="get-user-paying-month"]',function (e) {
    e.preventDefault();
    var element = $(this);
    var ambassador_id = element.val();
    var sponsor_id = '';
    if(element.closest('form').find('select[name="user_id"]').length){
        sponsor_id = element.closest('form').find('select[name="user_id"]').val();
    }else{
        sponsor_id = $(this).data('sponsor_id');
    }

    if(element.closest('#sponsor_pay_amount_modal').length){
        element.closest('form').find('button[type="submit"]').addClass('d-none');
        var form_url = element.closest('form').data('url');
        if(ambassador_id){
            form_url = form_url.replace('#',ambassador_id);
            element.closest('form').attr('action',form_url);
        }else{
            element.closest('form').attr('action','');
        }
    }

    var url = element.data('ajaxurl');
    element.closest('form').find('.month-section, .no-month-found-msg').addClass('d-none').find('select').prop('required',false).find('option').remove();
    $(this).closest('form').find('.amount').css({'background-color':'white','pointer-events':'auto'}).val('');
    $(this).closest('form').find('.total_amount').val('');


    if(ambassador_id && sponsor_id){
        $.ajax({
            type: "get",
            url: url,
            dataType :"Json",
            data: {'ambassador_id':ambassador_id,'sponsor_id':sponsor_id},
            success:function(response){
                element.closest('form').find('.month-section').removeClass('d-none').find('select').prop('required',true).append(response.data);
                if(response.data && element.closest('form').find('button[type="submit"]').length){
                    element.closest('form').find('button[type="submit"]').removeClass('d-none');
                }
                if(!response.data && element.closest('#sponsor_pay_amount_modal').length){
                    element.closest('form').find('.month-section').addClass('d-none');
                    element.closest('form').find('.no-month-found-msg').removeClass('d-none');
                }
            },
            failure:function () {

            }
        });
    }
});

//assign total amount and kms for multiselect box
$('.custom-payment-form select[name="month_year[]"].select2, #sponsor_pay_amount_modal select[name="month_year[]"].select2').on("select2:select select2:unselect", function (e) {
    var items = '"'+$(this).val()+'"';
    var total_km = 0;
    var this_obj = $(this);
    if(items){
        if(items.search(",") !== -1 ){
            items = items.replace(/"/gi, "");
            var explode = items.split(',');
            $( explode ).each(function( index, value ) {
                var val = value.replace('"','');
                total_km = total_km + (this_obj.find("option[value='"+val+"']").data('total_km'));
            });
            $(this).closest('form').find('.amount, .total_amount').css({'background-color':'#e9ecef','pointer-events':'none'}).val(total_km);
        }else{
            items = items.replace('"','');
            items = items.replace('"','');
            $(this).closest('form').find('.amount').css({'background-color':'white','pointer-events':'auto'}).val(this_obj.find("option[value='"+items+"']").data('total_km'));
            $(this).closest('form').find('.total_amount').val(this_obj.find("option[value='"+items+"']").data('total_km'));
        }
    }
});