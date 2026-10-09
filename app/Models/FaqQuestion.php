<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_type',
        'nim',
        'name',
        'level',
        'whatsapp',
        'question',
        'status',
        'admin_notes',
        'phone',
        'school_origin',
        'desired_prodi',
    ];

    public function getVisitorTypeLabelAttribute()
    {
        return $this->visitor_type === 'MAHASISWA_AKTIF' ? 'Mahasiswa Aktif' : 'Ingin Mendaftar';
    }

    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'Baru':
                return 'badge-danger';
            case 'Diproses':
                return 'badge-warning';
            case 'Selesai':
                return 'badge-success';
            default:
                return 'badge-secondary';
        }
    }
}
