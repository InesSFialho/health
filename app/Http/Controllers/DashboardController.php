<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Invoice;
use App\Supplier;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('backoffice.dashboard.index');
    }

    public function changeLanguage($locale)
    {
    	session()->put('locale', $locale);
    	return redirect()->back();
    }

}
