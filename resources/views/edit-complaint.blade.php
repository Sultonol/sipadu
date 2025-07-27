<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengaduan - {{ $complaint->ticket }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-comments text-white text-sm"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">SiPengMas</h1>
                        <p class="text-xs text-gray-500">Sistem Pengaduan Masyarakat</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                        <i class="fas fa-home mr-1 text-xs"></i>Dashboard
                    </a>
                    <a href="{{ route('user.all.complaints') }}"
                        class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                        <i class="fas fa-list mr-1 text-xs"></i>Semua Pengaduan
                    </a>
                    <a href="{{ route('user.complaints') }}"
                        class="text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors">
                        <i class="fas fa-file-alt mr-1 text-xs"></i>Pengaduan Saya
                    </a>
                    <a href="{{ route('complaint') }}"
                        class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                        <i class="fas fa-plus mr-1 text-xs"></i>Buat Pengaduan
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-3" x-data="{ open: false }">
                    <div class="hidden md:flex items-center space-x-2">
                        <div class="text-right">
                            <p class="text-xs font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">
                                <span
                                    class="bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded-full text-xs font-medium">Masyarakat</span>
                            </p>
                        </div>
                    </div>
                    <div class="relative">
                        <button @click="open = !open"
                            class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white hover:shadow-lg transition-shadow">
                            <i class="fas fa-user text-xs"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg py-1 z-50">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-2 text-xs"></i>Profil Saya
                            </a>
                            <a href="{{ route('user.all.complaints') }}"
                                class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-list mr-2 text-xs"></i>Semua Pengaduan
                            </a>
                            <a href="{{ route('user.complaints') }}"
                                class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-file-alt mr-2 text-xs"></i>Pengaduan Saya
                            </a>
                            <a href="{{ route('complaint') }}"
                                class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-plus mr-2 text-xs"></i>Buat Pengaduan
                            </a>
                            <a href="{{ route('panduan') }}"
                                class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-book mr-2 text-xs"></i>Panduan
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('logout') }}"
                                class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2 text-xs"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                        <i class="fas fa-edit text-blue-600 mr-4"></i>
                        Edit Pengaduan
                    </h1>
                    <p class="text-gray-600 mt-2">
                        Perbarui informasi pengaduan <span
                            class="font-semibold text-blue-600">{{ $complaint->ticket }}</span>
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">Status Saat Ini</p>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if ($complaint->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($complaint->status === 'rejected') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            @if ($complaint->status === 'pending')
                                <i class="fas fa-clock mr-2"></i>Menunggu Review
                            @elseif($complaint->status === 'rejected')
                                <i class="fas fa-times-circle mr-2"></i>Ditolak
                            @else
                                <i class="fas fa-question-circle mr-2"></i>{{ ucfirst($complaint->status) }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-green-800 mb-1">Berhasil!</h4>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-red-800 mb-1">Error!</h4>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle text-red-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-red-800 mb-2">Terjadi Kesalahan!</h4>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-start">
                                    <i class="fas fa-dot-circle text-xs mt-1.5 mr-2"></i>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Container -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <form action="{{ route('complaint.update', $complaint->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="p-6 space-y-6">
                            <!-- Judul Pengaduan -->
                            <div class="space-y-2">
                                <label for="title" class="block text-sm font-semibold text-gray-900">
                                    <i class="fas fa-heading text-blue-600 mr-2"></i>Judul Pengaduan
                                </label>
                                <input type="text" id="title" name="title"
                                    value="{{ old('title', $complaint->title) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                    placeholder="Masukkan judul pengaduan yang jelas dan singkat" required>
                                @error('title')
                                    <p class="text-red-600 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Kategori dan Lokasi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="category" class="block text-sm font-semibold text-gray-900">
                                        <i class="fas fa-tag text-blue-600 mr-2"></i>Kategori Pengaduan
                                    </label>
                                    <select id="category" name="category"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                        required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="">Pilih kategori pengaduan</option>
                                        <option value="Infrastructure"
                                            {{ old('category') == 'Infrastructure' ? 'selected' : '' }}>
                                            Infrastruktur</option>
                                        <option value="Disaster"
                                            {{ old('category') == 'Disaster' ? 'selected' : '' }}>Bencana</option>
                                        <option value="Public Service"
                                            {{ old('category') == 'Public Service' ? 'selected' : '' }}>
                                            Layanan Publik</option>
                                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                    @error('category')
                                        <p class="text-red-600 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="location" class="block text-sm font-semibold text-gray-900">
                                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Lokasi Kejadian
                                    </label>
                                    <input type="text" id="location" name="location"
                                        value="{{ old('location', $complaint->location) }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                        placeholder="Masukkan alamat lengkap lokasi kejadian" required>
                                    @error('location')
                                        <p class="text-red-600 text-sm mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Koordinat -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-semibold text-blue-900 mb-3 flex items-center">
                                    <i class="fas fa-map text-blue-600 mr-2"></i>
                                    Koordinat Lokasi (Opsional)
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="latitude"
                                            class="block text-xs font-medium text-blue-700 mb-1">Latitude</label>
                                        <input type="number" step="any" id="latitude" name="latitude"
                                            value="{{ old('latitude', $complaint->latitude) }}"
                                            class="w-full px-3 py-2 border border-blue-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm"
                                            placeholder="Contoh: -6.200000">
                                        @error('latitude')
                                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="longtitude"
                                            class="block text-xs font-medium text-blue-700 mb-1">Longitude</label>
                                        <input type="number" step="any" id="longtitude" name="longtitude"
                                            value="{{ old('longtitude', $complaint->longtitude) }}"
                                            class="w-full px-3 py-2 border border-blue-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm"
                                            placeholder="Contoh: 106.816666">
                                        @error('longtitude')
                                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <p class="text-xs text-blue-600 mt-2 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Koordinat membantu tim untuk menemukan lokasi dengan lebih akurat
                                </p>
                            </div>

                            <!-- Deskripsi -->
                            <div class="space-y-2">
                                <label for="description" class="block text-sm font-semibold text-gray-900">
                                    <i class="fas fa-align-left text-blue-600 mr-2"></i>Deskripsi Pengaduan
                                </label>
                                <textarea id="description" name="description" rows="6"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                                    placeholder="Jelaskan detail pengaduan Anda dengan lengkap dan jelas..." required>{{ old('description', $complaint->description) }}</textarea>
                                <div class="flex justify-between items-center">
                                    @error('description')
                                        <p class="text-red-600 text-sm flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @else
                                        <p class="text-xs text-gray-500">Minimal 20 karakter untuk deskripsi yang jelas</p>
                                    @enderror
                                    <span class="text-xs text-gray-400" id="charCount">0 karakter</span>
                                </div>
                            </div>

                            <!-- Media Upload -->
                            <div class="space-y-4">
                                <label class="block text-sm font-semibold text-gray-900">
                                    <i class="fas fa-camera text-blue-600 mr-2"></i>Media Pengaduan
                                </label>

                                <!-- Media Saat Ini -->
                                @if ($complaint->image)
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <h5 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                                            <i class="fas fa-images text-gray-500 mr-2"></i>Media Saat Ini
                                        </h5>
                                        <div class="flex items-start space-x-4">
                                            @if (in_array(pathinfo($complaint->image, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset('storage/' . $complaint->image) }}"
                                                    alt="Media Pengaduan"
                                                    class="w-24 h-24 object-cover rounded-lg shadow-sm border border-gray-200">
                                            @else
                                                <video controls
                                                    class="w-24 h-24 rounded-lg shadow-sm border border-gray-200">
                                                    <source src="{{ asset('storage/' . $complaint->image) }}"
                                                        type="video/mp4">
                                                    Browser Anda tidak mendukung video.
                                                </video>
                                            @endif
                                            <div class="flex-1">
                                                <p class="text-sm text-gray-600 mb-2">
                                                    <i class="fas fa-file text-gray-400 mr-1"></i>
                                                    {{ basename($complaint->image) }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Upload media baru jika ingin mengganti media yang ada
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Upload Media Baru -->
                                <div
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors bg-gray-50 hover:bg-blue-50">
                                    <input type="file" id="media" name="media" accept="image/*,video/*"
                                        class="hidden" onchange="previewMedia(this)">
                                    <label for="media" class="cursor-pointer">
                                        <div class="space-y-3">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                            <div>
                                                <p class="text-gray-600 font-medium">Klik untuk upload media baru</p>
                                                <p class="text-sm text-gray-500">atau drag & drop file di sini</p>
                                            </div>
                                            <div
                                                class="flex items-center justify-center space-x-4 text-xs text-gray-500">
                                                <span class="flex items-center">
                                                    <i class="fas fa-image mr-1"></i>PNG, JPG, GIF
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-video mr-1"></i>MP4, MOV, AVI
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-weight-hanging mr-1"></i>Max 10MB
                                                </span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div id="mediaPreview" class="hidden"></div>
                                @error('media')
                                    <p class="text-red-600 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl">
                            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                                <button type="button"
                                    onclick="window.location.href='{{ route('complaint.detail', $complaint->id) }}'"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition-all duration-200 flex items-center justify-center">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 flex items-center justify-center shadow-sm">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Info Pengaduan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Info Pengaduan
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Nomor Tiket</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $complaint->ticket }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Dibuat</span>
                            <span class="text-sm text-gray-900">{{ $complaint->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-gray-600">Terakhir Edit</span>
                            <span class="text-sm text-gray-900">{{ $complaint->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tips Edit -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        Tips Edit
                    </h3>
                    <ul class="space-y-3 text-sm text-blue-800">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 text-xs"></i>
                            <span>Pastikan judul jelas dan spesifik</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 text-xs"></i>
                            <span>Pilih kategori yang sesuai</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 text-xs"></i>
                            <span>Berikan deskripsi yang detail</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-2 mt-0.5 text-xs"></i>
                            <span>Upload foto/video sebagai bukti</span>
                        </li>
                    </ul>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-bolt text-yellow-600 mr-2"></i>
                        Aksi Cepat
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('complaint.detail', $complaint->id) }}"
                            class="w-full flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                            <div class="flex items-center">
                                <i class="fas fa-eye text-blue-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-900">Lihat Detail</span>
                            </div>
                            <i
                                class="fas fa-arrow-right text-blue-600 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('user.complaints') }}"
                            class="w-full flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-green-600 mr-3"></i>
                                <span class="text-sm font-medium text-gray-900">Pengaduan Saya</span>
                            </div>
                            <i
                                class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Padding -->
    <div class="h-20 md:hidden"></div>

    <!-- Mobile Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 z-30">
        <div class="flex justify-around">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-2 text-gray-400">
                <i class="fas fa-home text-lg"></i>
                <span class="text-xs mt-1">Dashboard</span>
            </a>
            <a href="{{ route('user.all.complaints') }}" class="flex flex-col items-center py-2 text-gray-400">
                <i class="fas fa-list text-lg"></i>
                <span class="text-xs mt-1">Semua</span>
            </a>
            <a href="{{ route('user.complaints') }}" class="flex flex-col items-center py-2 text-blue-600">
                <i class="fas fa-file-alt text-lg"></i>
                <span class="text-xs mt-1">Pengaduan</span>
            </a>
            <a href="{{ route('complaint') }}" class="flex flex-col items-center py-2 text-gray-400">
                <i class="fas fa-plus text-lg"></i>
                <span class="text-xs mt-1">Buat</span>
            </a>
        </div>
    </div>

    <script>
        // Character counter for description
        const descriptionTextarea = document.getElementById('description');
        const charCount = document.getElementById('charCount');

        function updateCharCount() {
            const count = descriptionTextarea.value.length;
            charCount.textContent = count + ' karakter';

            if (count < 20) {
                charCount.className = 'text-xs text-red-400';
            } else if (count < 100) {
                charCount.className = 'text-xs text-yellow-500';
            } else {
                charCount.className = 'text-xs text-green-500';
            }
        }

        descriptionTextarea.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial count

        // Media preview function
        function previewMedia(input) {
            const preview = document.getElementById('mediaPreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                preview.classList.remove('hidden');

                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group bg-white border border-gray-200 rounded-lg p-4 mt-4';

                    if (file.type.startsWith('image/')) {
                        div.innerHTML = `
                            <div class="flex items-start space-x-4">
                                <img src="${e.target.result}" alt="Preview" class="w-24 h-24 object-cover rounded-lg shadow-sm">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 mb-1">Media Baru</p>
                                    <p class="text-xs text-gray-500 mb-2">${file.name}</p>
                                    <p class="text-xs text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                </div>
                                <button type="button" onclick="removePreview()" 
                                        class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-full flex items-center justify-center text-sm transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                    } else if (file.type.startsWith('video/')) {
                        div.innerHTML = `
                            <div class="flex items-start space-x-4">
                                <video controls class="w-24 h-24 rounded-lg shadow-sm">
                                    <source src="${e.target.result}" type="${file.type}">
                                </video>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 mb-1">Video Baru</p>
                                    <p class="text-xs text-gray-500 mb-2">${file.name}</p>
                                    <p class="text-xs text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                </div>
                                <button type="button" onclick="removePreview()" 
                                        class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-full flex items-center justify-center text-sm transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                    }

                    preview.appendChild(div);
                };

                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        }

        function removePreview() {
            const input = document.getElementById('media');
            const preview = document.getElementById('mediaPreview');
            input.value = '';
            preview.innerHTML = '';
            preview.classList.add('hidden');
        }

        // Auto-save draft (optional enhancement)
        let autoSaveTimer;

        function autoSave() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                // Here you could implement auto-save functionality
                console.log('Auto-saving draft...');
            }, 5000);
        }

        // Add auto-save listeners
        ['title', 'description', 'location'].forEach(id => {
            document.getElementById(id).addEventListener('input', autoSave);
        });
    </script>
</body>

</html>
