<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\UnidadeEndereco;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;


class UnidadeController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidade = DB::table('unidade')->paginate(10);
        return response()->json([
            'Unidades' => $unidade
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validateUnidade = Validator::make($request->all(), 
            [
                'unid_nome' => 'required',
                'unid_sigla' => 'required|max:20'
            ]);

            if($validateUnidade->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateUnidades->errors()
                ], 401);
            }

            $unidade = Unidade::create([
                'unid_nome' => $request->unid_nome,
                'unid_sigla' => $request->unid_sigla,
            ]);

            return response()->json([
                "message" => "Unidade criada com sucesso"
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
        $unidade = DB::table('unidade')->where('unid_id', $id)->first();
        
        return response()->json([
            "Unidade" => $unidade
        ]);
    }

    public function update(Request $request, $id)
    {
        
        try {
            $validateUnidade = Validator::make($request->all(), 
            [
                'unid_nome' => 'required',
                'unid_sigla' => 'required|max:20'
            ]);

            if($validateUnidade->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateUnidades->errors()
                ], 401);
            }

            $unidade = Unidade::findOrFail($id);
            $unidade -> update([
                'unid_nome' => $request->unid_nome,
                'unid_sigla' => $request->unid_sigla,
            ]);

            return response()->json([
                "message" => "Unidade atualizada com sucesso"
            ], 201);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }    
    }
    public function deleta($id)
    {
        $lotacao = DB::table('lotacao')
            ->where('lot_id', $id)
            ->delete();
        return response()->json([
            'Quantidade de Lotação deletada' => $lotacao
        ]); 
    }
}
