@extends('layouts.app')
@section('title')
Webqa - Analysis Report
@endsection

@section("content")
@include("components.loader")
@include("components.modal-fix")
@include("components.modal-update-status")
@include("components.modal-email")

<input hidden id="test_id" value="{{$data->ref_id}}">   
<input hidden id="extendedTilesVal" value="{{Auth::user()->extended_tiles}}">   

@include("components.analysis-page")


@endsection

@section("js")
<script src="{{ asset('new-assets/js/jspdf.umd.min.js') }}"></script>
<script src="{{ asset('new-assets/js/jspdf.plugin.autotable.min.js') }}"></script>
<script src="{{ asset('new-assets/js/analysis.js') }}"></script>
<script src="{{ asset('new-assets/js/export-pdf.js') }}"></script>
@endsection