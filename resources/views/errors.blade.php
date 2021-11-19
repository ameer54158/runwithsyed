@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0 pl-0">
            @foreach ($errors->all() as $error)
                <li class="list-unstyled">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif     


