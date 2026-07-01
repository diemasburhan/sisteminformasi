<?php

namespace App\Mail;

use App\Models\EmployeeLatePermit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LatePermitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $permit;
    public $action;

    public $isForApplicant;

    /**
     * Create a new message instance.
     *
     * @param EmployeeLatePermit $permit
     * @param string $action
     * @param bool $isForApplicant
     */
    public function __construct(EmployeeLatePermit $permit, $action, $isForApplicant = false)
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
        $subject = 'Pengajuan Izin Telat';
        $employeeName = $this->permit->user ? $this->permit->user->name : 'Karyawan';

        if ($this->action === 'created') {
            $subject = 'Pengajuan Izin Telat Baru - ' . $employeeName;
        } elseif ($this->action === 'approved_coordinator') {
            $subject = 'Pengajuan Izin Telat Disetujui Koordinator - ' . $employeeName;
        } elseif ($this->action === 'rejected_coordinator') {
            $subject = 'Pengajuan Izin Telat Ditolak Koordinator - ' . $employeeName;
        } elseif ($this->action === 'approved_bas') {
            $subject = 'Pengajuan Izin Telat Disetujui Final (BAS) - ' . $employeeName;
        } elseif ($this->action === 'rejected_bas') {
            $subject = 'Pengajuan Izin Telat Ditolak (BAS) - ' . $employeeName;
        }

        return $this->subject($subject)
                    ->view('emails.late_permit');
    }
}
