<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PessoaController;
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
                'lot_data_remocao' => ['nullable', 'date', 
                    Rule::date()->after(today()),
                ],
                'lot_portaria' => 'required|max:100|String',
                'pes_nome' => 'required|max:200',
                'pes_data_nascimento' => ['required', 'date', Rule::date()->before(today()->subYears(18))
                ],
                'pes_sexo' => 'required|max:9',
                'pes_mae' => 'required|max:200',
                'pes_pai' => 'required|max:200',
                'se_matricula' => 'required|unique:servidor_efetivo,se_matricula|max:20',
                'end_tipo_logradouro' => 'required|max:50|String',
                'end_logradouro' => 'required|max:200|String',
                'end_numero' => 'required|Integer',
                'end_bairro'=> 'required|max:100|String',
                'cid_nome' => 'required|max:200',
                'cid_uf' => 'required|max:2',
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

            $FotoPessoa = FotoPessoa::create([
                'pes_id' => $pessoa->pes_id,
                'ft_data' => Carbon::parse($request->ft_data)->toDateString(),
                'ft_bucket'=> $request->ft_bucket,
                'ft_hash' => $request->ft_hash,
            ]);

            $servidor = ServidorEfetivo::create([
                'pes_id' => $pessoa->pes_id,
                'se_matricula' => $request->se_matricula,
            ]);

            if(!empty($request->lot_data_remocao)){
                $lotacao = Lotacao::create([
                    'pes_id' => $pessoa->pes_id,
                    'unid_id' => $request->unid_id,
                    'lot_data_lotacao' => Carbon::parse($request->lot_data_lotacao)->toDateString(),
                    'lot_data_remocao'=> Carbon::parse($request->lot_data_remocao)->toDateString(),
                    'lot_portaria' => $request->lot_portaria
                ]);
            }else{
               $lotacao = Lotacao::create([
                    'pes_id' => $pessoa->pes_id,
                    'unid_id' => $request->unid_id,
                    'lot_data_lotacao' => Carbon::parse($request->lot_data_lotacao)->toDateString(),
                    'lot_portaria' => $request->lot_portaria
                ]); 
            }   


            $cidade = Cidade::create([
                'cid_nome' => $request->cid_nome,
                'cid_uf' => $request->cid_uf,
            ]);

            $endereco = Endereco::create([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro'=> $request->end_bairro,
                'cid_id' => $cidade->cid_id,
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
            ->where('servidor_efetivo.pes_id', $id)->first();
        return response()->json([
            'Servidores Efetivo' => $servidorEfetivo
        ]);
    }

    public function buscarPorUnidade($id)
    {
        $servidorEfetivo = DB::table('pessoa')
            ->join('servidor_efetivo', 'servidor_efetivo.pes_id', '=', 'pessoa.pes_id')
            ->join('lotacao', 'lotacao.pes_id', '=', 'pessoa.pes_id' )
            ->join('unidade', 'unidade.unid_id', '=', 'lotacao.unid_id' )
            ->join('pessoa_endereco', 'pessoa_endereco.pes_id', '=', 'pessoa.pes_id')
            ->join('endereco', 'endereco.end_id', '=', 'pessoa_endereco.pes_id')
            ->join('cidade', 'cidade.cid_id', '=', 'endereco.cid_id')
            ->join('foto_pessoa', 'foto_pessoa.pes_id', '=', 'pessoa.pes_id')
            ->select('pessoa.pes_nome AS Nome', 'unidade.unid_nome AS Unidade de lotação','foto_pessoa.ft_hash AS Foto')
            ->selectRaw('EXTRACT(DAY FROM (now()-pes_data_nascimento)/365) AS Idade')
            ->where('unidade.unid_id', $id)->paginate(10);
        return response()->json([
            'Servidores por Unidade' => $servidorEfetivo
        ]);
    }

    public function enderecoFuncional($nome)
    {
        $pessoa = DB::table('pessoa')
            ->join('servidor_efetivo', 'servidor_efetivo.pes_id', '=', 'pessoa.pes_id')
            ->join('lotacao', 'lotacao.pes_id', '=', 'pessoa.pes_id' )
            ->join('unidade', 'unidade.unid_id', '=', 'lotacao.unid_id' )
            ->join('unidade_endereco', 'unidade_endereco.unid_id', '=', 'lotacao.unid_id')
            ->join('endereco', 'endereco.end_id', '=', 'unidade_endereco.end_id')
            ->join('cidade', 'cidade.cid_id', '=', 'endereco.cid_id')
            ->where('pessoa.pes_nome','ILIKE','%'.$nome.'%')
            ->select('pessoa.pes_nome AS Servidor','endereco.end_tipo_logradouro AS Tipo',
                      'endereco.end_logradouro AS Logradouro', 'endereco.end_numero AS Numero', 'endereco.end_bairro AS Bairro','cidade.cid_nome AS Cidade', 'cidade.cid_uf AS Estado')
            ->paginate(10);
        
        return response()->json(['Endereço Funcional' => $pessoa]);
    }

    public function update(Request $request, $id)
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
                'se_matricula' => 'required|exists:servidor_efetivo,se_matricula|max:20',
                'end_tipo_logradouro' => 'required|max:50|String',
                'end_logradouro' => 'required|max:200|String',
                'end_numero' => 'required|Integer',
                'end_bairro'=> 'required|max:100|String',
                'cid_nome' => 'required|max:200',
                'cid_uf' => 'required|max:2',
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

            $servidor = ServidorEfetivo::firstWhere('se_matricula', $request->se_matricula);
        
            $pessoa = Pessoa::findOrFail($servidor->pes_id);
            $pessoa->update([
            'pes_nome' => $request->pes_nome,
            'pes_data_nascimento' => Carbon::parse($request->pes_data_nascimento)->toDateString(),
            'pes_sexo' => $request->pes_sexo,
            'pes_mae' => $request->pes_mae,
            'pes_pai' => $request->pes_pai,
            ]);

            $fotoPessoa = FotoPessoa::firstWhere('pes_id', $servidor->pes_id);
            $fotoPessoa -> update([
                'pes_id' => $pessoa->pes_id,
                'ft_data' => Carbon::parse($request->ft_data)->toDateString(),
                'ft_bucket'=> $request->ft_bucket,
                'ft_hash' => $request->ft_hash,
            ]);

            $lotacao = Lotacao::firstWhere('pes_id', $servidor->pes_id);
            if(!empty($request->lot_data_remocao)){
                $lotacao -> update([
                    'pes_id' => $pessoa->pes_id,
                    'unid_id' => $request->unid_id,
                    'lot_data_lotacao' => Carbon::parse($request->lot_data_lotacao)->toDateString(),
                    'lot_data_remocao'=> Carbon::parse($request->lot_data_remocao)->toDateString(),
                    'lot_portaria' => $request->lot_portaria
                ]);
            }else{
               $lotacao -> update([
                    'pes_id' => $pessoa->pes_id,
                    'unid_id' => $request->unid_id,
                    'lot_data_lotacao' => Carbon::parse($request->lot_data_lotacao)->toDateString(),
                    'lot_portaria' => $request->lot_portaria
                ]); 
            }   

            $pessoaEnd = PessoaEndereco::firstWhere('pes_id', $servidor->pes_id);
            $endereco = Endereco::findOrFail($pessoaEnd->end_id);
            $endereco -> update([
                'end_tipo_logradouro' => $request->end_tipo_logradouro,
                'end_logradouro' => $request->end_logradouro,
                'end_numero' => $request->end_numero,
                'end_bairro'=> $request->end_bairro,
                'cid_id' => $endereco->cid_id,
            ]);

            $cidade = Cidade::findOrFail($endereco->cid_id);
            $cidade -> update([
                'cid_nome' => $request->cid_nome,
                'cid_uf' => $request->cid_uf,
            ]);

            return response()->json([
                "mensagem" => "Servidor Efetivo atualizado com sucesso"
            ], 201);
        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }    
    }
    public function deleta($matricula)
    {
        $servidor = ServidorEfetivo::firstWhere('se_matricula', $matricula);
        $pessoa = Pessoa::findOrFail($servidor->pes_id);
        $fotoPessoa = FotoPessoa::firstWhere('pes_id', $servidor->pes_id);
        $fotoP = DB::table('foto_pessoa')
            ->where('ft_id', $fotoPessoa->ft_id)
            ->delete();

        $pEnd = PessoaEndereco::firstWhere('pes_id', $servidor->pes_id);
        $end = Endereco::firstWhere('end_id', $pEnd->end_id);
        $endereco = DB::table('endereco')
            ->where('end_id', $end->end_id)
            ->delete();

        $lot = Lotacao::firstWhere('pes_id', $servidor->pes_id);
        $lotacao = DB::table('lotacao')
            ->where('lot_id', $lot->lot_id)
            ->delete();
        $pes = DB::table('pessoa')
            ->where('pes_id', $pessoa->pes_id)
            ->delete();
        $pesEnd = DB::table('pessoa_endereco')
            ->where('pes_id', $pEnd->pes_id)
            ->delete();

        $serEfetivo = DB::table('servidor_efetivo')
            ->where('se_matricula', $servidor->se_matricula)->delete();
        
        return response()->json([
            'Quantidade deletada' => $unidadeEnd + $endereco + $unidade
        ]); 
    }
}
