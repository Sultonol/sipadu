@props(['user'])

<nav class="bg-white shadow-sm border-b border-gray-200 nav-compact">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14">
            <!-- Logo & Brand -->
            <div class="flex items-center space-x-3">
                <div
                    class="logo-container bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-comments text-white logo-icon"></i>
                </div>
                <div>
                    <h1 class="brand-title text-gray-900">SiPengMas</h1>
                    <p class="brand-subtitle text-gray-500">Sistem Pengaduan Masyarakat</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center nav-spacing">
                <a href="{{ route('dashboard') }}" class="nav-link text-blue-600 hover:text-blue-700">
                    <i class="nav-icon fas fa-home"></i>Dashboard
                </a>

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
                    <a href="{{ route('admin.complaints.list') }}" class="nav-link text-gray-600 hover:text-blue-600">
                        <i class="nav-icon fas fa-file-alt"></i>Pengaduan
                    </a>
                    <a href="{{ route('admin.users.list') }}" class="nav-link text-gray-600 hover:text-blue-600">
                        <i class="nav-icon fas fa-users"></i>Users
                    </a>
                    <a href="{{ route('admin.reports') }}" class="nav-link text-gray-600 hover:text-blue-600">
                        <i class="nav-icon fas fa-chart-bar"></i>Laporan
                    </a>
                    <a href="{{ route('admin.settings') }}" class="nav-link text-gray-600 hover:text-blue-600">
                        <i class="nav-icon fas fa-cog"></i>Setting
                    </a>
                @elseif ($user->role === 'pemerintah')
                    <a href="{{ route('admin.complaints.list') }}" class="nav-link text-gray-600 hover:text-blue-600">
                        <i class="nav-icon fas fa-file-alt"></i>Pengaduan
                    </a>
                    <a href="{{ route('admin.reports') }}" class="nav-link text-gray-600 hover:text-blue-600">
                        <i class="nav-icon fas fa-chart-bar"></i>Laporan
                    </a>
                    <a href="{{ route('panduan') }}" class="nav-link text-gray-600 hover:text-blue-600">
                        <i class="nav-icon fas fa-book"></i>Panduan
                    </a>
                @endif
            </div>

            <!-- User Menu -->
            <div class="flex items-center user-info-spacing" x-data="{ open: false }">
                <div class="hidden md:flex items-center space-x-2">
                    <div class="text-right">
                        <p class="user-name text-gray-900">{{ Str::limit($user->name, 15) }}</p>
                        <div class="mt-0.5">
                            @if ($user->role === 'admin')
                                <span class="role-badge bg-red-100 text-red-800 rounded-full">Admin</span>
                            @elseif($user->role === 'government')
                                <span class="role-badge bg-green-100 text-green-800 rounded-full">Gov</span>
                            @else
                                <span class="role-badge bg-blue-100 text-blue-800 rounded-full">User</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button @click="open = !open"
                        class="user-avatar bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white hover:shadow-md transition-shadow">
                        <i class="fas fa-user"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="dropdown-menu absolute right-0 mt-2 bg-white rounded-lg shadow-lg py-1 z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="dropdown-item block text-gray-700 hover:bg-gray-50">
                            <i class="dropdown-icon fas fa-user-circle mr-2"></i>Profil
                        </a>

                        @if ($user->role === 'admin')
                            <a href="{{ route('admin.settings') }}"
                                class="dropdown-item block text-gray-700 hover:bg-gray-50">
                                <i class="dropdown-icon fas fa-cog mr-2"></i>Setting
                            </a>
                        @elseif($user->role === 'pemerintah')
                            <a href="{{ route('admin.reports') }}"
                                class="dropdown-item block text-gray-700 hover:bg-gray-50">
                                <i class="dropdown-icon fas fa-chart-line mr-2"></i>Laporan
                            </a>
                        @elseif($user->role === 'user')
                            <a href="{{ route('complaint') }}"
                                class="dropdown-item block text-gray-700 hover:bg-gray-50">
                                <i class="dropdown-icon fas fa-plus mr-2"></i>Buat
                            </a>
                        @endif

                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item block text-gray-700 hover:bg-gray-50">
                            <i class="dropdown-icon fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
