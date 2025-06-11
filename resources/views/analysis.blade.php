@extends('layouts.master')
@section("title")
webqa - Analysis
@endsection
@section("content")
@include("components.modal-fix")
@include("components.modal-update-status")
@include("components.modal-email")

<input hidden id="test_id" value="{{$id}}">   
<input hidden id="extendedTilesVal" value="1">   

<main class="main-sections" style="padding-block: 72px;">
    <div class="inner_content">
        <div class="container">
        @include("components.loader")

        @include("components.analysis-page")
        </div>
    </div>
</main>

@endsection

@section("js")
<script src="{{ asset('new-assets/js/analysis.js') }}"></script>
@endsection