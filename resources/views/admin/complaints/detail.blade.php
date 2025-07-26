<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.complaints.list') }}" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                    </a>
                </div>
                <h1 class="text-xl font-bold text-gray-900">Detail Pengaduan</h1>
                <div></div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Complaint Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ $complaint->title ?? 'Pengaduan #' . $complaint->id }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        Tiket: {{ $complaint->ticket }} •
                        Dibuat: {{ $complaint->created_at->format('d/m/Y H:i') }} •
                        Pelapor: {{ $complaint->user->name ?? 'Anonim' }}
                    </p>
                </div>
                @php
                    $status = $statusConfig[$complaint->status] ?? [
                        'label' => 'Unknown',
                        'color' => 'gray',
                    ];
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'accepted' => 'bg-blue-100 text-blue-800',
                        'in_progress' => 'bg-purple-100 text-purple-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                    ];
                    $statusColor = $statusColors[$complaint->status] ?? 'bg-gray-100 text-gray-800';
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                    {{ $status['label'] }}
                </span>
            </div>

            <div class="prose max-w-none">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                <p class="text-gray-700 mb-6">{{ $complaint->description ?? 'Tidak ada deskripsi' }}</p>

                @if ($complaint->location)
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Lokasi</h3>
                    <p class="text-gray-700 mb-6">
                        <i class="fas fa-map-marker-alt mr-2"></i>{{ $complaint->location }}
                    </p>
                @endif

                @if ($complaint->category)
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Kategori</h3>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-700">
                        <i class="fas fa-tag mr-2"></i>{{ $complaint->category }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>

            <form action="{{ route('admin.update-status', $complaint->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="accepted" {{ $complaint->status == 'accepted' ? 'selected' : '' }}>Diterima
                            </option>
                            <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>
                                Dalam Proses</option>
                            <option value="completed" {{ $complaint->status == 'completed' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan
                            (Opsional)</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Tambahkan catatan untuk perubahan status..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
