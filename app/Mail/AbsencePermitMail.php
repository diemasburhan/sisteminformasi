<?php

namespace App\Mail;

use App\Models\EmployeeAbsencePermit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbsencePermitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $permit;
    public $action;

    public $isForApplicant;

    /**
     * Create a new message instance.
     *
     * @param EmployeeAbsencePermit $permit
     * @param string $action
     * @param bool $isForApplicant
     */
    public function __construct(EmployeeAbsencePermit $permit, $action, $isForApplicant = false)
    {
        $this->permit = $permit;
        $this->action = $action;
        $this->isForApplicant = $isForApplicant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Pengajuan Izin Tidak Hadir';
        $employeeName = $this->permit->user ? $this->permit->user->name : 'Karyawan';

        if ($this->action === 'created') {
            $subject = 'Pengajuan Izin Tidak Hadir Baru - ' . $employeeName;
        } elseif ($this->action === 'approved_coordinator') {
            $subject = 'Pengajuan Izin Tidak Hadir Disetujui Koordinator - ' . $employeeName;
        } elseif ($this->action === 'rejected_coordinator') {
            $subject = 'Pengajuan Izin Tidak Hadir Ditolak Koordinator - ' . $employeeName;
        } elseif ($this->action === 'approved_bas') {
            $subject = 'Pengajuan Izin Tidak Hadir Disetujui Final (BAS) - ' . $employeeName;
        } elseif ($this->action === 'rejected_bas') {
            $subject = 'Pengajuan Izin Tidak Hadir Ditolak (BAS) - ' . $employeeName;
        }

        return $this->subject($subject)
                    ->view('emails.absence_permit');
    }
}
