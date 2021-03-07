<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Image;

use App\Configuration;

class ConfigurationsController extends Controller
{

    public function index()
    {


        $configurations = DB::table('configurations')->orderBy('created_at', 'desc')->first();
        if (!empty($configurations)) {
        $logo = DB::table('images')->where('id',  $configurations->image_id)->first();
        $logo_backoffice = DB::table('images')->where('id',  $configurations->image_mobile_id)->first();
       
        $bg1 = DB::table('images')->where('id',  $configurations->image_bg1_id)->first();
        $bg2 = DB::table('images')->where('id',  $configurations->image_bg2_id)->first();
        $bg3 = DB::table('images')->where('id',  $configurations->image_bg3_id)->first();
        $bg4 = DB::table('images')->where('id',  $configurations->image_bg4_id)->first();
       

        $filename = "assets/js/analytics.json";
        $analytics_json = file_get_contents($filename);
        }
        if (!empty($configurations)) {
            return view('backoffice.configurations.index', compact('configurations', 'analytics_json', 'logo', 'logo_backoffice','bg1','bg2','bg3','bg4'));
        } else {
            return view('backoffice.configurations.index');
        }
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            flash('Fill the fields!')->error();
            return redirect('backoffice/configurations')
                ->withErrors($validator)
                ->withInput();
        }

        //Grava ficheiro Json do Analytics
        $filename = "assets/js/analytics.json";
        file_put_contents($filename, $request->input('analytics_json'));


        $configuration =  DB::table('configurations')->insertGetId(['title' => $request->input('title'), 'subtitle' => $request->input('subtitle'), 'google_control_id' => $request->input('google_control_id'), 'google_view_ids' => $request->input('google_view_ids'), 'created_at' => now()]);

        if ($request->hasFile('imagens')) :
            foreach ($request->file('imagens') as $img) {
                $this->saveImage($img,  $configuration, 'logo', 'logo');
            }
        endif;

        $image = DB::table('images')->select('id')->whereNull('deleted_at')->where('type',  'logo')->orderBy('created_at', 'desc')->first();

        DB::table('configurations')->where('id',  $configuration)->update(['image_id' => $image->id]);

        DB::table('images')->where('id',  $image->id)->update(['main' => '1']);

        if ($request->hasFile('imagens-mobile')) :
            foreach ($request->file('imagens-mobile') as $img) {
                $this->saveImage($img,  $configuration, 'logo-backoffice', 'logo-backoffice');
            }
        endif;
        $image_mobile = DB::table('images')->select('id')->whereNull('deleted_at')->where('type',  'logo-backoffice')->orderBy('created_at', 'desc')->first();

        DB::table('configurations')->where('id',  $configuration)->update(['image_mobile_id' => $image_mobile->id]);

        DB::table('images')->where('id',  $image_mobile->id)->update(['main' => '1']);


        if ($request->hasFile('imagens-bg1')) :
            foreach ($request->file('imagens-bg1') as $img) {
                $this->saveImage($img, $configuration, 'bg1', 'bg1');
            }
        endif;
        $image_bg1 = DB::table('images')->select('id')->whereNull('deleted_at')->where('type', 'bg1')->orderBy('created_at', 'desc')->first();

        DB::table('configurations')->where('id', $configuration)->update(['image_bg1_id' => $image_bg1->id]);

        DB::table('images')->where('id', $image_bg1->id)->update(['main' => '1']);



        if ($request->hasFile('imagens-bg2')) :
            foreach ($request->file('imagens-bg2') as $img) {
                $this->saveImage($img, $configuration, 'bg2', 'bg2');
            }
        endif;
        $image_bg2 = DB::table('images')->select('id')->whereNull('deleted_at')->where('type', 'bg2')->orderBy('created_at', 'desc')->first();

        DB::table('configurations')->where('id', $configuration)->update(['image_bg2_id' => $image_bg2->id]);

        DB::table('images')->where('id', $image_bg2->id)->update(['main' => '1']);

        if ($request->hasFile('imagens-bg3')) :
            foreach ($request->file('imagens-bg3') as $img) {
                $this->saveImage($img, $configuration, 'bg3', 'bg3');
            }
        endif;
        $image_bg3 = DB::table('images')->select('id')->whereNull('deleted_at')->where('type', 'bg3')->orderBy('created_at', 'desc')->first();

        DB::table('configurations')->where('id', $configuration)->update(['image_bg3_id' => $image_bg3->id]);

        DB::table('images')->where('id', $image_bg3->id)->update(['main' => '1']);

        if ($request->hasFile('imagens-bg4')) :
            foreach ($request->file('imagens-bg4') as $img) {
                $this->saveImage($img, $configuration, 'bg4', 'bg4');
            }
        endif;
        $image_bg4 = DB::table('images')->select('id')->whereNull('deleted_at')->where('type', 'bg4')->orderBy('created_at', 'desc')->first();

        DB::table('configurations')->where('id', $configuration)->update(['image_bg4_id' => $image_bg4->id]);

        DB::table('images')->where('id', $image_bg4->id)->update(['main' => '1']);


        flash('Saved!')->success();

        return redirect()->route('backoffice.configurations.index');
    }

    public function changeLanguage($locale)
    {
        session()->put('locale', $locale);
        return redirect()->back();
    }

    protected function saveImage($img, $id,$type, $slug)
    {

        $image = new Image();
        $image->storeImage($img, $id, $type, $slug);
    }



    protected function imageDelete($id)
    {

        DB::table('images')->where('id',  $id)->update(['deleted_at' => now()]);
    }
}
