@extends('layouts.app')
@section('title', 'Blog')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            Search
            <a href="{{ route('blog.create') }}" class="btn btn-info float-right" type="button">Add New Blog</a>
        </div>
        <form action="{{ url()->current() }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="title">Title</label>
                        <input class="form-control" type="text" name="title" value="{{ request()->get('title') }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-secondary" type="button">Reset</a>
                        <button class="btn btn-primary float-right" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card mt-3">
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
                    @forelse ($blogs as $blog)
                        <tr>
                            <td>{{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}</td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->content }}</td>
                            <td>
                                @if($blog->img)
                                    <img src="{{ url('storage/' . $blog->img) }}" class="card-img-top blog-image" alt="{{ $blog->title }}" style="height: 100px; object-fit: cover;" data-toggle="modal" data-target="#imageModal" data-image="{{ url('storage/' . $blog->img) }}">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('blog.show', ['id' => $blog->id]) }}" class="btn btn-info">View</a>
                                <a href="{{ route('blog.destroy', ['blog' => $blog->id]) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                No Data Available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Custom Pagination Controls -->
            <div class="d-flex justify-content-between">
                @if ($blogs->onFirstPage())
                    <a href="#" class="btn btn-secondary disabled">Previous</a>
                @else
                    <a href="{{ $blogs->previousPageUrl() }}" class="btn btn-secondary">Previous</a>
                @endif

                @if ($blogs->hasMorePages())
                    <a href="{{ $blogs->nextPageUrl() }}" class="btn btn-secondary">Next</a>
                @else
                    <a href="#" class="btn btn-secondary disabled">Next</a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" id="modalImage" class="img-fluid" alt="Blog Image">
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.blog-image').forEach(image => {
            image.addEventListener('click', function () {
                const imageUrl = this.getAttribute('data-image');
                document.getElementById('modalImage').setAttribute('src', imageUrl);
            });
        });
    });
</script>
@endsection
