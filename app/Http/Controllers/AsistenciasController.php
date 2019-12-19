<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersCollection;
use Illuminate\Http\Request;
use App\Models\asistencias;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AsistenciasController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $id_estudiante number id_estudiante
     * @return [Function]  function validator
     */

    private function validation($request, $id_estudiante)
    {
        if ($id_estudiante !== null) {
            $unique = Rule::unique('asistencias')->ignore($request->id_estudiante, 'id_estudiante');
        } else {
            $unique = 'unique:asistencias';
        }
        $validator = Validator::make($request->all(), [
            'id_estudiante' => 'required',
            'id_em' => 'required',
            'estatus' => 'required',
        ]);
        return $validator;
    }
    /**
     * @OA\Get(
     *   path="/asistencias",
     *   summary="Lists available asistencias",
     *   description="Gets all available asistencias resources",
     *   tags={"asistencias"},
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
     *           description="The unique identifier of a asistencias resource"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="dataSearch",
     *       in="query",
     *       description="asistencias resource name",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           description="The unique identifier of a asistencias resource"
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
     *           description="The unique identifier of a asistencias resource"
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
     *           description="The unique identifier of a asistencias resource"
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
     *           description="The unique identifier of a asistencias resource"
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
     *       description="A list with asistencias",
     *       @OA\Header(
     *       header="X-Auth-Token",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the asistencias"
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
        $q = asistencias::select();
        $asistencias = asistencias::search($request->toArray(), $q);
        return  new UsersCollection($asistencias);
    }

    /**
     * @OA\Post(
     *   path="/asistencias",
     *   summary="Creates a new asistencias",
     *   description="Creates a new asistencias",
     *   tags={"asistencias"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/asistencias")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The  resource created",
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
     *    */


    public function store(Request $request)
    {
        try {
            if ($this->validation($request, null)->fails()) {
                $errors = $this->validation($request, null)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $asistencias = new asistencias();
                $asistencias->id_estudiante = $request->id_estudiante;
                $asistencias->id_em = $request->id_em;
                $asistencias->estatus = $request->estatus;
                $asistencias->user = $request->user;
                $asistencias->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
        //
    }
    /**
     * @OA\Get(
     *   path="/asistencias/{id_estudiante}",
     *   summary="Gets a asistencias resource",
     *   description="Gets a asistencias resource",
     *   tags={"asistencias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="id_estudiante",
     *   in="path",
     *   description="The asistencias resource id_estudiante",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a asistencias resource"
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
     * @param  int  $id_estudiante
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id_estudiante)
    {
        $asistencias = asistencias::where('id_estudiante', $id_estudiante)
            ->where('id_estudiante', $id_estudiante)
            ->first();
        if ($asistencias) {
            return response()->json($asistencias, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'asistencias no registrada'], 404);
        }
        //
    }
    /**
     * @OA\Put(
     *   path="/asistencias/{id_estudiante}",
     *   summary="Updates a asistencias resource",
     *   description="Updates a asistencias resource by the id_estudiante",
     *   tags={"asistencias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="id_estudiante",
     *   in="path",
     *   description="asistencias resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a asistencias resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/asistencias")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The asistencias resource updated"
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
     * @param  int  $id_estudiante
     *
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id_estudiante)
    {
        try {
            if ($this->validation($request, $id_estudiante)->fails()) {
                $errors = $this->validation($request, $id_estudiante)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $asistencias = asistencias::where('id_estudiante', $id_estudiante)
                    ->update([
                        'id_estudiante' =>  $request->id_estudiante,
                        'id_em' =>  $request->registro,
                        'estatus' =>  $request->direccion,
                    ]);
                return response()->json($asistencias, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
        //
    }
    /**
     * @OA\Delete(
     *   path="/asistencias/{dni}",
     *   summary="Removes a asistencias resource",
     *   description="Removes a asistencias resource",
     *   tags={"asistencias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The asistencias resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a asistencias resource"
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
        $asistencias = asistencias::where('dni', $dni)
            ->where('status', 'y')
            ->first();
        if ($asistencias) {
            asistencias::where('dni', $dni)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'usuario eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuario not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
