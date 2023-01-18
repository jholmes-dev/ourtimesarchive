@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <h2>Your Account</h2>
</div>

<div class="container md-wrapper">

    <div class="basic-info mb-5">
        <h3>Basic Info</h3>
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="info-group">
                            <h6>Name</h6>
                            <p>{{ $user->name }}</p>
                        </div>
                            

                        <div class="info-group mb-md-0">
                            <h6>Email</h6>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="info-group">
                            <h6>Active Vaults</h6>
                            <p>{{ $user->vaults->count() }}</p>
                        </div>
                            

                        <div class="info-group mb-0">
                            <h6>Current Entries</h6>
                            <p>{{ $user->entries->count() }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="password-change mb-5">
        <h3>Change Password</h3>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('user.password.change') }}" method="POST">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Current Password" required>
                        <label for="current_password">Current Password</label>

                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="New Password" required>
                        <label for="new_password">New Password</label>

                        @error('new_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" placeholder="Confirm Password" required>
                        <label for="new_password_confirmation">Confirm New Password</label>

                        @error('new_password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="text-end">
                        <input type="submit" value="Update Password" class="btn btn-outline-primary">
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="close-account mb-5">
        <h3>Delete Account</h3>
        <div class="card">
            <div class="card-body">

                <p>You can use the button below to permanently delete your account. This process cannot be undone, will delete your account, and:</p>

                <ul>
                    <li>Any entries you've created among all vaults will be deleted</li>
                    <li>You will be removed from any vaults you're currently in</li>
                    <li>Any vaults where you're the last member will be permanently deleted</li>
                </ul>

                <div class="mt-4 text-center">
                    <button type="button" class="btn btn-outline-danger">Permanently Delete My Account</button>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
