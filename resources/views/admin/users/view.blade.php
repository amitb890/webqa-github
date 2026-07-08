
@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        @include('admin.components.message')

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All accounts</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0" style="min-height: 200px;">
                        <thead>
                            <tr>
                                <th>Email address</th>
                                <th>Signup date</th>
                                <th style="width: 160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        @if($user->deleted_at)
                                            <span class="badge badge-danger ml-1">Deleted</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($user->created_at)->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if(!$user->deleted_at)
                                                    <a class="dropdown-item" href="#"
                                                        onclick="event.preventDefault(); document.getElementById('reset-email-{{ $user->id }}').submit();">
                                                        Send Reset Password Email
                                                    </a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#resetPasswordModal{{ $user->id }}">
                                                        Reset Password
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item text-success" href="#"
                                                        onclick="event.preventDefault(); document.getElementById('launch-{{ $user->id }}').submit();">
                                                        Launch Account
                                                    </a>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        onclick="if (confirm('Delete account {{ $user->email }}?')) { event.preventDefault(); document.getElementById('delete-{{ $user->id }}').submit(); } else { event.preventDefault(); }">
                                                        Delete Account
                                                    </a>
                                                @else
                                                    <a class="dropdown-item text-success" href="#"
                                                        onclick="if (confirm('Activate account {{ $user->email }}?')) { event.preventDefault(); document.getElementById('activate-{{ $user->id }}').submit(); } else { event.preventDefault(); }">
                                                        Activate Account
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Hidden action forms -->
                                        @if(!$user->deleted_at)
                                            <form id="reset-email-{{ $user->id }}" action="{{ route('admin.user.reset-email', $user->id) }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                            <form id="launch-{{ $user->id }}" action="{{ route('admin.user.launch', $user->id) }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                            <form id="delete-{{ $user->id }}" action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <form id="activate-{{ $user->id }}" action="{{ route('admin.user.activate', $user->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No accounts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reset password modals -->
@foreach($users as $user)
    @if(!$user->deleted_at)
        <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.user.reset-password', $user->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Reset password &mdash; {{ $user->email }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="password-{{ $user->id }}">New password</label>
                                <input type="password" name="password" id="password-{{ $user->id }}" class="form-control" placeholder="At least 8 characters" required>
                            </div>
                            <div class="form-group mb-0">
                                <label for="password-confirm-{{ $user->id }}">Confirm password</label>
                                <input type="password" name="password_confirmation" id="password-confirm-{{ $user->id }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
