<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class LecturerController extends Controller
{
    public function index(Request $request)
    {
        $query = Lecturer::with('expertises');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('expertise')) {
            $expertise = $request->expertise;
            $query->whereHas('expertises', function($q) use ($expertise) {
                if ($expertise === 'dev') {
                    $q->where('category', 'dev');
                } elseif ($expertise === 'data') {
                    $q->where('category', 'data');
                } elseif ($expertise === 'gov') {
                    $q->where('category', 'gov');
                } else {
                    $q->where('expertises.id', $expertise);
                }
            });
        }

        $lecturers = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        
        // Retrieve all expertises for filter dropdown
        $allExpertises = \App\Models\Expertise::orderBy('name', 'asc')->get();

        return view('admin.lecturers.index', compact('lecturers', 'allExpertises'));
    }

    public function create()
    {
        $expertises = \App\Models\Expertise::orderBy('name', 'asc')->get();
        return view('admin.lecturers.create-edit', compact('expertises'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'expertises' => 'required|array|min:1',
            'expertises.*' => 'exists:expertises,id',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lecturers'), $filename);
            $photoPath = 'uploads/lecturers/' . $filename;
        }

        $selectedExpertises = \App\Models\Expertise::whereIn('id', $request->expertises)->get();
        $expertiseString = $selectedExpertises->pluck('name')->implode(', ');

        $lecturer = Lecturer::create([
            'name' => $request->name,
            'expertise' => $expertiseString,
            'photo' => $photoPath,
        ]);

        $lecturer->expertises()->sync($request->expertises);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Create Lecturer',
            'details' => 'Added lecturer: "' . $lecturer->name . '" (Expertise: ' . $lecturer->expertise . ')'
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Dosen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $lecturer = Lecturer::with('expertises')->findOrFail($id);
        $expertises = \App\Models\Expertise::orderBy('name', 'asc')->get();
        $selectedExpertiseIds = $lecturer->expertises->pluck('id')->toArray();
        return view('admin.lecturers.create-edit', compact('lecturer', 'expertises', 'selectedExpertiseIds'));
    }

    public function update(Request $request, $id)
    {
        $lecturer = Lecturer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'expertises' => 'required|array|min:1',
            'expertises.*' => 'exists:expertises,id',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $lecturer->photo;
        if ($request->hasFile('photo_file')) {
            if ($lecturer->photo && file_exists(public_path($lecturer->photo))) {
                @unlink(public_path($lecturer->photo));
            }
            $file = $request->file('photo_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lecturers'), $filename);
            $photoPath = 'uploads/lecturers/' . $filename;
        }

        $selectedExpertises = \App\Models\Expertise::whereIn('id', $request->expertises)->get();
        $expertiseString = $selectedExpertises->pluck('name')->implode(', ');

        $lecturer->update([
            'name' => $request->name,
            'expertise' => $expertiseString,
            'photo' => $photoPath,
        ]);

        $lecturer->expertises()->sync($request->expertises);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Lecturer',
            'details' => 'Updated lecturer info: "' . $lecturer->name . '"'
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        
        if ($lecturer->photo && file_exists(public_path($lecturer->photo))) {
            @unlink(public_path($lecturer->photo));
        }

        $name = $lecturer->name;
        $lecturer->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Delete Lecturer',
            'details' => 'Deleted lecturer: "' . $name . '"'
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Dosen berhasil dihapus.');
    }
}
