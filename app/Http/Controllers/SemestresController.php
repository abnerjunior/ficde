<?php

namespace App\Http\Controllers;
use App\Http\Resources\UsersCollection;
use Illuminate\Http\Request;
use App\Models\semestres;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class SemestresController extends Controller
{/**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $nombre number nombre
     * @return [Function]  function validator
     */
    private function validation ($request, $nombre) {
        if ($nombre !== null) {
            $unique = Rule::unique('semestres')->ignore($request->nombre, 'nombre');
        } else {
            $unique = 'unique:semestres';
        }
        $validator = Validator::make($request->all(), [
            'cod_semestre' => 'required',
            'fecha' => 'required'            
        ]);
        return $validator;
    }
    /**
        * @OA\Get(
        *   path="/semestres",
        *   summary="Lists available semestres",
        *   description="Gets all available semestres resources",
        *   tags={"semestres"},
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
        *           description="The unique identifier of a semestres resource"
        *       )
        *   ),
        *   @OA\Parameter(
        *       name="dataSearch",
        *       in="query",
        *       description="semestres resource name",
        *       required=false,
        *       @OA\Schema(
        *           type="string",
        *           description="The unique identifier of a semestres resource"
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
        *           description="The unique identifier of a semestres resource"
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
        *           description="The unique identifier of a semestres resource"
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
        *           description="The unique identifier of a semestres resource"
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
        *       description="A list with semestres",
        *       @OA\Header(
        *       header="X-Auth-Token",
        *       @OA\Schema(
        *           type="integer",
        *           format="int32"
        *       ),
        *       description="calls per hour allowed by the semestres"
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

        $q = semestres::select();
        $semestres = semestres::search($request->toArray(), $q);
        return  new UsersCollection($semestres);
    }
    /**
        * @OA\Post(
        *   path="/semestres",
        *   summary="Creates a new semestres",
        *   description="Creates a new semestres",
        *   tags={"semestres"},
        *   security={{"passport": {"*"}}},
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/semestres")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *       response=200,
        *       description="The semestres resource created",
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
                $semestres= new semestres();
                $semestres->nombre = $request->nombre;
                $semestres->fecha = $request->fecha;
                $semestres->status = $request->status;

                $semestres->user = $request->user;
                $semestres->save();
                return response()->json($request, 200);      
            }
        }catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
        * @OA\Get(
        *   path="/semestres/{nombre}",
        *   summary="Gets a semestres resource",
        *   description="Gets a semestres resource",
        *   tags={"semestres"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="nombre",
        *   in="path",
        *   description="The semestres resource nombre",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a semestres resource"
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
        * @param  int  $nombre
        *
        * @return \Illuminate\Http\Response
        */
    public function show($nombre)
    {
       /** esto es una consulta por la cedula */
       $semestres = semestres::where('nombre', $nombre)
            ->where('nombre', $nombre)
            ->first();
        if ($semestres)
        {
            return response()->json($semestres, 200);
        } 
        else 
        {
            return response()->json(['status' => 'error', 'message' => 'semestres no inscrito'], 204);
        }
    }

   /**
        * @OA\Put(
        *   path="/semestres/{nombre}",
        *   summary="Updates a semestres resource",
        *   description="Updates a semestres resource by the nombre",
        *   tags={"semestres"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="nombre",
        *   in="path",
        *   description="semestres resource id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a semestres resource"
        *   )
        *   ),
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/semestres")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *           response=200,
        *           description="The semestres resource updated"
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
        * @param  int  $nombre
        *
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $nombre)
        {
            try {
                if ($this->validation($request, $nombre)->fails()) {
                    $errors = $this->validation($request, $nombre)->errors();
                    return response()->json($errors->all(), 201);
                } else {
                    $semestres = semestres::where('nombre', $nombre)
                    ->update([
                        'nombre' =>  $request->nombre,
                        'fecha' =>  $request->fecha,
                    ]);
                    return response()->json($semestres, 201);
                }
            } catch (Exception $e) {
                return response()->json($e);
            }
        }
}
