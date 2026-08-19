<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user()->load(['role', 'division', 'position', 'reportsTo']);

        return view('dashboard', ['user' => $user]);
    }
}
