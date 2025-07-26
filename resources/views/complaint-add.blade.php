<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengaduan - Sistem Pengaduan Masyarakat</title>
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
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-comments text-white text-lg"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">SiPengMas</h1>
                        <p class="text-sm text-gray-500">Sistem Pengaduan Masyarakat</p>
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
                        class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                        <i class=" fas fa-file-alt mr-1 text-xs"></i>Pengaduan Saya
                    </a>
                    <a href="{{ route('complaint') }}"
                        class="text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors">
                        <i class="fas fa-plus mr-1 text-xs"></i>Buat Pengaduan
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4" x-data="{ open: false }">
                    <div class="hidden md:flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'John Doe' }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role ?? 'user') }}</p>
                        </div>
                    </div>
                    <div class="relative">
                        <button @click="open = !open"
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white hover:shadow-lg transition-shadow">
                            <i class="fas fa-user"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-2"></i>Profil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="/dashboard" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Buat Pengaduan Baru</h1>
                    <p class="text-gray-600">Sampaikan keluhan atau aspirasi Anda kepada pemerintah</p>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200" x-data="complaintForm()">
            <!-- Alert Messages -->
            <div x-show="alertMessage" x-transition class="mx-6 mt-6">
                <div :class="alertType === 'success' ? 'bg-green-100 border-green-400 text-green-700' :
                    'bg-red-100 border-red-400 text-red-700'"
                    class="border px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i :class="alertType === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle'"
                            class="mr-2"></i>
                        <span x-text="alertMessage"></span>
                    </div>
                </div>
            </div>

            <form action="{{ '/complaint/create' }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6"
                @submit="validateForm">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading text-blue-600 mr-2"></i>Judul Pengaduan
                    </label>
                    <input type="text" id="title" name="title" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Masukkan judul pengaduan yang jelas dan singkat" value="{{ old('title') }}"
                        @blur="validateTitle">
                    <div x-show="errors.title" class="mt-1 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span x-text="errors.title"></span>
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tags text-blue-600 mr-2"></i>Kategori
                    </label>
                    <select id="category" name="category" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        @change="validateCategory">
                        <option value="">Pilih kategori pengaduan</option>
                        <option value="Infrastructure" {{ old('category') == 'Infrastructure' ? 'selected' : '' }}>
                            Infrastruktur</option>
                        <option value="Disaster" {{ old('category') == 'Disaster' ? 'selected' : '' }}>Bencana</option>
                        <option value="Public Service" {{ old('category') == 'Public Service' ? 'selected' : '' }}>
                            Layanan Publik</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <div x-show="errors.category" class="mt-1 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span x-text="errors.category"></span>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left text-blue-600 mr-2"></i>Deskripsi Pengaduan
                    </label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                        placeholder="Jelaskan detail pengaduan Anda dengan lengkap dan jelas" @blur="validateDescription">{{ old('description') }}</textarea>
                    <div x-show="errors.description" class="mt-1 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span x-text="errors.description"></span>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Lokasi Kejadian
                    </label>
                    <input type="text" id="location" name="location" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Contoh: Jl. Merdeka No. 123, Kelurahan ABC, Kecamatan XYZ"
                        value="{{ old('location') }}" @blur="validateLocation">
                    <div x-show="errors.location" class="mt-1 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span x-text="errors.location"></span>
                    </div>
                </div>

                <!-- Coordinates (Optional) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-crosshairs text-blue-600 mr-2"></i>Latitude (Opsional)
                        </label>
                        <input type="number" step="any" id="latitude" name="latitude"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="-6.200000" value="{{ old('latitude') }}" @blur="validateLatitude">
                        <div x-show="errors.latitude" class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span x-text="errors.latitude"></span>
                        </div>
                    </div>
                    <div>
                        <label for="longtitude" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-crosshairs text-blue-600 mr-2"></i>Longitude (Opsional)
                        </label>
                        <input type="number" step="any" id="longtitude" name="longtitude"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="106.816666" value="{{ old('longtitude') }}" @blur="validateLongitude">
                        <div x-show="errors.longitude" class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span x-text="errors.longitude"></span>
                        </div>
                    </div>
                </div>

                <!-- Get Current Location Button -->
                <div class="flex justify-center">
                    <button type="button" @click="getCurrentLocation()" :disabled="isGettingLocation"
                        class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <i :class="isGettingLocation ? 'fas fa-spinner fa-spin' : 'fas fa-location-arrow'"
                            class="mr-2"></i>
                        <span x-text="isGettingLocation ? 'Mendapatkan lokasi...' : 'Gunakan Lokasi Saat Ini'"></span>
                    </button>
                </div>

                <!-- Media Upload -->
                <div>
                    <label for="media" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-camera text-blue-600 mr-2"></i>Foto/Video Pendukung
                    </label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                        <input type="file" id="media" name="media" accept="image/*,video/*" required
                            class="hidden" @change="handleFileUpload($event)">
                        <label for="media" class="cursor-pointer">
                            <div class="space-y-2">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Klik untuk upload file</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, MP4 hingga 10MB</p>
                                </div>
                            </div>
                        </label>
                        <div x-show="fileName" class="mt-3 text-sm text-green-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            <span x-text="fileName"></span>
                        </div>
                    </div>
                    <div x-show="errors.media" class="mt-1 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span x-text="errors.media"></span>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Pengaduan
                    </button>
                    <button type="button" onclick="window.location.href='/dashboard'"
                        class="flex-1 sm:flex-none bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 rounded-xl p-6 border border-blue-200">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900 mb-2">Tips Membuat Pengaduan yang Baik</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Gunakan judul yang jelas dan spesifik</li>
                        <li>• Sertakan foto atau video sebagai bukti</li>
                        <li>• Berikan alamat lokasi yang detail</li>
                        <li>• Jelaskan kronologi kejadian dengan lengkap</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
        <div class="flex justify-around">
            <a href="/dashboard" class="flex flex-col items-center py-2 text-gray-400">
                <i class="fas fa-home text-lg"></i>
                <span class="text-xs mt-1">Dashboard</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 text-blue-600">
                <i class="fas fa-file-alt text-lg"></i>
                <span class="text-xs mt-1">Pengaduan</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 text-gray-400">
                <i class="fas fa-plus text-lg"></i>
                <span class="text-xs mt-1">Buat</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 text-gray-400">
                <i class="fas fa-chart-bar text-lg"></i>
                <span class="text-xs mt-1">Laporan</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 text-gray-400">
                <i class="fas fa-user text-lg"></i>
                <span class="text-xs mt-1">Profil</span>
            </a>
        </div>
    </div>

    <script>
        function complaintForm() {
            return {
                fileName: '',
                isGettingLocation: false,
                alertMessage: '',
                alertType: 'success',
                errors: {
                    title: '',
                    category: '',
                    description: '',
                    location: '',
                    latitude: '',
                    longitude: '',
                    media: ''
                },

                showAlert(message, type = 'success') {
                    this.alertMessage = message;
                    this.alertType = type;
                    setTimeout(() => {
                        this.alertMessage = '';
                    }, 5000);
                },

                validateTitle() {
                    const title = document.getElementById('title').value.trim();
                    if (title.length < 5) {
                        this.errors.title = 'Judul pengaduan minimal 5 karakter';
                    } else if (title.length > 255) {
                        this.errors.title = 'Judul pengaduan maksimal 255 karakter';
                    } else {
                        this.errors.title = '';
                    }
                },

                validateCategory() {
                    const category = document.getElementById('category').value;
                    if (!category) {
                        this.errors.category = 'Kategori harus dipilih';
                    } else {
                        this.errors.category = '';
                    }
                },

                validateDescription() {
                    const description = document.getElementById('description').value.trim();
                    if (description.length < 10) {
                        this.errors.description = 'Deskripsi minimal 10 karakter';
                    } else if (description.length > 1000) {
                        this.errors.description = 'Deskripsi maksimal 1000 karakter';
                    } else {
                        this.errors.description = '';
                    }
                },

                validateLocation() {
                    const location = document.getElementById('location').value.trim();
                    if (location.length < 5) {
                        this.errors.location = 'Lokasi minimal 5 karakter';
                    } else if (location.length > 255) {
                        this.errors.location = 'Lokasi maksimal 255 karakter';
                    } else {
                        this.errors.location = '';
                    }
                },

                validateLatitude() {
                    const latitude = document.getElementById('latitude').value;
                    if (latitude && (latitude < -90 || latitude > 90)) {
                        this.errors.latitude = 'Latitude harus antara -90 dan 90';
                    } else {
                        this.errors.latitude = '';
                    }
                },

                validateLongitude() {
                    const longitude = document.getElementById('longtitude').value;
                    if (longitude && (longitude < -180 || longitude > 180)) {
                        this.errors.longitude = 'Longitude harus antara -180 dan 180';
                    } else {
                        this.errors.longitude = '';
                    }
                },

                validateForm(event) {
                    this.validateTitle();
                    this.validateCategory();
                    this.validateDescription();
                    this.validateLocation();
                    this.validateLatitude();
                    this.validateLongitude();

                    // Check if there are any errors
                    const hasErrors = Object.values(this.errors).some(error => error !== '');
                    if (hasErrors) {
                        event.preventDefault();
                        this.showAlert('Mohon perbaiki kesalahan pada form', 'error');
                    }
                },

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Validate file size (10MB = 10 * 1024 * 1024 bytes)
                        if (file.size > 10 * 1024 * 1024) {
                            this.errors.media = 'Ukuran file maksimal 10MB';
                            this.fileName = '';
                            event.target.value = '';
                            return;
                        }

                        // Validate file type
                        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'video/mp4', 'video/avi',
                            'video/mov'
                        ];
                        if (!allowedTypes.includes(file.type)) {
                            this.errors.media = 'Format file tidak didukung. Gunakan JPG, PNG, atau MP4';
                            this.fileName = '';
                            event.target.value = '';
                            return;
                        }

                        this.fileName = file.name;
                        this.errors.media = '';
                    }
                },

                getCurrentLocation() {
                    if (!navigator.geolocation) {
                        this.showAlert('Browser Anda tidak mendukung fitur geolocation', 'error');
                        return;
                    }

                    this.isGettingLocation = true;

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            // Set both latitude and longitude
                            document.getElementById('latitude').value = position.coords.latitude;
                            document.getElementById('longtitude').value = position.coords.longitude;

                            this.isGettingLocation = false;
                            this.showAlert('Lokasi berhasil didapatkan!', 'success');

                            // Clear any previous coordinate errors
                            this.errors.latitude = '';
                            this.errors.longitude = '';
                        },
                        (error) => {
                            this.isGettingLocation = false;
                            let errorMessage = '';

                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage = 'Akses lokasi ditolak. Mohon izinkan akses lokasi di browser Anda.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage = 'Informasi lokasi tidak tersedia.';
                                    break;
                                case error.TIMEOUT:
                                    errorMessage = 'Waktu permintaan lokasi habis. Coba lagi.';
                                    break;
                                default:
                                    errorMessage = 'Gagal mendapatkan lokasi. Pastikan GPS aktif dan coba lagi.';
                                    break;
                            }

                            this.showAlert(errorMessage, 'error');
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 60000
                        }
                    );
                }
            }
        }
    </script>
</body>

</html>
