<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaRequest;
use Illuminate\Http\Request;
use App\Models\Sala;
use Exception;

class SalaController extends Controller
{
    private $totalPorPagina = 15;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/salas",
     *      tags={"Salas"},
     *      summary="Busca a lista de salas",
     *      description="Retorna a lista de salas",
     *      @OA\Parameter(
     *          parameter="nome",
     *          name="nome",
     *          description="O noma da sala para ser filtrado",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          in="header",
     *          required=false
     *      ),
     *      @OA\Parameter(
     *          parameter="disponivel",
     *          name="disponivel",
     *          description="Flag para filtrar apenas salas disponíveis",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          in="header",
     *          required=false
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
    public function index(Request $request)
    {
        if(isset($request->nome) && isset($request->disponivel)){
            $salas = Sala::where('nome','LIKE','%'.$request->nome.'%')->whereDoesntHave('agendamentos')->paginate($this->totalPorPagina);
        }else if(isset($request->nome)){
            $salas = Sala::where('nome','LIKE','%'.$request->nome.'%')
            // ->leftJoin('agendamentos', 'agendamentos.sala_id','=','salas.id')
            // ->select('salas.id','salas.nome','salas.capacidade','agendamentos.data_inicio as dataInicio','agendamentos.data_termino as dataTermino')
            ->paginate($this->totalPorPagina);
        }else if(isset($request->disponivel)){
            $salas = Sala::whereDoesntHave('agendamentos')
            ->paginate($this->totalPorPagina);
        }else{
            $salas = Sala::
            // leftJoin('agendamentos', 'agendamentos.sala_id','=','salas.id')
            // ->select('salas.id','salas.nome','salas.capacidade','agendamentos.data_inicio as dataInicio','agendamentos.data_termino as dataTermino')
            paginate($this->totalPorPagina);
        }

        return response()->json($salas, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/salas",
     *      tags={"Salas"},
     *      summary="Cria uma nova sala",
     *      description="Retorna a sala criada",
     *      @OA\Parameter(
     *          parameter="nome",
     *          name="nome da sala",
     *          description="Nome da sala a ser criada",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          in="header",
     *          required=true
     *      ),
     *      @OA\Parameter(
     *          parameter="capacidade",
     *          name="capacidade da sala",
     *          description="Capacidade da sala a ser criada",
     *          @OA\Schema(
     *              type="integer"
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

    /**
     * @OA\Get(
     *      path="/salas/{id}",
     *      tags={"Salas"},
     *      summary="Busca uma sala",
     *      description="Retorna uma sala por id",
     *      @OA\Parameter(
     *          parameter="id",
     *          name="id da sala",
     *          description="id da sala a ser mostrada",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          in="header",
     *          required=true
     *      ),
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
    /**
     * @OA\Put(
     *      path="/salas/{id}",
     *      tags={"Salas"},
     *      summary="Atualiza uma sala",
     *      description="Retorna a sala atualizada",
     *      @OA\Parameter(
     *          parameter="nome",
     *          name="nome da sala",
     *          description="Nome da sala a ser criada",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *          in="header",
     *          required=true
     *      ),
     *      @OA\Parameter(
     *          parameter="capacidade",
     *          name="capacidade da sala",
     *          description="Capacidade da sala a ser criada",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          in="header",
     *          required=true
     *      ),
     *      @OA\Parameter(
     *          parameter="id",
     *          name="id da sala",
     *          description="id da sala a ser atualizada",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          in="header",
     *          required=true
     *      ),
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
    /**
     * @OA\Delete(
     *      path="/salas/{id}",
     *      tags={"Salas"},
     *      summary="Deleta uma sala",
     *      description="Retorna a sala deletada",
     *      @OA\Parameter(
     *          parameter="id",
     *          name="id da sala",
     *          description="id da sala a ser deletada",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *          in="header",
     *          required=true
     *      ),
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
