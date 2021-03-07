<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Base{

    public static  function logo()
    {
      $logo = DB::table('images')->where('type','like','logo')->orderBy('created_at', 'desc')->first();
        return $logo;
    }

    public static  function bg1()
    {
      $logo = DB::table('images')->where('type','like','bg1')->orderBy('created_at', 'desc')->first();
        return $logo;
    }

    public static  function bg2()
    {
      $logo = DB::table('images')->where('type','like','bg2')->orderBy('created_at', 'desc')->first();
        return $logo;
    }

    public static  function bg3()
    {
      $logo = DB::table('images')->where('type','like','bg3')->orderBy('created_at', 'desc')->first();
        return $logo;
    }

    public static  function bg4()
    {
      $logo = DB::table('images')->where('type','like','bg4')->orderBy('created_at', 'desc')->first();
        return $logo;
    }
  
  
    public static  function logo_backoffice()
    {
      $logo_backoffice = DB::table('images')->where('type','like','logo-backoffice')->orderBy('created_at', 'desc')->first();
        return $logo_backoffice;
    }

    public static  function configs()
    {
      $configs = DB::table('configurations')->orderBy('created_at', 'desc')->first();
    
        return $configs;
    }


    

}
