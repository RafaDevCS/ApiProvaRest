<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Sanctum\HasApiTokens;

class PessoaController extends Controller
{
    use HasApiTokens;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    //public function store(StorePessoaRequest $request)
    public function store(Request $request)
    {
        $pessoa = Pessoa::create([
            'pes_nome' => $request->pes_nome,
            'pes_data_nascimento' => $request->pes_data_nascimento,
            'pes_sexo' => $request->pes_sexo,
            'pes_mae' => $request->pes_mae,
            'pes_pai' => $request->pes_pai,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pessoa $pessoa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pessoa $pessoa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePessoaRequest $request, Pessoa $pessoa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pessoa $pessoa)
    {
        //
    }
}
