<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function fetch()
    {
        return Message::with('user')->get();
    }

    public function sentMessage(Request $request)
    {
        $user = auth()->user();

        $message = Message::create([
            'message' => $request->get('message'),
            'user_id' => $user->id,
        ]);

        broadcast(new MessageSentEvent($user, $message))->toOthers();
    }
}
