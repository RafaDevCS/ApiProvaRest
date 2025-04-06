<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;


class CidadeController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cidade = DB::table('cidade')->paginate(10);
        return response()->json([
            'Cidades' => $cidade
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validateCidade = Validator::make($request->all(), 
            [
                'cid_nome' => 'required|String',
                'cid_uf' => 'required|max:2|String'
            ]);

            if($validateCidade->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateCidades->errors()
                ], 401);
            }

            $cidade = Cidade::create([
                'cid_nome' => $request->cid_nome,
                'cid_uf' => $request->cid_uf,
            ]);

            return response()->json([
                "message" => "Cidade criada com sucesso"
            ], 201);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cidade = DB::table('cidade')->where('cid_id', $id)->first();
        
        return response()->json([
            "Cidade" => $cidade
        ]);
    }

    public function update(Request $request, $id)
    {
        
        try {
            $validateCidade = Validator::make($request->all(), 
            [
                'cid_nome' => 'required|String',
                'cid_uf' => 'required|max:2|String'
            ]);

            if($validateCidade->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateCidades->errors()
                ], 401);
            }
            $cidade = Cidade::findOrFail($id);
            
            $cidade -> update([
                'cid_nome' => $request->cid_nome,
                'cid_uf' => $request->cid_uf,
            ]);

            return response()->json([
                "message" => "Cidade atualizada com sucesso"
            ], 201);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
