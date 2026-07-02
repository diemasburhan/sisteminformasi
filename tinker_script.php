<?php

$admin = \App\User::where('role', 'admin')->first() ?? \App\User::first();
$catAcademic = \App\Models\Category::where('slug', 'akademik')->first() ?? \App\Models\Category::first();
$catEvent = \App\Models\Category::where('slug', 'event-workshop')->first() ?? \App\Models\Category::first();
$catAnnouncement = \App\Models\Category::where('slug', 'pengumuman')->first() ?? \App\Models\Category::first();

$sliderPosts = [
    [
        'category_id' => $catAcademic->id ?? 1,
        'user_id' => $admin->id ?? 1,
        'title' => 'Inovasi Riset Mahasiswa di Laboratorium Komputer Terpadu',
        'slug' => \Illuminate\Support\Str::slug('Inovasi Riset Mahasiswa di Laboratorium Komputer Terpadu' . rand(100, 999)),
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
        'slug' => \Illuminate\Support\Str::slug('Kolaborasi Industri Kesiapan Mahasiswa dalam Dunia Startup' . rand(100, 999)),
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
        'slug' => \Illuminate\Support\Str::slug('Selamat dan Sukses Wisuda Angkatan 2026 LPKIA' . rand(100, 999)),
        'content' => '<p>Segenap civitas akademika mengucapkan selamat atas kelulusan mahasiswa angkatan 2026. Lulusan tahun ini telah mencatatkan rekor tingkat penyerapan tenaga kerja tercepat dengan rata-rata masa tunggu kurang dari 3 bulan setelah kelulusan.</p>',
        'featured_image' => 'uploads/posts/slider_grad.png',
        'status' => 'published',
        'published_at' => now()->subDays(2),
        'is_slider' => true,
    ]
];

foreach ($sliderPosts as $post) {
    \App\Models\Post::create($post);
}

echo "Dummy slider posts created successfully!\n";
