<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'Portal LPKIA'),
            'site_tagline' => Setting::get('site_tagline', 'Sistem Informasi Digital LPKIA'),
            'site_address' => Setting::get('site_address', ''),
            'site_phone' => Setting::get('site_phone', ''),
            'site_email' => Setting::get('site_email', ''),
            
            // Statistics values
            'stats_total_students' => Setting::get('stats_total_students', '0'),
            'stats_active_students' => Setting::get('stats_active_students', '0'),
            'stats_graduates' => Setting::get('stats_graduates', '0'),
            'stats_employment_rate' => Setting::get('stats_employment_rate', '0%'),

            // JSON formats for custom charts
            'stats_majors_data' => Setting::get('stats_majors_data', '[]'),
            'stats_gender_data' => Setting::get('stats_gender_data', '[]'),
            'stats_yearly_enrollment' => Setting::get('stats_yearly_enrollment', '[]'),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_address' => 'nullable|string',
            'site_phone' => 'nullable|string|max:50',
            'site_email' => 'nullable|email|max:255',
            
            // Stats
            'stats_total_students' => 'required|integer',
            'stats_active_students' => 'required|integer',
            'stats_graduates' => 'required|integer',
            'stats_employment_rate' => 'required|string|max:10',
            
            // JSON Charts
            'stats_majors_data' => 'required|json',
            'stats_gender_data' => 'required|json',
            'stats_yearly_enrollment' => 'required|json',
        ]);

        foreach ($inputs as $key => $value) {
            Setting::set($key, $value);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Settings',
            'details' => 'Updated site configuration and statistics dashboard'
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
