<?php
$helpers = new \App\Http\Helpers;
$all_codes = $helpers->getAllHTTPCodes();
$http_codes_allowed = ["200", "301", "302"];
$http_codes_allowed_string = implode(",", $http_codes_allowed);
?>

<label class="form-check-label">A page with the following HTTP Status codes should be considered a pass.</label>
<input class="d-none" type="text" id="http_status_code_accepted" value="{{$http_codes_allowed_string}}">



<div class="row">

<div class="col-md-6">


    <!-- Successful responses -->
    <div>
    <div class="category-header" data-bs-toggle="collapse" data-bs-target="#success">Successful responses <span class="toggle-icon">−</span></div>
    <div class="collapse show" id="success">
    @foreach($all_codes as $paramName => $value)
    @if($paramName >= 200 && $paramName < 300)
    <div class='form-check'>
        <input class='form-check-input http-checkbox' value="{{$paramName}}" type='checkbox' {{in_array($paramName, $http_codes_allowed) ? 'checked' : ''}}/>
        <label class='form-check-label'>{{$paramName}} - {{$value}}</label>
    </div>
    @endif
    @endforeach
    </div>
    </div>


</div>


<div class="col-md-6">
    <!-- Informational responses -->
    <div>
    <div class="category-header" data-bs-toggle="collapse" data-bs-target="#informational">Informational responses <span class="toggle-icon">−</span></div>
    <div class="collapse" id="informational">

    @foreach($all_codes as $paramName => $value)

    @if($paramName >= 100 && $paramName < 200)
    <div class='form-check'>
        <input class='form-check-input http-checkbox' value="{{$paramName}}" type='checkbox' {{in_array($paramName, $http_codes_allowed) ? 'checked' : ''}}/>
        <label class='form-check-label'>{{$paramName}} - {{$value}}</label>
    </div>
    @endif
    @endforeach

    </div>
    </div>

</div>

</div>

<div class="row">
<div class="col-md-6">



    <!-- Server error responses -->
    <div>
    <div class="category-header" data-bs-toggle="collapse" data-bs-target="#server">Server error responses <span class="toggle-icon">−</span></div>
    <div class="collapse" id="server">
    @foreach($all_codes as $paramName => $value)
    @if($paramName >= 500 && $paramName < 600)
    <div class='form-check'>
        <input class='form-check-input http-checkbox' value="{{$paramName}}" type='checkbox' {{in_array($paramName, $http_codes_allowed) ? 'checked' : ''}}/>
        <label class='form-check-label'>{{$paramName}} - {{$value}}</label>
    </div>
    @endif
    @endforeach
    </div>
    </div>


</div>
<div class="col-md-6">

    <!-- Redirection messages -->
    <div>
    <div class="category-header" data-bs-toggle="collapse" data-bs-target="#redirection">Redirection messages <span class="toggle-icon">−</span></div>
    <div class="collapse" id="redirection">
    @foreach($all_codes as $paramName => $value)
    @if($paramName >= 300 && $paramName < 400)
    <div class='form-check'>
        <input class='form-check-input http-checkbox' value="{{$paramName}}" type='checkbox' {{in_array($paramName, $http_codes_allowed) ? 'checked' : ''}}/>
        <label class='form-check-label'>{{$paramName}} - {{$value}}</label>
    </div>
    @endif
    @endforeach
    </div>
    </div>

</div>
</div>

<div class="row">
<div class="col-md-6">


    <!-- Client error responses -->
    <div>
    <div class="category-header" data-bs-toggle="collapse" data-bs-target="#client">Client error responses <span class="toggle-icon">−</span></div>
    <div class="collapse" id="client">
    @foreach($all_codes as $paramName => $value)
    @if($paramName >= 400 && $paramName < 500)
    <div class='form-check'>
        <input class='form-check-input http-checkbox' value="{{$paramName}}" type='checkbox' {{in_array($paramName, $http_codes_allowed) ? 'checked' : ''}}/>
        <label class='form-check-label'>{{$paramName}} - {{$value}}</label>
    </div>
    @endif
    @endforeach
    </div>
    </div>


</div>
</div>
