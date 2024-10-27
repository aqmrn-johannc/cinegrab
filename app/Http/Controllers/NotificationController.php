<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $user = auth()->user();
   
        $user->unreadNotifications->markAsRead();
        
        return response()->json(['success' => true]);
    }
}
