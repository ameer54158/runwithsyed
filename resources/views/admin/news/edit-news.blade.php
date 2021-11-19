<form action="{{route('admin.news.update',$news->id)}}" method="POST">
    @csrf @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="form-group col-md-6 mb-0">
                        <h6>English</h6>
                        <hr>
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <h6>Norwegian</h6>
                        <hr>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title_en" value="{{$news->title_en}}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title_no" value="{{$news->title_no}}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Description</label>
                        <textarea class="form-control" name="description_en" rows="5" required>{{$news->description_en}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Description</label>
                        <textarea class="form-control" name="description_no" rows="5" required>{{$news->description_no}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-row">
                    <div class="form-group">
                        <label for="title">Image</label>
                        <div class="clearfix"></div>
                        <div class="fileinput fileinput-new " data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="width: 90%; max-height: 150px;"></div>
                            <div class="ml-3">
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new btn btn-primary btn-sm"> Select image </span>
                                                    <input type="file" name="image">
                                                </span>
                                <a href="javascript:void(0);" class="btn red fileinput-exists btn btn-danger btn-sm" data-dismiss="fileinput"> Remove </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Update news</button>
    </div>
</form>