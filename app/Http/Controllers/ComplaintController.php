<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
        }
    }
