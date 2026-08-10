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

            // Appearance and Theme
            'theme_color' => Setting::get('theme_color', 'default'),
            'layout_style' => Setting::get('layout_style', 'full-width'),

            // Homepage Hero Section
            'home_hero_title' => Setting::get('home_hero_title', 'Sistem Informasi LPKIA'),
            'home_hero_text' => Setting::get('home_hero_text', 'Menciptakan Profesional IT Global di Bidang Tata Kelola & Analitik Data. Menghasilkan lulusan yang siap bersaing dalam era ekonomi digital dengan kurikulum berbasis industri.'),
            'home_hero_images' => Setting::get('home_hero_images', json_encode(['images/tech_hero.png'])),
            'home_hero_slider_interval' => Setting::get('home_hero_slider_interval', '5'),

            // Navigation Menu (JSON)
            'navigation_menu' => Setting::get('navigation_menu', json_encode([
                ["label" => "Home", "url" => "/", "children" => []],
                ["label" => "Akademik", "url" => "#", "children" => [
                    ["label" => "Kurikulum", "url" => "/#kurikulum"],
                    ["label" => "Jadwal Kuliah", "url" => "/#jadwal"],
                    ["label" => "Kalender Akademik", "url" => "/#shortcut-menu"]
                ]],
                ["label" => "Profil Prodi", "url" => "/page/tentang-kami", "children" => []],
                ["label" => "Berita", "url" => "/berita", "children" => []],
                ["label" => "Kontak", "url" => "/page/kontak", "children" => []]
            ])),

            // Class Schedule (JSON)
            'class_schedule' => Setting::get('class_schedule', json_encode([
                ["hari" => "Senin", "jam" => "08:00 - 10:30", "matkul" => "Big Data Analytics", "dosen" => "Hesti Lestari, M.C.S.", "ruangan" => "Lab Komputer 3"],
                ["hari" => "Selasa", "jam" => "10:40 - 13:10", "matkul" => "IT Governance & Audit", "dosen" => "Dr. Ahmad Sudrajat, M.T.", "ruangan" => "Ruang 402"],
                ["hari" => "Rabu", "jam" => "13:30 - 16:00", "matkul" => "Rekayasa Perangkat Lunak", "dosen" => "Rina Wijaya, M.Kom.", "ruangan" => "Ruang 305"],
                ["hari" => "Kamis", "jam" => "08:00 - 10:30", "matkul" => "Pemrograman Web Lanjut", "dosen" => "Yusuf Mansur, M.T.", "ruangan" => "Lab Komputer 1"],
                ["hari" => "Jumat", "jam" => "10:00 - 12:30", "matkul" => "Cloud Computing", "dosen" => "Budi Pratama, M.T.I.", "ruangan" => "Lab Komputer 2"]
            ])),
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
            
            // Appearance
            'theme_color' => 'required|string|max:50',
            'layout_style' => 'required|string|max:50',

            // New Customizations
            'home_hero_title' => 'required|string|max:255',
            'home_hero_text' => 'nullable|string',
            'home_hero_slider_interval' => 'required|integer|min:1|max:60',
            'navigation_menu' => 'required|json',
            'class_schedule' => 'required|json',
        ]);

        // Process Hero Slider Images
        $existingImages = json_decode($request->input('existing_hero_images', '[]'), true);
        if (!is_array($existingImages)) {
            $existingImages = ['images/tech_hero.png'];
        }

        if ($request->hasFile('hero_new_images')) {
            foreach ($request->file('hero_new_images') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/hero'), $filename);
                    $existingImages[] = 'uploads/hero/' . $filename;
                }
            }
        }

        if (empty($existingImages)) {
            $existingImages = ['images/tech_hero.png'];
        }

        Setting::set('home_hero_images', json_encode(array_values($existingImages)));

        foreach ($inputs as $key => $value) {
            Setting::set($key, $value);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Settings',
            'details' => 'Updated site configuration, homepage hero, navigation, class schedule, and slider images.'
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
