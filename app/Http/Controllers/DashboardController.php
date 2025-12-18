<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();

        return view('admin.dashboard', compact(
            'totalUser',
        ));
    }
}
