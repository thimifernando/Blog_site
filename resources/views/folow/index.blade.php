@extends('layouts.app')
@section('title', 'Following Users')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('follow.create') }}" class="btn btn-info float-right" type="button">Add New Followers</a>
            </div>
            <form action="{{ url()->current() }}" method="GET">
                <!-- Add any form inputs here if needed -->
                <div class="card-footer">
                    <div class="row">
                        <!-- Add any additional footer content here if needed -->
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                Results
            </div>
            <div class="card-body">
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($following as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->fname }}</td>
                                <td>
                                    <form action="{{ route('follow.destroy', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Unfollow</button>
                                    </form>
                                </td>
                        
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Data Available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
