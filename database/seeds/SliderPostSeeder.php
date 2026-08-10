<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\User;
use Illuminate\Support\Str;

class SliderPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get related models for foreign keys
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $catAcademic = Category::where('slug', 'akademik')->first() ?? Category::first();
        $catEvent = Category::where('slug', 'event-workshop')->first() ?? Category::first();
        $catAnnouncement = Category::where('slug', 'pengumuman')->first() ?? Category::first();

        $sliderPosts = [
            [
                'category_id' => $catAcademic->id ?? 1,
                'user_id' => $admin->id ?? 1,
                'title' => 'Inovasi Riset Mahasiswa di Laboratorium Komputer Terpadu',
                'slug' => Str::slug('Inovasi Riset Mahasiswa di Laboratorium Komputer Terpadu' . rand(100, 999)),
                'content' => '<p>Mahasiswa program studi Sistem Informasi kini diberikan akses penuh ke laboratorium komputer berfasilitas tinggi untuk menunjang riset big data dan kecerdasan buatan. Hal ini merupakan bagian dari komitmen LPKIA dalam mencetak generasi ahli IT masa depan.</p>',
                'featured_image' => 'uploads/posts/slider_lab.png',
                'status' => 'published',
                'published_at' => now(),
                'is_slider' => true,
            ],
            [
                'category_id' => $catEvent->id ?? 1,
                'user_id' => $admin->id ?? 1,
                'title' => 'Kolaborasi Industri: Kesiapan Mahasiswa dalam Dunia Startup',
                'slug' => Str::slug('Kolaborasi Industri Kesiapan Mahasiswa dalam Dunia Startup' . rand(100, 999)),
                'content' => '<p>Melalui kerja sama dengan berbagai startup teknologi terkemuka, LPKIA menyelenggarakan workshop intensif seputar manajemen proyek IT dan tata kelola bisnis digital di era industri 4.0. Acara ini dihadiri oleh para ahli dari perusahaan terkemuka.</p>',
                'featured_image' => 'uploads/posts/slider_office.png',
                'status' => 'published',
                'published_at' => now()->subDay(),
                'is_slider' => true,
            ],
            [
                'category_id' => $catAnnouncement->id ?? 1,
                'user_id' => $admin->id ?? 1,
                'title' => 'Selamat dan Sukses: Wisuda Angkatan 2026 LPKIA',
                'slug' => Str::slug('Selamat dan Sukses Wisuda Angkatan 2026 LPKIA' . rand(100, 999)),
                'content' => '<p>Segenap civitas akademika mengucapkan selamat atas kelulusan mahasiswa angkatan 2026. Lulusan tahun ini telah mencatatkan rekor tingkat penyerapan tenaga kerja tercepat dengan rata-rata masa tunggu kurang dari 3 bulan setelah kelulusan.</p>',
                'featured_image' => 'uploads/posts/slider_grad.png',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'is_slider' => true,
            ]
        ];

        foreach ($sliderPosts as $post) {
            Post::create($post);
        }
    }
}
