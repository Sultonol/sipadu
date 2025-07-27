@props(['user'])

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
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('dashboard') }}"
                    class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>

                @if ($user->role === 'user')
                    <!-- Menu khusus untuk User/Masyarakat -->
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
                @elseif ($user->role === 'admin')
                    <!-- Menu khusus untuk Administrator -->
                    <a href="{{ route('admin.complaints.list') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-file-alt mr-2"></i>Kelola Pengaduan
                    </a>
                    <a href="{{ route('admin.users.list') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-users mr-2"></i>Kelola User
                    </a>
                    <a href="{{ route('admin.reports') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-chart-bar mr-2"></i>Laporan & Statistik
                    </a>
                    <a href="{{ route('admin.settings') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-cog mr-2"></i>Pengaturan
                    </a>
                @elseif ($user->role === 'pemerintah')
                    <!-- Menu khusus untuk Pemerintah -->
                    <a href="{{ route('admin.complaints.list') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-file-alt mr-2"></i>Kelola Pengaduan
                    </a>
                    <a href="{{ route('admin.reports') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-chart-bar mr-2"></i>Laporan & Statistik
                    </a>
                    <a href="{{ route('panduan') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                        <i class="fas fa-book mr-2"></i>Panduan
                    </a>
                @endif
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4" x-data="{ open: false }">
                <div class="hidden md:flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">
                            @if ($user->role === 'admin')
                                <span
                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">Administrator</span>
                            @elseif($user->role === 'government')
                                <span
                                    class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Pemerintah</span>
                            @else
                                <span
                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Masyarakat</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <button @click="open = !open"
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white hover:shadow-lg transition-shadow">
                        <i class="fas fa-user"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-circle mr-2"></i>Profil Saya
                        </a>

                        @if ($user->role === 'admin')
                            <a href="{{ route('admin.settings') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Pengaturan Sistem
                            </a>
                            <a href="{{ route('admin.users.list') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-users mr-2"></i>Manajemen User
                            </a>
                        @elseif($user->role === 'government')
                            <a href="{{ route('admin.reports') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-chart-line mr-2"></i>Laporan
                            </a>
                        @elseif($user->role === 'user')
                            <a href="{{ route('complaint') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-plus mr-2"></i>Buat Pengaduan
                            </a>
                            <a href="{{ route('panduan') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-book mr-2"></i>Panduan
                            </a>
                        @endif

                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('logout') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div class="md:hidden" x-data="{ mobileOpen: false }">
        <div class="px-4 py-2 border-t border-gray-200">
            <button @click="mobileOpen = !mobileOpen"
                class="w-full flex items-center justify-between text-gray-600 hover:text-blue-600">
                <span class="text-sm font-medium">Menu</span>
                <i class="fas fa-chevron-down" :class="{ 'rotate-180': mobileOpen }"></i>
            </button>
        </div>

        <div x-show="mobileOpen" x-transition class="px-4 py-2 border-t border-gray-200 bg-gray-50">
            @if ($user->role === 'user')
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
            @elseif ($user->role === 'admin')
                <a href="{{ route('admin.complaints.list') }}"
                    class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                    <i class="fas fa-file-alt mr-2"></i>Kelola Pengaduan
                </a>
                <a href="{{ route('admin.users.list') }}"
                    class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                    <i class="fas fa-users mr-2"></i>Kelola User
                </a>
                <a href="{{ route('admin.reports') }}" class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                    <i class="fas fa-chart-bar mr-2"></i>Laporan & Statistik
                </a>
                <a href="{{ route('admin.settings') }}" class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                    <i class="fas fa-cog mr-2"></i>Pengaturan
                </a>
            @elseif ($user->role === 'pemerintah')
                <a href="{{ route('admin.complaints.list') }}"
                    class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                    <i class="fas fa-file-alt mr-2"></i>Kelola Pengaduan
                </a>
                <a href="{{ route('admin.reports') }}" class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                    <i class="fas fa-chart-bar mr-2"></i>Laporan & Statistik
                </a>
                <a href="{{ route('panduan') }}" class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                    <i class="fas fa-book mr-2"></i>Panduan
                </a>
            @endif
        </div>
    </div>
</nav>
