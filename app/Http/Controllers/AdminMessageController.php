<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminMessageController extends Controller
{
    public function showMessages()
    {
        $messages= Message::all();
        // Kirim data pesan ke tampilan
        return view('admin.message.index', compact('messages'));
    }

    public function replyMessage(Request $request, $id)
    {
        // Validasi input, pastikan pesan tidak kosong
        $message = Message::findOrFail($id);

        // Validasi request jika diperlukan
        $request->validate([
            'adminReply' => 'required|string',
        ]);

        // Simpan balasan ke dalam tabel replies
        $reply = $message->replies()->create([
            'content' => $request->input('adminReply'),
            'is_admin_reply' => true,
        ]);


        return redirect()->route('admin.message.index')
            ->with('success', 'Pesan berhasil di-reply!');
    }

}
