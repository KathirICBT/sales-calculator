<!-- resources/views/pages/userDashboard.blade.php -->

@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>User Dashboard</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ $user->name }}</h4>
                                <p class="mb-0">RESET PASSWORD</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img src="{{ asset('image/customer-support.jpg') }}" class="img-fluid illustration-img" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Info Section -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <section>
                                    <div class="container py-5">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="card mb-4">
                                                    <div class="card-body text-center">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                                            alt="avatar" class="rounded-circle img-fluid"
                                                            style="width: 70px;">
                                                        <h5 class="my-3">{{ $user->name }}</h5>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button type="button" id="forgotPasswordButton"
                                                        class="btn btn-primary btn-sm rounded-pill" data-toggle="modal"
                                                        data-target="#forgotPasswordModal">
                                                        Reset Password
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <p class="mb-0">Username:</p>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <p class="text-muted mb-0">{{ $user->username }}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- User Info Section end -->
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="forgotPasswordForm" method="POST" action="{{ route('user.resetPassword') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ $user->username }}" readonly>
                    </div>
                    <div class="form-group mt-3" id="newPasswordGroup">
                        <label for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="form-group mt-3" id="confirmPasswordGroup">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="newPassword_confirmation"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="resetPasswordButton">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#forgotPasswordButton').on('click', function() {            
            var username = '{{ $user->username }}';
            $('#username').val(username);
            $('#forgotPasswordModal').modal('show');
        });

        $('#forgotPasswordModal').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    });
</script>
@endsection
