<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Penggunaan - Sistem Pengaduan Masyarakat</title>
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
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-comments text-white text-lg"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">SiPengMas</h1>
                        <p class="text-sm text-gray-500">Sistem Pengaduan Masyarakat</p>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/dashboard" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                    <a href="/complaint-add" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-file-alt mr-2"></i>Pengaduan
                    </a>
                    <a href="#" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-chart-bar mr-2"></i>Laporan
                    </a>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                        <i class="fas fa-book mr-2"></i>Panduan
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
                        <button @click="open = !open" class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white hover:shadow-lg transition-shadow">
                            <i class="fas fa-user"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
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
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <a href="/dashboard" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Panduan Penggunaan</h1>
                    <p class="text-gray-600">Pelajari cara menggunakan sistem dengan mudah</p>
                </div>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-compass text-blue-600 mr-2"></i>Menu Panduan
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="scrollToSection('getting-started')" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors text-left">
                    <i class="fas fa-play-circle text-blue-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-medium text-gray-900">Memulai</h3>
                        <p class="text-sm text-gray-600">Cara login dan dashboard</p>
                    </div>
                </button>
                <button onclick="scrollToSection('create-complaint')" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors text-left">
                    <i class="fas fa-plus-circle text-green-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-medium text-gray-900">Buat Pengaduan</h3>
                        <p class="text-sm text-gray-600">Langkah membuat laporan</p>
                    </div>
                </button>
                
                <button onclick="scrollToSection('check-status')" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors text-left">
                    <i class="fas fa-eye text-purple-600 text-2xl mr-4"></i>
                    <div>
                        <h3 class="font-medium text-gray-900">Cek Status</h3>
                        <p class="text-sm text-gray-600">Lihat perkembangan laporan</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="space-y-8">
            <!-- Getting Started -->
            <section id="getting-started" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-play-circle text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Memulai Penggunaan</h2>
                        <p class="text-gray-600">Langkah awal menggunakan sistem</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">1</div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Login ke Sistem</h3>
                                <p class="text-sm text-gray-600">Masuk dengan email dan password yang sudah terdaftar</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">2</div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Lihat Dashboard</h3>
                                <p class="text-sm text-gray-600">Dashboard menampilkan ringkasan dan statistik pengaduan</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">3</div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Gunakan Menu</h3>
                                <p class="text-sm text-gray-600">Navigasi menggunakan menu di atas atau mobile navigation</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-900 mb-3">Menu Utama:</h3>
                        <div class="space-y-2">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-home text-blue-600 mr-3 w-4"></i>
                                <span><strong>Dashboard:</strong> Halaman utama</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-file-alt text-blue-600 mr-3 w-4"></i>
                                <span><strong>Pengaduan:</strong> Kelola laporan</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-chart-bar text-blue-600 mr-3 w-4"></i>
                                <span><strong>Laporan:</strong> Lihat statistik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Create Complaint -->
            <section id="create-complaint" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-plus-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Cara Membuat Pengaduan</h2>
                        <p class="text-gray-600">Langkah mudah membuat laporan pengaduan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-4">Langkah-langkah:</h3>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-xs">1</div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Klik "Buat Pengaduan"</h4>
                                    <p class="text-sm text-gray-600">Tombol ada di dashboard atau menu</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-xs">2</div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Isi Form Lengkap</h4>
                                    <p class="text-sm text-gray-600">Judul, kategori, deskripsi, dan lokasi</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-xs">3</div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Upload Foto/Video</h4>
                                    <p class="text-sm text-gray-600">Maksimal 10MB (JPG, PNG, MP4)</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center font-bold text-xs">4</div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Kirim Pengaduan</h4>
                                    <p class="text-sm text-gray-600">Dapatkan nomor tiket untuk tracking</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-lightbulb text-yellow-600 mr-2"></i>
                                <h4 class="font-medium text-yellow-800">Tips Pengaduan Baik</h4>
                            </div>
                            <ul class="text-sm text-yellow-800 space-y-1">
                                <li>• Judul jelas dan spesifik</li>
                                <li>• Sertakan foto sebagai bukti</li>
                                <li>• Alamat lokasi detail</li>
                                <li>• Deskripsi lengkap dan jelas</li>
                            </ul>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-location-arrow text-blue-600 mr-2"></i>
                                <h4 class="font-medium text-blue-800">Fitur Lokasi GPS</h4>
                            </div>
                            <p class="text-sm text-blue-800">Gunakan tombol "Lokasi Saat Ini" untuk mengisi koordinat otomatis</p>
                        </div>
                    </div>
                </div>
            </section>
            
            </section>
            {{-- @else --}}
            <!-- Check Status (For Users) -->
            <section id="check-status" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-eye text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Cek Status Pengaduan</h2>
                        <p class="text-gray-600">Cara melihat perkembangan laporan Anda</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-4">Status yang Mungkin Muncul:</h3>
                        <div class="space-y-3">
                            <div class="flex items-center p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <i class="fas fa-clock text-yellow-600 mr-3"></i>
                                <div>
                                    <h4 class="font-medium text-yellow-900">Sedang Diproses</h4>
                                    <p class="text-xs text-yellow-800">Pengaduan sedang ditinjau</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <i class="fas fa-check text-blue-600 mr-3"></i>
                                <div>
                                    <h4 class="font-medium text-blue-900">Diterima</h4>
                                    <p class="text-xs text-blue-800">Akan segera ditindaklanjuti</p>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                <div>
                                    <h4 class="font-medium text-green-900">Selesai</h4>
                                    <p class="text-xs text-green-800">Pengaduan telah diselesaikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-4">Cara Mengecek:</h3>
                        <div class="space-y-3">
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <h4 class="font-medium text-gray-900 text-sm">1. Lihat Dashboard</h4>
                                <p class="text-xs text-gray-600">Status terbaru ada di "Pengaduan Terbaru"</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <h4 class="font-medium text-gray-900 text-sm">2. Cek Nomor Tiket</h4>
                                <p class="text-xs text-gray-600">Gunakan nomor tiket (contoh: #PGD-001)</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <h4 class="font-medium text-gray-900 text-sm">3. Aktivitas Terbaru</h4>
                                <p class="text-xs text-gray-600">Lihat update di bagian "Aktivitas Terbaru"</p>
                            </div>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-lg border border-blue-200 mt-4">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-bell text-blue-600 mr-2"></i>
                                <h4 class="font-medium text-blue-900 text-sm">Notifikasi</h4>
                            </div>
                            <p class="text-xs text-blue-800">Anda akan mendapat notifikasi setiap ada update status</p>
                        </div>
                    </div>
                </div>
            </section>
            {{-- @endif --}}
        </div>

        <!-- Contact Support -->
        <div class="mt-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 text-white text-center">
            <i class="fas fa-headset text-3xl mb-3"></i>
            <h2 class="text-xl font-bold mb-2">Butuh Bantuan?</h2>
            <p class="text-blue-100 mb-4">Tim support siap membantu Anda</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="tel:+62-21-1234-5678" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                    <i class="fas fa-phone mr-2"></i>
                    (021) 1234-5678
                </a>
                <a href="mailto:support@sipengmas.go.id" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                    <i class="fas fa-envelope mr-2"></i>
                    Email Support
                </a>
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
            <a href="/complaint-add" class="flex flex-col items-center py-2 text-gray-400">
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
            <a href="#" class="flex flex-col items-center py-2 text-blue-600">
                <i class="fas fa-book text-lg"></i>
                <span class="text-xs mt-1">Panduan</span>
            </a>
        </div>
    </div>

    <script>
        function scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    </script>
</body>
</html>