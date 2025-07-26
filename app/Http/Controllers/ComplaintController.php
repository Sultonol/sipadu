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
    function add()
    {
        return view('complaint-add');
    }

    function create(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'location' => ['required'],
            'category' => ['required'],
            'media' => ['nullable', 'mimes:jpg,jpeg,png,gif,mp4,webm|max:5120']
        ]);

        $mediaPath = $request->file('media')->store('complaint_media', 'public');

        Complaint::create([
            'user_id' => auth()->id(), // data dari login, bukan form
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
            'media' => $mediaPath, // hasil olahan file upload
            'category' => $request->category,
            'ticket' => strtoupper(Str::random(10)), // auto generate
        ]);

        session::flash('message', 'Pengaduan laporan berhasil dibuat!');
        return redirect()->route('dashboard');
    }

    function editcomplaint($id)
    {
        $complaint = Complaint::findOrFail($id);
        if (Auth::user()->id !== $complaint->user_id) {
            abort(404, 'Unauthorized action');
        }
        return view('edit-complaint', compact('complaint'));
    }

    function updatecomplaint(Request $request, $id)
    {
        // return $request->all();
        // gunakan findOrFail untuk melakukan pengecekan jika bukan uuthornya maka tidak bisa akses fitur itu dan pengduan itu
        $complaint = Complaint::findOrFail($id);
        //inget jika update tidak boleh ada logika pengecekan id
        if (Auth::user()->id !== $complaint->user_id) {
            abort(403, 'Unauthorized action');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category' => 'required|in:Infrastructure,Disaster,Public Service,Environment,Transportation,Health,Education,Security,Other',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longtitude' => 'nullable|numeric|between:-180,180',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240', // file dibatesin sampe 10mb tidak boleh lebih
            // dan kalau mau ngatur size mb nya dibagian max itu
        ]);

        $data = $request->only(['title', 'description', 'location', 'category', 'latitude', 'longtitude']);

        // Handle file upload
        if ($request->hasFile('media')) {
            // Delete old media if exists
            //ini logika untk menghapus media yang lama dan ditimpa dengan media yang baru diupload user
            if ($complaint->media && Storage::exists('public/' . $complaint->media)) {
                Storage::delete('public/' . $complaint->media);
            }

            $mediaPath = $request->file('media')->store('complaint_media', 'public');
            $data['media'] = $mediaPath;
        }

        $complaint->update($data);

        return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil diperbarui!');
    }
}
