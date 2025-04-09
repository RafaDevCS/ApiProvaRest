<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{
    use HasApiTokens;
    
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'mensage' => 'Usuário Criado com Sucesso',
                'token:Acesso' => $user->createToken("TOKEN", ['acesso'], now()->addminutes(5)
                )->plainTextToken,
                'token:Admin' => $user->createToken("TOKEN", ['admin'], now()->addDays(7)
                )->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function renovarToken()
    {
        if(!$user = Auth::user()){
            return response()->json([
                'status' => false,
                'message' => 'Usuário não logado',
            ], 401);
        }
        
        if($id){
            return response()->json([$id]);
        }
        return response()->json([
            'status' => 'successo',
            'message' => 'Sua chave foi renovada',
            'token:Acesso' => $user->createToken("TOKEN", ['acesso'], now()->addminutes(5)
            )->plainTextToken
        ], 200);

    }
    public function renovarTokenId($id)
    {
        if(!$user = Auth::user()){
            return response()->json([
                'status' => false,
                'message' => 'Usuário não logado',
            ], 401);
        }
        
        $user = Auth::user();
        $user->tokens()->where('id', $id)->delete();
        return response()->json([
            'status' => 'successo',
            'message' => 'Sua nova chave foi registrada',
            'token:Acesso' => $user->createToken("TOKEN", ['acesso'], now()->addminutes(5)
            )->plainTextToken
        ], 200);

    }
    
    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password não encontrado',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}