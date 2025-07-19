<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #121212;
        }

        .container {
            height: 100vh;
            background: #121212;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            flex-direction: column;
        }

        .login-box {
            background: #1e1e1e;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }

        .form-label {
            color: #e0e0e0;
        }

        .form-control {
            background-color: #2c2c2c;
            color: #ffffff;
            border: 1px solid #444;
        }

        .form-control:focus {
            background-color: #2c2c2c;
            color: #fff;
            border-color: #007bff;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .forgot-password {
            display: block;
            margin-top: 0.5rem;
            text-align: right;
            font-size: 0.9rem;
            color: #9e9e9e;
        }

        .forgot-password:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .link-hover:hover {
            color: #0d6efd !important;
            /* Bootstrap primary blue */
            text-decoration: underline !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2 class="text-center mb-4">Login</h2>
            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" id="email" required />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required />
                </div>
                <div class="d-flex justify-content-between mt-2 mb-2">
                    <a href="/register" class="text-decoration-none text-secondary link-hover">Have Account?
                        Register</a>
                    <a href="/forgot-password" class="text-decoration-none text-secondary link-hover">Forget
                        Password</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
            </form>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger col-md-6 mt-3" style="max-width: 400px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success col-mc-6 mt-3">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
