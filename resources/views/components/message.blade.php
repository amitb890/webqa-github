@if(Session::has('message'))

@if (session()->has('message'))
    <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show">
        <span>{!! session('message') !!}</span>
        <button type="button" class="btn"></button>
    </div>
@endif

@endif