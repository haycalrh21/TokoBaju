<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function showMessages()
    {
        // Mendapatkan ID user yang sedang login
        $user = Auth::user();

        // Mendapatkan pesan dan balasan untuk pengguna yang sedang login
        $messages = Message::where('user_id', $user->id)->with('replies')->get();

        return view('page.user.message.index', compact('messages'));

    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'content'=>'required|string',
        ]);


        Message::create([
            'user_id'=> auth()->id(),
            'content'=> $request->input('content')
        ]);

        return redirect()->back();
    }


    public function storeReply(Request $request, $messageId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $user = Auth::user();

        // Pastikan pesan yang dijawab dimiliki oleh pengguna yang sedang login
        $parentMessage = Message::where('user_id', $user->id)->findOrFail($messageId);

        // Buat balasan untuk pesan
        $parentMessage->replies()->create([
            'content' => $request->input('content'),
            'parent_id' => $parentMessage->id, // Mengaitkan balasan dengan pesan yang dijawab
        ]);

        return redirect()->back();
    }
}
