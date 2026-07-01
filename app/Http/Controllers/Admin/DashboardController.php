<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Page;
use App\Models\Comment;
use App\Models\ActivityLog;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        $postsCount = Post::count();
        $pagesCount = Page::count();
        $commentsCount = Comment::count();
        $pendingCommentsCount = Comment::where('status', 'pending')->count();
        
        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $stats = [
            'total_students' => Setting::get('stats_total_students', '2450'),
            'active_students' => Setting::get('stats_active_students', '2180'),
            'graduates' => Setting::get('stats_graduates', '12800'),
            'employment_rate' => Setting::get('stats_employment_rate', '94%'),
            'majors' => json_decode(Setting::get('stats_majors_data', '[]'), true),
            'genders' => json_decode(Setting::get('stats_gender_data', '[]'), true),
            'enrollment' => json_decode(Setting::get('stats_yearly_enrollment', '[]'), true),
        ];

        return view('admin.dashboard', compact(
            'postsCount',
            'pagesCount',
            'commentsCount',
            'pendingCommentsCount',
            'recentLogs',
            'stats'
        ));
    }
}
