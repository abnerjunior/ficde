<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UsersCollection;

use App\Models\materias;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MateriasController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $descripcion number descripcion
     * @return [Function]  function validator
     */
    private function validation($request, $descripcion)
    {
        if ($descripcion !== null) {
            $unique = Rule::unique('materias')->ignore($request->descripcion, 'descripcion');
        } else {
            $unique = 'unique:materias';
        }
        $validator = Validator::make($request->all(), [
            'descripcion' => ['required', 'max:19', $unique]
        ]);
        return $validator;
    }

    /**
     * @OA\Get(
     *   path="/materias",
     *   summary="Lists available materias",
     *   description="Gets all available materias resources",
     *   tags={"materias"},
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
     *           description="The unique identifier of a User resource"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="dataSearch",
     *       in="query",
     *       description="User resource name",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           description="The unique identifier of a User resource"
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
     *           description="The unique identifier of a User resource"
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
     *           description="The unique identifier of a User resource"
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
     *           description="The unique identifier of a descripcion resource"
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
     *       description="A list with descripcion",
     *       @OA\Header(
     *       header="X-Auth-Token",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the user_r"
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
        $q = materias::select(
            'cursos.cod_curso',
            'cursos.curso',
            'materias.*'
        )->join('cursos', 'cursos.cod_curso','materias.cod_curso');
        $descripcion = materias::search($request->toArray(), $q, 'materias');
        return  new usersCollection($descripcion);
    }

    /**
     * @OA\Post(
     *   path="/materias",
     *   summary="Creates a new descripcion",
     *   description="Creates a new descripcion",
     *   tags={"materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/materias")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The descripcion resource created",
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
                $materias = new materias();
                $materias->cod_curso = $request->cod_curso;
                $materias->descripcion = $request->descripcion;
                $materias->materia = $request->materia;
                $materias->user_r = $request->user_r;
                $materias->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * @OA\Get(
     *   path="/materias/{descripcion}",
     *   summary="Gets a descripcion resource",
     *   description="Gets a descripcion resource",
     *   tags={"materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="descripcion",
     *   in="path",
     *   description="The descripcion resource descripcion",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a descripcion resource"
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
     * @param  int  $descripcion
     *
     * @return \Illuminate\Http\Response
     */
    public function show($descripcion)
    {
        /** esto es una consulta por la cedula */
        $materias = materias::where('descripcion', $descripcion)
            ->where('descripcion', $descripcion)
            ->first();
        if ($materias) {
            return response()->json($materias, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No existe este descripcion'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/materias/{descripcion}",
     *   summary="Updates a materias resource",
     *   description="Updates a materias resource by the descripcion",
     *   tags={"materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="descripcion",
     *   in="path",
     *   description="materias resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a materias resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/materias")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The materias resource updated"
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
     * @param  int  $descripcion
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $descripcion)
    {
        try {
            if ($this->validation($request, $descripcion)->fails()) {
                $errors = $this->validation($request, $descripcion)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $descripcion = materias::where('descripcion', $descripcion)
                    ->update([
                        'cod_curso' =>  $request->cod_curso,
                        'descripcion' =>  $request->descripcion,
                        'materia' =>  $request->materia,
                    ]);
                return response()->json($descripcion, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    /**
     * @OA\Delete(
     *   path="/materias/{dni}",
     *   summary="Removes a materias resource",
     *   description="Removes a materias resource",
     *   tags={"materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The materias resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a materias resource"
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
        $materias = materias::where('dni', $dni)
            ->where('status', 'y')
            ->first();
        if ($materias) {
            materias::where('dni', $dni)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'usuario eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuario not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
