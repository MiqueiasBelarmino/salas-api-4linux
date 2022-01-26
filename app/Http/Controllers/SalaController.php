<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->nome) && isset($request->disponivel)){
            return response()->json(Sala::where('nome','LIKE','%'.$request->nome.'%')->whereDoesntHave('agendamentos')->paginate(15), 200);
        }else if(isset($request->nome)){
            return response()->json(Sala::where('nome','LIKE','%'.$request->nome.'%')->paginate(15), 200);
        }else if(isset($request->disponivel)){
            return response()->json(Sala::whereDoesntHave('agendamentos')->paginate(15), 200);
        }else{
            return response()->json(Sala::paginate(15), 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (empty($request->nome)) {
            return response()->json(['message'=>'O campo Nome deve ser preenchido!'], 200);
        } else if (empty($request->capacidade)) {
            return response()->json(['message'=>'O campo Capacidade deve ser preenchido!'], 200);
        } else if (intval($request->capacidade) < 1) {
            return response()->json(['message'=>'O campo Capacidade deve ser maior que zero!'], 200);
        }else {
            Sala::create($request->all());
            return response()->json([
                "message" => "Sala registrada!"
            ], 201);
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
                "message" => "Sala não encontrada!"
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
    public function update(Request $request, $id)
    {
        if (Sala::where('id', $id)->exists()) {
            $sala = Sala::where('id', $id)->get();
            $sala->update($request->all());
            return response()->json($sala, 200);
        } else {
            return response()->json([
                "message" => "Sala não encontrada!"
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
                "message" => "Sala não encontrada!"
            ], 404);
        }
    }
}
