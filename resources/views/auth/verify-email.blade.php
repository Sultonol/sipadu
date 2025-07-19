<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-sm border-0 p-4" style="max-width: 450px; width: 100%;">
        <div class="text-center mb-4">
            <img src="https://cdn-icons-png.flaticon.com/512/561/561127.png" alt="Email Icon" width="70" class="mb-3">
            <h4 class="fw-bold">Verifikasi Email Anda</h4>
            <p class="text-muted small mb-0">
                Kami telah mengirim email verifikasi ke alamat Anda. Silakan cek inbox atau folder spam.
            </p>
        </div>

        @if (session('resent'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Link verifikasi baru telah dikirim ke email Anda!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    Kirim Ulang Email Verifikasi
                </button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none small text-primary">Sudah verifikasi? Login di sini</a>
        </div>
    </div>

    {{-- Bootstrap JS (opsional) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
