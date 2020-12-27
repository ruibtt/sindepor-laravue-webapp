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
            ['nome' => ['required']]
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
        // Alteração do método para atualizar o registo do Sócio
        // ver: https://doc.laravue.dev/guide/development/work-with-resource.html#update-resource

        // Se não recebeu o objecto $socio dá erro 404
        if ($socio === null) {
            return response()->json(['error' => 'Sócio não definido!'], 404);
        }

        // Valida os campos do Request
        // Se não tem o nome, então não Valida
        $validator = Validator::make(
            $request->all(),
            [
                'nome' => ['required']
            ]
        );

        // Se não Validou, então dá erro
        // Se validou bem, então retira os dados campos do Request, cria novo objecto Socio
        // e passa os dados para o objecto. Faz depois o save através do Model do Socio
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $socio->nome = $params['nome'];
            $socio->num_socio = $params['num_socio'];
            $socio->regiao = $params['regiao'];
            $socio->local_trabalho = $params['local_trabalho'];
            $socio->save();
        }

        // Envia o objecto para o Resource
        // Não sei bem o que faz o Resource
        // penso que aplica alguma lógica de negócio
        return new SocioResource($socio);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Socio  $socio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socio $socio)
    {
        // Alteração do método para eliminar o registo do Sócio
        // ver: https://doc.laravue.dev/guide/development/work-with-resource.html#delete-resource
        
        // Tenta eliminar o registo
        // Caso tenha insucesso, devolve um erro
        try {
            $socio->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
