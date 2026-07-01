@extends('layouts.admin')

@section('title', 'Admin Dashboard - Sistem Informasi LPKIA')
@section('page_title', 'Dashboard Ringkasan')

@section('content')

    <!-- Metrics Cards Grid -->
    <div class="stats-grid" style="margin-top: 0; margin-bottom: 30px;">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(0, 51, 102, 0.1); color: var(--primary);">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $postsCount }}</h4>
                <p>Postingan Terdaftar</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(255, 153, 0, 0.1); color: var(--secondary);">
                <i class="fa-solid fa-copy"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $pagesCount }}</h4>
                <p>Halaman Statis</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(16, 185, 129, 0.1); color: var(--success);">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $commentsCount }}</h4>
                <p>Komentar Pengunjung</p>
            </div>
        </div>
        <div class="stat-card" style="{{ $pendingCommentsCount > 0 ? 'border-bottom-color: var(--danger);' : '' }}">
            <div class="stat-icon" style="background-color: {{ $pendingCommentsCount > 0 ? 'rgba(239, 68, 68, 0.1)' : 'rgba(102, 102, 102, 0.1)' }}; color: {{ $pendingCommentsCount > 0 ? 'var(--danger)' : 'var(--text-muted)' }};">
                <i class="fa-solid fa-comment-dots"></i>
            </div>
            <div class="stat-info">
                <h4>{{ $pendingCommentsCount }}</h4>
                <p>Komentar Pending</p>
            </div>
        </div>
    </div>

    <!-- Charts & Analytics Preview -->
    <div class="analytics-grid" style="margin-bottom: 40px;">
        <!-- Majors Distribution -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fa-solid fa-chart-simple"></i> Statistika Pendaftaran Mahasiswa per Program Studi</h3>
            </div>
            <div class="bar-chart-container">
                @php
                    $maxStudents = count($stats['majors']) > 0 ? max(array_column($stats['majors'], 'students')) : 1;
                @endphp
                @foreach($stats['majors'] as $major)
                    @php
                        $percent = ($major['students'] / $maxStudents) * 100;
                    @endphp
                    <div class="bar-row">
                        <div class="bar-label" title="{{ $major['name'] }}">{{ $major['name'] }}</div>
                        <div class="bar-wrapper">
                            <div class="bar-fill" style="width: {{ $percent }}%; background-color: {{ $major['color'] ?? 'var(--primary)' }}"></div>
                        </div>
                        <div class="bar-value">{{ $major['students'] }} mhs</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Gender breakdown -->
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fa-solid fa-chart-pie"></i> Statistika Rasio Gender Mahasiswa</h3>
            </div>
            <div class="gender-donut-container">
                <div class="donut-graphic">
                    <div class="donut-center-text">
                        <div class="main">
                            @php
                                $total = 0;
                                foreach($stats['genders'] as $g) { $total += $g['value']; }
                            @endphp
                            {{ $total }}
                        </div>
                        <div class="sub">Mahasiswa</div>
                    </div>
                </div>
                <div class="donut-legends">
                    @foreach($stats['genders'] as $gender)
                        @php
                            $p = $total > 0 ? round(($gender['value'] / $total) * 100) : 0;
                        @endphp
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: {{ $gender['color'] }}"></div>
                            <span>{{ $gender['label'] }} ({{ $p }}%)</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- System Activities & Audit Trail -->
    <div class="table-card" style="margin-top: 0;">
        <div class="table-toolbar">
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--primary);"><i class="fa-solid fa-history"></i> Aktivitas & Log Sistem Terbaru</h3>
            <span class="badge badge-success">Live Updates</span>
        </div>
        
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Waktu Kejadian</th>
                        <th>Pengguna (User)</th>
                        <th>Tindakan (Aktivitas)</th>
                        <th>Rincian Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLogs as $log)
                        <tr>
                            <td style="font-weight: 500; font-size: 0.85rem; color: var(--text-muted);">
                                {{ $log->created_at->format('d M Y H:i:s') }}
                            </td>
                            <td style="font-weight: 600; color: var(--primary);">
                                {{ $log->user ? $log->user->name : 'System/Guest' }}
                            </td>
                            <td>
                                <span class="badge {{ $log->activity === 'Login' ? 'badge-success' : ($log->activity === 'Logout' ? 'badge-secondary' : 'badge-warning') }}">
                                    {{ $log->activity }}
                                </span>
                            </td>
                            <td style="font-size: 0.88rem; color: var(--text-muted);">
                                {{ $log->details }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 25px; color: var(--text-muted);">
                                Belum ada catatan aktivitas sistem terdeteksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
