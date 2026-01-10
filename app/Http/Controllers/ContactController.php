<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.kontak');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        // Simpan ke database
        Message::create($data);

        // OPTIONAL: Kirim email ke admin
        Mail::raw(
            "Nama: {$data['name']}\nEmail: {$data['email']}\nTelepon: {$data['phone']}\n\nPesan:\n{$data['message']}",
            function ($mail) {
                $mail->to('admin@kopimocha.id')
                    ->subject('Pesan Baru dari Website');
            }
        );

        return back()->with('success', 'Pesan kamu berhasil dikirim ☕');
    }
}
