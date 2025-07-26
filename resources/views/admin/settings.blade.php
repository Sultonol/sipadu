<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>
                <h1 class="text-xl font-bold text-gray-900">Pengaturan Sistem</h1>
                <div></div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Pengaturan Sistem</h3>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Sistem</label>
                        <input type="text" id="site_name" name="site_name"
                            value="SiPengMas - Sistem Pengaduan Masyarakat"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email
                            Kontak</label>
                        <input type="email" id="contact_email" name="contact_email" value="admin@sipengmas.go.id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                            Telepon</label>
                        <input type="text" id="contact_phone" name="contact_phone" value="021-12345678"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="office_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat
                            Kantor</label>
                        <textarea id="office_address" name="office_address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">Jl. Merdeka No. 123, Jakarta Pusat, DKI Jakarta 10110</textarea>
                    </div>

                    <div class="border-t pt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Pengaturan Notifikasi</h4>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="email_notifications" name="email_notifications" checked
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="email_notifications" class="ml-2 block text-sm text-gray-900">
                                    Kirim notifikasi email untuk pengaduan baru
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="auto_assign" name="auto_assign"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="auto_assign" class="ml-2 block text-sm text-gray-900">
                                    Otomatis assign pengaduan ke petugas
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
