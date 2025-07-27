<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function add()
    {
        return view('complaint-add');
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'category' => ['required'],
            'media' => ['nullable', 'mimes:jpg,jpeg,png,gif,mp4,webm', 'max:5120']
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('complaint_media', 'public');
        }

        Complaint::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
            'media' => $mediaPath, // DIPERBAIKI: sesuaikan dengan field database
            'category' => $request->category,
            'ticket' => strtoupper(Str::random(10)),
            'status' => 'pending' // TAMBAHKAN: status default
        ]);

        Session::flash('message', 'Pengaduan laporan berhasil dibuat!');
        return redirect()->route('dashboard');
    }

    public function editcomplaint($id)
    {
        $complaint = Complaint::with('user')->findOrFail($id);
        
        // DIPERBAIKI: Cek akses - hanya pemilik yang bisa edit
        if (Auth::user()->role === 'user' && Auth::user()->id !== $complaint->user_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit pengaduan ini.');
        }

        // TAMBAHKAN: Cek status - hanya status tertentu yang bisa diedit
        if (!in_array($complaint->status, ['pending', 'rejected'])) {
            return redirect()->route('complaint.detail', $complaint->id)
                           ->with('error', 'Pengaduan dengan status "' . $complaint->status . '" tidak dapat diedit.');
        }

        return view('edit-complaint', compact('complaint'));
    }

    public function updatecomplaint(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        
        // DIPERBAIKI: Cek akses
        if (Auth::user()->role === 'user' && Auth::user()->id !== $complaint->user_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit pengaduan ini.');
        }

        // TAMBAHKAN: Cek status
        if (!in_array($complaint->status, ['pending', 'rejected'])) {
            return redirect()->route('complaint.detail', $complaint->id)
                           ->with('error', 'Pengaduan dengan status "' . $complaint->status . '" tidak dapat diedit.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category' => 'required',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longtitude' => 'nullable|numeric|between:-180,180',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240',
        ]);

        $data = $request->only(['title', 'description', 'location', 'category', 'latitude', 'longtitude']);
        // dd($data['category']);

        // Handle file upload
        if ($request->hasFile('media')) {
            // Delete old media if exists
            if ($complaint->image && Storage::exists('public/' . $complaint->image)) {
                Storage::delete('public/' . $complaint->image);
            }
            
            $mediaPath = $request->file('media')->store('complaint_media', 'public');
            $data['image'] = $mediaPath; // DIPERBAIKI: sesuaikan dengan field database
        }
        
        $complaint->update($data);

        return redirect()->route('complaint.detail', $complaint->id)
                        ->with('success', 'Pengaduan berhasil diperbarui!');
    }
}