<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\SendMailing;
use App\Models\Audit;
use App\Models\Mailing;
use App\Models\Encuesta;
use App\Models\User;


class MarketingController extends Controller
{   
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
    *@group Marketing
    *Muestra el panel principal de creacion y envio de mailings
    *
    *
    */
    public function panelPublicidad(Request $request){
        $mailings = Mailing::paginate(30);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el dashboard de mailings.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el dashboard de mailings.","completado");
        }
        return view('admin.mark.publicidad',[
            'mailings' => $mailings
        ]);
    }

    /**
    *@group Marketing
    *Muestra el panel principal de creacion de encuestas
    *
    *
    */
    public function panelEncuestas(Request $request){
        $encuestas = Encuesta::paginate(30);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el dashboard de encuestas.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el dashboard de encuestas.","completado");
        }
        return view('admin.mark.encuestas',[
            'encuestas' => $encuestas
        ]);
    }

    /**
    *@group Marketing
    *Muestra el formulario para creacion de mailings
    *
    *
    */
    public function formCreateMailPub(Request $request){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario de creacion de mailings.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario de creacion de mailings.","completado");
        }
        return view('admin.mark.publicidad.agregar');
    }

    /**
    *@group Marketing
    *Guarda el mailing creado en la base de datos
    *
    *
    */
    public function createMailPub(Request $request){
        $request->validate([
            'nombre' => ['required','min:3','unique:App\Models\Mailing,nombre']
        ]);
        $radioHeader = $request->radio_Header;
        $radioBody = $request->radio_Body;
        $radioFooter = $request->radio_Footer;
        switch($radioHeader){
            case "0":
                $headerM = "";
                break;
            case "1":
                $headerM = $request->textareaHeader;
                break;
            case "2":
                $headerM = $request->imgHeader->store('mailings','public');
                $headerM = 'storage/' . $headerM;
                break;
        }
        switch($radioBody){
            case "1":
                $bodyM = $request->textareaBody;
                break;
            case "2":
                $bodyM = $request->imgBody->store('mailings','public');
                $bodyM = 'storage/' . $bodyM;
                break;
        }
        switch($radioFooter){
            case "0":
                $footerM = "";
                break;
            case "1":
                $footerM = $request->textareaFooter;
                break;
            case "2":
                $footerM = $request->imgFooter->store('mailings','public');
                $footerM = 'storage/' . $footerM;
                break;
        }
        $headerJson = json_encode([$radioHeader,$headerM]);
        $bodyJson = json_encode([$radioBody,$bodyM]);
        $footerJson = json_encode([$radioFooter,$footerM]);
        $mailing = Mailing::create([
            'nombre' => $request->nombre,
            'header' => $headerJson,
            'body' => $bodyJson,
            'footer' => $footerJson
        ]);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Creacion de nuevo mailing.","create");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Creacion de nuevo mailing.","create");
        }
        return redirect()->route('admin.emailPublicidad')->with('exito','¡'. $mailing->nombre .' agregad@ exitosamente!');
    }

    /**
    *@group Marketing
    *Muestra el formulario para edición de mailings
    *
    *
    */
    public function formEditMailPub(Request $request,Mailing $mailing){
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario de creacion de mailings.","completado");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Muestra el formulario de creacion de mailings.","completado");
        }
        return view('admin.mark.publicidad.agregar',[
            'mailing' => $mailing
        ]);
    }

    /**
    *@group Marketing
    *Guarda el mailing editado en la base de datos
    *
    *
    */
    public function editMailPub(Request $request,Mailing $mailing){
        $request->validate([
            'nombre' => ['required','min:3']
        ]);
        $radioHeader = $request->radio_Header;
        $radioBody = $request->radio_Body;
        $radioFooter = $request->radio_Footer;
        switch($radioHeader){
            case "0":
                $headerM = "";
                break;
            case "1":
                $headerM = $request->textareaHeader;
                break;
            case "2":
                $headerM = $request->imgHeader->store('mailings','public');
                $headerM = 'storage/' . $headerM;
                break;
        }
        switch($radioBody){
            case "1":
                $bodyM = $request->textareaBody;
                break;
            case "2":
                $bodyM = $request->imgBody->store('mailings','public');
                $bodyM = 'storage/' . $bodyM;
                break;
        }
        switch($radioFooter){
            case "0":
                $footerM = "";
                break;
            case "1":
                $footerM = $request->textareaFooter;
                break;
            case "2":
                $footerM = $request->imgFooter->store('mailings','public');
                $footerM = 'storage/' . $footerM;
                break;
        }
        $headerJson = json_encode([$radioHeader,$headerM]);
        $bodyJson = json_encode([$radioBody,$bodyM]);
        $footerJson = json_encode([$radioFooter,$footerM]);
        $mailing->update([
            'nombre' => $request->nombre,
            'header' => $headerJson,
            'body' => $bodyJson,
            'footer' => $footerJson
        ]);
        if (!$request->session()->has('guest_uuid')) {
            $request->session()->put('guest_uuid',Str::uuid());
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Edición del mailing ". $mailing->nombre.".","edit");
        }
        else{
            Audit::guardar($request->session()->get('guest_uuid'),class_basename($this),"Edición del mailing ". $mailing->nombre.".","edit");
        }
        return redirect()->route('admin.emailPublicidad')->with('exito','¡'. $mailing->nombre .' editad@ exitosamente!');
    }

    public function formSendMailing(Request $request,Mailing $mailing){

    }

    /**
    *@group Marketing
    *Envía el mailing seleccionado
    *
    *
    */
    public function sendMailing(Request $request){
        $mailing = Mailing::find($request->mailing);
        foreach(User::getActivos() as $user){
            $emails[] = $user->email;
        }
        switch(json_decode($mailing->header)[0]){
            case "0":
                $headerM = "";
                break;
            case "1":
                $headerM = json_decode($mailing->header)[1];
                break;
            case "2":
                $headerM = "<img id='headerImg' style='max-height:150px;margin-left:auto;margin-right:auto' src='".asset(json_decode($mailing->header)[1])."'> ";
                break;
        }
        switch(json_decode($mailing->body)[0]){
            case "0":
                $bodyM = "";
                break;
            case "1":
                $bodyM = json_decode($mailing->body)[1];
                break;
            case "2":
                $bodyM = "<img id='headerImg' style='max-height:150px;margin-left:auto;margin-right:auto' src='".asset(json_decode($mailing->body)[1])."'> ";
                break;
        }
        switch(json_decode($mailing->footer)[0]){
            case "0":
                $footerM = "";
                break;
            case "1":
                $footerM = json_decode($mailing->footer)[1];
                break;
            case "2":
                $footerM = "<img id='headerImg' style='max-height:150px;margin-left:auto;margin-right:auto' src='".asset(json_decode($mailing->footer)[1])."'> ";
                break;
        }
        SendMailing::dispatch($headerM,$bodyM,$footerM,$emails);
        return redirect()->route('admin.emailPublicidad')->with('exito','El mail de nombre "'. $mailing->nombre .'" esta siendo enviado a los usuarios.');
        return view('mail.marketing.mailing',[
            'headerM' => $headerM,
            'bodyM' => $bodyM,
            'footerM' => $footerM
        ]);
        dd($headerM,$bodyM,$footerM);
        dd($emails);
    }

    public function formCreateEncuesta(Request $request){
        return view('admin.mark.encuestas.agregar');
    }

    public function createEncusta(Request $request){

    }
}
