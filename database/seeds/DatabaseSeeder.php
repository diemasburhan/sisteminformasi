<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Page;
use App\Models\Comment;
use App\Models\ActivityLog;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Users
        $admin = User::create([
            'name' => 'Administrator LPKIA',
            'email' => 'admin@lpkia.ac.id',
            'password' => 'admin123', // Model setPasswordAttribute hashes this automatically!
            'role' => 'admin',
        ]);

        $staff = User::create([
            'name' => 'Staff Akademik',
            'email' => 'staff@lpkia.ac.id',
            'password' => 'staff123',
            'role' => 'staff',
        ]);

        // 2. Seed Categories
        $categories = [
            ['name' => 'Akademik', 'slug' => 'akademik'],
            ['name' => 'Kemahasiswaan', 'slug' => 'kemahasiswaan'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman'],
            ['name' => 'Karir & Alumni', 'slug' => 'karir-alumni'],
            ['name' => 'Event & Workshop', 'slug' => 'event-workshop'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Get Category Instances
        $catAcademic = Category::where('slug', 'akademik')->first();
        $catAnnouncement = Category::where('slug', 'pengumuman')->first();
        $catEvent = Category::where('slug', 'event-workshop')->first();

        // 3. Seed Settings (including Student Stats)
        $settings = [
            'site_name' => 'Portal LPKIA',
            'site_tagline' => 'Sistem Informasi Digital & Kemahasiswaan LPKIA',
            'site_address' => 'Jl. Soekarno-Hatta No. 456, Bandung, Jawa Barat',
            'site_phone' => '(022) 7564200',
            'site_email' => 'info@lpkia.ac.id',
            
            // Statistics Summary
            'stats_total_students' => '2450',
            'stats_active_students' => '2180',
            'stats_graduates' => '12800',
            'stats_employment_rate' => '94%',
            
            // Charts data
            'stats_majors_data' => json_encode([
                ['name' => 'Informatika', 'students' => 650, 'color' => '#0088ff'],
                ['name' => 'Sistem Informasi', 'students' => 520, 'color' => '#7c3aed'],
                ['name' => 'Teknik Komputer', 'students' => 310, 'color' => '#4F46E5'],
                ['name' => 'Komputerisasi Akuntansi', 'students' => 420, 'color' => '#10B981'],
                ['name' => 'Administrasi Bisnis', 'students' => 550, 'color' => '#EC4899']
            ]),
            'stats_gender_data' => json_encode([
                ['label' => 'Laki-laki', 'value' => 1420, 'color' => '#0088ff'],
                ['label' => 'Perempuan', 'value' => 1030, 'color' => '#7c3aed']
            ]),
            'stats_yearly_enrollment' => json_encode([
                ['year' => '2022', 'students' => 510],
                ['year' => '2023', 'students' => 580],
                ['year' => '2024', 'students' => 620],
                ['year' => '2025', 'students' => 680],
                ['year' => '2026', 'students' => 740]
            ])
        ];

        foreach ($settings as $key => $val) {
            Setting::set($key, $val);
        }

        // 4. Seed Posts
        $posts = [
            [
                'category_id' => $catAnnouncement->id,
                'user_id' => $admin->id,
                'title' => 'Penerimaan Mahasiswa Baru Semester Ganjil 2026/2027',
                'slug' => 'penerimaan-mahasiswa-baru-ganjil-2026-2027',
                'content' => '<p>Pendaftaran Mahasiswa Baru (PMB) untuk program studi D3 dan S1 di LPKIA kini telah dibuka! Dapatkan program beasiswa unggulan berupa potongan biaya kuliah hingga 100% bagi siswa berprestasi akademik dan non-akademik.</p><p>Proses pendaftaran dapat diakses secara online melalui portal PMB resmi kami. Segera daftarkan diri Anda dan jadilah bagian dari institusi digital terkemuka!</p>',
                'featured_image' => 'pmb_banner.jpg',
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'category_id' => $catAcademic->id,
                'user_id' => $admin->id,
                'title' => 'Kalender Akademik Tahun Ajaran 2026/2027 Resmi Dirilis',
                'slug' => 'kalender-akademik-tahun-ajaran-2026-2027',
                'content' => '<p>Yth. Seluruh Civitas Akademika LPKIA, Kalender Akademik untuk Tahun Ajaran 2026/2027 telah resmi diterbitkan. Kalender ini berisi jadwal registrasi ulang, pelaksanaan UTS/UAS, libur semester, dan jadwal wisuda.</p><p>Harap mengunduh salinan kalender akademik di tautan yang tersedia guna mempersiapkan perkuliahan Anda dengan baik.</p>',
                'featured_image' => 'academic_calendar.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(2),
            ],
            [
                'category_id' => $catEvent->id,
                'user_id' => $staff->id,
                'title' => 'Workshop UI/UX Design & Inovasi Digital Mahasiswa LPKIA',
                'slug' => 'workshop-ui-ux-design-inovasi-digital-mahasiswa',
                'content' => '<p>Ikuti workshop interaktif mengenai UI/UX Design bersama para praktisi industri startup teknologi. Acara ini akan diselenggarakan secara offline di Aula Utama LPKIA Bandung.</p><p>Peserta akan mendapatkan sertifikat resmi, snack, serta kesempatan networking dengan pemateri profesional.</p>',
                'featured_image' => 'uiux_workshop.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'category_id' => $catAcademic->id,
                'user_id' => $admin->id,
                'title' => 'Panduan Penggunaan Portal KRS Online Mahasiswa',
                'slug' => 'panduan-penggunaan-portal-krs-online-mahasiswa',
                'content' => '<p>Draf panduan ini menjelaskan langkah-langkah pengisian Kartu Rencana Studi (KRS) secara mandiri melalui portal akademik baru.</p>',
                'featured_image' => null,
                'status' => 'draft',
                'published_at' => null,
            ],
            [
                'category_id' => $catEvent->id,
                'user_id' => $staff->id,
                'title' => 'Seminar Karir: Sukses Bekerja di Industri FinTech',
                'slug' => 'seminar-karir-sukses-bekerja-di-fintech',
                'content' => '<p>Seminar ini dijadwalkan untuk mahasiswa tingkat akhir demi membekali kesiapan kerja di sektor industri finansial teknologi terkemuka.</p>',
                'featured_image' => null,
                'status' => 'scheduled',
                'published_at' => now()->addDays(3),
            ]
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }

        // 5. Seed Pages
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '<h2>Sejarah & Visi LPKIA</h2><p>LPKIA berdiri sebagai lembaga pendidikan tinggi yang berdedikasi menghasilkan lulusan profesional di bidang teknologi informasi dan administrasi bisnis. Kami berkomitmen untuk selalu menghadirkan kurikulum yang selaras dengan perkembangan industri global.</p><h3>Visi Kami</h3><p>Menjadi perguruan tinggi unggulan berbasis teknologi digital yang berintegritas dan siap kerja pada tahun 2030.</p>',
                'featured_image' => 'about_lpkia.jpg',
                'status' => 'published'
            ],
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content' => '<h2>Hubungi Kami</h2><p>Punya pertanyaan seputar pendaftaran kuliah, program studi, atau kerjasama? Silakan hubungi kami melalui saluran berikut:</p><ul><li><strong>Alamat:</strong> Jl. Soekarno-Hatta No. 456, Bandung</li><li><strong>Email:</strong> info@lpkia.ac.id</li><li><strong>Telepon:</strong> (022) 7564200</li><li><strong>WhatsApp:</strong> +62 812-3456-7890</li></ul>',
                'featured_image' => null,
                'status' => 'published'
            ],
            [
                'title' => 'Profil Jurusan',
                'slug' => 'profil-jurusan',
                'content' => '<h2>Program Studi Unggulan LPKIA</h2><p>Kami menyelenggarakan program studi D3 & S1 yang terakreditasi oleh BAN-PT dengan fokus praktikum tinggi:</p><ul><li><strong>S1 Informatika:</strong> Software Engineering, AI, Cloud Computing.</li><li><strong>S1 Sistem Informasi:</strong> IT Governance, Business Intelligence, E-Commerce.</li><li><strong>D3 Komputerisasi Akuntansi:</strong> FinTech, Accounting Information Systems.</li><li><strong>D3 Administrasi Bisnis:</strong> Digital Marketing, Corporate Administration.</li></ul>',
                'featured_image' => 'departments.jpg',
                'status' => 'published'
            ]
        ];

        foreach ($pages as $pageData) {
            Page::create($pageData);
        }

        // 6. Seed Comments
        $post1 = Post::first();
        Comment::create([
            'post_id' => $post1->id,
            'author_name' => 'Budi Santoso',
            'author_email' => 'budi.santoso@gmail.com',
            'content' => 'Apakah pendaftaran beasiswa ini berlaku untuk lulusan SMK angkatan 2024 juga? Terima kasih.',
            'status' => 'approved',
        ]);
        Comment::create([
            'post_id' => $post1->id,
            'author_name' => 'Siti Aminah',
            'author_email' => 'siti.aminah@yahoo.com',
            'content' => 'Saya sudah melakukan pendaftaran online, langkah berikutnya bagaimana ya?',
            'status' => 'pending',
        ]);

        // 7. Seed Activity Logs
        ActivityLog::create([
            'user_id' => $admin->id,
            'activity' => 'Login',
            'details' => 'Admin logged in from IP 127.0.0.1'
        ]);
        ActivityLog::create([
            'user_id' => $admin->id,
            'activity' => 'Create Post',
            'details' => 'Created new announcement post: Penerimaan Mahasiswa Baru'
        ]);
        ActivityLog::create([
            'user_id' => $staff->id,
            'activity' => 'Login',
            'details' => 'Staff logged in from IP 127.0.0.1'
        ]);
    }
}