@extends('layouts.app')

@section('content')
    <section>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="container py-5 h-100 ">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-2-strong shadow-lg" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center ">

                                <img src="../images/mrms_logo_2.png" class="rounded  w-50 mb-4" alt="Cinque Terre">


                                <div data-mdb-input-init class="form-outline mb-4">
                                    <h5 for="number" class="text-start">{{ __('Employee ID') }}</h5>
                                    <input type="number"
                                        id="employee_id"class="form-control  form-control-lg @error('employee_id') is-invalid @enderror"
                                        name="employee_id" />
                                    @error('employee_id')
                                        <span class="invalid-feedback text-start" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <h5 for="password" class="text-start">{{ __('Password') }}</h5>
                                    <div class="input-group">
                                        <input type="password" id="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            name="password" />
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @error('password')
                                            <span class="invalid-feedback text-start" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>


                               

                                {{-- <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block"
                                type="submit">Login</button> --}}

                                <button type="submit"
                                    class="btn btn-primary btn-block mb-4 w-50 d-flex justify-content-center mx-auto">
                                    {{ __('Login') }}
                                </button>

                                <hr class="my-4">



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            console.log("Toggle button clicked");
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Toggle eye icon
            const eyeIcon = togglePassword.querySelector('i');
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
