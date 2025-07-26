<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(Request $request)
    {
            if (Auth::user()->role === 'user') {
                abort(403, 'Unauthorized access');
            }
            return ($request);
    }

    // Kelola User (khusus admin)
    public function usersList()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $users = User::with('complaints')->paginate(10);
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalGovernment = User::where('role', 'pemerintah')->count();
        $totalRegularUsers = User::where('role', 'user')->count();

        return view('admin.users.list', compact(
            'users', 
            'totalUsers', 
            'totalAdmins', 
            'totalGovernment', 
            'totalRegularUsers'
        ));
    }

    public function createUser()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'required|string|max:100|unique:users',
            'role' => 'required|in:user,government,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.list')
            ->with('success', 'User berhasil dibuat!');
    }

    public function editUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'nik' => 'required|string|max:100|unique:users,nik,' . $id,
            'role' => 'required|in:user,government,admin',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users.list')
            ->with('success', 'User berhasil diupdate!');
    }

    public function deleteUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $user = User::findOrFail($id);
        
        // Prevent deleting self
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.list')
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.list')
            ->with('success', 'User berhasil dihapus!');
    }

    // Laporan dan Statistik
    public function reports()
    {
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'delayed')->count();
        $acceptedComplaints = Complaint::where('status', 'accepted')->count();
        $inProgressComplaints = Complaint::where('status', 'in_progress')->count();
        $completedComplaints = Complaint::where('status', 'completed')->count();
        $rejectedComplaints = Complaint::where('status', 'rejected')->count();

        // Data untuk chart
        $monthlyData = Complaint::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $categoryData = Complaint::selectRaw('category, COUNT(*) as count')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        $recentComplaints = Complaint::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports', compact(
            'totalComplaints',
            'pendingComplaints',
            'acceptedComplaints',
            'inProgressComplaints',
            'completedComplaints',
            'rejectedComplaints',
            'monthlyData',
            'categoryData',
            'recentComplaints'
        ));
    }

    // Pengaturan sistem
    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // Implementasi update pengaturan sistem
        // Bisa menggunakan config atau database untuk menyimpan pengaturan
        
        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil diupdate!');
    }
}
