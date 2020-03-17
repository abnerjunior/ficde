<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersCollection;
use App\Http\Resources\estudiantesCollection;
use App\Models\estudiantes;
use App\curso_estudiante;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class EstudiantesController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $dni number dni
     * @return [Function]  function validator
     */
    private function validation($request, $dni)
    {
        if ($dni !== null) {
            $unique = Rule::unique('estudiantes')->ignore($request->dni, 'dni');
        } else {
            $unique = Rule::unique('estudiantes')->where('status', 'y');
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => ['required', 'max:10', $unique],
            'email' => ['email', 'required'],
            'telefono' => 'required',
            'direccion' => 'required|min:5'
        ]);
        return $validator;
    }
    /**
     * @OA\Get(
     *   path="/estudiantes",
     *   summary="Lists available estudiantes",
     *   description="Gets all available estudiantes resources",
     *   tags={"estudiantes"},
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
     *           description="The unique identifier of a estudiante resource"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="dataSearch",
     *       in="query",
     *       description="estudiante resource name",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           description="The unique identifier of a estudiante resource"
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
     *           description="The unique identifier of a estudiante resource"
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
     *           description="The unique identifier of a estudiante resource"
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
     *           description="The unique identifier of a estudiantes resource"
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
     *       description="A list with estudiantes",
     *       @OA\Header(
     *       header="X-Auth-Token",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the estudiante"
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

        $q = estudiantes::select()->with('cursos');
        $estudiantes = estudiantes::search($request->toArray(), $q,'estudiantes');
        return  new UsersCollection($estudiantes);
        // return response()->json(['message' => 'hola'], 200);
    }
    /**
     * @OA\Post(
     *   path="/estudiantes",
     *   summary="Creates a new estudiante",
     *   description="Creates a new estudiante",
     *   tags={"estudiantes"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/estudiantes")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The estudiante resource created",
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
                $id = DB::table('estudiantes')->insertGetId(
                    [
                        'dni' => $request->dni,
                        'nombre' => $request->nombre,
                        'apellido' => $request->apellido,
                        'email' => $request->email,
                        'telefono' => $request->telefono,
                        'direccion' => $request->direccion,
                        'user_r' => $request->user_r
                    ]
                );                
                $this->storeCourses($id, $request->cursos, $request->user_r);
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }

    /**
     * @OA\Get(
     *   path="/estudiantes/{dni}",
     *   summary="Gets a estudiante resource",
     *   description="Gets a estudiante resource",
     *   tags={"estudiantes"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The estudiante resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a estudiante resource"
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
    public function show($dni)
    {
        /** esto es una consulta por la cedula */
        $estudiantes = estudiantes::where('dni', $dni)
            ->where('status', 'y')
            ->first();
        if ($estudiantes) {
            return response()->json($estudiantes, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no inscrito'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/estudiantes/{dni}",
     *   summary="Updates a estudiantes resource",
     *   description="Updates a estudiantes resource by the dni",
     *   tags={"estudiantes"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="estudiantes resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a estudiantes resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/estudiantes")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The estudiantes resource updated"
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
     * @param  int  $dni
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if ($this->validation($request, $id)->fails()) {
                $errors = $this->validation($request, $id)->errors();
                return response()->json($errors->all(), 400);
            } else {
                DB::table('curso_estudiantes')->where('id', $id)->delete();
                $this->storeCourses($id, $request->cursos, $request->user_r);
                return response()->json($request, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function storeCourses($id, $courses, $user_r)
    {
        foreach ($courses as $key => $value) {
            DB::table('curso_estudiantes')->insert(
                [
                    'id_estudiante' => $id,
                    'id_curso' => $courses[$key],
                    'user_r' => $request->user_r
                ]
            );
        }
    }

    /**
     * @OA\Delete(
     *   path="/estudiantes/{dni}",
     *   summary="Removes a estudiantes resource",
     *   description="Removes a estudiantes resource",
     *   tags={"estudiantes"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The estudiantes resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a estudiantes resource"
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
        $estudiantes = estudiantes::where('dni', $dni)
            ->where('status', 'y')
            ->first();
        if ($estudiantes) {
            estudiantes::where('dni', $dni)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'estudiante eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'estudiante not inscrito'], 401);
        }
    }
}
