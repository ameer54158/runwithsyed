$(document).ready(function () {

    $(document).ajaxStart(function() {
        $('.loader-section').removeClass('d-none');
        if($('.instagram-feed-section .show_more_feed_button').length){
            $('.instagram-feed-section .show_more_feed_button').addClass('disabled');
        }
    });
    $(document).ajaxStop(function() {
        $('.loader-section').addClass('d-none');

        if($('.instagram-feed-section .show_more_feed_button').length){
            $('.instagram-feed-section .show_more_feed_button').removeClass('disabled');
        }
    });

    if($('.our-ambassadors-page .sort-ambassador-dropdown').length){
        var dropdown_width = $('.our-ambassadors-page .sort-ambassador-dropdown').outerWidth();
        $('.our-ambassadors-page .dropdown-menu').css('width',dropdown_width+'px');
    }

    //assign total amount and kms for multiselect box
    $('#pay_amount_modal select.select2').on("select2:select select2:unselect", function (e) {
        var items = '"'+$(this).val()+'"';
        var total_km = 0;
        if(items){
            if(items.search(",") !== -1 ){
                var explode = items.split(',');
                $( explode ).each(function( index, value ) {
                    var val = value.replace('"','');
                    total_km = total_km + ($("#pay_amount_modal select.select2 option[value='"+val+"']").data('total_km'));
                });
                $(this).closest('#pay_amount_modal').find('.amount, .total_amount').val(total_km);

                if(('#pay_amount_modal.ambassador-pay-modal').length){
                    $(this).closest('#pay_amount_modal').find('.amount').css('background-color','#e9ecef');
                    $(this).closest('#pay_amount_modal').find('.amount').css('pointer-events','none');
                }
            }else{
                items = items.replace('"','');
                items = items.replace('"','');
                $(this).closest('#pay_amount_modal').find('.amount, .total_amount').val($("#pay_amount_modal select.select2 option[value='"+items+"']").data('total_km'));
                if(('#pay_amount_modal.ambassador-pay-modal').length){
                    $(this).closest('#pay_amount_modal').find('.amount').css('background-color','white');
                    $(this).closest('#pay_amount_modal').find('.amount').css('pointer-events','auto');
                }
            }
        }
    })

});