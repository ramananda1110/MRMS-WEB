@extends('layouts.app')

@section('content')
    <section>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="container py-5 h-100 ">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-2-strong" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center shadow-lg">

                                <img src="../images/mrms_logo_2.png" class="rounded  w-50 mb-4" alt="Cinque Terre">


                                <div data-mdb-input-init class="form-outline mb-4">
                                    <h5 for="number" class="text-start">{{ __('Employee ID') }}</h5>
                                    <input type="number"
                                        id="employee_id"class="form-control  form-control-lg @error('employee_id') is-invalid @enderror"
                                        name="employee_id" />
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <h5 for="password" class="text-start">{{ __('Password') }}</h5>
                                    <input type="password"
                                        id="password"class="form-control  form-control-lg @error('employee_id') is-invalid @enderror"
                                        name="password" />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Checkbox -->
                                <div class="form-check d-flex justify-content-end mb-4">
                                    <a class="form-check-label" for="form1Example3"> Forgot Password? </a>
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
@endsection
