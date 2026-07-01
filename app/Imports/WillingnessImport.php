<?php

namespace App\Imports;

use App\Models\Willingness;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WillingnessImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private $rowCount = 0;
    private $successCount = 0;

    public function model(array $row)
    {
        $this->rowCount++;

        // Map keys to handle potential variations in headers
        $mappedRow = $this->mapHeaders($row);

        // Debug log
        Log::info("?? [Import] Row #{$this->rowCount} data mentah:", $mappedRow);

        try {
            $startDate = $this->parseDate($mappedRow['start_date']);
            $endDate   = $this->parseDate($mappedRow['end_date']);

            $willingness = new Willingness([
                'pin'            => (string) $mappedRow['pin'],
                'start_date'     => $startDate,
                'end_date'       => $endDate,
                'day_code'       => $mappedRow['day_code'],
                'time_of_entry'  => $mappedRow['time_of_entry'],
                'time_of_return' => $mappedRow['time_of_return'],
            ]);

            $this->successCount++;
            Log::info("? [Import] Row {$this->rowCount} siap disimpan:", $willingness->toArray());

            return $willingness;
        } catch (\Throwable $e) {
            Log::error("? [Import] Error di row {$this->rowCount}: " . $e->getMessage(), [
                'row' => $mappedRow,
            ]);
            return null;
        }
    }

    public function rules(): array
    {
        return [
            '*.pin' => 'required',
            // We use the raw Excel row keys for validation before mapping, 
            // but since we want to be robust, we'll do manual mapping first or use generic rules.
        ];
    }

    /**
     * Map common header variations to expected keys
     */
    private function mapHeaders(array $row): array
    {
        $result = [];
        $normalized = [];

        // Normalize all keys to lowercase and replace spaces/dots with underscores
        foreach ($row as $key => $value) {
            $cleanKey = strtolower(str_replace([' ', '.', '-'], '_', trim($key)));
            $normalized[$cleanKey] = trim($value);
        }

        // Map aliases
        $result['pin'] = $normalized['pin'] ?? $normalized['nomor_induk'] ?? $normalized['id_karyawan'] ?? null;
        $result['start_date'] = $normalized['start_date'] ?? $normalized['tanggal_mulai'] ?? $normalized['mulai'] ?? null;
        $result['end_date'] = $normalized['end_date'] ?? $normalized['tanggal_selesai'] ?? $normalized['sampai'] ?? null;
        $result['day_code'] = $normalized['day_code'] ?? $normalized['hari'] ?? $normalized['day'] ?? null;
        $result['time_of_entry'] = $normalized['time_of_entry'] ?? $normalized['jam_masuk'] ?? $normalized['masuk'] ?? null;
        $result['time_of_return'] = $normalized['time_of_return'] ?? $normalized['jam_pulang'] ?? $normalized['pulang'] ?? null;

        return $result;
    }

    private function parseDate($value)
    {
        if (empty($value)) return null;

        if (is_numeric($value)) {
            return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
        }

        $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'm/d/Y'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $value)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function isEmpty($row): bool
    {
        return empty(array_filter($row));
    }
}