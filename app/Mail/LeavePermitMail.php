<?php

namespace App\Mail;

use App\Models\EmployeeLeavePermit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeavePermitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $permit;
    public $action;

    public $isForApplicant;

    /**
     * Create a new message instance.
     *
     * @param EmployeeLeavePermit $permit
     * @param string $action
     * @param bool $isForApplicant
     */
    public function __construct(EmployeeLeavePermit $permit, $action, $isForApplicant = false)
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
        $subject = 'Pengajuan Cuti';
        $employeeName = $this->permit->user ? $this->permit->user->name : 'Karyawan';

        if ($this->action === 'created') {
            $subject = 'Pengajuan Cuti Baru - ' . $employeeName;
        } elseif ($this->action === 'approved_coordinator') {
            $subject = 'Pengajuan Cuti Disetujui Koordinator - ' . $employeeName;
        } elseif ($this->action === 'rejected_coordinator') {
            $subject = 'Pengajuan Cuti Ditolak Koordinator - ' . $employeeName;
        } elseif ($this->action === 'approved_bas') {
            $subject = 'Pengajuan Cuti Disetujui Final (BAS) - ' . $employeeName;
        } elseif ($this->action === 'rejected_bas') {
            $subject = 'Pengajuan Cuti Ditolak (BAS) - ' . $employeeName;
        }

        return $this->subject($subject)
                    ->view('emails.leave_permit');
    }
}
