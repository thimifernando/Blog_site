<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .card {
            margin-bottom: 1.5rem;
        }
        .card-img-top {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            cursor: pointer;
        }
        .avatar-icon {
            font-size: 2rem;
            margin-right: 10px;
            color: #6c757d;
        }
        .modal-header .avatar-icon {
            font-size: 1.5rem;
        }
        .modal-body img {
            width: 100%;
            height: auto;
        }
        .comment-section {
            margin-top: 1.5rem;
        }
        .comment-form textarea {
            resize: none;
        }
        .reply-form {
            margin-top: 1rem;
            padding-left: 2rem;
            border-left: 2px solid #e9ecef;
        }
        .replies-list {
            padding-left: 2rem;
            border-left: 2px solid #e9ecef;
            margin-top: 1rem;
        }
        .reply {
            margin-bottom: 1rem;
        }
        .like-section {
            margin-top: 1rem;
        }
        .comment-content {
            display: flex;
            align-items: center;
        }
        .comment-content i,
        .reply-content i {
            font-size: 1.5rem;
            margin-right: 10px;
            color: #6c757d;
        }
        .tags-container {
            margin-top: 1rem;
        }
        .tags-container .badge {
            margin-right: 5px;
        }
        .navbar .form-control {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body style="background-color: rgb(101, 99, 99)">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('senter') }}">Back</a>
                    </li>
                    <li class="nav-item">
                        @auth
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger w-100">
                              <i class="fas fa-sign-out-alt"></i>
                              Logout
                            </button>
                        </form>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('dashboard') }}">Go to Panel</a>
                        </li>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @endauth
                    </li>

                </ul>
                <!-- Search form centered and full width -->
                <form class="d-flex ms-auto" method="GET" action="{{ route('home') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder=" title or user name" aria-label="Search" value="{{ request('search') }}">
                    <button class="btn btn-outline-success me-2" type="submit">Search</button>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Reset</a>
                </form>
            </div>
        </div>
    </nav>

    <br><br>

    <div class="container">
        @if ($blogs->isEmpty())
            <h1 class="text-center text-white">No Blog found</h1>
        @else
            <div class="row">
                @foreach ($blogs as $blog)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="user-info">
                                <i class="bi bi-person avatar-icon"></i>
                                <div>
                                    <strong>{{ $blog->user->fname ?? 'Unknown User' }}</strong><br>
                                    <small class="text-muted">Posted on {{ $blog->created_at->format('F j, Y \a\t g:i A') }}</small>
                                </div>
                            </div>
                            @if ($blog->img)
                            <img src="{{ url('storage/' . $blog->img) }}" class="card-img-top" alt="{{ $blog->title }}" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ url('storage/' . $blog->img) }}">
                            @endif
                            <h5 class="card-title mt-3">Title:{{ $blog->title }}</h5>
                            <p class="card-text">{{ $blog->content }}</p>

                            <!-- Display Tags -->
                            @if ($blog->tags->isNotEmpty())
                            <div class="tags-container">
                                <h6>Tags:</h6>
                                @foreach ($blog->tags as $tag)
                                <span class="badge bg-primary">{{ $tag->user->fname }}</span>
                                @endforeach
                            </div>
                            @endif

                            @auth
                            <!-- Like Section -->
                            <div class="like-section">
                                @if ($blog->likes->contains('user_id', auth()->id()))
                                <form action="{{ route('likes.destroy', $blog->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-heart-fill"></i> Unlike ({{ $blog->like_count }})
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('likes.store') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="bi bi-heart"></i> Like ({{ $blog->like_count }})
                                    </button>
                                </form>
                                @endif
                            </div>

                            <!-- Comment Section -->
                            <div class="comment-section">
                                <h6>Comments</h6>
                                <div class="comments-list">
                                    @foreach ($blog->comments as $comment)
                                    <div class="comment mb-2">
                                        <div class="comment-content">
                                            <i class="bi bi-person avatar-icon"></i>
                                            <div>
                                                <strong>{{ $comment->user->fname ?? 'Anonymous' }}:</strong>
                                                <p>{{ $comment->content }}</p>
                                                <small class="text-muted">Commented on {{ $comment->created_at->format('F j, Y \a\t h:i A') }}</small>
                                            </div>
                                        </div>

                                        <!-- Reply Form -->
                                        <div class="reply-form">
                                            <h6>Reply</h6>
                                            <form action="{{ route('replies.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="content" rows="2" placeholder="Add a reply..."></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-2">Post Reply</button>
                                            </form>
                                        </div>

                                        <!-- Display Replies -->
                                        <div class="replies-list">
                                            @foreach ($comment->replies as $reply)
                                            <div class="reply">
                                                <div class="reply-content">
                                                    <i class="bi bi-person avatar-icon"></i>
                                                    <div>
                                                        <strong>{{ $reply->user->fname ?? 'Anonymous' }}:</strong>
                                                        <p>{{ $reply->content }}</p>
                                                        <small class="text-muted">Replied on {{ $reply->created_at->format('F j, Y \a\t h:i A') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Comment Form -->
                                <h6>Add a Comment</h6>
                                <form action="{{ route('comments.store') }}" method="POST" class="comment-form">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                    <div class="form-group">
                                        <textarea class="form-control" name="content" rows="3" placeholder="Add a comment..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                                </form>
                            </div>
                            @else
                            <!-- For not-logged-in users -->
                            <div class="like-section">
                                <p class="text-muted mt-2">Please <a href="{{ route('login') }}">log in</a> to like and comment this blog.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-4">
                @if ($blogs->onFirstPage())
                    <span class="btn btn-secondary disabled me-2">Previous</span>
                @else
                    <a href="{{ $blogs->previousPageUrl() }}" class="btn btn-primary me-2">Previous</a>
                @endif

                @if ($blogs->hasMorePages())
                    <a href="{{ $blogs->nextPageUrl() }}" class="btn btn-primary">Next</a>
                @else
                    <span class="btn btn-secondary disabled">Next</span>
                @endif
            </div>
        @endif
    </div>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="bi bi-person avatar-icon"></i>
                    <h5 class="modal-title ms-2" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" alt="Blog Image" id="modalImage">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal image preview
        var imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var imageUrl = button.getAttribute('data-bs-image');
            var modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageUrl;
        });
    </script>
</body>
</html>
