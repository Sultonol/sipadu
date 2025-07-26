<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Saya - Sistem Pengaduan Masyarakat</title>
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

<body class="bg-gray-50 min-h-screen" x-data="complaintsPage()">
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div
                class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 rounded-2xl p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-2">Pengaduan Saya 📋</h2>
                    <p class="text-blue-100 text-lg mb-6">
                        Pantau status dan perkembangan semua pengaduan yang telah Anda ajukan
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <button onclick="window.location.href='{{ route('complaint') }}'"
                            class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors flex items-center">
                            <i class="fas fa-plus mr-2"></i>Buat Pengaduan Baru
                        </button>
                        <button onclick="window.location.href='{{ route('dashboard') }}'"
                            class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                        </button>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            @php
                $statsCards = [
                    [
                        'title' => 'Total',
                        'value' => $stats['total'],
                        'icon' => 'fas fa-file-alt',
                        'color' => 'blue',
                        'status' => 'all',
                    ],
                    [
                        'title' => 'Menunggu',
                        'value' => $stats['pending'],
                        'icon' => 'fas fa-clock',
                        'color' => 'yellow',
                        'status' => 'pending',
                    ],
                    [
                        'title' => 'Diterima',
                        'value' => $stats['accepted'],
                        'icon' => 'fas fa-check',
                        'color' => 'blue',
                        'status' => 'accepted',
                    ],
                    [
                        'title' => 'Proses',
                        'value' => $stats['in_progress'],
                        'icon' => 'fas fa-hourglass-half',
                        'color' => 'purple',
                        'status' => 'in_progress',
                    ],
                    [
                        'title' => 'Selesai',
                        'value' => $stats['completed'],
                        'icon' => 'fas fa-check-circle',
                        'color' => 'green',
                        'status' => 'completed',
                    ],
                    [
                        'title' => 'Ditolak',
                        'value' => $stats['rejected'],
                        'icon' => 'fas fa-times',
                        'color' => 'red',
                        'status' => 'rejected',
                    ],
                ];
            @endphp
            @foreach ($statsCards as $card)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow cursor-pointer"
                    @click="filterByStatus('{{ $card['status'] }}')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600">{{ $card['title'] }}</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-{{ $card['color'] }}-100 rounded-lg flex items-center justify-center">
                            <i class="{{ $card['icon'] }} text-{{ $card['color'] }}-600"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select x-model="filters.status" @change="applyFilters()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Semua Status</option>
                        <option value="pending">Menunggu</option>
                        <option value="accepted">Diterima</option>
                        <option value="in_progress">Dalam Proses</option>
                        <option value="completed">Selesai</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select x-model="filters.category" @change="applyFilters()"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                    <input type="text" x-model="filters.search" @input.debounce.500ms="applyFilters()"
                        placeholder="Cari pengaduan..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Reset Filter -->
                <div class="flex items-end">
                    <button @click="resetFilters()"
                        class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-refresh mr-2"></i>Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Complaints List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Daftar Pengaduan (<span x-text="filteredComplaints.length"></span>)
                    </h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Urutkan:</span>
                        <select x-model="sortBy" @change="sortComplaints()"
                            class="px-3 py-1 border border-gray-300 rounded text-sm">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="status">Status</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div x-show="loading" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500">Memuat data...</p>
                </div>

                <div x-show="!loading && filteredComplaints.length === 0" class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Pengaduan</h3>
                    <p class="text-gray-500 mb-4">Belum ada pengaduan yang sesuai dengan filter yang dipilih.</p>
                    <button onclick="window.location.href='{{ route('complaint') }}'"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Buat Pengaduan Pertama
                    </button>
                </div>

                <div x-show="!loading && filteredComplaints.length > 0" class="grid gap-6">
                    <template x-for="complaint in paginatedComplaints" :key="complaint.id">
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <div :class="getStatusConfig(complaint.status).bg"
                                            class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i
                                                :class="getStatusConfig(complaint.status).icon + ' ' + getStatusConfig(complaint
                                                    .status).text"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-900 mb-2">
                                                <a :href="'/detail-panduan/' + complaint.id"
                                                    class="hover:text-blue-600 transition-colors"
                                                    x-text="complaint.title || 'Pengaduan #' + complaint.id"></a>
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-3 line-clamp-2"
                                                x-text="complaint.description || 'Tidak ada deskripsi'"></p>

                                            <div class="flex flex-wrap items-center gap-3 mb-3">
                                                <span :class="getStatusConfig(complaint.status).badge"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                    <i :class="getStatusConfig(complaint.status).icon + ' mr-1'"></i>
                                                    <span x-text="getStatusConfig(complaint.status).label"></span>
                                                </span>
                                                <span x-show="complaint.category"
                                                    class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                                    <i class="fas fa-tag mr-1"></i>
                                                    <span x-text="complaint.category"></span>
                                                </span>
                                            </div>

                                            <!-- Status Description -->
                                            <div class="mb-3">
                                                <p :class="getStatusDescriptionClass(complaint.status)"
                                                    class="text-xs px-3 py-2 rounded-lg">
                                                    <i :class="getStatusConfig(complaint.status).icon + ' mr-1'"></i>
                                                    <span x-text="getStatusDescription(complaint.status)"></span>
                                                </p>
                                            </div>

                                            <div class="flex items-center text-sm text-gray-500 space-x-4">
                                                <span>
                                                    <i class="fas fa-clock mr-1"></i>
                                                    <span x-text="formatDate(complaint.created_at)"></span>
                                                </span>
                                                <span>
                                                    <i class="fas fa-ticket-alt mr-1"></i>
                                                    <span x-text="complaint.ticket"></span>
                                                </span>
                                            </div>
                                            <p x-show="complaint.location" class="text-xs text-gray-400 mt-2">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                <span x-text="complaint.location"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-4 flex space-x-2">
                                    <a :href="'/detail-panduan/' + complaint.id"
                                        class="inline-flex items-center px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        <i class="fas fa-eye mr-2"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Pagination -->
                <div x-show="!loading && filteredComplaints.length > itemsPerPage" class="mt-8 flex justify-center">
                    <div class="flex items-center space-x-2">
                        <button @click="previousPage()" :disabled="currentPage === 1"
                            class="px-3 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <template x-for="page in totalPages" :key="page">
                            <button @click="goToPage(page)"
                                :class="page === currentPage ? 'bg-blue-600 text-white' :
                                    'bg-gray-200 text-gray-600 hover:bg-gray-300'"
                                class="px-3 py-2 rounded-lg transition-colors" x-text="page"></button>
                        </template>
                        <button @click="nextPage()" :disabled="currentPage === totalPages"
                            class="px-3 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function complaintsPage() {
            return {
                complaints: @json($complaints->items()),
                filteredComplaints: @json($complaints->items()),
                loading: false,
                currentPage: 1,
                itemsPerPage: 6,
                sortBy: 'newest',
                filters: {
                    status: 'all',
                    category: 'all',
                    search: ''
                },
                statusConfig: @json($statusConfig),

                init() {
                    this.filteredComplaints = [...this.complaints];
                },

                get paginatedComplaints() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredComplaints.slice(start, end);
                },

                get totalPages() {
                    return Math.ceil(this.filteredComplaints.length / this.itemsPerPage);
                },

                filterByStatus(status) {
                    this.filters.status = status;
                    this.applyFilters();
                },

                applyFilters() {
                    this.loading = true;

                    setTimeout(() => {
                        let filtered = [...this.complaints];

                        // Filter by status
                        if (this.filters.status !== 'all') {
                            filtered = filtered.filter(complaint => complaint.status === this.filters.status);
                        }

                        // Filter by category
                        if (this.filters.category !== 'all') {
                            filtered = filtered.filter(complaint => complaint.category === this.filters.category);
                        }

                        // Filter by search
                        if (this.filters.search) {
                            const search = this.filters.search.toLowerCase();
                            filtered = filtered.filter(complaint =>
                                (complaint.title && complaint.title.toLowerCase().includes(search)) ||
                                (complaint.description && complaint.description.toLowerCase().includes(
                                    search)) ||
                                (complaint.ticket && complaint.ticket.toLowerCase().includes(search))
                            );
                        }

                        this.filteredComplaints = filtered;
                        this.currentPage = 1;
                        this.sortComplaints();
                        this.loading = false;
                    }, 300);
                },

                resetFilters() {
                    this.filters = {
                        status: 'all',
                        category: 'all',
                        search: ''
                    };
                    this.applyFilters();
                },

                sortComplaints() {
                    if (this.sortBy === 'newest') {
                        this.filteredComplaints.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    } else if (this.sortBy === 'oldest') {
                        this.filteredComplaints.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                    } else if (this.sortBy === 'status') {
                        const statusOrder = ['pending', 'accepted', 'in_progress', 'completed', 'rejected'];
                        this.filteredComplaints.sort((a, b) => statusOrder.indexOf(a.status) - statusOrder.indexOf(b
                            .status));
                    }
                },

                previousPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },

                goToPage(page) {
                    this.currentPage = page;
                },

                getStatusConfig(status) {
                    return this.statusConfig[status] || {
                        label: 'Unknown',
                        icon: 'fas fa-question',
                        bg: 'bg-gray-100',
                        text: 'text-gray-600',
                        badge: 'bg-gray-100 text-gray-800'
                    };
                },

                getStatusDescription(status) {
                    const descriptions = {
                        'pending': 'Pengaduan Anda sedang menunggu review dari tim admin. Mohon bersabar.',
                        'accepted': 'Selamat! Pengaduan Anda telah diterima dan akan segera diproses oleh tim terkait.',
                        'in_progress': 'Pengaduan Anda sedang dalam proses penanganan. Tim sedang bekerja menyelesaikan masalah ini.',
                        'completed': 'Pengaduan Anda telah diselesaikan! Terima kasih atas partisipasi Anda.',
                        'rejected': 'Pengaduan Anda ditolak. Silakan lihat detail untuk informasi lebih lanjut atau hubungi admin.'
                    };
                    return descriptions[status] || 'Status tidak diketahui';
                },

                getStatusDescriptionClass(status) {
                    const classes = {
                        'pending': 'text-yellow-700 bg-yellow-100',
                        'accepted': 'text-blue-700 bg-blue-100',
                        'in_progress': 'text-purple-700 bg-purple-100',
                        'completed': 'text-green-700 bg-green-100',
                        'rejected': 'text-red-700 bg-red-100'
                    };
                    return classes[status] || 'text-gray-700 bg-gray-100';
                },

                formatDate(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diffTime = Math.abs(now - date);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    if (diffDays === 1) return 'Kemarin';
                    if (diffDays < 7) return `${diffDays} hari lalu`;
                    if (diffDays < 30) return `${Math.ceil(diffDays / 7)} minggu lalu`;
                    if (diffDays < 365) return `${Math.ceil(diffDays / 30)} bulan lalu`;
                    return `${Math.ceil(diffDays / 365)} tahun lalu`;
                }
            }
        }
    </script>

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
