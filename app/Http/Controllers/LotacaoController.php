<?php

namespace App\Http\Controllers;

use App\Models\Lotacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class LotacaoController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lotacao = DB::table('lotacao')
            ->join('pessoa', 'pessoa.pes_id', '=', 'lotacao.pes_id')
            ->join('unidade', 'unidade.unid_id', '=', 'lotacao.unid_id')
            ->select('lotacao.lot_data_lotacao', 'lotacao.lot_data_remocao', 'lotacao.lot_portaria', 'pessoa.pes_nome', 'pessoa.pes_data_nascimento', 'pessoa.pes_sexo', 'pessoa.pes_mae', 'pessoa.pes_pai', 'unidade.unid_nome', 'unidade.unid_sigla')
            ->paginate(10);
        return response()->json([
            'Lotação' => $lotacao
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validateLotacao = Validator::make($request->all(), 
            [
                'pes_id' => 'required|exists:pessoa,pes_id',
                'unid_id' => 'required|exists:unidade,unid_id',
                'lot_data_lotacao' => ['required', 'date', 
                    Rule::date()->beforeOrEqual(today()),
                ],
                'lot_data_remocao' => ['nullable', 'date', 
                    Rule::date()->after(today()),
                ],
                'lot_portaria' => 'required|max:100|String',
            ]);

            if($validateLotacao->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateLotacao->errors()
                ], 401);
            }


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


            return response()->json([
                "message" => "Lotação criada com sucesso"
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
        $lotacao = DB::table('lotacao')
            ->join('pessoa', 'pessoa.pes_id', '=', 'lotacao.pes_id')
            ->join('unidade', 'unidade.unid_id', '=', 'lotacao.unid_id')
            ->select('lotacao.lot_data_lotacao', 'lotacao.lot_data_remocao', 'lotacao.lot_portaria', 'pessoa.pes_nome', 'pessoa.pes_data_nascimento', 'pessoa.pes_sexo', 'pessoa.pes_mae', 'pessoa.pes_pai', 'unidade.unid_nome', 'unidade.unid_sigla')
            ->where('lot_id', $id)->first();
        return response()->json([
            'Lotação' => $lotacao
        ]);
    }

    public function update(Request $request, $id)
    {
        
        try {
            $validateLotacao = Validator::make($request->all(), 
            [
                'pes_id' => 'required|exists:pessoa,pes_id',
                'unid_id' => 'required|exists:unidade,unid_id',
                'lot_data_lotacao' => ['required', 'date', 
                    Rule::date()->beforeOrEqual(today()->subDays(7)),
                ],
                'lot_data_remocao' => ['required', 'date', 
                    Rule::date()->after(today()->subDays(7)),
                ],
                'lot_portaria' => 'required|max:100|String',
            ]);

            if($validateLotacao->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateLotacao->errors()
                ], 401);
            }

            $lotacao = Lotacao::findOrFail($id);
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

            return response()->json([
                "message" => "Lotação atualizada com sucesso"
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
