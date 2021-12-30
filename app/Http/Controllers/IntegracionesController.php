<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Integraciones;
use App\Models\Comuna;


class IntegracionesController extends Controller
{
	public function __construct()
    {
        $this->middleware('admin');
    }

	/**
    *@group Integracion con Mercado Libre
    *Obtener el codigo al enlazar la cuenta
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
	public function formDatosMercadoLibre(Request $request){
		$intML = Integraciones::getIntegracionPorNombre('mercadolibre');
		return view('admin.integraciones.mercado-libre',[
			'intML' => $intML
		]);
	}

	/**
    *@group Integracion con Mercado Libre
    *Guardar datos de la app para obtener el codigo del usuario
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
	public function setDatosMercadoLibre(Request $request){
		$datos = $request->validate([
			'client_id' => ['required'],
			'client_secret' => ['required'],
			'state' => ['required','min:3','max:30']
		]);
		$intML = Integraciones::updateOrCreate([
			'nombre' => 'mercadolibre'
		],[
			'client_id' => $datos['client_id'],
			'client_secret' => $datos['client_secret'],
			'tipo' => 'marketplace'
		]);
		if($intML->refresh_token == NULL){
			$urlMLCode = 'http://auth.mercadolibre.cl/authorization?response_type=code&client_id='. $intML->client_id .'&state='. $datos['state'] .'&redirect_uri=https://forcegamer.test/administracion/integraciones';
			return redirect()->to($urlMLCode);
		}
		else{
			$resp = IntegracionesController::getMercadoLibreTokenRefresh($intML->client_id,$intML->client_secret,$intML->refresh_token);
			$intML->access_token = $resp['access_token'];
			$intML->refresh_token = $resp['refresh_token'];
			$intML->save();
			return redirect()->route('admin.panelIntegraciones')->with('exito','Se ha creado un vinculo entre tu tienda de Clevermarket y Mercado Libre.');
		}
	}


	/**
    *@group Integracion con Mercado Libre
    *Obtener el token para trabajar con la data
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public static function getMercadoLibreToken($client_id,$client_secret,$code){
		$url = "https://api.mercadolibre.com/oauth/token";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "accept: application/json",
		   "content-type: application/x-www-form-urlencoded",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = 'grant_type=authorization_code&client_id='. $client_id .'&client_secret='. $client_secret .'&code='. $code .'&redirect_uri=https://forcegamer.test/administracion/integraciones';

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp,true);
    }
    
    /**
    *@group Integracion con Mercado Libre
    *Obtener el token mediante el refresh
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public static function getMercadoLibreTokenRefresh($client_id,$client_secret,$refresh_token){
		$url = "https://api.mercadolibre.com/oauth/token";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "accept: application/json",
		   "content-type: application/x-www-form-urlencoded",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = 'grant_type=refresh_token&client_id='.$client_id.'&client_secret='.$client_secret.'&refresh_token='.$refresh_token.'';

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp,true);
    }


    public static function updateProductoMercadoLibre(Request $request, $access_token,$item_id){
		$url = "https://api.mercadolibre.com/items/" . $item_id;

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Authorization: Bearer ".$access_token,
		   "Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = '{
		   "title":"'.$request->nombre.'",
		   "price":'.$request->precio.',
		   "available_quantity":'.$request->cantidad.',
		   "description":{
		      "plain_text":"'.$request->descripcion.'"
		   },
		};';

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp,true);
    }

    public static function setProductoMercadoLibre(Request $request, $access_token){
		$url = "https://api.mercadolibre.com/items";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Authorization: Bearer ".$access_token,
		   "Content-Type: application/json",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = '{
		   "title":"'.$request->nombre.'",
		   "category_id":"MLC3530",
		   "price":'.$request->precio.',
		   "official_store_id":null,
		   "currency_id":"CLP",
		   "available_quantity":'.$request->cantidad.',
		   "buying_mode":"buy_it_now",
		   "listing_type_id":"bronze",
		   "condition":"new",
		   "description":{
		      "plain_text":"Descripcion de Prueba"
		   },
		   "video_id":"YOUTUBE_ID_HERE",
		   "sale_terms":[
		      {
		         "id":"WARRANTY_TYPE",
		         "value_id":"2230280",
		         "value_name":"Garantia de vendedor"
		      },
		      {
		         "id":"WARRANTY_TIME",
		         "value_name":"90 días"
		      }
		   ],

		   "pictures":[
		      {
		         "source":"http://upload.wikimedia.org/wikipedia/commons/f/fd/Ray_Ban_Original_Wayfarer.jpg"
		      },
		      {
		         "source":"http://en.wikipedia.org/wiki/File:Teashades.gif"
		      }
		   ]
		};';

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp,true);
    }

    /**
    *@group Integracion con Chilexpress
    *Obtener el codigo al enlazar la cuenta
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
	public function formDatosChilexpress(Request $request){
		$intCE = Integraciones::getIntegracionPorNombre('Chilexpress');
		if(!is_null($intCE)){
			if($intCE->activo == 1){
				$intCE->activo = 0;
				$intCE->save();
				return redirect()->route('admin.panelIntegraciones')->with('exito','Se ha desactivado el vinculo entre tu tienda de Clevermarket y Chilexpress.');
			}
			return view('admin.integraciones.chilexpress',[
				'intML' => $intCE
			]);
		}
		else{
			return view('admin.integraciones.chilexpress',[
				'intML' => null
			]);
		}
	}

	/**
    *@group Integracion con Chilexpress
    *Guardar datos de la integracion (Prueba)
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
	public function setDatosChilexpress(Request $request){
		$datos = $request->validate([
			'client_id' => ['required']
		]);
		$intML = Integraciones::updateOrCreate([
			'nombre' => 'Chilexpress'
		],[
			'client_id' => $datos['client_id'],
			'tipo' => 'courier',
			'activo' => 1
		]);
		$intML->activo = 1;
		$intML->save();
		return redirect()->route('admin.panelIntegraciones')->with('exito','Se ha creado un vinculo entre tu tienda de Clevermarket y Chilexpress.');
		
	}

	/**
    *@group Integracion con Chilexpress
    *Obtener el codigo al enlazar la cuenta
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
	public function formDatosBluexpress(Request $request){
		$intBE = Integraciones::getIntegracionPorNombre('Blue Express');
		if(!is_null($intBE)){
			if($intBE->activo == 1){
				$intBE->activo = 0;
				$intBE->save();
				return redirect()->route('admin.panelIntegraciones')->with('exito','Se ha desactivado el vinculo entre tu tienda de Clevermarket y Blue Express.');
			}
			return view('admin.integraciones.bluexpress',[
				'intML' => $intBE
			]);
		}
		else{
			return view('admin.integraciones.bluexpress',[
				'intML' => null
			]);
		}
	}

	/**
    *@group Integracion con Chilexpress
    *Guardar datos de la integracion (Prueba)
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
	public function setDatosBluexpress(Request $request){
		$datos = $request->validate([
			'client_id' => ['required']
		]);
		$intML = Integraciones::updateOrCreate([
			'nombre' => 'Blue Express'
		],[
			'client_id' => $datos['client_id'],
			'tipo' => 'courier',
			'activo' => 1
		]);
		$intML->activo = 1;
		$intML->save();
		return redirect()->route('admin.panelIntegraciones')->with('exito','Se ha creado un vinculo entre tu tienda de Clevermarket y Blue Express.');
		
	}

	/**
    *@group Integracion con Chilexpress
    *Obtener datos de regiones de envio
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
	public static function getCountyChilexpress($subscriptionKey,$regionCode,Comuna $comuna){
		$url = "https://testservices.wschilexpress.com/georeference/api/v1.0/coverage-areas?RegionCode=". $regionCode ."&type=0";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Cache-Control: no-cache",
		   "Ocp-Apim-Subscription-Key: ".$subscriptionKey,
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);

		$allCountys = json_decode($resp,true);

		foreach($allCountys['coverageAreas'] as $county){
			$countyNameLower = Str::lower($county['countyName']);
			if($countyNameLower == Str::lower($comuna->comuna)){
				return $county;
			}
		}

		return NULL;
	}


	public static function getGeoReferenceChilexpress($subscriptionKey,$countyName,$calle,$numeracion){
		$url = "https://testservices.wschilexpress.com/georeference/api/v1.0/addresses/georeference";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Content-Type: application/json",
		   "Cache-Control: no-cache",
		   "Ocp-Apim-Subscription-Key: ".$subscriptionKey,
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = '{
		    "countyName": "'. $countyName .'",
		    "streetName": "'. $calle .'",
		    "number": '. $numeracion .'
		}
		';

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp,true);
	}

	public static function getOficinaCercana($subscriptionKey,$geoReferenceID){
		$url = "https://testservices.wschilexpress.com/georeference/api/v1.0/nearby-offices/" .$geoReferenceID ."?type=0&radius=10";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
		   "Cache-Control: no-cache",
		   "Ocp-Apim-Subscription-Key: ".$subscriptionKey,
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);

		$respArray = json_decode($resp,true);

		if($respArray['statusCode'] == 0){
			$oficinas = $respArray['nearbyOffice'];
			foreach($oficinas as $oficinaCercana){
				if($oficinaCercana['office']['officeType'] == 3){
					return $oficinaCercana;
				}
			}
		}
		else{
			return NULL;
		}
	}
}