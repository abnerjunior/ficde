<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
   /**
        * @OA\Get(
        *   path="/horarios",
        *   summary="Lists available horarios",
        *   description="Gets all available horarios resources",
        *   tags={"horarios"},
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
        *           description="The unique identifier of a horarios resource"
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
        *       description="A list with horarios",
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
     
    public function index($dni)
    {
        $horarios = DB::table('sedes')
            ->select(
                'sedes.nombre as nombreSedes',
                'sedes.direccion',
                'aulas.nombre as nombreAulas',
                'materias.materia as nombreMateria',
                'cursos.curso as nombreCurso',
                'usuarios.nombre as nombreUsuario',
                'usuarios.apellido as apellidoUsuario',
                'estudiantes.nombre as nombreEstudiante',
                'estudiantes.apellido as apellidoEstudiante',
                'estudiantes.email as emailEstudiante',
                'estudiantes.telefono as telefonoEstudiante',
                'turnos.turno',
                'turnos.hora',
                'modalidades.modalidad'
            )
            ->join('aulas', 'aulas.cod_sede', 'sedes.cod_sede')
            ->join('semestres_materias', 'aulas.cod_aula', 'semestres_materias.id_aula')
            ->join('materias', 'materias.cod_materia', 'semestres_materias.id_materia')
            ->join('cursos','cursos.cod_curso','materias.cod_curso')
            ->join('usuarios','usuarios.cod_usuario','semestres_materias.id_usuario')
            ->join('estudiantes_materias','estudiantes_materias.id_materia','semestres_materias.cod_sm')
            ->join('estudiantes','estudiantes.cod_estudiante','estudiantes_materias.id_estudiante')
            ->join('turnos','turnos.cod_turno','estudiantes_materias.id_turno')
            ->join('modalidades','modalidades.cod_modalidad','estudiantes_materias.id_modalidad')
            ->where('where estudiantes.dni','=',$dni)
            ->get();
        return response()->json($horarios, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
