<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //para el inicio de session
    public function funLogin(Request $request){
        //validar datos
        $credenciales = $request->validate([
            "email" => "required|email",
            "password"=>"required"
        ]);
        //autenticar
        if(!Auth::attempt($credenciales)){
            return response()->json([
                "mensaje"=>"Credenciales Incorrectos"
            ], 401);
        }
        //generar token
        $token = $request->user()->createToken('Token Auth')->plainTextToken;
        //responder

        return response()->json([
            "access_token" => $token,
            "usuario"=>"usuario Autenticado con exito"
        ],201);
    }

    //para registrar
    public function funRegistrar(Request $request){
        //valirdar
        $request->validate([
            "name"  => "required|max:100|min:2|string",
            "email" => "required|email|unique:users,email",
            "password"=>"required|same:c_password"

        ]);
        //crear usuario
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password =  Hash::make($request->password);
        $usuario->save();
        //respuesta
        return response()->json([
            "mensaje"=>"Usuario Registrado"
        ], 201);
    }

    //para funPerfil
    public function funPerfil(Request $request) {
        return response()->json($request->user(), 200);
    }

    //para cerrar session
    public function funLogout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            "mensaje"=>"Se cerro la session"
        ]);
    }
}
