<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersCollection;
use App\Models\estudiantes_materias;
use App\Models\semestres_materias;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Estudiantes_MateriasController extends Controller
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
            $unique = Rule::unique('estudiantes_materias')->ignore($request->id_estudiante, 'id_estudiante');
        } else {
            $unique = 'unique:estudiantes_materias';
        }
        $validator = Validator::make($request->all(), [
            'id_semestre' => 'required',
            'id_estudiante' => 'required'
        ]);
        return $validator;
    }
    /**
     * @OA\Get(
     *   path="/estudiantes_materias",
     *   summary="Lists available estudiantes_materias",
     *   description="Gets all available estudiantes_materias resources",
     *   tags={"estudiantes_materias"},
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
     *           description="The unique identifier of a estudiantes_materias resource"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="dataSearch",
     *       in="query",
     *       description="estudiantes_materias resource name",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           description="The unique identifier of a estudiantes_materias resource"
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
     *           description="The unique identifier of a estudiantes_materias resource"
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
     *           description="The unique identifier of a estudiantes_materias resource"
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
     *           description="The unique identifier of a estudiantes_materias resource"
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
     *       description="A list with estudiantes_materias",
     *       @OA\Header(
     *       header="X-Auth-Token",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the estudiantes_materias"
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

        $q = semestres_materias::select(
            'aulas.nombre as nombreAula',
            'materias.materia as nombreMateria',
            'semestres.nombre as nombreSemestre',
            'usuarios.dni as dniProfesor',
            'usuarios.nombre as nombreProfesor',
            'usuarios.apellido as apellidoProfesor',
            'semestres_materias.*',
            'cursos.curso',
            'turnos.turno',
            'turnos.hora_e',
            'turnos.hora_s',
            'turnos.dia',
            'modalidades.modalidad'
        )
        ->join('aulas', 'aulas.cod_aula', 'semestres_materias.id_aula')
        ->join('materias', 'materias.cod_materia', 'semestres_materias.id_materia')
        ->join('usuarios', 'usuarios.cod_usuario', 'semestres_materias.id_usuario')
        ->join('semestres', 'semestres.cod_semestre', 'semestres_materias.id_semestres')
        ->join('cursos', 'cursos.cod_curso', 'materias.cod_curso')
        ->join('turnos', 'turnos.cod_turno', 'semestres_materias.id_turno')
        ->join('modalidades', 'modalidades.cod_modalidad', 'semestres_materias.id_modalidad');
        $semestres_materias = semestres_materias::search($request->toArray(), $q,'semestres_materias');
        return  new UsersCollection($semestres_materias);
    }
    /**
     * @OA\Post(
     *   path="/estudiantes_materias",
     *   summary="Creates a new estudiantes_materias",
     *   description="Creates a new estudiantes_materias",
     *   tags={"estudiantes_materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/estudiantes_materias")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The estudiantes_materias resource created",
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
                $estudiantes_materias = new estudiantes_materias();
                $estudiantes_materias->id_estudiante = $request->id_estudiante;
                $estudiantes_materias->id_sm = $request->id_semestre;
                $estudiantes_materias->user_r = $request->user_r;
                $estudiantes_materias->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * @OA\Get(
     *   path="/estudiantes_materias/{id_estudiante}",
     *   summary="Gets a estudiantes_materias resource",
     *   description="Gets a estudiantes_materias resource",
     *   tags={"estudiantes_materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="id_estudiante",
     *   in="path",
     *   description="The estudiantes_materias resource id_estudiante",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a estudiantes_materias resource"
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
        /** esto es una consulta por la cedula */
        $estudiantes_materias = estudiantes_materias::where('id_estudiante', $id_estudiante)
            ->where('status', 'y')
            ->first();
        if ($estudiantes_materias) {
            return response()->json($estudiantes_materias, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no inscrito'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/estudiantes_materias/{id_estudiante}",
     *   summary="Updates a estudiantes_materias resource",
     *   description="Updates a estudiantes_materias resource by the id_estudiante",
     *   tags={"estudiantes_materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="id_estudiante",
     *   in="path",
     *   description="estudiantes_materias resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a estudiantes_materias resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/estudiantes_materias")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The estudiantes_materias resource updated"
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
                $estudiantes_materias = estudiantes_materias::where('cod_em', $id_estudiante)
                    ->update([
                        'id_estudiante' => $request->id_estudiante,
                        'id_semestre' => $request->id_semestre,
                        'id_turno' => $request->id_turno,
                        'id_modalidad' => $request->id_modalidad,
                        'user_r' => $request->user_r
                    ]);
                return response()->json($estudiantes_materias, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    /**
     * @OA\Delete(
     *   path="/estudiantes_materias/{dni}",
     *   summary="Removes a estudiantes_materias resource",
     *   description="Removes a estudiantes_materias resource",
     *   tags={"estudiantes_materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The estudiantes_materias resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a estudiantes_materias resource"
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
        $estudiantes_materias = estudiantes_materias::where('cod_em', $dni)
            ->where('status', 'y')
            ->first();
        if ($estudiantes_materias) {
            estudiantes_materias::where('cod_em', $dni)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'usuario eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuario not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
