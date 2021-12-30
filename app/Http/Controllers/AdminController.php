<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Audit;
use App\Models\Integraciones;
use App\Models\User;
use App\Models\Venta;
use App\Models\Clase;
use App\Models\Producto;
use App\Models\ProductosVendidos;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Perfil;
/**
*@group Controlador del panel de administracion
*
*Funciones de las paginas asociadas al panel de administración
*/
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     *@group Dashboard y Reportabilidad
     *Pagina principal
     *
     *@response {
     *"view": "admin/principal.blade.php",
     *}
     */
    public function index(Request $request,$year = NULL){   
        $clases = Clase::all();
        $nombreClases = "[";
        $cantidadClases = "[";
        $ventasPorClase = Venta::ventasPorClase($clases,$year);
        foreach($ventasPorClase as $key => $ventas){
            if($key == count($ventasPorClase)-1){
                $nombreClases = $nombreClases . "'" . $ventas['nombre'] . "']";
                $cantidadClases = $cantidadClases . "'" . $ventas['ventaClase'] . "']";
            }
            else{
                $nombreClases = $nombreClases . "'" . $ventas['nombre'] . "',";
                $cantidadClases = $cantidadClases . "'" . $ventas['ventaClase'] . "',";
            }
            
        }
        $ventasPorMes = Venta::ventasPorMes($year);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra la pagina principal de administracion","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra la pagina principal de administracion","completado");
        }
        return view('admin.dashboard.main',[
            'ventasPorMes' => $ventasPorMes,
            'nombreClases' => $nombreClases,
            'cantidadClases' => $cantidadClases
        ]);
    }

    /**
     *@group Dashboard y Reportabilidad
     *Descarga de productos vendidos
     *
     *@response {
     *"view": "admin/principal.blade.php",
     *}
     */
    public function descargaProductosVendidos(Request $request){
        $fileName = 'productos_vendidos.csv';
        $productosVendidos = ProductosVendidos::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('SKU', 'Nombre', 'Marca', 'Cantidad Vendida', 'Precio Unitario','Precio Total');

        $callback = function() use($productosVendidos, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns,",");

            foreach ($productosVendidos as $prodVenta) {
                $row['SKU']  = $prodVenta->sku;
                $row['Nombre']    = $prodVenta->nombre;
                $row['Marca']    = $prodVenta->marca;
                $row['Cantidad Vendida']  = $prodVenta->cantidad_vendida;
                $row['Precio Unitario']  = $prodVenta->precio_unitario;
                $row['Precio Total']  = $prodVenta->precio_total;
                fputcsv($file, array($row['SKU'], $row['Nombre'], $row['Marca'], $row['Cantidad Vendida'], $row['Precio Unitario'],$row['Precio Total']),",");
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    /**
    *@group Mantenedor de Productos
     *Mantenedor de Productos
     *
     *@response {
     *"view": "admin/mantenedores/sillas.blade.php",
     *}
     */
    public function mantenedorProductos(Request $request,Clase $clase){
    	$productos = Producto::todosPorClase($clase);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de productos","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de productos","completado");
        }
    	return view('admin.mantenedores.productos',[
    		'productos' => $productos,
            'clase' => $clase
    	]);
    }

    /**
    *@group Mantenedor de Productos
     *Mantenedor de Productos
     *
     *@response {
     *"view": "admin/mantenedores/sillas.blade.php",
     *}
     */
    public function dashboardProductos(Request $request){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el dashboard de los productos.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el dashboard de los productos.","completado");
        }
        return view('admin.principal');
    }


    /**
    *@group Mantenedor de Productos
    *Formularo para agregar producto principal
    *
    *@response {
    *"view": "admin/mantenedores/productos/agregar.blade.php",
    *}
    */
    public function formCreateProducto(Request $request,Clase $clase){
        $marcas = Marca::all();

        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar productos","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar productos","completado");
        }
        return view('admin.mantenedores.productos.agregar',[
            'marcas' => $marcas,
            'clase' => $clase
        ]);
    }

    /**
    *@group Mantenedor de Productos
    *Editar producto principal
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function formEditProducto(Request $request, Clase $clase,Producto $producto){
        $marcas = Marca::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar productos","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar productos","completado");
        }
        return view('admin.mantenedores.productos.editar',[
            'marcas' => $marcas,
            'clase' => $clase,
            'producto' => $producto
        ]);
    }


    /**
    *@group Mantenedor de Productos
    *Creacion de producto primaria
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function createProducto(Request $request,Clase $clase){
        $datos = $request->validate([
            'sku' => ['required','min:3','unique:App\Models\Producto,sku'],
            'nombre' => ['required','min:3','unique:App\Models\Producto,nombre'],
            'nom_fabricante' => ['unique:App\Models\Producto,nombre_fabricante','nullable'],
            'desc' => ['required','min:10'],
            'precio' =>['required','numeric'],
            'marca' =>['required','numeric'],
            'cantidad' =>['required','numeric','min:0'],
            'imgPrincipal' => ['required','image']
        ]);
        $url_image_array = explode(" ",ucwords($datos['nombre']));
        $url_image = ''. date("Ymd_His") . '_';
        foreach($url_image_array as $url_part){
            $url_image = $url_image . $url_part;
        }
        $imagenNombre = $url_image.'.'.$request->imgPrincipal->getClientOriginalExtension();
        $request->imgPrincipal->move(public_path('images/productos/'.$clase->nombre .''), $imagenNombre);
        $producto = Producto::create([
            'sku' => $datos['sku'],
            'id_clase' => $clase->id,
            'nombre' => $datos['nombre'],
            'nombre_fabricante' => $datos['nom_fabricante'],
            'descripcion' => $datos['desc'],
            'precio' => $datos['precio'],
            'id_marca' => $datos['marca'],
            'cantidad' => $datos['cantidad'],
            'imagen_principal' => 'images/productos/'. $clase->nombre .'/' . $imagenNombre,
            'url' => $url_image
        ]);
        //Revisa las integraciones y realiza las cargas correspondientes
        if(Integraciones::getIntegracionPorNombre('mercadolibre') != NULL){
            $intML = Integraciones::getIntegracionPorNombre('mercadolibre');
            $resp = IntegracionesController::setProductoMercadoLibre($request,$intML->access_token);
            $intML->productos()->attach($producto,[
                'id_producto_externo' => $resp['id']
            ]);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto " . $producto->nombre . " creado con exito","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto " . $producto->nombre . " creado con exito","create");
        }
        return redirect()->route('admin.manProductos',$clase)->with('exito','¡'. $clase->nombre .' agregad@ exitosamente!');
    }

    /**
    *@group Mantenedor de Productos
    *Guardar actualizacion de producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function formProductoMasivo(Request $request,Clase $clase){
        $marcas = Marca::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar productos de manera masiva.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar productos de manera masiva.","completado");
        }
        return view('admin.mantenedores.productos.masivo',[
            'marcas' => $marcas,
            'clase' => $clase
        ]);
    }

    /**
    *@group Mantenedor de Productos
    *Guardar actualizacion de producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function setProductoMasivo(Request $request){
        $datos = $request->validate([
            'csvCarga' => ['required','mimetypes:text/csv,text/plain,application/vnd.ms-excel,text/comma-separated-values,application/csv']
        ],[
            'csvCarga.required' => 'Debe adjuntar un archivo.',
            'csvCarga.mimetypes' => 'El archivo debe estar en formato .csv'
        ]);
        $productosCSV = productosCsvToArray($request->csvCarga);
        if(count($productosCSV[0]) > 1){
            foreach ($productosCSV as $productoArray) {
                $producto = new Producto();
                $producto->nombre = $productoArray['nombre_producto'];
                $producto->nombre_fabricante = $productoArray['nombre_del_fabricante'];
                $producto->sku = $productoArray['sku'];
                $producto->id_clase = Clase::getClasePorNombre($productoArray['nombre_clase'])->id;
                $producto->descripcion = $productoArray['descripcion'];
                $producto->precio = $productoArray['precio'];
                $producto->id_marca = Marca::getMarcaPorNombre($productoArray['marca'])->id;
                $producto->cantidad = $productoArray['cantidad'];
                $url_array = explode(" ",ucwords($productoArray['nombre_producto']));
                $url = ''. date("Ymd_His") . '_';
                foreach($url_array as $url_part){
                    $url = $url . $url_part;
                }
                $producto->url = $url;
                $productosArray[] = $producto;
            }
        }
        else{
            $productosCSV = productosCsvToArray($request->csvCarga,';');
            foreach ($productosCSV as $productoArray) {
                $producto = new Producto();
                $producto->nombre = $productoArray['nombre_producto'];
                $producto->nombre_fabricante = $productoArray['nombre_del_fabricante'];
                $producto->sku = $productoArray['sku'];
                $producto->id_clase = Clase::getClasePorNombre($productoArray['nombre_clase'])->id;
                $producto->descripcion = $productoArray['descripcion'];
                $producto->precio = $productoArray['precio'];
                $producto->id_marca = Marca::getMarcaPorNombre($productoArray['marca'])->id;
                $producto->cantidad = $productoArray['cantidad'];
                $producto->imagen_principal = 'images/productos/imagen_no_disponible.png';
                $url_array = explode(" ",ucwords($productoArray['nombre_producto']));
                $url = ''. date("Ymd_His") . '_';
                foreach($url_array as $url_part){
                    $url = $url . $url_part;
                }
                $producto->url = $url;
                $productosArray[] = $producto;
            }
        }
        $request->session()->put('productos',$productosArray);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Procesa el CSV cargado para su posterior revision.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Procesa el CSV cargado para su posterior revision.","completado");
        }
        return view('admin.mantenedores.productos.masivo.revisar',[
            'productos' => $productosArray
        ]);
    }

    /**
    *@group Mantenedor de Productos
    *Guardar actualizacion de producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function createProductoMasivo(Request $request){
        $productos = $request->session()->get('productos');
        $request->session()->forget('productos');
        foreach ($productos as $producto) {
            $producto->activo = 0;
            $producto->save();
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Carga el CSV de productos de manera correcta.","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Carga el CSV de productos de manera correcta.","create");
        }
        return redirect()->route('admin')->with('exito','¡Productos agregados masivamente de manera exitosa!');
    }

    /**
    *@group Mantenedor de Productos
    *Guardar actualizacion de producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function updateProducto(Request $request,Clase $clase,Producto $producto){
        $datos = $request->validate([
            'sku' => ['required','min:3'],
            'nombre' => ['required','min:3'],
            'nom_fabricante' => [],
            'desc' => ['required','min:10'],
            'precio' =>['required','numeric'],
            'marca' =>['required','numeric'],
            'cantidad' =>['required','numeric','min:0'],
            'imgPrincipal' => ['image']
        ]);
        if(!empty($datos['imgPrincipal'])){
            $url_image_array = explode(" ",ucwords($datos['nombre']));
            $url_image = ''. date("Ymd_His") . '_';
            foreach($url_image_array as $url_part){
                $url_image = $url_image . $url_part;
            }
            $imagenNombre = $url_image.'.'.$request->imgPrincipal->getClientOriginalExtension();
            $request->imgPrincipal->move(public_path('images/productos/'.$clase->nombre .''), $imagenNombre);
            $producto->update([
                'sku' => $datos['sku'],
                'nombre' => $datos['nombre'],
                'nombre_fabricante' => $datos['nom_fabricante'],
                'descripcion' => $datos['desc'],
                'precio' => $datos['precio'],
                'id_marca' => $datos['marca'],
                'cantidad' => $datos['cantidad'],
                'imagen_principal' => 'images/productos/'.$clase->nombre .'/' . $imagenNombre,
                'url' => $url_image
            ]);
        }
        else{
            $producto->update([
                'sku' => $datos['sku'],
                'nombre' => $datos['nombre'],
                'nombre_fabricante' => $datos['nom_fabricante'],
                'descripcion' => $datos['desc'],
                'precio' => $datos['precio'],
                'id_marca' => $datos['marca'],
                'cantidad' => $datos['cantidad']
            ]);
        }
        //Revisa las integraciones y realiza las cargas correspondientes
        if(getIntegracionPorNombre('mercadolibre') != NULL){
            $intML = getIntegracionPorNombre('mercadolibre');
            $prodML = $producto->integradoML();
            if($prodML != NULL){
                $resp = IntegracionesController::updateProductoMercadoLibre($request,$intML->access_token,$prodML->id_producto_externo);
                $intML->productos()->syncWithoutDetaching($producto,[
                    'id_producto_externo' => $resp['id']
                ]);
            }
            else{
                $resp = IntegracionesController::createProductoMercadoLibre($request,$intML->access_token);
                $intML->productos()->syncWithoutDetaching($producto,[
                    'id_producto_externo' => $resp['id']
                ]);
            } 
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto " . $producto->nombre . " editado con exito","edit");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto " . $producto->nombre . " editado con exito","edit");
        }
        return redirect()->route('admin.manProductos',$clase)->with('exito','¡'. $clase->nombre .' editad@ exitosamente!');
    }


    /**
    *@group Mantenedor de Productos
    *AJAX: Inactivar producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function activadorProductos(Request $request){
        $producto = Producto::find($request->id);
        if($producto->activo == 1){
            $producto->activo = 0;
            $producto->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto " . $producto->nombre . " desactivado","delete");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto " . $producto->nombre . " desactivado","delete");
            }
            return response()->json(['success'=>'desactivado']);
        }
        elseif ($producto->activo == 0) {
            $producto->activo = 1;
            $producto->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto " . $producto->nombre . " activado","activado");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Producto " . $producto->nombre . " activado","activado");
            }
            return response()->json(['success'=>'activado']);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
        }
        return response()->json(['failed'=>'error']);       
    }

    /**
    *@group Mantenedor de Productos
    *AJAX: Cambiar cantidad del producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function cantidadProductos(Request $request){
        $producto = Producto::find($request->id);
        switch ($request->tipo) {
            case 'suma':
                $producto->cantidad += 1;
                $producto->save();
                if (!$request->session()->has('guest_uuid')) {
                    $request->session()->put('guest_uuid',Str::uuid());
                    Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $producto->nombre . " aumentada","sumado");
                }
                else{
                    Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $producto->nombre . " aumentada","sumado");
                }
                return response()->json(['success'=>'sumado']); 
                break;
            case 'resta':
                if($producto->cantidad > 0){
                    $producto->cantidad -= 1;
                    $producto->save();
                    if (!$request->session()->has('guest_uuid')) {
                        $request->session()->put('guest_uuid',Str::uuid());
                        Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $producto->nombre . " disminuida","restado");
                    }
                    else{
                        Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $producto->nombre . " disminuida","restado");
                    }
                    return response()->json(['success'=>'sumado']);
                }
                else{
                    if (!$request->session()->has('guest_uuid')) {
                        $request->session()->put('guest_uuid',Str::uuid());
                        Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $producto->nombre . " no puede ser menor a 0","excedeminimo");
                    }
                    else{
                        Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Cantidad de producto " . $producto->nombre . " no puede ser menor a 0","excedeminimo");
                    }
                    return response()->json(['success'=>'excede']); 
                }
            default:
                if (!$request->session()->has('guest_uuid')) {
                    $request->session()->put('guest_uuid',Str::uuid());
                    Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
                }
                else{
                    Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
                }
                return response()->json(['failed'=>'error']); 
                break;
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
        }
        return response()->json(['failed'=>'error']);       
    }

    /**
    *@group Mantenedor de Clases
     *Mantenedor de Clases
     *
     *@response {
     *"view": "admin/mantenedores/clases.blade.php",
     *}
     */
    public function mantenedorClases(Request $request){
        $clases = Clase::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de clases","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de clases","completado");
        }
        return view('admin.mantenedores.clases',[
            'clases' => $clases
        ]);
    }

    /**
    *@group Mantenedor de Clases
    *Formularo para agregar producto principal
    *
    *@response {
    *"view": "admin/mantenedores/clases/agregar.blade.php",
    *}
    */
    public function formCreateClase(Request $request){
        $categorias = Categoria::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar clases","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar clases","completado");
        }
        return view('admin.mantenedores.clases.agregar',[
            'categorias' => $categorias
        ]);
    }

    /**
    *@group Mantenedor de Clases
    *Editar producto principal
    *
    *@response {
    *"view": "admin/mantenedores/clases/editar.blade.php",
    *}
    */
    public function formEditClase(Request $request, Clase $clase){
        $categorias = Categoria::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar clases","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar clases","completado");
        }
        return view('admin.mantenedores.clases.editar',[
            'clase' => $clase
        ]);
    }


    /**
    *@group Mantenedor de Clases
    *Creacion de producto primaria
    *
    *
    *@response {
    *"view": "admin/mantenedores/clases/editar.blade.php",
    *}
    */
    public function createClase(Request $request){
        $datos = $request->validate([
            'nombre' => ['required','min:3','unique:App\Models\Clase,nombre'],
            'categorias' => ['required']
        ]);
        $clase = Clase::create([
            'nombre' => $datos['nombre']
        ]);
        foreach ($datos['categorias'] as $cat) {
            $clase->categorias()->attach($cat);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Clase " . $clase->nombre . " creada con exito","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Clase " . $clase->nombre . " creada con exito","create");
        }
        return redirect()->route('admin.manClases')->with('exito','¡Clase de nombre '. $clase->nombre .' agregad@ exitosamente!');
    }

    /**
    *@group Mantenedor de Clases
    *Guardar actualizacion de producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/clases/editar.blade.php",
    *}
    */
    public function updateClase(Request $request,Clase $clase){
        $datos = $request->validate([
            'nombre' => ['required','min:3'],
            'categorias' => ['required']
        ]);
        $clase->update([
            'nombre' => $datos['nombre']
        ]);
        $clase->categorias()->detach();
        foreach ($datos['categorias'] as $cat) {
            $clase->categorias()->attach($cat);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Clase " . $clase->nombre . " editada con exito","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Clase " . $clase->nombre . " editada con exito","create");
        }
        return redirect()->route('admin.manClases')->with('exito','¡Clase de nombre '. $clase->nombre .' actualizad@ exitosamente!');
    }

    /**
    *@group Mantenedor de Clase
    *AJAX: Inactivar producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function activadorClases(Request $request){
        $clase = Clase::find($request->id);
        if($clase->activo == 1){
            $clase->activo = 0;
            $clase->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Clase " . $clase->nombre . " desactivada","delete");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Clase " . $clase->nombre . " desactivada","delete");
            }
            return response()->json(['success'=>'desactivado']);
        }
        elseif ($clase->activo == 0) {
            $clase->activo = 1;
            $clase->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Clase " . $clase->nombre . " activada","activado");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Clase " . $clase->nombre . " activada","activado");
            }
            return response()->json(['success'=>'activado']);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
        }
        return response()->json(['failed'=>'error']);       
    }

    /**
    *@group Mantenedor de Marcas
     *Mantenedor de Marcas
     *
     *@response {
     *"view": "admin/mantenedores/marcas.blade.php",
     *}
     */
    public function mantenedorMarcas(Request $request){
        $marcas = Marca::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de marcas","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de marcas","completado");
        }
        return view('admin.mantenedores.marcas',[
            'marcas' => $marcas
        ]);
    }

    /**
    *@group Mantenedor de Marcas
     *Creacion de una nueva marca en el sistema
    *
    *@response {
    *"view": "admin/mantenedores/marcas/agregar.blade.php",
    *}
    */
    public function formCreateMarca(Request $request){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar marcas","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar marcas","completado");
        }
        return view('admin.mantenedores.marcas.agregar');
    }

    /**
    *@group Mantenedor de Marcas
     *Actualizacion de una marca en el sistema
    *
    *@response {
    *"view": "admin/mantenedores/marcas/editar.blade.php",
    *}
    */
    public function formEditMarca(Request $request, Marca $marca){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar marcas","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar marcas","completado");
        }
        return view('admin.mantenedores.marcas.editar',[
            'marca' => $marca
        ]);
    }

    /**
    *@group Mantenedor de Marcas
    *Guardar en BBDD la creacion de la Marca
    *
    *
    *@response {
    *"view": "admin/mantenedores/marcas/editar.blade.php",
    *}
    */
    public function createMarca(Request $request){
        $datos = $request->validate([
            'nombre' => ['required','min:2','unique:App\Models\Marca,nombre']
        ]);
        $marca = Marca::create([
            'nombre' => $datos['nombre']
        ]);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Marca " . $marca->nombre . " creada con exito","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Marca " . $marca->nombre . " creada con exito","create");
        }
        return redirect()->route('admin.manMarcas')->with('exito','¡Marca de nombre '. $marca->nombre .' agregad@ exitosamente!');
    }

    /**
    *@group Mantenedor de Marcas
    *Guardar actualizacion de producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/marcas/editar.blade.php",
    *}
    */
    public function updateMarca(Request $request,Marca $marca){
        $datos = $request->validate([
            'nombre' => ['required','min:3']
        ]);
        $marca->update([
            'nombre' => $datos['nombre']
        ]);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Marca " . $marca->nombre . " editada con exito","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Marca " . $marca->nombre . " editada con exito","create");
        }
        return redirect()->route('admin.manMarcas')->with('exito','¡Marca de nombre '. $marca->nombre .' actualizad@ exitosamente!');
    }

    /**
    *@group Mantenedor de Marcas
    *AJAX: Activar o inactivar Marca
    *
    *
    *@response {
    *"view": "admin/mantenedores/marcas/editar.blade.php",
    *}
    */
    public function activadorMarcas(Request $request){
        $marca = Marca::find($request->id);
        if($marca->activo == 1){
            $marca->activo = 0;
            $marca->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Marca " . $marca->nombre . " desactivada","delete");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Marca " . $marca->nombre . " desactivada","delete");
            }
            return response()->json(['success'=>'desactivado']);
        }
        elseif ($marca->activo == 0) {
            $marca->activo = 1;
            $marca->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Marca " . $marca->nombre . " activada","activado");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Marca " . $marca->nombre . " activada","activado");
            }
            return response()->json(['success'=>'activado']);
        }
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Error desconocido. Contacte al administrador del sistema","error");
        }
        return response()->json(['failed'=>'error']);       
    }

    /**
    *@group Mantenedor de Usuarios
    *Editar producto principal
    *
    *@response {
    *"view": "admin/mantenedores/clases/editar.blade.php",
    *}
    */
    public function mantenedorUsuarios(Request $request){
        $usuarios = User::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de usuarios","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de usuarios","completado");
        }
        return view('admin.mantenedores.usuarios',[
            'usuarios' => $usuarios
        ]);
    }

    /**
    *@group Mantenedor de Usuario
    *Formularo para agregar producto principal
    *
    *@response {
    *"view": "admin/mantenedores/clases/agregar.blade.php",
    *}
    */
    public function formCreateUsuario(Request $request){
        $perfiles = Perfil::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar usuarios","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para agregar usuarios","completado");
        }
        return view('admin.mantenedores.usuarios.agregar',[
            'perfiles' => $perfiles
        ]);
    }

    /**
    *@group Mantenedor de Usuario
    *Formularo para agregar producto principal
    *
    *@response {
    *"view": "admin/mantenedores/clases/agregar.blade.php",
    *}
    */
    public function formEditUsuario(Request $request,User $usuario){
        $perfiles = Perfil::all();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar usuarios","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario para editar usuarios","completado");
        }
        return view('admin.mantenedores.usuarios.editar',[
            'perfiles' => $perfiles,
            'usuario' => $usuario
        ]);
    }

    /**
    *@group Mantenedor de Usuarios
    *Creacion de producto primaria
    *
    *
    *@response {
    *"view": "admin/mantenedores/clases/editar.blade.php",
    *}
    */
    public function createUsuario(Request $request){
        $datos = $request->validate([
            'nombre' => ['required','min:3'],
            'email' => ['required','unique:App\Models\User,email'],
            'password' => 'required|string|min:8|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[.!@%^&*-]).{9,}$/',
            'perfil' => ['required','integer']
        ]);
        $usuario = User::create([
            'name' => $datos['nombre'],
            'email' => $datos['email'],
            'perfil' => $datos['perfil'],
            'password' => Hash::make($request->password)
        ]);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Usuario " . $usuario->name . " creado con exito","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Usuario " . $usuario->name . " creado con exito","create");
        }
        return redirect()->route('admin.manUsuarios')->with('exito','¡Usuario de nombre '. $usuario->name .' agregad@ exitosamente!');
    }

    /**
    *@group Mantenedor de Usuarios
    *Creacion de producto primaria
    *
    *
    *@response {
    *"view": "admin/mantenedores/clases/editar.blade.php",
    *}
    */
    public function updateUsuario(Request $request, User $usuario){
        $datos = $request->validate([
            'nombre' => ['required','min:3'],
            'email' => ['required'],
            'perfil' => ['required','integer']
        ]);
        $usuario->update([
            'name' => $datos['nombre'],
            'email' => $datos['email'],
            'perfil' => $datos['perfil']
        ]);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Usuario " . $usuario->name . " editado con exito","update");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Usuario " . $usuario->name . " editado con exito","update");
        }
        return redirect()->route('admin.manUsuarios')->with('exito','¡Usuario de nombre '. $usuario->name .' editado exitosamente!');
    }

    /**
    *@group Mantenedor de Usuarios
    *AJAX: Inactivar producto
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function activadorUsuarios(Request $request){
        $usuario = User::find($request->id);
        if($usuario->activo == 1){
            $usuario->activo = 0;
            $usuario->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Usuario " . $usuario->name . " desactivado","delete");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Usuario " . $usuario->name . " desactivado","delete");
            }
            return response()->json(['success'=>'desactivado']);
        }
        elseif ($usuario->activo == 0) {
            $usuario->activo = 1;
            $usuario->save();
            if (!$request->session()->has('guest_uuid')) {
                $request->session()->put('guest_uuid',Str::uuid());
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Usuario " . $usuario->name . " activado","activado");
            }
            else{
                Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Usuario " . $usuario->name . " activado","activado");
            }
            return response()->json(['success'=>'activado']);
        }
        return response()->json(['failed'=>'error']);       
    }

    /**
    *@group Mantenedor para Personalizacion
    *
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function mantenedorPersonalizacion(Request $request){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de personalizacion del sitio","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de personalizacion del sitio","completado");
        }
        return view('admin.mantenedores.personalizacion');
    }

    /**
    *@group Mantenedor para Personalizacion
    *
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function cambiarBanner(Request $request){
        $datos = $request->validate(
            ['imgBanner' => ['required','image']],
            ['imgBanner.required' => 'Si desea cambiar la imagen debe seleccionar un archivo.',
            'imgBanner.image' => 'El archivo debe ser una imagen']
        );
        PersonalizacionController::cambiarBanner($request);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Banner del sitio cambiado","update");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Banner del sitio cambiado","update");
        }
        return redirect()->route('admin.manPersonalizacion')->with('exito','Se ha cambiado el banner.');;
    }

    /**
    *@group Mantenedor para Personalizacion
    *
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function cambiarLogo(Request $request){
        $datos = $request->validate(
            ['imgLogo' => ['required','image']],
            ['imgLogo.required' => 'Si desea cambiar la imagen debe seleccionar un archivo.',
            'imgLogo.image' => 'El archivo debe ser una imagen']
        );
        PersonalizacionController::cambiarLogo($request);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Logo del sitio cambiado","update");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Logo del sitio cambiado","update");
        }
        return redirect()->route('admin.manPersonalizacion')->with('exito','Se ha cambiado el logo.');
    }

    /**
    *@group Mantenedor para Personalizacion
    *
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function cambiarColorBtns(Request $request){
        $datos = $request->validate(
            ['colorBack' => ['required'],
            'colorFront' => ['required']
        ],
            ['colorBack.required' => 'Debe seleccionar un color para el boton.',
            'colorFront.required' => 'Debe seleccionar un color para el texto del boton.']
        );
        PersonalizacionController::cambiarColorBtns($request);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Color de los botones cambiado","update");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Color de los botones cambiado","update");
        }
        return redirect()->route('admin.manPersonalizacion')->with('exito','Se ha cambiado el color de los botones de la pagina principal.');
    }

    /**
    *@group Mantenedor para Integraciones
    *
    *
    *
    *@response {
    *"view": "admin/mantenedores/productos/editar.blade.php",
    *}
    */
    public function panelIntegraciones(Request $request){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el panel de integraciones con marketplaces","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el panel de integraciones con marketplaces","completado");
        }
        if($request->code != NULL || $request->state == 'clevermarket'){
            $intML = Integraciones::getIntegracionPorNombre('mercadolibre');
            $intML->code = $request->code;
            $resp = IntegracionesController::getMercadoLibreToken($intML->client_id,$intML->client_secret,$intML->code);
            $intML->access_token = $resp['access_token'];
            $intML->refresh_token = $resp['refresh_token'];
            $intML->save();
        }
        $integraciones = new Integraciones();
        return view('admin.integraciones',[
            'integraciones' => $integraciones
        ]);
    }

    /**
    *@group Mantenedor de Productos
     *Mantenedor de Productos
     *
     *@response {
     *"view": "admin/mantenedores/sillas.blade.php",
     *}
     */
    public function mantenedorAuditoria(Request $request){
        //Seteo de filtros para auditoria
        $filtros['usuario'] = $request->audit_email;
        $filtros['perfil'] = $request->audit_perfil;
        $filtros['modulo'] = $request->audit_modulo;
        $filtros['accion'] = $request->audit_accion;
        $filtros['estado'] = $request->audit_estado;
        $filtros['fechaini'] = $request->audit_fechaini;
        $filtros['fechahasta'] = $request->audit_fechahasta;
        $audits = Audit::paginateConFiltros($filtros);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de auditoria","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de auditoria","completado");
        }
        return view('admin.mantenedores.auditoria',[
            'audits' => $audits
        ]);
    }

    /**
    *@group Mantenedor de Ventas
     *Muestra el mantenedor de vents
     *
     *@response {
     *"view": "admin/mantenedores/sillas.blade.php",
     *}
    */
    public function mantenedorVentas(Request $request){
        $ventasPendientes = Venta::pendientes();
        $ventasDespachadas = Venta::despachadas();
        $ventasCerradas = Venta::cerradas();
        $couriers = Integraciones::getCouriers();
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de ventas","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el mantenedor de ventas","completado");
        }
        return view('admin.mantenedores.ventas',[
            'ventasPendientes' => $ventasPendientes,
            'ventasDespachadas' => $ventasDespachadas,
            'ventasCerradas' => $ventasCerradas,
            'couriers' => $couriers
        ]);
    }

}