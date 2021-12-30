<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'cantidad_articulos',
        'precio_total',
        'region',
        'comuna',
        'calle',
        'estado'
    ];

    public function usuario(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function comuna(){
        return $this->belongsTo(Comuna::class,'comuna_id','id');
    }

    public function courier(){
        return $this->belongsTo(Integraciones::class,'courier_id','id');
    }

    public function productos(){
    	return $this->belongsToMany(Producto::class,'ventas_detalles','id_venta','id_producto')
    		->as('detalle')
    		->withPivot('cantidad_articulos','precio_total','estado')
    		->withTimestamps();
    }

    public function codigoDescuento(){
        return $this->belongsTo(CodigoDescuento::class,'codigo_descuento_id','id');
    }

    public static function pendientes(){
        $venta = Venta::where('estado','=',1)->get();
        if($venta->count() > 0){
            return $venta;
        }
        else{
            return NULL;
        }
    }

    public static function despachadas(){
        $venta = Venta::where('estado','=',2)->get();
        if($venta->count() > 0){
            return $venta;
        }
        else{
            return NULL;
        }
    }

    public static function cerradas(){
        $venta = Venta::where('estado','=',3)->get();
        if($venta->count() > 0){
            return $venta;
        }
        else{
            return NULL;
        }
    }

    public function getCourier(){
        return Integraciones::where('id','=',$this->courier_id)->first();
    }

    public static function getRegiones(){
        return DB::table('regiones')->get();
    }

    public static function getComunas(){
        return DB::table('comunas')->orderBy('comuna','asc')->get();
    }

    public static function ventasPorMes($year){
        $ventasPorMes = [];
        if($year == NULL){
            for ($mes=1; $mes <= 12; $mes++) {
                $ventasPorMes[] = Venta::whereMonth('created_at',$mes)
                ->whereYear('created_at',now()->year)->count();
            }
        }
        else{
            for ($mes=1; $mes <= 12; $mes++) {
                $ventasPorMes[] = Venta::whereMonth('created_at',$mes)
                ->whereYear('created_at',$year)->count();
            }
        }
        return $ventasPorMes;

    }

    public static function ventasPorClase($clases,$year = NULL){
        $ventasPorClase = [];
        if($year == NULL){
            $result = DB::table('ventas_detalles')
                                    ->join('productos','productos.id','=','ventas_detalles.id_producto')
                                    ->rightJoin('clases','clases.id','=','productos.id_clase')
                                    ->select(DB::raw('sum(ventas_detalles.cantidad_articulos) as ventaClase'),'clases.nombre')
                                    ->whereRaw(DB::raw('year(`ventas_detalles`.`created_at`) is null or year(`ventas_detalles`.`created_at`) = '.now()->year))
                                    ->groupBy('clases.id')
                                    ->orderBy('clases.id','asc')
                                    ->get();            
        }
        else{
            $result = DB::table('ventas_detalles')
                                    ->join('productos','productos.id','=','ventas_detalles.id_producto')
                                    ->rightJoin('clases','clases.id','=','productos.id_clase')
                                    ->select(DB::raw('sum(ventas_detalles.cantidad_articulos) as ventaClase'),'clases.nombre')
                                    ->whereRaw(DB::raw('year(`ventas_detalles`.`created_at`) is null or year(`ventas_detalles`.`created_at`) = '.$year))
                                    ->groupBy('clases.id')
                                    ->orderBy('clases.id','asc')
                                    ->get();   
        }
        $ventasPorClase = json_decode(json_encode($result),true);
        foreach($ventasPorClase as $key => $ventas){
            if($ventas['ventaClase'] == null){
                $ventasPorClase[$key]['ventaClase'] = "0";
            }
        }
        return $ventasPorClase;
    }

}
