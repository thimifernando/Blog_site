@extends('layouts.app')
@section('title', 'Blog')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('myblog.create') }}" class="btn btn-info float-right" type="button">Add New Blog</a>
        </div>
        <form action="{{ url()->current() }}">
            <div class="card-footer">
                <div class="row">
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
                        <th>Title</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blog as $blog)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->content }}</td>
                        <td>
                            <img src="{{ url('storage/' . $blog->img) }}" class="card-img-top blog-image" alt="{{ $blog->title }}" style="height: 100px; object-fit: cover;" data-toggle="modal" data-target="#imageModal" data-image="{{ url('storage/' . $blog->img) }}">
                        </td>
                        <td>
                            <!-- Flex container for buttons -->
                            <div class="d-flex align-items-center">
                                <!-- Dropdown for status -->
                                <div class="dropdown mr-2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown{{ $blog->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $blog->status == 1 ? 'Published' : 'Unpublished' }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="statusDropdown{{ $blog->id }}">
                                        <a class="dropdown-item" href="{{ route('myblog.updateStatus', ['id' => $blog->id, 'status' => 1]) }}">Publish</a>
                                        <a class="dropdown-item" href="{{ route('myblog.updateStatus', ['id' => $blog->id, 'status' => 0]) }}">Unpublish</a>
                                        {{-- <a class="dropdown-item" href="{{ route('myblog.updateStatus', ['id' => $blog->id, 'status' => 2]) }}"></a> --}}
                                    </div>
                                </div>
                                <!-- Edit button -->
                                <a href="{{ route('myblog.edit', ['id' => $blog->id]) }}" class="btn btn-warning mr-2">Edit</a>
                                <!-- Delete button -->
                                <a href="{{ route('myblog.destroy', ['id' => $blog->id]) }}" class="btn btn-danger">Delete</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="modalImage" class="img-fluid" alt="Blog Image">
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.blog-image').on('click', function () {
            const imageUrl = $(this).data('image');
            $('#modalImage').attr('src', imageUrl);
        });
    });
</script>
@endsection
