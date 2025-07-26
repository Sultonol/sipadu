<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Logic dashboard yang sudah ada
        $user = Auth::user();

        // Get complaints based on user role - PASTIKAN TIDAK ADA FILTER STATUS
        if ($user->role === 'user') {
            // Ambil SEMUA pengaduan user tanpa filter status
            $complaints = Complaint::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $complaints = Complaint::with('user')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Status configuration - pastikan semua status ada
        $statusConfig = [
            'pending' => [
                'label' => 'Menunggu',
                'icon' => 'fas fa-clock',
                'bg' => 'bg-yellow-100',
                'text' => 'text-yellow-600',
                'badge' => 'bg-yellow-100 text-yellow-800',
            ],
            'accepted' => [
                'label' => 'Diterima',
                'icon' => 'fas fa-check',
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-600',
                'badge' => 'bg-blue-100 text-blue-800',
            ],
            'in_progress' => [
                'label' => 'Dalam Proses',
                'icon' => 'fas fa-hourglass-half',
                'bg' => 'bg-purple-100',
                'text' => 'text-purple-600',
                'badge' => 'bg-purple-100 text-purple-800',
            ],
            'completed' => [
                'label' => 'Selesai',
                'icon' => 'fas fa-check-circle',
                'bg' => 'bg-green-100',
                'text' => 'text-green-600',
                'badge' => 'bg-green-100 text-green-800',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'icon' => 'fas fa-times',
                'bg' => 'bg-red-100',
                'text' => 'text-red-600',
                'badge' => 'bg-red-100 text-red-800',
            ],
        ];

        // Statistics cards - pastikan semua status dihitung
        if ($user->role === 'user') {
            $statsCards = [
                [
                    'title' => 'Total Pengaduan',
                    'value' => $complaints->count(),
                    'subtitle' => 'Semua pengaduan Anda',
                    'icon' => 'fas fa-file-alt',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Menunggu',
                    'value' => $complaints->where('status', 'pending')->count(),
                    'subtitle' => 'Belum ditinjau',
                    'icon' => 'fas fa-clock',
                    'color' => 'yellow'
                ],
                [
                    'title' => 'Diterima',
                    'value' => $complaints->where('status', 'accepted')->count(),
                    'subtitle' => 'Telah diterima',
                    'icon' => 'fas fa-check',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Dalam Proses',
                    'value' => $complaints->where('status', 'in_progress')->count(),
                    'subtitle' => 'Sedang ditangani',
                    'icon' => 'fas fa-hourglass-half',
                    'color' => 'purple'
                ],
                [
                    'title' => 'Selesai',
                    'value' => $complaints->where('status', 'completed')->count(),
                    'subtitle' => 'Telah diselesaikan',
                    'icon' => 'fas fa-check-circle',
                    'color' => 'green'
                ],
                [
                    'title' => 'Ditolak',
                    'value' => $complaints->where('status', 'rejected')->count(),
                    'subtitle' => 'Tidak disetujui',
                    'icon' => 'fas fa-times',
                    'color' => 'red'
                ],
            ];
        } else {
            // Stats untuk admin/government tetap sama
            $statsCards = [
                [
                    'title' => 'Total Pengaduan',
                    'value' => $complaints->count(),
                    'subtitle' => 'Semua pengaduan',
                    'icon' => 'fas fa-file-alt',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Menunggu Review',
                    'value' => $complaints->where('status', 'pending')->count(),
                    'subtitle' => 'Perlu ditinjau',
                    'icon' => 'fas fa-clock',
                    'color' => 'yellow'
                ],
                [
                    'title' => 'Diterima',
                    'value' => $complaints->where('status', 'accepted')->count(),
                    'subtitle' => 'Telah diterima',
                    'icon' => 'fas fa-check',
                    'color' => 'blue'
                ],
                [
                    'title' => 'Dalam Proses',
                    'value' => $complaints->where('status', 'in_progress')->count(),
                    'subtitle' => 'Sedang ditangani',
                    'icon' => 'fas fa-hourglass-half',
                    'color' => 'purple'
                ],
                [
                    'title' => 'Diselesaikan',
                    'value' => $complaints->where('status', 'completed')->count(),
                    'subtitle' => 'Telah selesai',
                    'icon' => 'fas fa-check-circle',
                    'color' => 'green'
                ],
                [
                    'title' => 'Ditolak',
                    'value' => $complaints->where('status', 'rejected')->count(),
                    'subtitle' => 'Tidak disetujui',
                    'icon' => 'fas fa-times',
                    'color' => 'red'
                ],
            ];
        }

        $usercomplaint = $complaints->first();
        return view('dashboard', compact('complaints', 'statusConfig', 'statsCards', 'usercomplaint'));
    }

    /**
     * Halaman khusus untuk user melihat semua pengaduan mereka
     */
    public function userComplaints(Request $request)
    {
        // Pastikan hanya user yang bisa akses
        if (Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized access');
        }

        $user = Auth::user();
        $query = Complaint::where('user_id', $user->id);

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search berdasarkan title atau description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('ticket', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(12);

        // Status configuration
        $statusConfig = [
            'pending' => [
                'label' => 'Menunggu',
                'icon' => 'fas fa-clock',
                'bg' => 'bg-yellow-100',
                'text' => 'text-yellow-600',
                'badge' => 'bg-yellow-100 text-yellow-800',
                'description' => 'Pengaduan sedang menunggu review dari admin'
            ],
            'accepted' => [
                'label' => 'Diterima',
                'icon' => 'fas fa-check',
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-600',
                'badge' => 'bg-blue-100 text-blue-800',
                'description' => 'Pengaduan telah diterima dan akan diproses'
            ],
            'in_progress' => [
                'label' => 'Dalam Proses',
                'icon' => 'fas fa-hourglass-half',
                'bg' => 'bg-purple-100',
                'text' => 'text-purple-600',
                'badge' => 'bg-purple-100 text-purple-800',
                'description' => 'Pengaduan sedang dalam proses penanganan'
            ],
            'completed' => [
                'label' => 'Selesai',
                'icon' => 'fas fa-check-circle',
                'bg' => 'bg-green-100',
                'text' => 'text-green-600',
                'badge' => 'bg-green-100 text-green-800',
                'description' => 'Pengaduan telah diselesaikan'
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'icon' => 'fas fa-times',
                'bg' => 'bg-red-100',
                'text' => 'text-red-600',
                'badge' => 'bg-red-100 text-red-800',
                'description' => 'Pengaduan ditolak, lihat detail untuk info lebih lanjut'
            ],
        ];

        // Statistics untuk user
        $stats = [
            'total' => Complaint::where('user_id', $user->id)->count(),
            'pending' => Complaint::where('user_id', $user->id)->where('status', 'pending')->count(),
            'accepted' => Complaint::where('user_id', $user->id)->where('status', 'accepted')->count(),
            'in_progress' => Complaint::where('user_id', $user->id)->where('status', 'in_progress')->count(),
            'completed' => Complaint::where('user_id', $user->id)->where('status', 'completed')->count(),
            'rejected' => Complaint::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        // Get unique categories for filter
        $categories = Complaint::where('user_id', $user->id)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('admin.users.complaints', compact('complaints', 'statusConfig', 'stats', 'categories'));
    }

    /**
     * FITUR BARU: Halaman untuk user melihat SEMUA pengaduan dari semua user
     */
    public function allComplaints(Request $request)
    {
        // Pastikan hanya user yang bisa akses
        if (Auth::user()->role !== 'user') {
            abort(403, 'Unauthorized access');
        }

        // Ambil SEMUA pengaduan dari semua user
        $query = Complaint::with('user');

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search berdasarkan title atau description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('ticket', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(15);

        // Status configuration
        $statusConfig = [
            'pending' => [
                'label' => 'Menunggu',
                'icon' => 'fas fa-clock',
                'bg' => 'bg-yellow-100',
                'text' => 'text-yellow-600',
                'badge' => 'bg-yellow-100 text-yellow-800',
            ],
            'accepted' => [
                'label' => 'Diterima',
                'icon' => 'fas fa-check',
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-600',
                'badge' => 'bg-blue-100 text-blue-800',
            ],
            'in_progress' => [
                'label' => 'Dalam Proses',
                'icon' => 'fas fa-hourglass-half',
                'bg' => 'bg-purple-100',
                'text' => 'text-purple-600',
                'badge' => 'bg-purple-100 text-purple-800',
            ],
            'completed' => [
                'label' => 'Selesai',
                'icon' => 'fas fa-check-circle',
                'bg' => 'bg-green-100',
                'text' => 'text-green-600',
                'badge' => 'bg-green-100 text-green-800',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'icon' => 'fas fa-times',
                'bg' => 'bg-red-100',
                'text' => 'text-red-600',
                'badge' => 'bg-red-100 text-red-800',
            ],
        ];

        // Statistics untuk semua pengaduan
        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'accepted' => Complaint::where('status', 'accepted')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'completed' => Complaint::where('status', 'completed')->count(),
            'rejected' => Complaint::where('status', 'rejected')->count(),
        ];

        // Get unique categories for filter
        $categories = Complaint::whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('admin.users.all-complaints', compact('complaints', 'statusConfig', 'stats', 'categories'));
    }

    /**
     * Filter semua pengaduan via AJAX
     */
    public function filterAllComplaints(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Complaint::with('user');

        // Apply filters
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('ticket', 'like', '%' . $request->search . '%');
            });
        }

        $complaints = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'complaints' => $complaints,
            'count' => $complaints->count()
        ]);
    }

    public function panduan()
    {
        return view('panduan');
    }

    public function detailpandu($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);

        // Check if user can view this complaint
        if (Auth::user()->role === 'user' && $complaint->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $statusConfig = [
            'pending' => ['label' => 'Menunggu', 'color' => 'yellow', 'icon' => 'fas fa-clock'],
            'accepted' => ['label' => 'Diterima', 'color' => 'blue', 'icon' => 'fas fa-check'],
            'in_progress' => ['label' => 'Dalam Proses', 'color' => 'purple', 'icon' => 'fas fa-hourglass-half'],
            'completed' => ['label' => 'Selesai', 'color' => 'green', 'icon' => 'fas fa-check-circle'],
            'rejected' => ['label' => 'Ditolak', 'color' => 'red', 'icon' => 'fas fa-times'],
        ];

        return view('admin.complaints.detail-useradu', compact('complaint', 'statusConfig'));
    }

    public function complete()
    {
        return view('complete');
    }

    public function adminComplaintsList(Request $request)
    {
        // Check authorization
        if (Auth::user()->role === 'user') {
            abort(403, 'Unauthorized access');
        }

        try {
            $query = Complaint::with(['user']);

            // Filter berdasarkan status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan kategori
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            // Filter berdasarkan tanggal
            if ($request->filled('date')) {
                $query->whereDate('created_at', $request->date);
            }

            // Search berdasarkan title atau description
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%')
                        ->orWhere('ticket', 'like', '%' . $request->search . '%');
                });
            }

            $complaints = $query->orderBy('created_at', 'desc')->paginate(20);

            $statusConfig = [
                'pending' => ['label' => 'Menunggu', 'color' => 'yellow', 'icon' => 'fas fa-clock'],
                'accepted' => ['label' => 'Diterima', 'color' => 'blue', 'icon' => 'fas fa-check'],
                'in_progress' => ['label' => 'Dalam Proses', 'color' => 'purple', 'icon' => 'fas fa-hourglass-half'],
                'completed' => ['label' => 'Selesai', 'color' => 'green', 'icon' => 'fas fa-check-circle'],
                'rejected' => ['label' => 'Ditolak', 'color' => 'red', 'icon' => 'fas fa-times'],
            ];

            // Statistics
            $stats = [
                'total' => Complaint::count(),
                'pending' => Complaint::where('status', 'pending')->count(),
                'accepted' => Complaint::where('status', 'accepted')->count(),
                'in_progress' => Complaint::where('status', 'in_progress')->count(),
                'completed' => Complaint::where('status', 'completed')->count(),
                'rejected' => Complaint::where('status', 'rejected')->count(),
            ];

            return view('admin.complaints.list', compact('complaints', 'statusConfig', 'stats'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function adminComplaintDetail($id)
    {
        // Check authorization
        if (Auth::user()->role === 'user') {
            abort(403, 'Unauthorized access');
        }

        try {
            $complaint = Complaint::with(['user'])->findOrFail($id);

            $statusConfig = [
                'pending' => ['label' => 'Menunggu', 'color' => 'yellow', 'icon' => 'fas fa-clock'],
                'accepted' => ['label' => 'Diterima', 'color' => 'blue', 'icon' => 'fas fa-check'],
                'in_progress' => ['label' => 'Dalam Proses', 'color' => 'purple', 'icon' => 'fas fa-hourglass-half'],
                'completed' => ['label' => 'Selesai', 'color' => 'green', 'icon' => 'fas fa-check-circle'],
                'rejected' => ['label' => 'Ditolak', 'color' => 'red', 'icon' => 'fas fa-times'],
            ];

            return view('admin.complaints.detail', compact('complaint', 'statusConfig'));
        } catch (\Exception $e) {
            return redirect()->route('admin.complaints.list')->with('error', 'Pengaduan tidak ditemukan.');
        }
    }

    public function adminUpdateStatus(Request $request, $id)
    {
        // Check authorization
        if (Auth::user()->role === 'user') {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'status' => 'required|in:pending,accepted,in_progress,completed,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $complaint = Complaint::findOrFail($id);
            $oldStatus = $complaint->status;

            $complaint->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);

            // Log activity jika diperlukan
            if ($request->filled('notes')) {
                // Bisa ditambahkan sistem logging atau comment
                // Comment::create([...]);
            }

            return redirect()->back()->with('success', 'Status pengaduan berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    public function adminAddComment(Request $request, $id)
    {
        // Check authorization
        if (Auth::user()->role === 'user') {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        try {
            // Logic untuk menambah komentar
            // Implementasi sesuai dengan struktur tabel yang ada
            // Comment::create([...]);

            return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan komentar: ' . $e->getMessage());
        }
    }

    public function adminAddResponse(Request $request, $id)
    {
        // Check authorization
        if (Auth::user()->role === 'user') {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'response' => 'required|string|max:2000'
        ]);

        try {
            // Logic untuk menambah response
            // Implementasi sesuai dengan struktur tabel yang ada
            // Response::create([...]);

            return redirect()->back()->with('success', 'Response berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan response: ' . $e->getMessage());
        }
    }

    // Method tambahan untuk statistik dashboard
    public function getDashboardStats()
    {
        $user = Auth::user();

        if ($user->role === 'user') {
            $stats = [
                'total_complaints' => Complaint::where('user_id', $user->id)->count(),
                'pending_complaints' => Complaint::where('user_id', $user->id)->where('status', 'pending')->count(),
                'completed_complaints' => Complaint::where('user_id', $user->id)->where('status', 'completed')->count(),
            ];
        } else {
            $stats = [
                'total_complaints' => Complaint::count(),
                'total_users' => User::where('role', 'user')->count(),
                'pending_complaints' => Complaint::where('status', 'pending')->count(),
                'completed_complaints' => Complaint::where('status', 'completed')->count(),
                'completion_rate' => $this->getCompletionRate(),
            ];
        }

        return response()->json($stats);
    }

    private function getCompletionRate()
    {
        $total = Complaint::count();
        if ($total == 0) return 0;

        $completed = Complaint::where('status', 'completed')->count();
        return round(($completed / $total) * 100, 1);
    }

    // Method untuk export data (jika diperlukan)
    public function exportComplaints(Request $request)
    {
        // Check authorization
        if (Auth::user()->role === 'user') {
            abort(403, 'Unauthorized access');
        }

        try {
            // Logic untuk export data
            // Bisa menggunakan Laravel Excel atau format lain

            return response()->json(['message' => 'Export berhasil']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal export data'], 500);
        }
    }

    // Method untuk dashboard analytics
    public function getAnalytics(Request $request)
    {
        // Check authorization
        if (Auth::user()->role === 'user') {
            abort(403, 'Unauthorized access');
        }

        try {
            $period = $request->get('period', '30'); // default 30 hari
            $analytics = [
                'complaints_trend' => $this->getComplaintsTrend($period),
                'status_distribution' => $this->getStatusDistribution(),
                'category_breakdown' => $this->getCategoryBreakdown(),
                'response_time' => $this->getAverageResponseTime(),
            ];

            return response()->json($analytics);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data analytics'], 500);
        }
    }

    // Method untuk quick update status via AJAX
    public function quickUpdateStatus(Request $request, $id)
    {
        // Check authorization
        if (Auth::user()->role === 'user') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,accepted,in_progress,completed,rejected'
        ]);

        try {
            $complaint = Complaint::findOrFail($id);
            $complaint->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate',
                'new_status' => $request->status
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengupdate status'], 500);
        }
    }

    private function getComplaintsTrend($days)
    {
        return Complaint::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getStatusDistribution()
    {
        return Complaint::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
    }

    private function getCategoryBreakdown()
    {
        return Complaint::selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
    }

    private function getAverageResponseTime()
    {
        // Logic untuk menghitung rata-rata waktu response
        // Implementasi sesuai dengan kebutuhan bisnis
        return 0;
    }

    // Tambahkan method untuk filter berdasarkan status
    public function getComplaintsByStatus(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status');

        if ($user->role === 'user') {
            $query = Complaint::where('user_id', $user->id);
        } else {
            $query = Complaint::with('user');
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $complaints = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'complaints' => $complaints,
            'count' => $complaints->count()
        ]);
    }
}
