<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Lecturer;
use App\Models\OrgMember;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->where(function($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $pages = Page::where('status', 'published')->get();

        // Load stats from Settings
        $stats = [
            'total_students' => Setting::get('stats_total_students', '2450'),
            'active_students' => Setting::get('stats_active_students', '2180'),
            'graduates' => Setting::get('stats_graduates', '12800'),
            'employment_rate' => Setting::get('stats_employment_rate', '94%'),
            'majors' => json_decode(Setting::get('stats_majors_data', '[]'), true),
            'genders' => json_decode(Setting::get('stats_gender_data', '[]'), true),
            'enrollment' => json_decode(Setting::get('stats_yearly_enrollment', '[]'), true),
        ];

        $lecturers = Lecturer::orderBy('name', 'asc')->get();
        $orgMembers = OrgMember::orderBy('sort_order', 'asc')->get();

        return view('public.home', compact('posts', 'pages', 'stats', 'lecturers', 'orgMembers'));
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'author', 'comments' => function($q) {
                $q->where('status', 'approved')->orderBy('created_at', 'desc');
            }])
            ->firstOrFail();

        $categories = Category::withCount(['posts' => function($q) {
            $q->where('status', 'published');
        }])->get();

        $recentPosts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('public.post-detail', compact('post', 'categories', 'recentPosts'));
    }

    public function posts()
    {
        $posts = Post::where('status', 'published')
            ->where(function($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('public.posts', compact('posts'));
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.page-detail', compact('page'));
    }

    public function comment(Request $request, $postId)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|min:5',
        ]);

        Comment::create([
            'post_id' => $postId,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'content' => $request->content,
            'status' => 'pending', // Awaiting approval
        ]);

        return back()->with('success', 'Komentar Anda telah dikirim dan menunggu persetujuan admin.');
    }
}
