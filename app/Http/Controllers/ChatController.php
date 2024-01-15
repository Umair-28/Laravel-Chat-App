<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Events\ChatMessageEvent;

class ChatController extends Controller
{
    public function index()
    {
        try {
            // Retrieve messages from Redis
            $messages = Redis::lrange('chat_messages', 0, -1);
            $messages = $messages ?: [];
            return view('chat', ['messages' => $messages]);
        } catch (\Exception $e) {
            \Log::error('Error getting messages: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            $message = $request->input('message');
            Redis::lpush('chat_messages', $message);
    
            broadcast(new ChatMessageEvent($message)); // Broadcast to all other connected users
    
            return response()->json(['status' => 'Message Sent!']);
        } catch (\Exception $e) {
            \Log::error('Error sending message: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getMessages()
{
    try {
        // Retrieve messages from Redis
        $messages = Redis::lrange('chat_messages', 0, -1);

        return response()->json(['messages' => $messages]);
    } catch (\Exception $e) {
        \Log::error('Error getting messages: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

}
