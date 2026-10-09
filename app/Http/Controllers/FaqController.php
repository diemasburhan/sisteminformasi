<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FaqQuestion;

class FaqController extends Controller
{
    /**
     * Simpan pertanyaan yang diajukan oleh pengunjung lewat widget FAQ MinSI
     */
    public function submit(Request $request)
    {
        $visitorType = $request->input('visitor_type');

        if ($visitorType === 'MAHASISWA_AKTIF') {
            $validated = $request->validate([
                                'visitor_type' => 'required|in:MAHASISWA_AKTIF,CALON_MAHASISWA',
                'nim' => 'required|string|max:50',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'level' => 'required|in:1,2,3,4',
                'question' => 'required|string|min:5|max:2000',
            ], [
                'nim.required' => 'NIM wajib diisi.',
                'name.required' => 'Nama lengkap wajib diisi.',
                'level.required' => 'Tingkat semester wajib dipilih.',
                'level.in' => 'Tingkat hanya boleh bernilai 1, 2, 3, atau 4.',
                'question.required' => 'Pertanyaan tidak boleh kosong.',
                'question.min' => 'Pertanyaan minimal 5 karakter.',
            ]);

            $faq = FaqQuestion::create([
                'visitor_type' => 'MAHASISWA_AKTIF',
                'nim' => strip_tags($validated['nim']),
                'name' => strip_tags($validated['name']),
                'phone' => strip_tags($validated['phone']),
                'level' => (int) $validated['level'],
                'question' => strip_tags($validated['question']),
                'status' => 'Baru',
            ]);
        } elseif ($visitorType === 'CALON_MAHASISWA') {
            $validated = $request->validate([
                'visitor_type' => 'required|in:MAHASISWA_AKTIF,CALON_MAHASISWA',
                'name' => 'required|string|max:255',
                'whatsapp' => 'required|string|max:50',
                'school_origin' => 'required|string|max:255',
                'desired_prodi' => 'required|in:SISTEM_INFORMASI,AKUNTANSI,INFORMATIKA,ADMINISTRASI_BISNIS',
                'question' => 'required|string|min:5|max:2000',
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
                'question.required' => 'Pertanyaan tidak boleh kosong.',
                'question.min' => 'Pertanyaan minimal 5 karakter.', 
            ]);

$faq = FaqQuestion::create([
                'visitor_type' => 'CALON_MAHASISWA',
                'name' => strip_tags($validated['name']),
                'whatsapp' => strip_tags($validated['whatsapp']),
                'school_origin' => strip_tags($validated['school_origin']),
                'desired_prodi' => $validated['desired_prodi'],
                'question' => strip_tags($validated['question']),
                'status' => 'Baru',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Status identitas pengunjung tidak valid.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pertanyaan berhasil dikirim. Terima kasih, pertanyaan kamu sudah diterima oleh Prodi Sistem Informasi.',
            'data' => [
                'id' => $faq->id,
            ]
        ]);
    }
}
