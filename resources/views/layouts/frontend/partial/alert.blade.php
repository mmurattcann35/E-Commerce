@if($message = session()->get('success'))
    <div class="row">
        <div class="alert alert-info col-md-6 col-md-offset-3 text-center" >
            {{$message}}
        </div>
    </div>
@endif

@if($message = session()->get('error'))
    <div class="row">
        <div class="alert alert-danger col-md-6 col-md-offset-3 text-center" >
            {{$message}}
        </div>
    </div>
@endif
