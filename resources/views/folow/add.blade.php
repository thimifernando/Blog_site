@extends('layouts.app')
@section('title', 'Add Blog')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            Details
        </div>
        <form action="{{route('follow.store')}}" method="POST">
            @csrf
            
            <div class="col-md-12 form-group">
                <label for="user-select" class="req_fld">Folow Users</label>
                <div id="tag-container" class="border p-2" style="min-height: 50px;">
                    <!-- Tags will appear here -->
                </div>
                <select class="form-control mt-2" id="user-select">
                    <option value="" disabled selected>Select a user to follow</option>
                    @foreach($folow as $id => $fname)
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
