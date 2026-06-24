@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tests</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Tests</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All tests</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.tests') }}" class="row mb-3">
                <div class="col-md-3">
                    <input type="date" name="date" value="{{ $date }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All results</option>
                        <option value="success" {{ $status === 'success' ? 'selected' : '' }}>Test Success</option>
                        <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Test Failed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.tests') }}" class="btn btn-default">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Test date</th>
                            <th>Test URL</th>
                            <th>Type</th>
                            <th>Source</th>
                            <th>Result</th>
                            <th>Cached Test Link</th>
                            <th>See Error Log</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                            <tr>
                                <td>{{ optional($row['date'])->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($row['url'] && $row['url'] !== 'Not captured')
                                        <a href="{{ $row['url'] }}" target="_blank">{{ \Illuminate\Support\Str::limit($row['url'], 70) }}</a>
                                    @else
                                        {{ $row['url'] }}
                                    @endif
                                </td>
                                <td>{{ $row['type'] }}</td>
                                <td>{{ $row['source'] }}</td>
                                <td>
                                    @if($row['result'] === 'success')
                                        <span class="badge badge-success">Test Success</span>
                                    @elseif($row['result'] === 'failed')
                                        <span class="badge badge-danger">Test Failed</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row['cached_url'])
                                        <a href="{{ $row['cached_url'] }}" target="_blank">Open</a>
                                    @else
                                        Not applicable
                                    @endif
                                </td>
                                <td>
                                    @if($row['error_url'])
                                        <a href="{{ $row['error_url'] }}">Show</a>
                                    @else
                                        Not applicable
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No tests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
