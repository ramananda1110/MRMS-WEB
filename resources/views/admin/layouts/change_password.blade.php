@extends('admin.layouts.master')

@section('content')
    <form id="changepasswordform" action="{{ route('password.change') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container mt-5">

            @if (Session::has('message'))
                <div class='alert alert-success'>
                    {{ Session::get('message') }}
                </div>
            @endif

            @if (Session::has('error'))
                <div class='alert alert-warning'>
                    {{ Session::get('error') }}
                </div>
            @endif





            <div class="row d-flex justify-content-center align-items-center ">
                <div class="col-sm-12 ">
                    <div class="card shadow">
                        <div class="card-header text-center ">Change Password</div>
                        <div class="card-body mt-1">

                            <div class="form-group mt-3">
                                <label for="current_password">Current Password</label>
                                <input type="password"
                                    class="form-control mt-1 @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control mt-1 @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" required>
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password"
                                    class="form-control mt-1 @error('password_confirmation') is-invalid @enderror"
                                    id="confirm_password" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <button type="button" class="w-25 btn btn-primary mt-4 mb-3"
                                id="savePasswordBtn">Update</button>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </form>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const changepasswordform = document.getElementById('changepasswordform');

        changepasswordform.addEventListener('submit', function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();
            event.stopPropagation();

            // Trigger form validation
            changepasswordform.classList.add('was-validated');

            if (changepasswordform.checkValidity()) {
                // If the form is valid, submit the form
                this.submit();
            }
        });

        // Add a click event listener to the confirmation button in the modal
        document.getElementById('savePasswordBtn').addEventListener('click', function() {
            // Manually trigger form submission
            changepasswordform.dispatchEvent(new Event('submit'));
        });

    });
</script>
