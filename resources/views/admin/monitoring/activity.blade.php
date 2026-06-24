@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Activity & Failures</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Activity & Failures</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tracked app actions</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.activity') }}" class="row mb-3">
                <div class="col-md-3">
                    <input type="date" name="date" value="{{ $date }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All statuses</option>
                        <option value="success" {{ $status === 'success' ? 'selected' : '' }}>Success</option>
                        <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="info" {{ $status === 'info' ? 'selected' : '' }}>Info</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.activity') }}" class="btn btn-default">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User / Email</th>
                            <th>Action</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>{{ $event->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ optional($event->user)->email ?: $event->email ?: 'Guest / unknown' }}</td>
                                <td>{{ \Illuminate\Support\Str::title(str_replace(['_', '-'], ' ', $event->action)) }}</td>
                                <td>{{ $event->source ?: 'App' }}</td>
                                <td>
                                    <span class="badge {{ $event->status === 'failed' ? 'badge-danger' : ($event->status === 'success' ? 'badge-success' : 'badge-info') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $event->message }}
                                    @if($event->context)
                                        <br>
                                        <small>{{ \Illuminate\Support\Str::limit(json_encode($event->context, JSON_UNESCAPED_SLASHES), 180) }}</small>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No tracked app actions found yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent signups</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($signups as $user)
                        <tr>
                            <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $user->name ?: 'Not provided' }}</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td>
                                <span class="badge {{ $user->deleted_at ? 'badge-danger' : 'badge-success' }}">
                                    {{ $user->deleted_at ? 'Deleted' : 'Signed up' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No signups found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
