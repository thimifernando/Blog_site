@extends('layouts.app')
@section('title', 'Student')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            Details
        </div>
        <form action="{{ route('blog.status') }}" method="POST">
@csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="title" class="req_fld">Titleee</label>
                        <input class="form-control" type="text" disabled value="{{$blog->title}}">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="content" class="req_fld">content</label>
                        <input class="form-control" type="text" disabled value="{{$blog->content}}" autocomplete="off">
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="img" class="req_fld">Image</label>
                        <input class="form-control" type="text" disabled value="{{$blog->img}}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        {{-- {{dd($blog->status)}} --}}
                        <a href="{{ route('blog.index') }}" class="btn btn-info" type="button">Back</a>
                        <button class="btn btn-secondary" type="reset">Reset</button>
                        <input type="hidden" name="id" value="{{$blog->id}}">
                        @if ($blog->status)
                        <input type="hidden" name="status" value="0">
                        <button class="btn btn-danger float-right" type="submit">Deactivate Employee</button>
                        @else
                        <input type="hidden" name="status" value="1">
                        <button class="btn btn-primary float-right" type="submit">Activate Employee</button>
                        @endif
                    </div>
                </div>
            </div>
        </form>   
    </div>
</div>
        </form>



@endsection