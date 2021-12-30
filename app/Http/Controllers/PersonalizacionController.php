<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;
use App\Models\Personalizacion;

class PersonalizacionController extends Controller
{
    public static function cambiarBanner(Request $request){
    	$custom = Personalizacion::find(1);
        if(is_null($custom)){
            $custom = new Personalizacion();
        }
    	$imagenNombre = 'banner_custom.'.$request->imgBanner->getClientOriginalExtension();
        $request->imgBanner->move(public_path('images/custom/banners/'), $imagenNombre);
        $imagenPath = 'http://forcegamer.test/images/custom/banners/' . $imagenNombre;
        $custom->img_banner = $imagenPath;
        $custom->save();
    }

    public static function cambiarLogo(Request $request){
    	$custom = Personalizacion::find(1);
        if(is_null($custom)){
            $custom = new Personalizacion();
        }
    	$imagenNombre = 'logo_custom.'.$request->imgLogo->getClientOriginalExtension();
        $request->imgLogo->move(public_path('images/custom/logos/'), $imagenNombre);
		$imagenPath = 'http://forcegamer.test/images/custom/logos/' . $imagenNombre;
        $custom->img_logo = $imagenPath;
        $custom->save();
    }

    public static function cambiarColorBtns(Request $request){
        $custom = Personalizacion::find(1);
        if(is_null($custom)){
            $custom = new Personalizacion();
        }
        $custom->color_botones_back = $request->colorBack;
        $custom->color_botones_front = $request->colorFront;
        $custom->save();
    }
}
