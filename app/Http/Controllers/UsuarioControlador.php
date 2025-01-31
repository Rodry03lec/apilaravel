<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioControlador extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::get();
        return response()->json($usuarios, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name'      => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required'
            ]);

            $usuario           = new User();
            $usuario->name     = $request->name;
            $usuario->email    = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            DB::commit();
            return response()->json([
                'mensaje'=>'Usuario creado correctamente'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'=>$e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::findOrFail($id);
        return response()->json($usuario, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$id
        ]);

        try {
            $usuario           = User::findOrFail($id);
            $usuario->name     = $request->name;
            $usuario->email    = $request->email;
            if(isset($request->password)){
                $usuario->password = Hash::make($request->password);
            }
            $usuario->update();
            DB::commit();

            return response()->json([
                'mensaje'=>'Usuario actualizado correctamente'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'=>$e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);
        //$usuario->delete();
        return response()->json([
            'mensaje'=>'Usuario eliminado correctamente'
        ], 200);
    }
}
