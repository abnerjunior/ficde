<?php

namespace App\Http\Controllers;
use App\Http\Resources\UsersCollection;
use Illuminate\Http\Request;
use App\Models\notas;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class NotasController extends Controller
{
   
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $id_em number id_em
     * @return [Function]  function validator
     */
    private function validation ($request, $id_em) {
        if ($id_em !== null) {
            $unique = Rule::unique('notas')->ignore($request->id_em, 'id_em');
        } else {
            $unique = 'unique:notas';
        }
        $validator = Validator::make($request->all(), [
            'id_em' => 'required',
            'nota' => 'required',
            'id_estudiante' => ['email', 'required'],
            'telefono' => 'required',
            'direccion' => 'required|min:5'
        ]);
        return $validator;
    }
    /**
        * @OA\Get(
        *   path="/notas",
        *   summary="Lists available notas",
        *   description="Gets all available notas resources",
        *   tags={"notas"},
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
        *           description="The unique identifier of a notas resource"
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
        *       description="A list with notas",
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
      public function index(Request $request) {

        $q = notas::select();
        $notas = notas::search($request->toArray(), $q);
        return  new UsersCollection($notas);
    }
    /**
        * @OA\Post(
        *   path="/notas",
        *   summary="Creates a new estudiante",
        *   description="Creates a new estudiante",
        *   tags={"notas"},
        *   security={{"passport": {"*"}}},
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/notas")
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
                return response()->json($errors->all(), 201);
            } else {
                $notas= new notas();
                $notas->id_em = $request->id_em;
                $notas->nombre = $request->nombre;
                $notas->apellido = $request->apellido;
                $notas->email = $request->email;
                $notas->telefono = $request->telefono;
                $notas->direccion = $request->direccion;
                $notas->save();
                return response()->json($request, 200);      
            }
        }catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
        * @OA\Get(
        *   path="/notas/{id_em}",
        *   summary="Gets a estudiante resource",
        *   description="Gets a estudiante resource",
        *   tags={"notas"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="id_em",
        *   in="path",
        *   description="The estudiante resource id_em",
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
        * @param  int  $id_em
        *
        * @return \Illuminate\Http\Response
        */
    public function show($id_em)
    {
       /** esto es una consulta por la cedula */
       $notas = notas::where('id_em', $id_em)
            ->where('id_em', $id_em)
            ->first();
        if ($notas)
        {
            return response()->json($notas, 200);
        } 
        else 
        {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no inscrito'], 204);
        }
    }
    
   /**
        * @OA\Put(
        *   path="/notas/{id_em}",
        *   summary="Updates a notas resource",
        *   description="Updates a notas resource by the id_em",
        *   tags={"notas"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="id_em",
        *   in="path",
        *   description="notas resource id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a notas resource"
        *   )
        *   ),
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/notas")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *           response=200,
        *           description="The notas resource updated"
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
        * @param  int  $id_em
        *
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $id_em)
        {
            try {
                if ($this->validation($request, $id_em)->fails()) {
                    $errors = $this->validation($request, $id_em)->errors();
                    return response()->json($errors->all(), 201);
                } else {
                    $estudiante = notas::where('id_em', $id_em)
                    ->update([
                        'nombre' =>  $request->nombre,
                        'apellido' =>  $request->apellido,
                        'direccion' =>  $request->direccion,
                        'email' => $request->email,
                        'telefono' => $request->telefono,
                    ]);
                    return response()->json($estudiante, 201);
                }
            } catch (Exception $e) {
                return response()->json($e);
            }
        }
}
