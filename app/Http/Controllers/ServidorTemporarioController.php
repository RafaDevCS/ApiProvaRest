<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServidorTemporarioRequest;
use App\Http\Requests\UpdateServidorTemporarioRequest;
use App\Models\ServidorTemporario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ServidorTemporarioController extends Controller
{
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
    public function store(StoreServidorTemporarioRequest $request)
    {
        /*$serT = ServidorTemporario::create(
            'st_data_admissao'$request->admissao,
            'st_data_demissao'$request->demissao,
        );*/
    }

    /**
     * Display the specified resource.
     */
    //public function show(ServidorTemporario $servidorTemporario)
    public function show()
    {
        $serT = DB::table('servidor_temporario')->paginate(15);
        return response($serT, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServidorTemporario $servidorTemporario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServidorTemporarioRequest $request, ServidorTemporario $servidorTemporario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServidorTemporario $servidorTemporario)
    {
        //
    }
}
