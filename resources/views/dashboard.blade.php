<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Pengaduan Masyarakat</title>
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

<body class="bg-gray-50 min-h-screen" x-data="{ showAllModal: false }">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
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
                        class="text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors">
                        <i class="fas fa-home mr-1 text-xs"></i>Dashboard
                    </a>

                    @if (auth()->user()->role === 'user')
                        <!-- Menu khusus untuk User/Masyarakat - DIUBAH -->
                        <a href="{{ route('user.all.complaints') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-list mr-1 text-xs"></i>Semua Pengaduan
                        </a>
                        <a href="{{ route('user.complaints') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-file-alt mr-1 text-xs"></i>Pengaduan Saya
                        </a>
                        <a href="{{ route('complaint') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-plus mr-1 text-xs"></i>Buat Pengaduan
                        </a>
                    @elseif (auth()->user()->role === 'admin')
                        <!-- Menu khusus untuk Administrator -->
                        <a href="{{ route('admin.complaints.list') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-file-alt mr-1 text-xs"></i>Kelola Pengaduan
                        </a>
                        <a href="{{ route('admin.users.list') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-users mr-1 text-xs"></i>Kelola User
                        </a>
                        <a href="{{ route('admin.reports') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-chart-bar mr-1 text-xs"></i>Laporan
                        </a>
                        <a href="{{ route('admin.settings') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-cog mr-1 text-xs"></i>Pengaturan
                        </a>
                    @elseif (auth()->user()->role === 'pemerintah')
                        <!-- Menu khusus untuk Pemerintah -->
                        <a href="{{ route('admin.complaints.list') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-file-alt mr-1 text-xs"></i>Kelola Pengaduan
                        </a>
                        <a href="{{ route('admin.reports') }}"
                            class="text-gray-600 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-chart-bar mr-1 text-xs"></i>Laporan
                        </a>
                    @endif
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-3" x-data="{ open: false }">
                    <div class="hidden md:flex items-center space-x-2">
                        <div class="text-right">
                            <p class="text-xs font-medium text-gray-900">{{ Auth::user()->name ?? 'John Doe' }}</p>
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

                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('admin.settings') }}"
                                    class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2 text-xs"></i>Pengaturan
                                </a>
                                <a href="{{ route('admin.users.list') }}"
                                    class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-users mr-2 text-xs"></i>Kelola User
                                </a>
                            @elseif(auth()->user()->role === 'government')
                                <a href="{{ route('admin.reports') }}"
                                    class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-chart-line mr-2 text-xs"></i>Laporan
                                </a>
                            @elseif(auth()->user()->role === 'user')
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
                            @endif

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
        <!-- Welcome Section -->
        <div class="mb-8">
            <div
                class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-2">
                        Selamat Datang, {{ Auth::user()->name ?? 'Pengguna' }}! 👋
                    </h2>

                    @if (auth()->user()->role === 'user')
                        <p class="text-blue-100 text-lg mb-6">
                            Mari bersama-sama membangun masyarakat yang lebih baik melalui sistem pengaduan yang
                            transparan dan efektif.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <!-- DIUBAH: Tombol utama sekarang untuk melihat semua pengaduan -->
                            <button onclick="window.location.href='{{ route('user.all.complaints') }}'"
                                class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors flex items-center">
                                <i class="fas fa-list mr-2"></i>Lihat Semua Pengaduan
                            </button>
                            <button onclick="window.location.href='{{ route('complaint') }}'"
                                class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors flex items-center">
                                <i class="fas fa-plus mr-2"></i>Buat Pengaduan Baru
                            </button>
                            <button onclick="window.location.href='{{ route('user.complaints') }}'"
                                class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors flex items-center">
                                <i class="fas fa-file-alt mr-2"></i>Pengaduan Saya
                            </button>
                        </div>
                    @else
                        <p class="text-blue-100 text-lg mb-6">
                            @if (auth()->user()->role === 'admin')
                                Kelola sistem pengaduan masyarakat dengan efisien dan transparan sebagai Administrator.
                            @else
                                Tanggapi dan kelola pengaduan masyarakat untuk pelayanan yang lebih baik sebagai
                                Pemerintah.
                            @endif
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <button onclick="window.location.href='{{ route('admin.complaints.list') }}'"
                                class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors flex items-center">
                                <i class="fas fa-tasks mr-2"></i>Kelola Pengaduan
                            </button>
                            @if (auth()->user()->role === 'admin')
                                <button onclick="window.location.href='{{ route('admin.users.list') }}'"
                                    class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors flex items-center">
                                    <i class="fas fa-users mr-2"></i>Kelola User
                                </button>
                            @endif
                            <button onclick="window.location.href='{{ route('admin.reports') }}'"
                                class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors flex items-center">
                                <i class="fas fa-chart-line mr-2"></i>Lihat Laporan
                            </button>
                        </div>
                    @endif
                </div>
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
            @foreach ($statsCards as $card)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">{{ $card['title'] }}</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $card['value'] }}</p>
                            <p class="text-sm text-{{ $card['color'] }}-600 flex items-center mt-1">
                                <i class="fas fa-arrow-up mr-1"></i>{{ $card['subtitle'] }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-{{ $card['color'] }}-100 rounded-lg flex items-center justify-center">
                            <i class="{{ $card['icon'] }} text-{{ $card['color'] }}-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Complaints -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">
                                @if (auth()->user()->role === 'user')
                                    Pengaduan Saya
                                @else
                                    Pengaduan Terbaru
                                @endif
                            </h3>
                            @if (auth()->user()->role === 'user')
                                <a href="{{ route('user.complaints') }}"
                                    class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline">
                                    Lihat Semua
                                </a>
                            @else
                                <a href="#" @click.prevent="showAllModal = true"
                                    class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline cursor-pointer">
                                    Lihat Semua
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        @if ($complaints->count() > 0)
                            <div class="space-y-4">
                                @foreach ($complaints->take(5) as $complaint)
                                    @php
                                        $status = $statusConfig[$complaint->status] ?? [
                                            'label' => ucfirst(str_replace('_', ' ', $complaint->status)),
                                            'icon' => 'fas fa-file-alt',
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-600',
                                            'badge' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <div
                                        class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div
                                            class="w-10 h-10 {{ $status['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="{{ $status['icon'] }} {{ $status['text'] }}"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-gray-900 truncate">
                                                        <a href="{{ route('complaint.detail', $complaint->id) }}"
                                                            class="hover:text-blue-600 transition-colors">
                                                            {{ $complaint->title ?? 'Pengaduan #' . $complaint->id }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        @if (auth()->user()->role === 'user')
                                                            Dibuat {{ $complaint->created_at->diffForHumans() }}
                                                        @else
                                                            Dilaporkan oleh {{ $complaint->user->name ?? 'Anonim' }} •
                                                            {{ $complaint->created_at->diffForHumans() }}
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        <i
                                                            class="fas fa-map-marker-alt mr-1"></i>{{ $complaint->location ?? 'Lokasi tidak tersedia' }}
                                                    </p>
                                                </div>
                                                <div class="ml-4 flex flex-col items-end">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['badge'] }} mb-2">
                                                        <i
                                                            class="{{ $status['icon'] }} mr-1"></i>{{ $status['label'] }}
                                                    </span>
                                                    <span
                                                        class="text-xs text-gray-400">{{ $complaint->ticket }}</span>
                                                </div>
                                            </div>
                                            @if ($complaint->category)
                                                <div class="mt-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                                        <i class="fas fa-tag mr-1"></i>{{ $complaint->category }}
                                                    </span>
                                                </div>
                                            @endif

                                            <!-- Status Description untuk User -->
                                            @if (auth()->user()->role === 'user')
                                                <div class="mt-2">
                                                    @if ($complaint->status === 'pending')
                                                        <p
                                                            class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded">
                                                            <i class="fas fa-info-circle mr-1"></i>Pengaduan Anda
                                                            sedang menunggu review dari admin
                                                        </p>
                                                    @elseif($complaint->status === 'accepted')
                                                        <p class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded">
                                                            <i class="fas fa-check-circle mr-1"></i>Pengaduan Anda
                                                            telah diterima dan akan segera diproses
                                                        </p>
                                                    @elseif($complaint->status === 'in_progress')
                                                        <p
                                                            class="text-xs text-purple-600 bg-purple-50 px-2 py-1 rounded">
                                                            <i class="fas fa-cog mr-1"></i>Pengaduan Anda sedang dalam
                                                            proses penanganan
                                                        </p>
                                                    @elseif($complaint->status === 'completed')
                                                        <p
                                                            class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded">
                                                            <i class="fas fa-check-double mr-1"></i>Pengaduan Anda
                                                            telah diselesaikan
                                                        </p>
                                                    @elseif($complaint->status === 'rejected')
                                                        <p class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded">
                                                            <i class="fas fa-times-circle mr-1"></i>Pengaduan Anda
                                                            ditolak. Lihat detail untuk informasi lebih lanjut
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">
                                    @if (auth()->user()->role === 'user')
                                        Belum Ada Pengaduan
                                    @else
                                        Belum Ada Pengaduan Masuk
                                    @endif
                                </h3>
                                <p class="text-gray-500">
                                    @if (auth()->user()->role === 'user')
                                        Anda belum membuat pengaduan apapun.
                                    @else
                                        Belum ada pengaduan yang masuk ke sistem.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Info -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        @if (auth()->user()->role === 'user')
                            <!-- DIUBAH: Urutan menu diubah, Semua Pengaduan jadi prioritas utama -->
                            <a href="{{ route('user.all.complaints') }}"
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
                                    <span class="text-sm font-medium text-gray-900">Buat Pengaduan</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('user.complaints') }}"
                                class="w-full flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-file-alt text-purple-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Pengaduan Saya</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-purple-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('user.complaints', ['status' => 'completed']) }}"
                                class="w-full flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Pengaduan Selesai</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('panduan') }}"
                                class="w-full flex items-center justify-between p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-book text-yellow-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Lihat Panduan</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-yellow-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        @else
                            <a href="{{ route('admin.complaints.list') }}"
                                class="w-full flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-tasks text-blue-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Kelola Pengaduan</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-blue-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            <a href="{{ route('admin.reports') }}"
                                class="w-full flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                                <div class="flex items-center">
                                    <i class="fas fa-chart-line text-green-600 mr-3"></i>
                                    <span class="text-sm font-medium text-gray-900">Lihat Laporan</span>
                                </div>
                                <i
                                    class="fas fa-arrow-right text-green-600 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            @if (auth()->user()->role === 'admin')
                                <a href="{{ route('admin.users.list') }}"
                                    class="w-full flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-purple-600 mr-3"></i>
                                        <span class="text-sm font-medium text-gray-900">Kelola User</span>
                                    </div>
                                    <i
                                        class="fas fa-arrow-right text-purple-600 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Status Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Status</h3>
                    <div class="space-y-3">
                        @php
                            $statusSummary = [
                                'pending' => [
                                    'count' => $complaints->where('status', 'pending')->count(),
                                    'config' => $statusConfig['pending'],
                                ],
                                'accepted' => [
                                    'count' => $complaints->where('status', 'accepted')->count(),
                                    'config' => $statusConfig['accepted'],
                                ],
                                'in_progress' => [
                                    'count' => $complaints->where('status', 'in_progress')->count(),
                                    'config' => $statusConfig['in_progress'],
                                ],
                                'completed' => [
                                    'count' => $complaints->where('status', 'completed')->count(),
                                    'config' => $statusConfig['completed'],
                                ],
                                'rejected' => [
                                    'count' => $complaints->where('status', 'rejected')->count(),
                                    'config' => $statusConfig['rejected'],
                                ],
                            ];
                        @endphp

                        @foreach ($statusSummary as $statusKey => $data)
                            @if ($data['count'] > 0)
                                <div class="flex items-center justify-between p-3 {{ $data['config']['bg'] }} rounded-lg hover:{{ str_replace('100', '200', $data['config']['bg']) }} transition-colors cursor-pointer"
                                    onclick="filterByStatus('{{ $statusKey }}')">
                                    <div class="flex items-center">
                                        <i
                                            class="{{ $data['config']['icon'] }} {{ $data['config']['text'] }} mr-3"></i>
                                        <div>
                                            <span
                                                class="text-sm font-medium text-gray-900">{{ $data['config']['label'] }}</span>
                                            @if (auth()->user()->role === 'user')
                                                <p class="text-xs {{ $data['config']['text'] }} opacity-75">
                                                    @if ($statusKey === 'pending')
                                                        Menunggu review admin
                                                    @elseif($statusKey === 'accepted')
                                                        Siap diproses
                                                    @elseif($statusKey === 'in_progress')
                                                        Sedang ditangani
                                                    @elseif($statusKey === 'completed')
                                                        Telah selesai
                                                    @elseif($statusKey === 'rejected')
                                                        Tidak disetujui
                                                    @endif
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <span
                                        class="text-lg font-bold {{ $data['config']['text'] }}">{{ $data['count'] }}</span>
                                </div>
                            @endif
                        @endforeach

                        @if ($complaints->count() == 0)
                            <div class="text-center py-4">
                                <p class="text-sm text-gray-500">Belum ada pengaduan</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Help Center -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pusat Bantuan</h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-question-circle text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-700">FAQ</span>
                        </a>
                        <a href="#" class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-phone text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-700">Hubungi Kami</span>
                        </a>
                        <a href="{{ route('panduan') }}"
                            class="flex items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-book text-gray-400 mr-3"></i>
                            <span class="text-sm text-gray-700">Panduan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
                </div>
                <div class="p-6">
                    @if ($complaints->count() > 0)
                        <div class="flow-root">
                            <ul class="-mb-auto">
                                @foreach ($complaints->take(3) as $index => $complaint)
                                    @php
                                        $status = $statusConfig[$complaint->status] ?? [
                                            'label' => 'Unknown',
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-600',
                                            'icon' => 'fas fa-file-alt',
                                        ];
                                        $activityMessages = [
                                            'completed' => 'telah diselesaikan',
                                            'accepted' => 'telah diterima dan diverifikasi',
                                            'in_progress' => 'sedang dalam proses penanganan',
                                            'rejected' => 'ditolak',
                                            'pending' => 'menunggu review',
                                        ];
                                        $message =
                                            $activityMessages[$complaint->status] ??
                                            'telah dibuat oleh ' . ($complaint->user->name ?? 'Anonim');
                                    @endphp
                                    <li>
                                        <div class="relative {{ $index < 2 ? 'pb-8' : '' }}">
                                            @if ($index < 2)
                                                <span
                                                    class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div
                                                    class="w-8 h-8 {{ $status['bg'] }} rounded-full flex items-center justify-center">
                                                    <i
                                                        class="{{ $status['icon'] }} {{ $status['text'] }} text-sm"></i>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <p class="text-sm text-gray-500">
                                                        Pengaduan <span
                                                            class="font-medium text-gray-900">{{ $complaint->ticket }}</span>
                                                        {{ $message }}
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        {{ $complaint->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div
                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-history text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Aktivitas</h3>
                            <p class="text-gray-500">Aktivitas akan muncul setelah ada pengaduan yang masuk.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Lihat Semua Pengaduan (Hanya untuk Admin/Government) -->
    @if (auth()->user()->role !== 'user')
        <div x-show="showAllModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            style="display: none;">
            <div @click.away="showAllModal = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-white sticky top-0 z-10">
                    <h2 class="text-2xl font-bold text-gray-900">Semua Pengaduan</h2>
                    <button @click="showAllModal = false"
                        class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors">
                        <i class="fas fa-times text-gray-600"></i>
                    </button>
                </div>
                <!-- Modal Content -->
                <div class="overflow-y-auto max-h-[calc(90vh-120px)]">
                    @if ($complaints->count() > 0)
                        <div class="p-6">
                            <div class="grid gap-4">
                                @foreach ($complaints as $complaint)
                                    @php
                                        $status = $statusConfig[$complaint->status] ?? [
                                            'label' => ucfirst(str_replace('_', ' ', $complaint->status)),
                                            'icon' => 'fas fa-file-alt',
                                            'bg' => 'bg-gray-100',
                                            'text' => 'text-gray-600',
                                            'badge' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <div class="complaint-item flex items-start space-x-4 p-6 bg-white border border-gray-200 rounded-xl hover:shadow-md transition-shadow"
                                        data-status="{{ $complaint->status }}">
                                        <div
                                            class="w-12 h-12 {{ $status['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="{{ $status['icon'] }} {{ $status['text'] }}"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                                        <a href="{{ route('complaint.detail', $complaint->id) }}"
                                                            class="hover:text-blue-600 transition-colors">
                                                            {{ $complaint->title ?? 'Pengaduan #' . $complaint->id }}
                                                        </a>
                                                    </h4>
                                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                        {{ $complaint->description ?? 'Tidak ada deskripsi' }}
                                                    </p>
                                                    <div class="flex flex-wrap items-center gap-3 mb-3">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $status['badge'] }}">
                                                            <i
                                                                class="{{ $status['icon'] }} mr-1"></i>{{ $status['label'] }}
                                                        </span>
                                                        @if ($complaint->category)
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                                                <i
                                                                    class="fas fa-tag mr-1"></i>{{ $complaint->category }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex items-center text-sm text-gray-500 space-x-4">
                                                        <span>
                                                            <i
                                                                class="fas fa-user mr-1"></i>{{ $complaint->user->name ?? 'Anonim' }}
                                                        </span>
                                                        <span>
                                                            <i
                                                                class="fas fa-clock mr-1"></i>{{ $complaint->created_at->diffForHumans() }}
                                                        </span>
                                                        <span>
                                                            <i
                                                                class="fas fa-ticket-alt mr-1"></i>{{ $complaint->ticket }}
                                                        </span>
                                                    </div>
                                                    @if ($complaint->location)
                                                        <p class="text-xs text-gray-400 mt-2">
                                                            <i
                                                                class="fas fa-map-marker-alt mr-1"></i>{{ $complaint->location }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="ml-4 flex space-x-2">
                                                    <a href="{{ route('complaint.detail', $complaint->id) }}"
                                                        class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        <i class="fas fa-eye mr-2"></i>Detail
                                                    </a>
                                                    <a href="{{ route('admin.complaint.detail', $complaint->id) }}"
                                                        class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        <i class="fas fa-cog mr-2"></i>Kelola
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div
                                class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Pengaduan</h3>
                            <p class="text-gray-500">Belum ada pengaduan yang masuk ke sistem.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Mobile Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
        <div class="flex justify-around">
            @if (auth()->user()->role === 'user')
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-2 text-blue-600">
                    <i class="fas fa-home text-lg"></i>
                    <span class="text-xs mt-1">Dashboard</span>
                </a>
                <a href="{{ route('user.all.complaints') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-list text-lg"></i>
                    <span class="text-xs mt-1">Semua</span>
                </a>
                <a href="{{ route('user.complaints') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-file-alt text-lg"></i>
                    <span class="text-xs mt-1">Pengaduan</span>
                </a>
                <a href="{{ route('complaint') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-plus text-lg"></i>
                    <span class="text-xs mt-1">Buat</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-user text-lg"></i>
                    <span class="text-xs mt-1">Profil</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-2 text-blue-600">
                    <i class="fas fa-home text-lg"></i>
                    <span class="text-xs mt-1">Dashboard</span>
                </a>
                <a href="{{ route('admin.complaints.list') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-file-alt text-lg"></i>
                    <span class="text-xs mt-1">Pengaduan</span>
                </a>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users.list') }}" class="flex flex-col items-center py-2 text-gray-400">
                        <i class="fas fa-users text-lg"></i>
                        <span class="text-xs mt-1">Users</span>
                    </a>
                @endif
                <a href="{{ route('admin.reports') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-chart-bar text-lg"></i>
                    <span class="text-xs mt-1">Laporan</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center py-2 text-gray-400">
                    <i class="fas fa-user text-lg"></i>
                    <span class="text-xs mt-1">Profil</span>
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

    <script>
        document.addEventListener('alpine:init', () => {
            console.log('Alpine.js initialized');
        });

        function filterByStatus(status) {
            // Show modal with filtered complaints
            const modal = document.querySelector('[x-data]').__x.$data;
            modal.showAllModal = true;

            // Filter complaints by status
            setTimeout(() => {
                const complaints = document.querySelectorAll('.complaint-item');
                complaints.forEach(complaint => {
                    const complaintStatus = complaint.dataset.status;
                    if (status === 'all' || complaintStatus === status) {
                        complaint.style.display = 'block';
                    } else {
                        complaint.style.display = 'none';
                    }
                });
            }, 100);
        }
    </script>
</body>

</html>
