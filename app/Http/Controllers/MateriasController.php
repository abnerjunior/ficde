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
     * @param  [String] $materia number materia
     * @return [Function]  function validator
     */
    private function validation ($request, $materia) {
        if ($materia !== null) {
            $unique = Rule::unique('materias')->ignore($request->materia, 'materia');
        } else {
            $unique = 'unique:materias';
        }
        $validator = Validator::make($request->all(), [
            'materia' => ['required', 'max:19', $unique]
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
        *           description="The unique identifier of a materia resource"
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
        *       description="A list with materia",
        *       @OA\Header(
        *       header="X-Auth-Token",
        *       @OA\Schema(
        *           type="integer",
        *           format="int32"
        *       ),
        *       description="calls per hour allowed by the user"
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

        $q = materias::select();
        $materia = materias::search($request->toArray(), $q);
        return  new usersCollection($materia);
    }

    /**
        * @OA\Post(
        *   path="/materias",
        *   summary="Creates a new materia",
        *   description="Creates a new materia",
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
        *       description="The materia resource created",
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
                $materias= new materias();
                $materias->cod_curso = $request->cod_curso;
                $materias->materia = $request->materia;
                $materias->descripcion = $request->descripcion;
                $materias->status = $request->status;

                $materias->user = $request->user;
                $materias->save();
                return response()->json($request, 200);      
            }
        }catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
        * @OA\Get(
        *   path="/materias/{materia}",
        *   summary="Gets a materia resource",
        *   description="Gets a materia resource",
        *   tags={"materias"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="materia",
        *   in="path",
        *   description="The materia resource materia",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a materia resource"
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
        * @param  int  $materia
        *
        * @return \Illuminate\Http\Response
        */
    public function show($materia)
    {
       /** esto es una consulta por la cedula */
       $materias = materias::where('materia', $materia)
            ->where('materia', $materia)
            ->first();
        if ($materias)
        {
            return response()->json($materias, 200);
        } 
        else 
        {
            return response()->json(['status' => 'error', 'message' => 'No existe este materia'], 204);
        }
    }

        /**
        * @OA\Put(
        *   path="/materias/{materia}",
        *   summary="Updates a materias resource",
        *   description="Updates a materias resource by the materia",
        *   tags={"materias"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="materia",
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
        * @param  int  $materia
        *
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $materia)
        {
            try {
                if ($this->validation($request, $materia)->fails()) {
                    $errors = $this->validation($request, $materia)->errors();
                    return response()->json($errors->all(), 201);
                } else {
                    $materia = materias::where('materia', $materia)
                    ->update([
                        'cod_curso' =>  $request->cod_curso,
                        'materia' =>  $request->materia,
                        'descripcion' =>  $request->descripcion,
                    ]);
                    return response()->json($materia, 201);
                }
            } catch (Exception $e) {
                return response()->json($e);
            }
        }
}
