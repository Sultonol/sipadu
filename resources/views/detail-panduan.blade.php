<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan - {{ $complaint->ticket }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    @php
        $status = $statusConfig[$complaint->status] ?? ['label' => 'Unknown', 'color' => 'gray', 'icon' => 'fas fa-file'];
    @endphp

    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-4xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button onclick="history.back()" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-arrow-left text-gray-600"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Detail Pengaduan</h1>
                        <p class="text-sm text-gray-500">{{ $complaint->ticket }}</p>
                    </div>
                </div>
                @if(Auth::id() === $complaint->user_id)
                    <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-6">
        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-sm border mb-6">
            <div class="bg-{{ $status['color'] }}-50 p-6 rounded-t-xl border-b">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-{{ $status['color'] }}-100 rounded-lg flex items-center justify-center">
                            <i class="{{ $status['icon'] }} text-{{ $status['color'] }}-600"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $complaint->title ?? 'Pengaduan #' . $complaint->id }}</h2>
                            <span class="inline-block px-3 py-1 bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 rounded-full text-sm font-medium mt-2">
                                {{ $status['label'] }}
                            </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Tiket</p>
                        <p class="font-bold text-{{ $status['color'] }}-600">{{ $complaint->ticket }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- Deskripsi -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-file-text mr-3 text-blue-600"></i>Deskripsi
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $complaint->description ?? 'Tidak ada deskripsi.' }}</p>
                </div>

                <!-- Lokasi -->
                @if($complaint->location)
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt mr-3 text-red-600"></i>Lokasi
                    </h3>
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-700">{{ $complaint->location }}</p>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($complaint->location) }}" 
                               target="_blank" 
                               class="inline-flex items-center mt-3 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                <i class="fas fa-external-link-alt mr-2"></i>Lihat di Maps
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Foto -->
                @if($complaint->images && count($complaint->images) > 0)
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-camera mr-3 text-purple-600"></i>Foto Bukti
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($complaint->images as $image)
                            <img src="{{ $image }}" alt="Bukti" class="w-full h-32 object-cover rounded-lg border hover:shadow-lg transition-shadow cursor-pointer">
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Pelapor -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-user mr-3 text-indigo-600"></i>Pelapor
                    </h3>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ $complaint->user->name ?? 'Anonim' }}</p>
                            <p class="text-sm text-gray-500">{{ $complaint->user->email ?? 'Email tidak tersedia' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-3 text-gray-600"></i>Detail
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID</span>
                            <span class="font-medium">#{{ $complaint->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tiket</span>
                            <span class="font-medium">{{ $complaint->ticket }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibuat</span>
                            <span class="font-medium">{{ $complaint->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Update</span>
                            <span class="font-medium">{{ $complaint->updated_at->format('d/m/Y') }}</span>
                        </div>
                        @if($complaint->category)
                        <div class="pt-3 border-t">
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                <i class="fas fa-tag mr-1"></i>{{ $complaint->category }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Aksi -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-bolt mr-3 text-yellow-600"></i>Aksi
                    </h3>
                    <div class="space-y-3">
                        <button onclick="window.print()" class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            <i class="fas fa-print mr-2"></i>Cetak
                        </button>
                        <button onclick="navigator.share({title: 'Pengaduan {{ $complaint->ticket }}', url: window.location.href})" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg">
                            <i class="fas fa-share-alt mr-2"></i>Bagikan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fallback untuk share jika tidak support
        if (!navigator.share) {
            document.querySelector('[onclick*="navigator.share"]').onclick = function() {
                navigator.clipboard.writeText(window.location.href);
                alert('Link disalin!');
            };
        }
    </script>
</body>
</html>