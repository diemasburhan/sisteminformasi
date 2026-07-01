@extends('layouts.admin')

@section('title', 'Pengaturan Situs - Admin LPKIA')
@section('page_title', 'Pengaturan Umum & Statistik')

@section('content')

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <!-- Site Identity Widget -->
            <div class="editor-sidebar-widget" style="background-color: var(--bg-white); border-radius: var(--border-radius-lg); border: 1px solid var(--border-color); padding: 30px; box-shadow: var(--shadow-sm);">
                <div class="editor-widget-title" style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px;"><i class="fa-solid fa-circle-nodes"></i> Identitas & Kontak Lembaga</div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="site_name">Nama Situs</label>
                        <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', $settings['site_name']) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="site_tagline">Slogan (Tagline)</label>
                        <input type="text" name="site_tagline" id="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline']) }}">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">
                    <div class="form-group">
                        <label class="form-label" for="site_phone">Telepon Kampus</label>
                        <input type="text" name="site_phone" id="site_phone" class="form-control" value="{{ old('site_phone', $settings['site_phone']) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="site_email">Email Layanan</label>
                        <input type="email" name="site_email" id="site_email" class="form-control" value="{{ old('site_email', $settings['site_email']) }}">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 15px;">
                    <label class="form-label" for="site_address">Alamat Lengkap</label>
                    <textarea name="site_address" id="site_address" rows="3" class="form-control" style="resize: vertical;">{{ old('site_address', $settings['site_address']) }}</textarea>
                </div>
            </div>

            <!-- Student Dashboard numbers widget -->
            <div class="editor-sidebar-widget" style="background-color: var(--bg-white); border-radius: var(--border-radius-lg); border: 1px solid var(--border-color); padding: 30px; box-shadow: var(--shadow-sm);">
                <div class="editor-widget-title" style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px;"><i class="fa-solid fa-users-viewfinder"></i> Indikator & Angka Ringkasan Mahasiswa</div>
                
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="stats_total_students">Total Mahasiswa</label>
                        <input type="number" name="stats_total_students" id="stats_total_students" class="form-control" value="{{ old('stats_total_students', $settings['stats_total_students']) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="stats_active_students">Mahasiswa Aktif</label>
                        <input type="number" name="stats_active_students" id="stats_active_students" class="form-control" value="{{ old('stats_active_students', $settings['stats_active_students']) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="stats_graduates">Alumni Terdaftar</label>
                        <input type="number" name="stats_graduates" id="stats_graduates" class="form-control" value="{{ old('stats_graduates', $settings['stats_graduates']) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="stats_employment_rate">Tingkat Serapan Kerja</label>
                        <input type="text" name="stats_employment_rate" id="stats_employment_rate" class="form-control" value="{{ old('stats_employment_rate', $settings['stats_employment_rate']) }}" required>
                    </div>
                </div>
            </div>

            <!-- JSON Charts configs widget -->
            <div class="editor-sidebar-widget" style="background-color: var(--bg-white); border-radius: var(--border-radius-lg); border: 1px solid var(--border-color); padding: 30px; box-shadow: var(--shadow-sm);">
                <div class="editor-widget-title" style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px;"><i class="fa-solid fa-chart-column"></i> Konfigurasi Data Grafik (Format JSON)</div>
                
                <div class="alert alert-success" style="background-color: #EFF6FF; color: #1E40AF; border-color: rgba(30, 64, 175, 0.15); margin-bottom: 25px;">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Pengaturan bagan grafis mahasiswa menggunakan representasi JSON terstruktur untuk menjaga fleksibilitas dan pemetaan data.</span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="stats_majors_data">Data Program Studi JSON</label>
                    <textarea name="stats_majors_data" id="stats_majors_data" rows="5" class="form-control" style="font-family: monospace; font-size: 0.85rem;" required>{{ old('stats_majors_data', $settings['stats_majors_data']) }}</textarea>
                    @error('stats_majors_data')
                        <span style="font-size: 0.75rem; color: var(--danger);">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                    <div class="form-group">
                        <label class="form-label" for="stats_gender_data">Rasio Gender JSON</label>
                        <textarea name="stats_gender_data" id="stats_gender_data" rows="5" class="form-control" style="font-family: monospace; font-size: 0.85rem;" required>{{ old('stats_gender_data', $settings['stats_gender_data']) }}</textarea>
                        @error('stats_gender_data')
                            <span style="font-size: 0.75rem; color: var(--danger);">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="stats_yearly_enrollment">Grafik Pendaftaran Tahunan JSON</label>
                        <textarea name="stats_yearly_enrollment" id="stats_yearly_enrollment" rows="5" class="form-control" style="font-family: monospace; font-size: 0.85rem;" required>{{ old('stats_yearly_enrollment', $settings['stats_yearly_enrollment']) }}</textarea>
                        @error('stats_yearly_enrollment')
                            <span style="font-size: 0.75rem; color: var(--danger);">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit buttons -->
            <div style="display: flex; justify-content: flex-end; gap: 15px;">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </div>
            
        </div>
    </form>

@endsection
