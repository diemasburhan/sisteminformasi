<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqQuestion;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FaqQuestionController extends Controller
{
    /**
     * Export semua data FAQ ke file Excel (.xlsx)
     */
    public function export(Request $request)
{
    // Ambil SEMUA data FAQ dari database
    $questions = FaqQuestion::orderBy('created_at', 'desc')->get();

    // Buat workbook Excel
    $spreadsheet = new Spreadsheet();

    // Ambil sheet pertama
    $sheet = $spreadsheet->getActiveSheet();

    // Nama sheet
    $sheet->setTitle('FAQ Questions');

    // Header
    $headers = [
        'No',
        'Tipe Pengunjung',
        'Nama',
        'NIM',
        'Nomor Telepon',
        'WhatsApp',
        'Tingkat',
        'Asal Sekolah',
        'Prodi yang Diminati',
        'Pertanyaan',
        'Status',
        'Catatan Admin',
        'Tanggal Dibuat',
        'Tanggal Diperbarui',
    ];

    // Masukkan header
    foreach ($headers as $index => $header) {
        $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);

        $sheet->setCellValue(
            $column . '1',
            $header
        );
    }

    // Style header
    $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
        count($headers)
    );

    $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
        'font' => [
            'bold' => true,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'D9EAF7',
            ],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
    ]);

    // Data
    $row = 2;
    $no = 1;

    foreach ($questions as $faq) {

        // Tipe pengunjung
        $visitorType = $faq->visitor_type === 'MAHASISWA_AKTIF'
            ? 'Mahasiswa Aktif'
            : 'Ingin Mendaftar';

        // Tingkat
        $level = (
            $faq->visitor_type === 'MAHASISWA_AKTIF'
            && $faq->level
        )
            ? 'Tingkat ' . $faq->level
            : '-';

        // Data satu baris
        $data = [
            $no++,
            $visitorType,
            $faq->name ?? '-',
            $faq->nim ?? '-',
            $faq->phone ?? '-',
            $faq->whatsapp ?? '-',
            $level,
            $faq->school_origin ?? '-',
            $faq->desired_prodi ?? '-',
            $faq->question ?? '-',
            $faq->status ?? '-',
            $faq->admin_notes ?? '-',

            $faq->created_at
                ? $faq->created_at->format('d/m/Y H:i')
                : '-',

            $faq->updated_at
                ? $faq->updated_at->format('d/m/Y H:i')
                : '-',
        ];

        // Masukkan data ke Excel
        foreach ($data as $index => $value) {

            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                $index + 1
            );

            $sheet->setCellValue(
                $column . $row,
                $value
            );
        }

        $row++;
    }

    // Auto-size semua kolom
    for ($i = 1; $i <= count($headers); $i++) {

        $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);

        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Freeze header
    $sheet->freezePane('A2');

    // Nama file
    $filename = 'faq-questions-' . date('Y-m-d-H-i-s') . '.xlsx';

    // Buat writer Excel
    $writer = new Xlsx($spreadsheet);

    // Download
    return response()->streamDownload(
        function () use ($writer) {
            $writer->save('php://output');
        },
        $filename,
        [
            'Content-Type' =>
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

            'Cache-Control' => 'max-age=0',
        ]
    );
}

    /**
     * Tampilkan daftar pertanyaan FAQ yang masuk.
     */
    public function index(Request $request)
    {
        $query = FaqQuestion::query();

        // Search berdasarkan Nama, NIM, WhatsApp, atau Pertanyaan
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nim', 'like', '%' . $search . '%')
                    ->orWhere('whatsapp', 'like', '%' . $search . '%')
                    ->orWhere('question', 'like', '%' . $search . '%');
            });
        }

        // Filter tipe pengunjung
        if ($request->filled('visitor_type')) {
            $query->where(
                'visitor_type',
                $request->visitor_type
            );
        }

        // Filter status pertanyaan
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        // Filter tingkat
        if ($request->filled('level')) {
            $query->where(
                'level',
                $request->level
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION DASHBOARD
        |--------------------------------------------------------------------------
        */

        $questions = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $stats = [

            'total' => FaqQuestion::count(),

            'baru' => FaqQuestion::where(
                'status',
                'Baru'
            )->count(),

            'diproses' => FaqQuestion::where(
                'status',
                'Diproses'
            )->count(),

            'selesai' => FaqQuestion::where(
                'status',
                'Selesai'
            )->count(),

            'mahasiswa' => FaqQuestion::where(
                'visitor_type',
                'MAHASISWA_AKTIF'
            )->count(),

            'calon' => FaqQuestion::where(
                'visitor_type',
                'CALON_MAHASISWA'
            )->count(),
        ];

        return view(
            'admin.faq-questions.index',
            compact(
                'questions',
                'stats'
            )
        );
    }

    /**
     * Tampilkan detail pertanyaan.
     */
    public function show($id)
    {
        $faq = FaqQuestion::findOrFail($id);

        if (request()->wantsJson()) {

            return response()->json([
                'success' => true,
                'data' => $faq,
                'created_at_formatted' =>
                    $faq->created_at
                        ? $faq->created_at->format('d/m/Y H:i')
                        : null,
            ]);
        }

        return redirect()->route(
            'admin.faq-questions.index'
        );
    }

    /**
     * Update status dan catatan admin.
     */
    public function update(Request $request, $id)
    {
        $faq = FaqQuestion::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $oldStatus = $faq->status;

        $faq->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Update Status FAQ',
            'details' =>
                "Status pertanyaan FAQ #{$faq->id} ({$faq->name}) diubah dari {$oldStatus} ke {$request->status}",
        ]);

        return redirect()
            ->route('admin.faq-questions.index')
            ->with(
                'success',
                'Status pertanyaan berhasil diperbarui.'
            );
    }

    /**
     * Hapus pertanyaan FAQ.
     */
    public function destroy($id)
    {
        $faq = FaqQuestion::findOrFail($id);

        $name = $faq->name;
        $faqId = $faq->id;

        $faq->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Hapus FAQ Question',
            'details' =>
                "Menghapus pertanyaan FAQ #{$faqId} dari {$name}",
        ]);

        return redirect()
            ->route('admin.faq-questions.index')
            ->with(
                'success',
                'Pertanyaan FAQ berhasil dihapus.'
            );
    }
}