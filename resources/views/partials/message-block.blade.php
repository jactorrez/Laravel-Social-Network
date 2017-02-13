@if(count($errors) > 0 )
    <div class="row">
        <div class="col-md-6 col-md-offset-4 alert alert-danger " role="alert">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    </div> 

@endif

@if(Session::has('message'))

 <div class="row">
    <div class="col-md-6 col-md-offset-3 alert alert-info " role="alert">
        {{ session('message') }}
    </div>
 </div> 

@endif