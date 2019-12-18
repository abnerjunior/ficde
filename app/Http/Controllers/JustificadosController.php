<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersCollection;

use Illuminate\Http\Request;
use App\Models\justificados;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JustificadosController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $id_asistencia number id_asistencia
     * @return [Function]  function validator
     */
    private function validation($request, $id_asistencia)
    {
        if ($id_asistencia !== null) {
            $unique = Rule::unique('justificados')->ignore($request->id_asistencia, 'id_asistencia');
        } else {
            $unique = 'unique:justificados';
        }
        $validator = Validator::make($request->all(), [
            'fecha' => 'required',
            'tipo' => 'required',
            'id_asistencia' => ['required', $unique]
        ]);
        return $validator;
    }
    /**
     * @OA\Get(
     *   path="/justificados",
     *   summary="Lists available justificados",
     *   description="Gets all available justificados resources",
     *   tags={"justificados"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *       name="paginate",
     *       in="query",
     *       description="paginate",
     *       required=false,
     *       @OA\Schema(
     *           title="Paginate",
     *           example="true",
     *           type="boolean",
     *           description="The unique identifier of a justificados resource"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="dataSearch",
     *       in="query",
     *       description="justificados resource name",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           description="The unique identifier of a justificados resource"
     *       )
     *    ),
     *   @OA\Parameter(
     *       name="sortField",
     *       in="query",
     *       description="Sort field",
     *       required=false,
     *       @OA\Schema(
     *           title="name",
     *           type="string",
     *           example="name",
     *           description="The unique identifier of a justificados resource"
     *       )
     *    ),
     *   @OA\Parameter(
     *       name="sortOrder",
     *       in="query",
     *       description="Sort order field",
     *       @OA\Schema(
     *           title="sortOrder",
     *           example="asc",
     *           type="string",
     *           description="The unique identifier of a justificados resource"
     *       )
     *    ),
     *   @OA\Parameter(
     *       name="perPage",
     *       in="query",
     *       description="Sort order field",
     *       @OA\Schema(
     *           title="perPage",
     *           type="number",
     *           default="0",
     *           description="The unique identifier of a justificados resource"
     *       )
     *    ),
     * @OA\Parameter(
     *     name="authorization",
     *     in="header",
     *     description="authorization",
     *     @OA\Schema(
     *         title="authorization",
     *         type="string",
     *     )
     * ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="A list with justificados",
     *       @OA\Header(
     *       header="X-Auth-Token",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the justificados"
     *     ),
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=401,
     *       description="Unauthenticated."
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response="default",
     *       description="an ""unexpected"" error"
     *   ),
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $q = justificados::select();
        $justificados = justificados::search($request->toArray(), $q);
        return  new UsersCollection($justificados);
    }
    /**
     * @OA\Post(
     *   path="/justificados",
     *   summary="Creates a new justificados",
     *   description="Creates a new justificados",
     *   tags={"justificados"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/justificados")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The justificados resource created",
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=401,
     *       description="Unauthenticated."
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response="default",
     *       description="an ""unexpected"" error",
     *   )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($this->validation($request, null)->fails()) {
                $errors = $this->validation($request, null)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $justificados = new justificados();
                $justificados->id_asistencia = $request->id_asistencia;
                $justificados->fecha = $request->fecha;
                $justificados->tipo = $request->tipo;
                $justificados->status = $request->status;

                $justificados->user = $request->user;
                $justificados->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * @OA\Get(
     *   path="/justificados/{id_asistencia}",
     *   summary="Gets a justificados resource",
     *   description="Gets a justificados resource",
     *   tags={"justificados"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="id_asistencia",
     *   in="path",
     *   description="The justificados resource id_asistencia",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a justificados resource"
     *   )
     *   ),
     *   @OA\Response(
     *   @OA\MediaType(mediaType="application/json"),
     *   response=204,
     *   description="The resource has been deleted"
     *   ),
     *   @OA\Response(
     *   @OA\MediaType(mediaType="application/json"),
     *   response=401,
     *   description="Unauthenticated."
     *   ),
     *   @OA\Response(
     *   @OA\MediaType(mediaType="application/json"),
     *   response="default",
     *   description="an ""unexpected"" error"
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $id_asistencia
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id_asistencia)
    {
        /** esto es una consulta por la cedula */
        $justificados = justificados::where('id_asistencia', $id_asistencia)
            ->where('id_asistencia', $id_asistencia)
            ->first();
        if ($justificados) {
            return response()->json($justificados, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no inscrito'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/justificados/{id_asistencia}",
     *   summary="Updates a justificados resource",
     *   description="Updates a justificados resource by the id_asistencia",
     *   tags={"justificados"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="id_asistencia",
     *   in="path",
     *   description="justificados resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a justificados resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/justificados")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The justificados resource updated"
     *       ),
     *       @OA\Response(
     *           @OA\MediaType(mediaType="application/json"),
     *           response=401,
     *           description="Unauthenticated."
     *       ),
     *       @OA\Response(
     *           @OA\MediaType(mediaType="application/json"),
     *           response="default",
     *           description="an ""unexpected"" error"
     *       )
     *   )
     *
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id_asistencia
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_asistencia)
    {
        try {
            if ($this->validation($request, $id_asistencia)->fails()) {
                $errors = $this->validation($request, $id_asistencia)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $justificados = justificados::where('id_asistencia', $id_asistencia)
                    ->update([
                        'fecha' =>  $request->fecha,
                        'tipo' =>  $request->tipo,
                        'id_asistencia' =>  $request->id_asistencia,
                    ]);
                return response()->json($justificados, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    /**
     * @OA\Delete(
     *   path="/justificados/{dni}",
     *   summary="Removes a justificados resource",
     *   description="Removes a justificados resource",
     *   tags={"users"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The justificados resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a justificados resource"
     *   )
     *   ),
     *   @OA\Response(
     *   @OA\MediaType(mediaType="application/json"),
     *   response=204,
     *   description="The resource has been deleted"
     *   ),
     *   @OA\Response(
     *   @OA\MediaType(mediaType="application/json"),
     *   response=401,
     *   description="Unauthenticated."
     *   ),
     *   @OA\Response(
     *   @OA\MediaType(mediaType="application/json"),
     *   response="default",
     *   description="an ""unexpected"" error"
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param  int  $dni
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($dni)
    {
        $justificados = justificados::where('dni', $dni)
            ->where('status', 'y')
            ->first();
        if ($justificados) {
            justificados::where('dni', $dni)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'usuario eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuario not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
