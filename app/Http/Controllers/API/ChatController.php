<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $receiverId = $request->query('receiver_id');

        $userId = Auth::id();

        $messages = Message::where(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $userId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        return $this->json(data: $messages, message: 'Get message successfully!');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'message' => $request->input('message'),
            'receiver_id' => $request->receiver_id,
            'sender_id' => Auth::user()->id,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return $this->json(message: 'Message sent successfully!');
    }
}
