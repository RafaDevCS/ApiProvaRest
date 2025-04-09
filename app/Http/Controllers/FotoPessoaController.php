<?php

namespace App\Http\Controllers;

use App\Models\FotoPessoa;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Validation\Rule;
use Carbon\Carbon;



class FotoPessoaController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fotoP = DB::table('foto_pessoa')
            ->join('pessoa', 'pessoa.pes_id', '=', 'foto_pessoa.pes_id')
            ->select('pessoa.pes_nome', 'pessoa.pes_data_nascimento', 'pessoa.pes_sexo', 'pessoa.pes_mae', 'pessoa.pes_pai','foto_pessoa.*')
            ->paginate(10);
        return response()->json([
            'Lotação' => $fotoP
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'arq' => 'required|image',
            ]);
            $request->arq->store('.');
            $imagesUrl = Storage::disk('s3')->allFiles('');
            $i = 0;
            foreach($imagesUrl as $url){
                $urlImg[$i] = Storage::disk('s3')->url($url);
                $i++;
            }
            return response()->json([$urlImg]);

            $validateFP = Validator::make($request->all(), 
            [
                'pes_id' => 'required|exists:pessoa,pes_id',
                'ft_data' => 'required|date',
                'ft_bucket'=> 'required|max:50',
                'ft_hash' => 'required|max:50',
                
            ]);

            if($validateFP->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateFP->errors()
                ], 401);
            }


            $FotoPessoa = FotoPessoa::create([
                'pes_id' => $request->pes_id,
                'ft_data' => Carbon::parse($request->ft_data)->toDateString(),
                'ft_bucket'=> $request->ft_bucket,
                'ft_hash' => $request->ft_hash
            ]);

            return response()->json([
                "message" => "Foto criada com sucesso"
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
        $fotoP = DB::table('foto_pessoa')
            ->join('pessoa', 'pessoa.pes_id', '=', 'foto_pessoa.pes_id')
            ->select('pessoa.pes_nome', 'pessoa.pes_data_nascimento', 'pessoa.pes_sexo', 'pessoa.pes_mae', 'pessoa.pes_pai','foto_pessoa.*')
            ->where('foto_pessoa.ft_id', $id)->first();
        return response()->json([
            'Lotação' => $fotoP
        ]);
    }

    public function update(Request $request, $id)
    {
        
        try {
            $validateFP = Validator::make($request->all(), 
            [
                'pes_id' => 'required|exists:pessoa,pes_id',
                'ft_data' => 'required|date',
                'ft_bucket'=> 'required|max:50',
                'ft_hash' => 'required|max:50',
                
            ]);

            if($validateFP->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Formato dos dados incorreto',
                    'errors' => $validateFP->errors()
                ], 401);
            }

            $fotoPessoa = FotoPessoa::findOrFail($id);
            $fotoPessoa -> update([
                'pes_id' => $request->pes_id,
                'ft_data' => Carbon::parse($request->ft_data)->toDateString(),
                'ft_bucket'=> $request->ft_bucket,
                'ft_hash' => $request->ft_hash
            ]);

            return response()->json([
                "message" => "Foto atualizada com sucesso"
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
         
    }
}
