<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

// File: app/Http/Controllers/CategoryController.php
use App\Http\Resources\SocioResource;
use App\Laravue\Models\Socio;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SocioController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SocioResource::collection(Socio::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Alterações para guardar os dados no registo
        $validator = Validator::make(
            $request->all(),
            [ 'nome' => ['required'] ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $socio = Socio::create([
                'nome' => $params['nome'],
                'num_socio' => $params['num_socio'],
                'regiao' => $params['regiao'],
                'local_trabalho' => $params['local_trabalho'],
            ]);
        }

        //Log::info($socio);
        
        return new SocioResource($socio);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function show(Socio $socio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function edit(Socio $socio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Socio $socio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socio $socio)
    {
        //
    }
}
