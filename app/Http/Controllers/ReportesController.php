<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
    /**
     * @OA\Get(
     *   path="/Reporte_Inscripcion",
     *   summary="Lists available Inscripcion",
     *   description="Gets all available Inscripcion resources",
     *   tags={"Reporte de Inscripcion"},
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
     *           description="The unique identifier of a Inscripcion resource"
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
     *       description="A list with Inscripcion",
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

    public function RGI()
    {
        /** Reporte General de Inscripciones */
        $Inscripcion = DB::table('sedes')
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
                'semestres.nombre as nombresemestre',
                'modalidades.modalidad'
            )
            ->join('aulas', 'aulas.cod_sede', 'sedes.cod_sede')
            ->join('semestres_materias', 'semestres_materias.id_aula', 'aulas.cod_aula')
            ->join('usuarios', 'usuarios.cod_usuario', 'semestres_materias.id_usuario')
            ->join('semestres', 'semestres.cod_semestre', 'semestres_materias.id_semestres')
            ->join('estudiantes_materias', 'estudiantes_materias.id_semestre', 'semestres.cod_semestre')
            ->join('estudiantes', 'estudiantes.cod_estudiante', 'estudiantes_materias.id_estudiante')
            ->join('turnos', 'turnos.cod_turno', 'estudiantes_materias.id_turno')
            ->join('modalidades', 'modalidades.cod_modalidad', 'estudiantes_materias.id_modalidad')
            ->join('materias', 'materias.cod_materia', 'semestres_materias.id_materia')
            ->join('cursos', 'cursos.cod_curso', 'materias.cod_curso')

            ->get();
        return response()->json($Inscripcion, 200);
    }

    /**
     * @OA\Get(
     *   path="/Reporte_Inscripcion/{dni}",
     *   summary="Gets a estudiante resource",
     *   description="Gets a estudiante resource",
     *   tags={"Reporte de Inscripcion"},
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
    public function BRI($dni)
    {
        /** esto es una consulta por la cedula busqueda de reporte de inscripcion */

        $Inscripcion = DB::table('sedes')
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
                'semestres.nombre as nombresemestre',
                'modalidades.modalidad'
            )
            ->join('aulas', 'aulas.cod_sede', 'sedes.cod_sede')
            ->join('semestres_materias', 'semestres_materias.id_aula', 'aulas.cod_aula')
            ->join('usuarios', 'usuarios.cod_usuario', 'semestres_materias.id_usuario')
            ->join('semestres', 'semestres.cod_semestre', 'semestres_materias.id_semestres')
            ->join('estudiantes_materias', 'estudiantes_materias.id_semestre', 'semestres.cod_semestre')
            ->join('estudiantes', 'estudiantes.cod_estudiante', 'estudiantes_materias.id_estudiante')
            ->join('turnos', 'turnos.cod_turno', 'estudiantes_materias.id_turno')
            ->join('modalidades', 'modalidades.cod_modalidad', 'estudiantes_materias.id_modalidad')
            ->join('materias', 'materias.cod_materia', 'semestres_materias.id_materia')
            ->join('cursos', 'cursos.cod_curso', 'materias.cod_curso')
            ->where('estudiantes.dni', '=', $dni)

            ->get();
        if ($Inscripcion) {
            return response()->json($Inscripcion, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no inscrito'], 204);
        }
    }
    /**
     * @OA\Get(
     *   path="/Reporte_aprobacion",
     *   summary="Gets a estudiante resource",
     *   description="Gets a estudiante resource",
     *   tags={"Reporte de aprobacion"},
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

    public function RGA($dni)
    {
        /** esto es una consulta por la cedula */

        $Inscripcion = DB::table('materias')
            ->select(
                'materias.materia as nombreMateria',
                'cursos.curso as nombreCurso',
                'estudiantes.nombre as nombreEstudiante',
                'estudiantes.apellido as apellidoEstudiante',
                'estudiantes.email as emailEstudiante',
                'estudiantes.telefono as telefonoEstudiante',                
                'semestres.nombre as nombresemestre',
                'notas.notas as notaregular',
                'recuperatorios.notarecuperada'
            )
            ->join('semestres_materias','semestres_materias.id_materia','materias.cod_materia')
            ->join('semestres','semestres.cod_semestre','semestres_materias.id_semestre')
            ->join('','','')
            ->join('','','')
            ->join('','','')
            ->join('','','')
            ->join('','','')
            ->where('estudiantes.dni', '=', $dni)
          
            ->get();
        if ($Inscripcion) {
            return response()->json($Inscripcion, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no inscrito'], 204);
        }
    }
}
