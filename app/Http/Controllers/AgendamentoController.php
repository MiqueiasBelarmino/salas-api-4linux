<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendamentoRequest;
use App\Models\Agendamento;
use App\Models\Sala;

class AgendamentoController extends Controller
{
    public $totalPorPagina = 15;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

         /**
     * @OA\Post(
     *      path="/agendamentos",
     *      tags={"Agendamentos"},
     *      summary="Busca os agendamentos",
     *      description="Retorna todos os agendamentos",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     )
     */
    public function index()
    {
        $agendamentos = Agendamento::join('salas','agendamentos.sala_id','=','salas.id')
        ->select('salas.id','salas.nome','salas.capacidade','agendamentos.data_inicio as dataInicio','agendamentos.data_termino as dataTermino')
        ->orderBy('agendamentos.data_inicio','ASC')
        ->paginate($this->totalPorPagina);

        return response()->json($agendamentos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/agendamentos/{sala_id}",
     *      tags={"Agendamentos"},
     *      summary="Reserva uma sala",
     *      description="Retorna um status referente a reserva",
     *      @OA\Parameter(
     *          parameter="sala_id",
     *          name="sala_id",
     *          description="O id da sala a ser reservada",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          in="header",
     *          required=true
     *      ),
     *      @OA\Parameter(
     *          parameter="data_inicio",
     *          name="data_inicio",
     *          description="A data inicial da reserva",
     *          @OA\Schema(
     *              type="date"
     *          ),
     *          in="header",
     *          required=true
     *      ),
     *      @OA\Parameter(
     *          parameter="data_termino",
     *          name="data_termino",
     *          description="A data de término da reserva",
     *          @OA\Schema(
     *              type="date"
     *          ),
     *          in="header",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     )
     */
    public function store(AgendamentoRequest $request)
    {

        if (!Sala::where('id', $request->sala_id)->exists()) {
            return response()->json([
                "message" => "Sala não encontrada",
                "status" => false
            ], 404);
        } else if (Agendamento::where('sala_id', $request->sala_id)
                    ->whereYear('data_inicio','=',date('Y',strtotime($request->data_inicio)))
                    ->whereMonth('data_inicio','=',date('m',strtotime($request->data_inicio)))
                    ->whereDay('data_inicio','<=',date('d',strtotime($request->data_inicio)))
                    ->whereTime('data_inicio','<=',date('H:i:s',strtotime($request->data_inicio)))
                    ->whereYear('data_termino','=',date('Y',strtotime($request->data_inicio)))
                    ->whereMonth('data_termino','=',date('m',strtotime($request->data_inicio)))
                    ->whereDay('data_termino','=',date('d',strtotime($request->data_inicio)))
                    ->whereTime('data_termino','>=',date('H:i:s',strtotime($request->data_inicio)))
                    ->count() > 0) {
            return response()->json([
                "message" => "Sala não disponível nesse período",
                "status" => false
            ], 200);
        } else {
            Agendamento::create($request->all());
            return response()->json([
                "message" => "Sala reservada!",
                "status" => true
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
}
