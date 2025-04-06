<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\Endereco;
use App\Models\UnidadeEndereco;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;


class UnidadeEnderecoController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidadeEnd = DB::table('unidade_endereco')
            ->join('unidade', 'unidade.unid_id', '=', 'unidade_endereco.unid_id')
            ->join('endereco', 'endereco.end_id', '=', 'unidade_endereco.end_id' )
            ->join('cidade', 'cidade.cid_id', '=', 'endereco.end_id' )
            ->select('endereco.end_tipo_logradouro',
                      'endereco.end_logradouro', 'endereco.end_numero', 'endereco.end_bairro','cidade.cid_nome', 'cidade.cid_uf', 'unidade.unid_nome', 'unidade.unid_sigla')
            ->paginate(10);
        return response()->json([
            'Unidades' => $unidadeEnd
        ]);
    }

    
    public function store(Request $request)
    {
        try {
            $validateUnidadeEnd = Validator::make($request->all(), 
            [
                'unid_nome' => 'required',
                'unid_sigla' => 'required|max:20',
                'end_tipo_logradouro' => 'required|max:50|String',
                'end_logradouro' => 'required|max:200|String',
                'end_numero' => 'required|Integer',
                'end_bairro'=> 'required|max:100|String',
                'cid_id' => 'required|exists:cidade,cid_id',
            ]);

            if($validateUnidadeEnd->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateUnidadeEnd->errors()
                ], 401);
            }

            $unidade = Unidade::create([
                'unid_nome' => $request->unid_nome,
                'unid_sigla' => $request->unid_sigla,
            ]);

            $endereco = Endereco::create([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro'=> $request->end_bairro,
                'cid_id' => $request->cid_id
            ]);

            $unidaEnd = UnidadeEndereco::create([
                'unid_id' => $unidade->unid_id,
                'end_id' => $endereco->end_id
            ]);

            return response()->json([
                "mensagem" => "Unidade com endereço criada com sucesso"
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
        
        $unidadeEnd = DB::table('unidade_endereco')
            ->join('unidade', 'unidade.unid_id', '=', 'unidade_endereco.unid_id')
            ->join('endereco', 'endereco.end_id', '=', 'unidade_endereco.end_id' )
            ->join('cidade', 'cidade.cid_id', '=', 'endereco.end_id' )
            ->select('endereco.end_tipo_logradouro',
                      'endereco.end_logradouro', 'endereco.end_numero', 'endereco.end_bairro','cidade.cid_nome', 'cidade.cid_uf', 'unidade.unid_nome', 'unidade.unid_sigla')
            ->where('unidade_endereco.unid_id', $id)->first();
        return response()->json([
            'Unidades' => $unidadeEnd
        ]);
    }

    public function update(Request $request, $id)
    {
        
        try {
            $validateUnidadeEnd = Validator::make($request->all(), 
            [
                'unid_nome' => 'required',
                'unid_sigla' => 'required|max:20',
                'end_tipo_logradouro' => 'required|max:50|String',
                'end_logradouro' => 'required|max:200|String',
                'end_numero' => 'required|Integer',
                'end_bairro'=> 'required|max:100|String',
                'cid_id' => 'required|exists:cidade,cid_id',
            ]);

            if($validateUnidadeEnd->fails()){
                return response()->json([
                    'status' => false,
                    'mensage' => 'Formato dos dados incorreto',
                    'errors' => $validateUnidadeEnd->errors()
                ], 401);
            }
            $unidadeEnd = UnidadeEndereco::findOrFail($id);

            $unidade = Unidade::findOrFail($unidadeEnd->unid_id);
            $unidade -> update([
                'unid_nome' => $request->unid_nome,
                'unid_sigla' => $request->unid_sigla,
            ]);

            $endereco = Endereco::findOrFail($unidadeEnd->end_id);
            $endereco -> update([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro'=> $request->end_bairro,
                'cid_id' => $request->cid_id
            ]);

            return response()->json([
                "mensagem" => "Unidade com endereço atualizada com sucesso"
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
        $uniend = UnidadeEndereco::findOrFail($id);
        $unidadeEnd = DB::table('unidade_endereco')
            ->where('unid_id', $id)->delete();
        $endereco = DB::table('endereco')
            ->where('end_id', $uniend->end_id)->delete();    
        $unidade = DB::table('unidade')
            ->where('unid_id', $id)->delete();
        return response()->json([
            'Quantidade de Lotação deletada' => $unidadeEnd + $endereco + $unidade
        ]); 
    }
}
