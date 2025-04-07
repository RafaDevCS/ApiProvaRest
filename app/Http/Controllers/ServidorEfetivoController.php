<?php

namespace App\Http\Controllers;

use App\Models\ServidorEfetivo;
use App\Models\Unidade;
use App\Models\Endereco;
use App\Models\Pessoa;
use App\Models\Lotacao;
use App\Models\Cidade;
use App\Models\FotoPessoa;
use App\Models\PessoaEndereco;
use App\Models\UnidadeEndereco;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class ServidorEfetivoController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servidorEfetivo = DB::table('pessoa')
            ->join('servidor_efetivo', 'servidor_efetivo.pes_id', '=', 'pessoa.pes_id')
            ->join('lotacao', 'lotacao.pes_id', '=', 'pessoa.pes_id' )
            ->join('unidade', 'unidade.unid_id', '=', 'lotacao.unid_id' )
            ->join('pessoa_endereco', 'pessoa_endereco.pes_id', '=', 'pessoa.pes_id')
            ->join('endereco', 'endereco.end_id', '=', 'pessoa_endereco.pes_id')
            ->join('cidade', 'cidade.cid_id', '=', 'endereco.cid_id')
            ->join('foto_pessoa', 'foto_pessoa.pes_id', '=', 'pessoa.pes_id')
            ->select('pessoa.pes_nome', 'pessoa.pes_data_nascimento', 'pessoa.pes_sexo', 'pessoa.pes_mae', 'pessoa.pes_pai', 'endereco.end_tipo_logradouro',
                      'endereco.end_logradouro', 'endereco.end_numero', 'endereco.end_bairro','cidade.cid_nome', 'cidade.cid_uf','servidor_efetivo.se_matricula', 'lotacao.lot_data_lotacao', 'lotacao.lot_data_remocao', 'lotacao.lot_portaria', 'unidade.unid_nome', 'unidade.unid_sigla', 'foto_pessoa.ft_data', 'foto_pessoa.ft_bucket', 'foto_pessoa.ft_hash')
            ->paginate(10);
        return response()->json([
            'Servidores Efetivo' => $servidorEfetivo
        ]);
    }

    
    public function store(Request $request)
    {
        try {
            $validateServidor = Validator::make($request->all(), 
            [
                'unid_id' => 'required|exists:unidade,unid_id',
                'lot_data_lotacao' => ['required', 'date', 
                    Rule::date()->beforeOrEqual(today()),
                ],
                'lot_data_remocao' => ['required', 'date', 
                    Rule::date()->after(today()),
                ],
                'lot_portaria' => 'required|max:100|String',
                'pes_nome' => 'required|max:200',
                'pes_data_nascimento' => ['required', 'date', Rule::date()->before(today()->subYears(18))
                ],
                'pes_sexo' => 'required|max:9',
                'pes_mae' => 'required|max:200',
                'pes_pai' => 'required|max:200',
                'se_matricula' => 'required|max:20',
                'end_tipo_logradouro' => 'required|max:50|String',
                'end_logradouro' => 'required|max:200|String',
                'end_numero' => 'required|Integer',
                'end_bairro'=> 'required|max:100|String',
                'cid_id' => 'required|exists:cidade,cid_id',
                'ft_data' => 'required|date',
                'ft_bucket'=> 'required|max:50',
                'ft_hash' => 'required|max:50',
            ]);

            if($validateServidor->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateServidor->errors()
                ], 401);
            }

            $pessoa = Pessoa::create([
            'pes_nome' => $request->pes_nome,
            'pes_data_nascimento' => Carbon::parse($request->pes_data_nascimento)->toDateString(),
            'pes_sexo' => $request->pes_sexo,
            'pes_mae' => $request->pes_mae,
            'pes_pai' => $request->pes_pai,
            ]);
return response()->json([$pessoa]);
            $FotoPessoa = FotoPessoa::create([
                'pes_id' => $pessoa->pes_id,
                'ft_data' => Carbon::parse($request->ft_data)->toDateString(),
                'ft_bucket'=> $request->ft_bucket,
                'ft_hash' => $request->ft_hash
            ]);

            $servidor = ServidorEfetivo::create([
                'pes_id' => $pessoa->pes_id,
                'se_matricula' => $request->se_matricula,
            ]);

            $lotacao = Lotacao::create([
                'pes_id' => $pessoa->pes_id,
                'unid_id' => $request->unid_id,
                'lot_data_lotacao' => Carbon::parse($request->lot_data_lotacao)->toDateString(),
                'lot_data_remocao'=> Carbon::parse($request->lot_data_remocao)->toDateString(),
                'lot_portaria' => $request->lot_portaria
            ]);



            $endereco = Endereco::create([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro'=> $request->end_bairro,
                'cid_id' => $request->cid_id
            ]);


            $pessoaEnd = PessoaEndereco::create([
                'pes_id' => $pessoa->pes_id,
                'end_id' => $endereco->end_id
            ]);

            return response()->json([
                "mensagem" => "Servidor Efetivo criado com sucesso"
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
