<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:newsletters']);
        Newsletter::create($request->only('email'));
        return back()->with('success', 'Berhasil berlangganan ☕');
    }
}
