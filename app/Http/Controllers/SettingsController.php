<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    
    public function index()
    {
        $settings = DB::table('settings')->latest('created_at')->first();
        if(!empty($settings)){
            return view('backoffice.settings.index', compact('settings'));
        }
        else{
            return view('backoffice.settings.new');
        }
    }
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'about' => 'required|max:3255',
        ]);

        if ($validator->fails()) {
            flash('Fill the fields!')->error();
            return redirect('backoffice/settings')
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->hasFile('video')){
            $file = $request->file('video');
            $filename = $file->getClientOriginalName();
            $url = '/uploads/videos/';
            $path = public_path().$url;
            $file->move($path, $filename);
        } else {
            $settings = DB::table('settings')->latest('created_at')->first();
            $filename = $settings->file;
            $path = $settings->path;  
            $url = $settings->url;    
        }

        DB::table('settings')->insert([
            ['title' => $request->input('title'),
            'about' => $request->input('about'), 
            'shipping_return' => $request->input('shipping_return'), 
            'termsofsales' => $request->input('termsofsales'), 
            'title_en' => $request->input('title_en'),
            'about_en' => $request->input('about_en'), 
            'shipping_return_en' => $request->input('shipping_return_en'), 
            'termsofsales_en' => $request->input('termsofsales_en'), 
            'path' => $path, 'url' => $url, 'file' => $filename, 'created_at' => now()]
        ]);

       
    
        flash('Saved!')->success();
    
        return redirect()->route('backoffice.settings.index');
        
    }
    public function changeLanguage($locale)
    {
    	session()->put('locale', $locale);
    	return redirect()->back();
    }

    
}
