<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan - {{ $complaint->ticket }}</title>
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

<body class="bg-gray-50 min-h-screen" x-data="{ showImageModal: false, currentImage: '' }">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14">
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

                    @if (auth()->user()->role === 'user')
                        <a href="{{ route('user.complaints') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-file-alt mr-1 text-xs"></i>Pengaduan Saya
                        </a>
                        <a href="{{ route('complaint') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-plus mr-1 text-xs"></i>Buat Pengaduan
                        </a>
                    @else
                        <a href="{{ route('admin.complaints.list') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-file-alt mr-1 text-xs"></i>Kelola Pengaduan
                        </a>
                    @endif

                    <a href="{{ route('panduan') }}"
                        class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                        <i class="fas fa-book mr-1 text-xs"></i>Panduan
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-3" x-data="{ open: false }">
                    <div class="hidden md:flex items-center space-x-2">
                        <div class="text-right">
                            <p class="text-xs font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">
                                @if (auth()->user()->role === 'admin')
                                    <span
                                        class="bg-red-100 text-red-800 px-1.5 py-0.5 rounded-full text-xs font-medium">Admin</span>
                                @elseif(auth()->user()->role === 'government')
                                    <span
                                        class="bg-green-100 text-green-800 px-1.5 py-0.5 rounded-full text-xs font-medium">Pemerintah</span>
                                @else
                                    <span
                                        class="bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded-full text-xs font-medium">Masyarakat</span>
                                @endif
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            @if (auth()->user()->role === 'user')
                                <a href="{{ route('user.complaints') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-blue-600">Pengaduan Saya</a>
                            @else
                                <a href="{{ route('admin.complaints.list') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-blue-600">Kelola Pengaduan</a>
                            @endif
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-sm font-medium text-gray-500">Detail Pengaduan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Header Section -->
        <div class="mb-8">
            <div
                class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Detail Pengaduan</h2>
                            <p class="text-blue-100 text-lg">
                                Nomor Tiket: <span class="font-semibold">{{ $complaint->ticket }}</span>
                            </p>
                        </div>
                        <div class="text-right">
                            @php
                                $status = $statusConfig[$complaint->status] ?? [
                                    'label' => 'Unknown',
                                    'color' => 'gray',
                                    'icon' => 'fas fa-question',
                                ];
                            @endphp
                            <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2">
                                <p class="text-sm text-blue-100">Status Pengaduan</p>
                                <div class="flex items-center mt-1">
                                    <i class="{{ $status['icon'] }} mr-2"></i>
                                    <span class="font-semibold">{{ $status['label'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-6">
                        @if (auth()->user()->role === 'user')
                            <button onclick="window.location.href='{{ route('user.complaints') }}'"
                                class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                            </button>
                        @else
                            <button onclick="window.location.href='{{ route('admin.complaints.list') }}'"
                                class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                            </button>
                        @endif
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Detail Pengaduan -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informasi Utama -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-file-alt text-blue-600 mr-3"></i>
                            Informasi Pengaduan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Judul -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengaduan</label>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="text-lg font-semibold text-gray-900">
                                        {{ $complaint->title ?? 'Pengaduan #' . $complaint->id }}
                                    </h4>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Pengaduan</label>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">
                                        {{ $complaint->description ?? 'Tidak ada deskripsi tersedia.' }}</p>
                                </div>
                            </div>

                            <!-- Kategori dan Lokasi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        @if ($complaint->category)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-tag mr-2"></i>{{ $complaint->category }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 italic">Tidak ada kategori</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Kejadian</label>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-gray-800 flex items-center">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                            {{ $complaint->location ?? 'Lokasi tidak tersedia' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bukti Foto -->
                            @if ($complaint->image)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Foto</label>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @php
                                                $images = is_array($complaint->image)
                                                    ? $complaint->image
                                                    : [$complaint->image];
                                            @endphp
                                            @foreach ($images as $image)
                                                <div class="relative group cursor-pointer"
                                                    @click="showImageModal = true; currentImage = '{{ asset('storage/' . $image) }}'">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Bukti Pengaduan"
                                                        class="w-full h-48 object-cover rounded-lg shadow-sm group-hover:shadow-md transition-shadow">
                                                    <div
                                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all flex items-center justify-center">
                                                        <i
                                                            class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 text-2xl transition-opacity"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-history text-green-600 mr-3"></i>
                            Timeline Status
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul class="-mb-auto">
                                @php
                                    $statusHistory = [
                                        [
                                            'status' => 'pending',
                                            'date' => $complaint->created_at,
                                            'description' => 'Pengaduan diterima dan menunggu review',
                                        ],
                                    ];

                                    if ($complaint->status !== 'pending') {
                                        $statusHistory[] = [
                                            'status' => $complaint->status,
                                            'date' => $complaint->updated_at,
                                            'description' => 'Status pengaduan diperbarui',
                                        ];
                                    }
                                @endphp

                                @foreach ($statusHistory as $index => $history)
                                    @php
                                        $statusInfo = $statusConfig[$history['status']] ?? [
                                            'label' => 'Unknown',
                                            'color' => 'gray',
                                            'icon' => 'fas fa-question',
                                        ];
                                    @endphp
                                    <li>
                                        <div class="relative {{ $index < count($statusHistory) - 1 ? 'pb-8' : '' }}">
                                            @if ($index < count($statusHistory) - 1)
                                                <span
                                                    class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div
                                                    class="w-8 h-8 bg-{{ $statusInfo['color'] }}-100 rounded-full flex items-center justify-center">
                                                    <i
                                                        class="{{ $statusInfo['icon'] }} text-{{ $statusInfo['color'] }}-600 text-sm"></i>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $statusInfo['label'] }}</p>
                                                    <p class="text-sm text-gray-500">{{ $history['description'] }}</p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        {{ $history['date']->format('d M Y, H:i') }} WIB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Informasi Pelapor -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-user text-blue-600 mr-3"></i>
                            Informasi Pelapor
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $complaint->user->name ?? 'Anonim' }}
                                    </p>
                                    <p class="text-sm text-gray-500">Pelapor</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-envelope w-5 text-gray-400 mr-3"></i>
                                    <span>{{ $complaint->user->email ?? 'Email tidak tersedia' }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-phone w-5 text-gray-400 mr-3"></i>
                                    <span>{{ $complaint->user->phone ?? 'Nomor telepon tidak tersedia' }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt w-5 text-gray-400 mr-3"></i>
                                    <span>{{ $complaint->user->address ?? 'Alamat tidak tersedia' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Pengaduan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-info-circle text-green-600 mr-3"></i>
                            Detail Pengaduan
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Nomor Tiket</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $complaint->ticket }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Tanggal Pengaduan</span>
                                <span
                                    class="text-sm text-gray-900">{{ $complaint->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Waktu Pengaduan</span>
                                <span class="text-sm text-gray-900">{{ $complaint->created_at->format('H:i') }}
                                    WIB</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Status Saat Ini</span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                                    <i class="{{ $status['icon'] }} mr-1"></i>{{ $status['label'] }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Terakhir Diupdate</span>
                                <span
                                    class="text-sm text-gray-900">{{ $complaint->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Explanation -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-question-circle text-purple-600 mr-3"></i>
                            Penjelasan Status
                        </h3>
                    </div>
                    <div class="p-6">
                        <div
                            class="bg-{{ $status['color'] }}-50 border border-{{ $status['color'] }}-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="{{ $status['icon'] }} text-{{ $status['color'] }}-600 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="font-semibold text-{{ $status['color'] }}-800 mb-2">
                                        {{ $status['label'] }}</h4>
                                    <p class="text-sm text-{{ $status['color'] }}-700">
                                        @if ($complaint->status === 'pending')
                                            Pengaduan Anda sedang menunggu review dari tim admin. Mohon bersabar, kami
                                            akan segera memproses pengaduan Anda.
                                        @elseif($complaint->status === 'accepted')
                                            Selamat! Pengaduan Anda telah diterima dan diverifikasi oleh tim admin.
                                            Pengaduan akan segera diproses oleh instansi terkait.
                                        @elseif($complaint->status === 'in_progress')
                                            Pengaduan Anda sedang dalam proses penanganan oleh instansi terkait. Tim
                                            sedang bekerja untuk menyelesaikan masalah yang Anda laporkan.
                                        @elseif($complaint->status === 'completed')
                                            Pengaduan Anda telah diselesaikan! Terima kasih atas partisipasi Anda dalam
                                            membangun masyarakat yang lebih baik.
                                        @elseif($complaint->status === 'rejected')
                                            Pengaduan Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut
                                            atau ajukan pengaduan baru dengan informasi yang lebih lengkap.
                                        @else
                                            Status pengaduan tidak diketahui. Silakan hubungi admin untuk informasi
                                            lebih lanjut.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                @if (auth()->user()->role === 'user')
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-bolt text-yellow-600 mr-3"></i>
                                Aksi Cepat
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('user.complaints') }}"
                                    class="w-full flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                                    <div class="flex items-center">
                                        <i class="fas fa-list text-blue-600 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-900">Lihat Semua Pengaduan</span>
                                    </div>
                                    <i
                                        class="fas fa-arrow-right text-blue-600 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                                <a href="{{ route('complaint') }}"
                                    class="w-full flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                                    <div class="flex items-center">
                                        <i class="fas fa-plus text-green-600 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-900">Buat Pengaduan Baru</span>
                                    </div>
                                    <i
                                        class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                                <a href="{{ route('panduan') }}"
                                    class="w-full flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                                    <div class="flex items-center">
                                        <i class="fas fa-book text-purple-600 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-900">Lihat Panduan</span>
                                    </div>
                                    <i
                                        class="fas fa-arrow-right text-purple-600 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Image Modal -->
    <div x-show="showImageModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4" style="display: none;">
        <div @click.away="showImageModal = false" class="relative max-w-4xl max-h-full">
            <button @click="showImageModal = false"
                class="absolute top-4 right-4 w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center text-white transition-colors z-10">
                <i class="fas fa-times"></i>
            </button>
            <img :src="currentImage" alt="Bukti Pengaduan" class="max-w-full max-h-full object-contain rounded-lg">
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
        <div class="flex justify-around">
            @if (auth()->user()->role === 'user')
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-home text-lg"></i>
                    <span class="text-xs mt-1">Dashboard</span>
                </a>
                <a href="{{ route('user.complaints') }}" class="flex flex-col items-center py-2 text-blue-600">
                    <i class="fas fa-file-alt text-lg"></i>
                    <span class="text-xs mt-1">Pengaduan</span>
                </a>
                <a href="{{ route('complaint') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-plus text-lg"></i>
                    <span class="text-xs mt-1">Buat</span>
                </a>
                <a href="{{ route('panduan') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-book text-lg"></i>
                    <span class="text-xs mt-1">Panduan</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-home text-lg"></i>
                    <span class="text-xs mt-1">Dashboard</span>
                </a>
                <a href="{{ route('admin.complaints.list') }}" class="flex flex-col items-center py-2 text-blue-600">
                    <i class="fas fa-file-alt text-lg"></i>
                    <span class="text-xs mt-1">Pengaduan</span>
                </a>
                <a href="{{ route('admin.reports') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-chart-bar text-lg"></i>
                    <span class="text-xs mt-1">Laporan</span>
                </a>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>

</html>
