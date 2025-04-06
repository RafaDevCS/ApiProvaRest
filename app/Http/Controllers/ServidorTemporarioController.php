<?php

namespace App\Http\Controllers;

use App\Models\ServidorTemporario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;


class ServidorTemporarioController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servidores = DB::table('servidor_temporario')
            ->join('pessoa', 'pessoa.pes_id', '=', 'servidor_temporario.pes_id')
            ->select('pessoa.pes_nome', 'pessoa.pes_data_nascimento', 'servidor_temporario.st_data_admissao','servidor_temporario.st_data_demissao', )
            ->paginate(10);
        return response()->json([
            'Servidores' => $servidores
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validateEndereco = Validator::make($request->all(), 
            [
                'pes_id' => 'required|max:50|String',
                'st_data_admissao' => 'required|max:50|String',
                'st_data_demissao' => 'required|max:50|String',
                'end_tipo_logradouro' => 'required|max:50|String',
                'end_logradouro' => 'required|max:200|String',
                'end_numero' => 'required|Integer',
                'end_bairro'=> 'required|max:100|String',
                'cid_id' => 'required|exists:cidade,cid_id',
            ]);

            if($validateEndereco->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateEndereco->errors()
                ], 401);
            }

            $endereco = Endereco::create([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro'=> $request->end_bairro,
                'cid_id' => $request->cid_id
            ]);

            return response()->json([
                "message" => "Endereco criada com sucesso"
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
        $endereco = DB::table('endereco')
            ->join('cidade', 'cidade.cid_id', '=', 'endereco.cid_id')
            ->select('endereco.end_tipo_logradouro',
                        'endereco.end_logradouro', 'endereco.end_numero', 'endereco.end_bairro','cidade.cid_nome', 'cidade.cid_uf')
            ->where('end_id', $id)->first();
        //$end = Endereco::findOrFail($id)->with('cidade');
        return response()->json([
            "Endereco" => $endereco
        ]);
    }

    public function update(Request $request, $id)
    {
        
        try {
            $validateEndereco = Validator::make($request->all(), 
            [
                'end_tipo_logradouro' => 'required|max:50|String',
                'end_logradouro' => 'required|max:200|String',
                'end_numero' => 'required|Integer',
                'end_bairro'=> 'required|max:100|String',
                'cid_id' => 'required|exists:cidade,cid_id',
            ]);

            if($validateEndereco->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateEndereco->errors()
                ], 401);
            }

            $endereco = Endereco::findOrFail($id);
            $endereco -> update([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro'=> $request->end_bairro,
                'cid_id' => $request->cid_id
            ]);

            return response()->json([
                "message" => "Endereco atualizado com sucesso"
            ], 201);
            

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
