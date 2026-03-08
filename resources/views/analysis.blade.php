@extends('layouts.master')
@section("title")
Webpage Analysis Report | Webqa
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
<script src="{{ asset('new-assets/js/pdf-images.js') }}"></script>
<script src="{{ asset('new-assets/js/jspdf.umd.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/js/jspdf.plugin.autotable.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/js/roboto-fonts.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/js/analysis.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/js/export-pdf.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/js/exceljs.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/js/export-excel.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>

@endsection