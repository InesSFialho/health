<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontoffice.index');
    }

    public function changeLanguage($locale)
    {
    	session()->put('locale', $locale);
    	return redirect()->back();
    }

    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }
    
}
