<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UsersCollection;

use App\Models\cursos;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CursosController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $curso number curso
     * @return [Function]  function validator
     */
    private function validation($request, $curso)
    {
        if ($curso !== null) {
            $unique = Rule::unique('cursos')->ignore($request->curso, 'curso');
        } else {
            $unique = 'unique:cursos';
        }
        $validator = Validator::make($request->all(), [
            'curso' => ['required', 'max:30', $unique]
        ]);
        return $validator;
    }

    /**
     * @OA\Get(
     *   path="/cursos",
     *   summary="Lists available cursos",
     *   description="Gets all available cursos resources",
     *   tags={"cursos"},
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
     *           description="The unique identifier of a curso resource"
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
     *       description="A list with curso",
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

        $q = cursos::select();
        $curso = cursos::search($request->toArray(), $q,'cursos');
        return  new usersCollection($curso);
    }

    /**
     * @OA\Post(
     *   path="/cursos",
     *   summary="Creates a new curso",
     *   description="Creates a new curso",
     *   tags={"cursos"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/cursos")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The curso resource created",
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
                $cursos = new cursos();
                $cursos->curso = $request->curso;
                $cursos->descripcion = $request->descripcion;
                $cursos->user_r = $request->user_r;
                $cursos->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * @OA\Get(
     *   path="/cursos/{cod_curso}",
     *   summary="Gets a curso resource",
     *   description="Gets a curso resource",
     *   tags={"cursos"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="curso",
     *   in="path",
     *   description="The curso resource curso",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a curso resource"
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
     * @param  int  $cod_curso
     *
     * @return \Illuminate\Http\Response
     */
    public function show($curso)
    {
        /** esto es una consulta por la cedula */
        $cursos = cursos::where('curso', $curso)
            ->first();
        if ($cursos) {
            return response()->json($cursos, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No existe este curso'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/cursos/{cod_curso}",
     *   summary="Updates a cursos resource",
     *   description="Updates a cursos resource by the curso",
     *   tags={"cursos"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="curso",
     *   in="path",
     *   description="cursos resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a cursos resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/cursos")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The cursos resource updated"
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
     * @param  int  $cod_curso
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cod_curso)
    {
        try {
            if ($this->validation($request, $cod_curso)->fails()) {
                $errors = $this->validation($request, $cod_curso)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $curso = cursos::where('cod_curso', $cod_curso)
                    ->update([
                        'curso' =>  $request->curso,
                        'descripcion' =>  $request->descripcion,
                    ]);
                return response()->json($curso, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    /**
     * @OA\Delete(
     *   path="/cursos/{dni}",
     *   summary="Removes a cursos resource",
     *   description="Removes a cursos resource",
     *   tags={"cursos"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The cursos resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a cursos resource"
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
    public function destroy($cod_curso)
    {
        $cursos = cursos::where('cod_curso', $cod_curso)
            ->where('status', 'y')
            ->first();
        if ($cursos) {
            cursos::where('cod_curso', $cod_curso)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'curso eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'curso not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
