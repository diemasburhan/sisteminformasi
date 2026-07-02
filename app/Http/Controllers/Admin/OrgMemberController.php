<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrgMember;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class OrgMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = OrgMember::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('role', 'like', '%' . $request->search . '%');
        }

        $members = $query->orderBy('sort_order', 'asc')->paginate(10)->withQueryString();

        return view('admin.org-members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.org-members.create-edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/org'), $filename);
            $photoPath = 'uploads/org/' . $filename;
        }

        $member = OrgMember::create([
            'name' => $request->name,
            'role' => $request->role,
            'nip' => $request->nip,
            'sort_order' => $request->sort_order,
            'photo' => $photoPath,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Create Org Member',
            'details' => 'Added organization member: "' . $member->name . '" (Role: ' . $member->role . ')'
        ]);

        return redirect()->route('admin.org-members.index')->with('success', 'Anggota struktur organisasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $member = OrgMember::findOrFail($id);
        return view('admin.org-members.create-edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = OrgMember::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255',
            'sort_order' => 'required|integer',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $member->photo;
        if ($request->hasFile('photo_file')) {
            if ($member->photo && file_exists(public_path($member->photo))) {
                @unlink(public_path($member->photo));
            }
            $file = $request->file('photo_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/org'), $filename);
            $photoPath = 'uploads/org/' . $filename;
        }

        $member->update([
            'name' => $request->name,
            'role' => $request->role,
            'nip' => $request->nip,
            'sort_order' => $request->sort_order,
            'photo' => $photoPath,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Org Member',
            'details' => 'Updated organization member info: "' . $member->name . '"'
        ]);

        return redirect()->route('admin.org-members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = OrgMember::findOrFail($id);
        
        if ($member->photo && file_exists(public_path($member->photo))) {
            @unlink(public_path($member->photo));
        }

        $name = $member->name;
        $member->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Delete Org Member',
            'details' => 'Deleted organization member: "' . $name . '"'
        ]);

        return redirect()->route('admin.org-members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
