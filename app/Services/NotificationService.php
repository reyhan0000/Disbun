<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Pengajuan;
use App\Models\User;

class NotificationService
{
    public function send($userId, $title, $message, $type = 'sistem', $dataId = null, $dataType = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data_id' => $dataId,
            'data_type' => $dataType,
        ]);
    }

    public function sendToMultiple($userIds, $title, $message, $type = 'sistem', $dataId = null, $dataType = null)
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = $this->send($userId, $title, $message, $type, $dataId, $dataType);
        }

        return $notifications;
    }

    public function notifyPengajuanBaru(Pengajuan $pengajuan)
    {
        $operators = User::where('role', 'operator')->get();
        foreach ($operators as $op) {
            $this->send(
                $op->id,
                'Pengajuan Baru',
                "Pengajuan baru dari {$pengajuan->nama_kelompok_tani} - {$pengajuan->perihal}",
                'pengajuan',
                $pengajuan->id,
                Pengajuan::class
            );
        }
    }

    public function notifyVerifikasi(Pengajuan $pengajuan, $keputusan, $note = '')
    {
        $this->send(
            $pengajuan->user_id,
            'Pengajuan Diverifikasi',
            "Pengajuan {$pengajuan->nomor_surat} telah diverifikasi: {$keputusan}. {$note}",
            'verifikasi',
            $pengajuan->id,
            Pengajuan::class
        );

        $kabids = User::where('role', 'kabid')->get();
        foreach ($kabids as $kabid) {
            $this->send(
                $kabid->id,
                'Pengajuan Perlu Persetujuan',
                "Pengajuan dari {$pengajuan->nama_kelompok_tani} - {$pengajuan->perihal} menunggu persetujuan Anda",
                'persetujuan',
                $pengajuan->id,
                Pengajuan::class
            );
        }
    }

    public function notifyPersetujuan(Pengajuan $pengajuan, $keputusan, $note = '')
    {
        // Notifikasi ke Petani
        $this->send(
            $pengajuan->user_id,
            'Status Pengajuan Bantuan',
            "Pengajuan {$pengajuan->nomor_surat} telah {$keputusan}. {$note}",
            'persetujuan',
            $pengajuan->id,
            Pengajuan::class
        );

        // Jika disetujui Kabid, beri tahu Operator untuk unggah BAST
        if ($pengajuan->status === 'approved_kabid') {
            $operators = User::where('role', 'operator')->get();
            foreach ($operators as $op) {
                $this->send(
                    $op->id,
                    'Perlu Unggah BAST',
                    "Pengajuan dari {$pengajuan->nama_kelompok_tani} telah disetujui Kabid. Silakan unggah dokumen BAST.",
                    'persetujuan',
                    $pengajuan->id,
                    Pengajuan::class
                );
            }
        }
    }

    public function notifyStatusChange(Pengajuan $pengajuan, $oldStatus, $newStatus)
    {
        $this->send(
            $pengajuan->user_id,
            'Update Status Pengajuan',
            "Status pengajuan {$pengajuan->nomor_surat} berubah dari {$oldStatus} menjadi {$newStatus}",
            'sistem',
            $pengajuan->id,
            Pengajuan::class
        );
    }

    public function getUnreadCount($userId)
    {
        return Notification::where('user_id', $userId)->where('is_read', false)->count();
    }

    public function getForUser($userId, $limit = 20)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function markAsRead($notificationId)
    {
        $notif = Notification::find($notificationId);
        if ($notif) {
            $notif->markAsRead();
        }
    }

    public function markAllAsRead($userId)
    {
        Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
    }

    public function cleanOldNotifications($days = 30)
    {
        $date = now()->subDays($days);

        return Notification::where('created_at', '<', $date)->delete();
    }
}
