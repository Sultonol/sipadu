<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengaduan - Sistem Pengaduan Masyarakat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-comments text-white text-lg"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">SiPengMas</h1>
                        <p class="text-sm text-gray-500">Edit Pengaduan</p>
                    </div>
                </div>
                <!-- Back Button -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Edit Pengaduan</h2>
                        <p class="text-gray-600">Tiket: {{ $complaint->ticket }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('complaints.update', $complaint->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Pengaduan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" required
                           value="{{ old('title', $complaint->title) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Masukkan judul pengaduan">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Pengaduan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="6" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                              placeholder="Jelaskan detail pengaduan Anda">{{ old('description', $complaint->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="location" name="location" required
                           value="{{ old('location', $complaint->location) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Masukkan lokasi kejadian">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category" name="category" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="">Pilih Kategori</option>
                        <option value="Infrastructure" {{ old('category', $complaint->category) == 'Infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                        <option value="Disaster" {{ old('category', $complaint->category) == 'Disaster' ? 'selected' : '' }}>Disaster</option>
                        <option value="Public Service" {{ old('category', $complaint->category) == 'Public Service' ? 'selected' : '' }}>Public Service</option>
                        <option value="Environment" {{ old('category', $complaint->category) == 'Environment' ? 'selected' : '' }}>Environment</option>
                        <option value="Transportation" {{ old('category', $complaint->category) == 'Transportation' ? 'selected' : '' }}>Transportation</option>
                        <option value="Health" {{ old('category', $complaint->category) == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Education" {{ old('category', $complaint->category) == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Security" {{ old('category', $complaint->category) == 'Security' ? 'selected' : '' }}>Security</option>
                        <option value="Other" {{ old('category', $complaint->category) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Coordinates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                            Latitude
                        </label>
                        <input type="number" step="any" id="latitude" name="latitude"
                               value="{{ old('latitude', $complaint->latitude) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="Contoh: -6.200000">
                        @error('latitude')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="longtitude" class="block text-sm font-medium text-gray-700 mb-2">
                            Longtitude
                        </label>
                        <input type="number" step="any" id="longtitude" name="longtitude"
                               value="{{ old('longtitude', $complaint->longtitude) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               placeholder="Contoh: 106.816666">
                        @error('longtitude')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Current Media -->
                @if($complaint->media)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Media Saat Ini
                        </label>
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file text-gray-400 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ basename($complaint->media) }}</p>
                                <p class="text-xs text-gray-500">File saat ini</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- New Media -->
                <div>
                    <label for="media" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $complaint->media ? 'Ganti Media (Opsional)' : 'Upload Media (Opsional)' }}
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                        <input type="file" id="media" name="media" accept="image/*,video/*" class="hidden">
                        <label for="media" class="cursor-pointer">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-cloud-upload-alt text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-sm text-gray-600">Klik untuk upload gambar atau video</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, MP4 hingga 10MB</p>
                        </label>
                    </div>
                    @error('media')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-900">Status Pengaduan</h4>
                            <p class="text-sm text-blue-700 mt-1">
                                Status saat ini: <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $complaint->status)) }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>