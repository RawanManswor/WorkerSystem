<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminNotificationController extends Controller
{
    public function index() {
        $admin = Admin::find(auth()->id());
        return response()->json([
            "notifications" => $admin->notifications,
        ]);
    }
    public function unread() {
        $admin = Admin::find(auth()->id());
        return response()->json([
            "notifications" => $admin->unreadNotifications ,
        ]);
    }
    public function markRead() {
        $admin = Admin::find(auth()->id());
//        foreach ($admin->unreadNotifications as $notification) {
//            $notification->markAsRead();
//        }
        $admin->unreadNotifications()->update(['read_at' => now()]);
        return response()->json([
            "message" => 'success' ,
        ]);
    }
    public function deleteById($id) {
        DB::table('notifications')->where('id',$id)->delete();
        return response()->json([
            "message" => 'success delete' ,
        ]);
    }


}
