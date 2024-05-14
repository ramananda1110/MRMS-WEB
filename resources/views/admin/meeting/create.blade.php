@extends('admin.layouts.master')

@section('content')
<div class="container mt-5">
    @if(Session::has('message'))
        <div class='alert alert-success'>
            {{Session::get('message')}}
        </div>
     @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Create Meeting</li>
        </ol>
     </nav>

 <form action="{{route('users.store')}}" method="post", enctype="multipart/form-data">@csrf
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Meeting Information</div>

                <div class="card-body">


                    <div class="form-group  mt-2">
                        <label>Room</label>
                        <select class="form-control mt-1" name="department_id"
                        require="">
                            @foreach(App\Models\Room::all() as $room)
                            <option value="{{$room->id}}">{{$room->name}}</option>
                            @endforeach
                        </select>


                    </div>

                    <div class="form-group  mt-2">
                        <label>Start Date</label>
                        <input  name="start_from"
                        class="form-control" required="" placeholder="yy-mm-dd" id="datepicker">

                        @error('start_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="form-group  mt-2">
                        <label>From</label>
                        <input  name="start_from"
                        class="form-control" required="" placeholder="10:00" id="datepicker2">

                        @error('start_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>


                    <div class="form-group  mt-2">
                        <label>To</label>
                        <input  name="start_from"
                        class="form-control" required="" placeholder="11:00" id="datepicker">

                        @error('start_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>



                    <div class="form-group mt-2">
                        <label>Co-Host</label>
                        <select  name="department_id" class="form-select" id="select_box">
                            @foreach(App\Models\Employee::all() as $employee)
                            <option value="{{$employee->employee_id}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group  mt-2">
                    <label>Participant</label>

                            <select id="choices-multiple-remove-button" placeholder="Select up to 25 Participants" multiple>
                            @foreach(App\Models\Employee::all() as $employee)
                            <option value="{{$employee->employee_id}}">{{$employee->name}}</option>
                            @endforeach
                            </select>
                    </div>



                    <div class="form-group mt-3">
                        <button class="btn btn-outline-primary">Submit</button>
                    </div>



            </div>



        </div>


      </div>
    </form>
</div>
@endsection



<script>

    var select_box_element = document.querySelector('#select_box');

    dselect(select_box_element, {
        search: true
    });

</script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var selectElement = document.getElementById('choices-multiple-remove-button');
         

            var choices = new Choices(selectElement, {
                removeItemButton: true,
                maxItemCount: 25
            });
        });
    </script>

   

