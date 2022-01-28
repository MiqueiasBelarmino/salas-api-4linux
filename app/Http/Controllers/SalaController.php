<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaRequest;
use Illuminate\Http\Request;
use App\Models\Sala;
use Exception;

class SalaController extends Controller
{
    private $totalPorPagina = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->nome) && isset($request->disponivel)){
            $salas = Sala::where('nome','LIKE','%'.$request->nome.'%')->whereDoesntHave('agendamentos')->paginate($this->totalPorPagina);
        }else if(isset($request->nome)){
            $salas = Sala::where('nome','LIKE','%'.$request->nome.'%')
            ->leftJoin('agendamentos', 'agendamentos.sala_id','=','salas.id')
            ->select('salas.nome','salas.capacidade','agendamentos.data_inicio as dataInicio','agendamentos.data_termino as dataTermino')
            ->paginate($this->totalPorPagina);
        }else if(isset($request->disponivel)){
            $salas = Sala::whereDoesntHave('agendamentos')
            ->paginate($this->totalPorPagina);
        }else{
            $salas = Sala::leftJoin('agendamentos', 'agendamentos.sala_id','=','salas.id')
            ->select('salas.nome','salas.capacidade','agendamentos.data_inicio as dataInicio','agendamentos.data_termino as dataTermino')
            ->paginate($this->totalPorPagina);
        }

        return response()->json($salas, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaRequest $request)
    {
        try{
            Sala::create($request->all());
            return response()->json([
                "message" => "Sala registrada!",
                "status" => true
            ], 201);
        }catch(Exception $e){
            return response()->json([
                "message" => "Falha ao registrar Sala!",
                "status" => false
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Sala::where('id', $id)->exists()) {
            return response()->json(Sala::where('id', $id)->get(), 200);
        } else {
            return response()->json([
                "message" => "Sala não encontrada!",
                "status" => false
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalaRequest $request, $id)
    {
        if (Sala::where('id', $id)->exists()) {
            $sala = Sala::where('id', $id)->get();
            $sala->update($request->all());
            return response()->json($sala, 200);
        } else {
            return response()->json([
                "message" => "Sala não encontrada!",
                "status" => false
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Sala::where('id', $id)->exists()) {
            $sala = Sala::where('id', $id)->first();
            $sala->delete();
            return response()->json($sala, 200);
        } else {
            return response()->json([
                "message" => "Sala não encontrada!",
                "status" => false
            ], 404);
        }
    }
}
