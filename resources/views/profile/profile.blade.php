@extends('layouts.app')
@section('title','Profile')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            Details
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="name" class="req_fld">First Name</label>
                    <input class="form-control" type="text" name="fname" value="{{auth()->user()->fname}} " readonly>
                    {{-- <input class="form-control" type="text" name="name" value="{{$user->name}}"> --}}

                </div>

                <div class="col-md-4 form-group">
                    <label for="contact_no" class="req_fld">Email</label>
                    <input class="form-control" type="text" name="contact_no" value="{{$use->email}}" readonly>

                </div>
            </div>
            <div class="row">


                <div class="col-md-4 form-group">
                    <label for="gender" class="req_fld">Mobile</label>
                    <input class="form-control" type="text" name="contact_no" value="{{$use->phone}}" readonly>
                   

                </div>


            </div>
            <div>
                <a href="{{ route('user.edit', ['user' => $use->id]) }}"
                     class="btn btn-warning">Edit</a>

                    </div>
        </div>
    </div> 

 @endsection   


