<?php

namespace App\Http\Controllers;

//use App\Http\Requests\StorePessoaRequest;
//use App\Http\Requests\UpdatePessoaRequest;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Validation\Rule;


class PessoaController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoa = DB::table('pessoa')
            ->select('pessoa.pes_nome', 'pessoa.pes_data_nascimento', 'pessoa.pes_sexo', 'pessoa.pes_mae', 'pessoa.pes_pai')
            ->paginate(15);
        return response()->json([
            'Pessoas' => $pessoa
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatePessoa = Validator::make($request->all(), 
            [
                'pes_nome' => 'required|max:200',
                'pes_data_nascimento' => ['required', 'date', Rule::date()->before(today()->subYears(18))
                ],
                'pes_sexo' => 'required|max:9',
                'pes_mae' => 'required|max:200',
                'pes_pai' => 'required|max:200'
            ]);

            if($validatePessoa->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validatePessoa->errors()
                ], 401);
            }

            $pessoa = Pessoa::create([
            'pes_nome' => $request->pes_nome,
            'pes_data_nascimento' => Carbon::parse($request->pes_data_nascimento)->toDateString(),
            'pes_sexo' => $request->pes_sexo,
            'pes_mae' => $request->pes_mae,
            'pes_pai' => $request->pes_pai,
            ]);
            return response()->json([
                "message" => "Pessoa criada com sucesso"
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
        $pessoa = DB::table('pessoa')->where('pes_id', $id)->first();
        
        return response()->json([
            "Pessoa" => $pessoa
        ]);
    }

    public function update(Request $request, $id)
    {
        
        try {
            $validatePessoa = Validator::make($request->all(), 
            [
                'pes_nome' => 'required|max:200',
                'pes_data_nascimento' => ['required', 'date', Rule::date()->before(today()->subYears(18))
                ],
                'pes_sexo' => 'required|max:9',
                'pes_mae' => 'required|max:200',
                'pes_pai' => 'required|max:200'
            ]);

            if($validatePessoa->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validatePessoa->errors()
                ], 401);
            }

            $pessoa = Pessoa::findOrFail($id); 
            $pessoa -> update([
            'pes_nome' => $request->pes_nome,
            'pes_data_nascimento' => Carbon::parse($request->pes_data_nascimento)->toDateString(),
            'pes_sexo' => $request->pes_sexo,
            'pes_mae' => $request->pes_mae,
            'pes_pai' => $request->pes_pai,
            ]); 

            return response()->json([
                "message" => "Pessoa alterada com sucesso"
            ], 201);

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }    
    }
}
