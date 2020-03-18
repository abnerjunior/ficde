<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersCollection;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\semestres_materias;

class Semestres_MateriasController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $id_semestres number id_semestres
     * @return [Function]  function validator
     */
    private function validation($request, $id_semestres)
    {
        if ($id_semestres !== null) {
            $unique = Rule::unique('semestres_materias')->ignore($request->id_semestres, 'id_semestres');
        } else {
            $unique = 'unique:semestres_materias';
        }
        $validator = Validator::make($request->all(), [
            'id_materia' => 'required',
            'id_semestres' => 'required',
            'id_usuario' => 'required',
            'id_aula' => 'required',
            'id_modalidad' => 'required'
        ]);
        return $validator;
    }
    /**
     * @OA\Get(
     *   path="/semestres_materias",
     *   summary="Lists available semestres_materias",
     *   description="Gets all available semestres_materias resources",
     *   tags={"semestres_materias"},
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
     *           description="The unique identifier of a semestres_materias resource"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="dataSearch",
     *       in="query",
     *       description="semestres_materias resource name",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           description="The unique identifier of a semestres_materias resource"
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
     *           description="The unique identifier of a semestres_materias resource"
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
     *           description="The unique identifier of a semestres_materias resource"
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
     *           description="The unique identifier of a semestres_materias resource"
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
     *       description="A list with semestres_materias",
     *       @OA\Header(
     *       header="X-Auth-Token",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the semestres_materias"
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
            'modalidades.modalidad'
        )
        ->with('turnos')
        ->join('aulas', 'aulas.cod_aula', 'semestres_materias.id_aula')
        ->join('materias', 'materias.cod_materia', 'semestres_materias.id_materia')
        ->join('usuarios', 'usuarios.cod_usuario', 'semestres_materias.id_usuario')
        ->join('semestres', 'semestres.cod_semestre', 'semestres_materias.id_semestres')
        ->join('cursos', 'cursos.cod_curso', 'materias.cod_curso')
        ->join('modalidades', 'modalidades.cod_modalidad', 'semestres_materias.id_modalidad');
        $semestres_materias = semestres_materias::search($request->toArray(), $q,'semestres_materias');
        return  new UsersCollection($semestres_materias);
    }
    /**
     * @OA\Post(
     *   path="/semestres_materias",
     *   summary="Creates a new semestres_materias",
     *   description="Creates a new semestres_materias",
     *   tags={"semestres_materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/semestres_materias")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The semestres_materias resource created",
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
                $semestres_materias = new semestres_materias();
                $semestres_materias->id_semestres = $request->id_semestres;
                $semestres_materias->id_materia = $request->id_materia;
                $semestres_materias->id_usuario = $request->id_usuario;
                $semestres_materias->id_aula = $request->id_aula;
                $semestres_materias->id_turno = $request->id_turno;
                $semestres_materias->id_modalidad = $request->id_modalidad;
                $semestres_materias->user_r = $request->user_r;
                $semestres_materias->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }

    /**
     * @OA\Get(
     *   path="/semestres_materias/{id_semestres}",
     *   summary="Gets a semestres_materias resource",
     *   description="Gets a semestres_materias resource",
     *   tags={"semestres_materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="id_semestres",
     *   in="path",
     *   description="The semestres_materias resource id_semestres",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a semestres_materias resource"
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
     * @param  int  $id_semestres
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id_semestres)
    {
        /** esto es una consulta por la cedula */
        $semestres_materias = Semestres_Materias::where('id_semestres', $id_semestres)
            ->where('id_semestres', $id_semestres)
            ->where('status', 'y')
            ->first();
        if ($semestres_materias) {
            return response()->json($semestres_materias, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no inscrito'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/semestres_materias/{id_semestres}",
     *   summary="Updates a semestres_materias resource",
     *   description="Updates a semestres_materias resource by the id_semestres",
     *   tags={"semestres_materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="id_semestres",
     *   in="path",
     *   description="semestres_materias resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a semestres_materias resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/semestres_materias")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The semestres_materias resource updated"
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
     * @param  int  $id_semestres
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_semestres)
    {
        try {
            if ($this->validation($request, $id_semestres)->fails()) {
                $errors = $this->validation($request, $id_semestres)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $semestres_materias = Semestres_Materias::where('cod_sm', $id_semestres)
                    ->update([
                        'id_materia' =>  $request->id_materia,
                        'id_semestres' =>  $request->id_semestres,
                        'id_usuario' =>  $request->id_usuario,
                        'id_aula' => $request->id_aula,
                        'id_turno' => $request->id_turno,
                        'id_modalidad' => $request->id_modalidad
                    ]);
                return response()->json($semestres_materias, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    /**
     * @OA\Delete(
     *   path="/semestres_materias/{dni}",
     *   summary="Removes a semestres_materias resource",
     *   description="Removes a semestres_materias resource",
     *   tags={"semestres_materias"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The semestres_materias resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a semestres_materias resource"
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
     * @param  int  $id_semestres
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_semestres)
    {
        $semestres_materias = Semestres_Materias::where('cod_sm', $id_semestres)
            ->where('status', 'y')
            ->first();
        if ($semestres_materias) {
            Semestres_Materias::where('cod_sm', $id_semestres)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'usuario eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuario not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
