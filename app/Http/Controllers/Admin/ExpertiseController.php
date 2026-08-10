<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expertise;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ExpertiseController extends Controller
{
    public function index(Request $request)
    {
        $expertises = Expertise::orderBy('name', 'asc')->get();
        $editingExpertise = null;

        if ($request->filled('edit')) {
            $editingExpertise = Expertise::find($request->edit);
        }

        return view('admin.expertises.index', compact('expertises', 'editingExpertise'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:expertises,name',
            'category' => 'required|string|in:dev,data,gov,other',
        ]);

        $expertise = Expertise::create([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Create Expertise',
            'details' => 'Added expertise: "' . $expertise->name . '" (Category: ' . $expertise->category . ')'
        ]);

        return redirect()->route('admin.expertises.index')->with('success', 'Bidang keahlian berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $expertise = Expertise::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:expertises,name,' . $id,
            'category' => 'required|string|in:dev,data,gov,other',
        ]);

        $expertise->update([
            'name' => $request->name,
            'category' => $request->category,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Expertise',
            'details' => 'Updated expertise: "' . $expertise->name . '"'
        ]);

        return redirect()->route('admin.expertises.index')->with('success', 'Bidang keahlian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $expertise = Expertise::findOrFail($id);
        $name = $expertise->name;
        $expertise->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Delete Expertise',
            'details' => 'Deleted expertise: "' . $name . '"'
        ]);

        return redirect()->route('admin.expertises.index')->with('success', 'Bidang keahlian berhasil dihapus.');
    }
}
