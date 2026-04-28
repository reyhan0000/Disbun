<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $notifications = $this->notificationService->getForUser(auth()->id(), 50);
        $unreadCount = $this->notificationService->getUnreadCount(auth()->id());

        return view('petani.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function show($id)
    {
        $this->notificationService->markAsRead($id);

        $notification = Notification::findOrFail($id);

        if ($notification->data_type && $notification->data_id) {
            return redirect()->route('petani.pengajuan.show', $notification->data_id);
        }

        return redirect()->route('petani.notifications.index');
    }

    public function markAllRead()
    {
        $this->notificationService->markAllAsRead(auth()->id());

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
