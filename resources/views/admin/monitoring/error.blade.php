@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tests') }}">Tests</a></li>
                    <li class="breadcrumb-item active">Error Log</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Failure details</h3>
        </div>
        <div class="card-body">
            <p><strong>Date:</strong> {{ optional($date)->format('Y-m-d H:i:s') }}</p>
            <p><strong>Test URL:</strong> {{ $testedUrl }}</p>
            <pre style="white-space: pre-wrap;">{{ json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
        </div>
    </div>
</section>
@endsection
