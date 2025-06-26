<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Summary of index
     * Displaying home page for users
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('user.dashboard');
    }
}
