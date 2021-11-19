<form action="{{route('admin.users.update',$user->id)}}" method="POST">
    @csrf @method('PUT')
    <div class="modal-body">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Role</label>
                <input type="text" class="form-control" disabled value="{{$user->roles->first()->name}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label>First name</label>
                <input type="text" class="form-control" name="first_name" value="{{old('first_name',$user->first_name)}}">
            </div>
            <div class="form-group col-md-4">
                <label>Last name</label>
                <input type="text" class="form-control" name="last_name" value="{{old('last_name',$user->last_name)}}">
            </div>
            <div class="form-group col-md-4">
                <label>Mobile no</label>
                <input type="number" class="form-control" name="mobile_no" value="{{old('mobile_no',$user->mobile_no)}}" min="1" onkeydown="if(event.key==='-' || event.key==='+' || event.key==='.'){event.preventDefault();}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" autocomplete="new-email" value="{{old('email',$user->email)}}" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" autocomplete="new-password" name="password">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm">Update user</button>
    </div>
</form>