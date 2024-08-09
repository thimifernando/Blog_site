@extends('layouts.app')
@section('title', 'Add Blog')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            Details
        </div>
        <form action="{{ route('myblog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="title" class="req_fld">Title</label>
                        <input class="form-control" type="text" name="title" value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="img" class="req_fld">Image</label>
                        <input class="form-control" type="file" name="img" accept="image/jpeg, image/png,image/jpg">
                        @error('img')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="content" class="req_fld">Content</label>
                        <textarea class="form-control" name="content" id="content" cols="90" rows="10" autocomplete="off">{{ old('content') }}</textarea>
                        @error('content')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="status" class="req_fld">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Publish</option>
                            <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Save as Draft</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="user-select" class="req_fld">Tag Users</label>
                        <div id="tag-container" class="border p-2" style="min-height: 50px;">
                            <!-- Tags will appear here -->
                        </div>
                        <select class="form-control mt-2" id="user-select">
                            <option value="" disabled selected>Select a user to tag</option>
                            @foreach($nonAdminUsers as $id => $fname)
                                <option value="{{ $id }}">{{ $fname }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <button class="btn btn-secondary" type="reset">Reset</button>
                        <button class="btn btn-primary float-right" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userSelect = document.getElementById('user-select');
        const tagContainer = document.getElementById('tag-container');

        userSelect.addEventListener('change', function () {
            const userId = this.value;
            const userName = this.options[this.selectedIndex].text;

            // Check if the user is already tagged
            if (document.querySelector(`input[name="user_id[]"][value="${userId}"]`)) {
                return;
            }

            // Create tag element
            const tag = document.createElement('div');
            tag.classList.add('badge', 'badge-primary', 'mr-2', 'mb-2', 'p-2', 'd-inline-flex', 'align-items-center');
            tag.innerHTML = `
                ${userName}
                <button type="button" class="btn btn-sm btn-light ml-2 p-0" aria-label="Remove" style="line-height: 0.5;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="user_id[]" value="${userId}">
            `;

            // Remove tag on click
            tag.querySelector('button').addEventListener('click', function () {
                tag.remove();
            });

            // Append tag to container
            tagContainer.appendChild(tag);

            // Reset the select input
            userSelect.value = '';
        });
    });
</script>

@endsection
