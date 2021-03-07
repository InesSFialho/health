<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\User;
use App\Supplier;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = User::find(auth()->user()->id);
        return view('backoffice.dashboard.index', compact('user'));
    }

    public function changeLanguage($locale)
    {
    	session()->put('locale', $locale);
    	return redirect()->back();
    }

}
