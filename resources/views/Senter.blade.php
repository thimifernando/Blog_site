<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog Site Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .info-card {
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            background-color: #ffffff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .info-card h5 {
            margin-bottom: 1rem;
        }
        .info-card p {
            margin-bottom: 0.5rem;
        }
        .info-card i {
            font-size: 1.5rem;
            margin-right: 10px;
            color: #6c757d;
        }
    </style>
</head>
<body style="background-color: rgb(101, 99, 99)">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Blog Site</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
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
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @endauth
                    </li>

                </ul>
                <!-- Search form centered and full width -->

            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center text-white mb-4">Welcome to Our Blog Site!</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="info-card">
                    <h5><i class="bi bi-pencil"></i>User Features</h5>
                    <p>1. **Create Blogs**: Users can write and publish new blog posts.</p>
                    <p>2. **Update Blogs**: Users can edit their existing blog posts.</p>
                    <p>3. **Delete Blogs**: Users can remove their blog posts if needed.</p>
                    <p>4. **Save as Draft**: Users can save their blog posts as drafts and publish them later.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <h5><i class="bi bi-shield-lock"></i>Admin Features</h5>
                    <p>1. **Manage Users**: Admins have control over all user accounts.</p>
                    <p>2. **Manage Blogs**: Admins can oversee and manage all blog posts across the site.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <h5><i class="bi bi-chat-dots"></i>Interaction Features</h5>
                    <p>1. **Like Posts**: Logged-in users can like blog posts.</p>
                    <p>2. **Comment on Posts**: Users can leave comments on blog posts.</p>
                    <p>3. **Reply to Comments**: Users can reply to comments on their posts or others' posts.</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-primary">See More</a>
        </div>
    </div>

</body>
</html>
