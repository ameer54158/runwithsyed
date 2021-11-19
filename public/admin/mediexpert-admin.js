$(document).ready(function () {

    $(document).ajaxStart(function() {
        $("#generic-loader").show();
    });
    $(document).ajaxStop(function() {
        $("#generic-loader").hide();
    });

    $('#sidebarCollapse').on('click', function () {
        $('body').toggleClass('collapse-sidebar');
        $(this).children('svg').toggleClass('fa-bars fa-align-left');
        localStorage.getItem("collapse-sidebar") ? localStorage.removeItem("collapse-sidebar") : localStorage.setItem("collapse-sidebar",true);
    });

    if($('textarea.text-editor').length){
        tinymce.init({
            menubar: false, // remove menubar if you want to show the menubar
            statusbar: false,
            selector: 'textarea.text-editor',

            height: 250,
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
    }

    //Change the status
    $(document).on('click', '.status', function(e) {
        var id = ($(this).attr('id'));
        var class_name = $(this).data('model_name');
        var column_name = $(this).data('column_name');
        id = id.replace(/\D/g,'');
        if ($(this).is(":checked")) {
            var status = 1;
        }
        else {
            var status = 0;
        }
        var action = $(this).data('ajaxurl');
        if(action){
            $.ajax({
                url: action,
                type:'GET',
                data: {'id':id,'status':status,'class_name':class_name,'column_name':column_name},
                dataType:'json',
                success: function (data) {
                    // location.reload();
                }
            });
        }
    });


    var _URL = window.URL || window.webkitURL;
    $(".single-image-input").change(function(e) {
        var size = $(this).closest('.form-row').find('.image-size').data('size');
        if(size){
            e.preventDefault();
            var split_size = size.split('x');
            var img_width = split_size[0];
            var img_height = split_size[1];
            var file, img;
            $("form").unbind();
            $('#image-size-error').remove();

            if (img_width && img_height && (file = this.files[0])) {
                img = new Image();
                img.onload = function() {
                    if(img_width > this.width || img_height > this.height ){
                        alert('Minimum image size will be '+img_width+"px" + " X " + img_height+"px");

                        $("form").submit(function(e){
                            e.preventDefault();
                        });
                        $('.fileinput.fileinput-exists').append('<span style="color:red;" class="font-weight-bold" id="image-size-error">Enter Valid Image Size</span>');

                    }else{

                    }
                };
                img.onerror = function() {
                    alert( "not a valid file: " + file.type);
                };
                img.src = _URL.createObjectURL(file);
            }
        }
    });


    //remove single image
    $(document).on('click','.remove-single-image',function (e) {
        var filename = $(this).attr('id');
        var delete_media = $('.deleted_media').val();
        var dataArr = [];
        if(delete_media){
            delete_media = JSON.parse(delete_media);
            if(delete_media){
                dataArr[0] = filename;
                $.each(delete_media, function (index, value) {
                    dataArr[index+1] = value;
                });
            }
        }else{
            dataArr[0] = filename; //JSON.stringify(filename);
        }

        if(filename && dataArr.length){
            $('.deleted_media').val(JSON.stringify(dataArr));
        }
    });

});