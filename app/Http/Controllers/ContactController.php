<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request)
    {
        // Honeypot: manusia tidak bisa melihat field ini, jadi kalau terisi kemungkinan besar bot.
        // Pura-pura berhasil supaya bot tidak tahu ia ketahuan, tapi jangan simpan apa pun.
        if ($request->filled('website')) {
            return $this->redirectWithSuccess();
        }

        ContactMessage::create($request->validated());

        return $this->redirectWithSuccess();
    }

    private function redirectWithSuccess()
    {
        return redirect()->to(route('home') . '#send-message')
            ->with('contact_success', true);
    }
}