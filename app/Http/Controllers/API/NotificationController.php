<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Policies\NotificationPolicy;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = Notification::where('recipient_id', $user->id_User)
            ->orWhere('recipient_id', null)
            ->orderBy('created_at', 'desc')
            ->get();

        return NotificationResource::collection($notifications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Notification::class);

        $validated = $request->validate([
            'recipient_id' => 'nullable|exists:users,id_User',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'sender_id' => Auth::user()->id_User,
            'recipient_id' => $validated['recipient_id'],
            'message' => $validated['message'],
        ]);

        return new NotificationResource($notification);
    }
}
