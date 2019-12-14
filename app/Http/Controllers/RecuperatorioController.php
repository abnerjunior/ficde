<?php

namespace App\Http\Controllers;
use App\Http\Resources\UsersCollection;
use App\Models\recuperatorio;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RecuperatorioController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $id_nota number id_nota
     * @return [Function]  function validator
     */
    private function validation ($request, $id_nota) {
        if ($id_nota !== null) {
            $unique = Rule::unique('recuperatorios')->ignore($request->id_nota, 'id_nota');
        } else {
            $unique = 'unique:recuperatorios';
        }
        $validator = Validator::make($request->all(), [
            'fecha' => 'required',
            'id_nota' => 'required',
            'nota_r' => 'required'
        ]);
        return $validator;
    }
    /**
        * @OA\Get(
        *   path="/recuperatorios",
        *   summary="Lists available recuperatorios",
        *   description="Gets all available recuperatorios resources",
        *   tags={"recuperatorios"},
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
        *           description="The unique identifier of a recuperatorio resource"
        *       )
        *   ),
        *   @OA\Parameter(
        *       name="dataSearch",
        *       in="query",
        *       description="recuperatorio resource name",
        *       required=false,
        *       @OA\Schema(
        *           type="string",
        *           description="The unique identifier of a recuperatorio resource"
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
        *           description="The unique identifier of a recuperatorio resource"
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
        *           description="The unique identifier of a recuperatorio resource"
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
        *           description="The unique identifier of a recuperatorios resource"
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
        *       description="A list with recuperatorios",
        *       @OA\Header(
        *       header="X-Auth-Token",
        *       @OA\Schema(
        *           type="integer",
        *           format="int32"
        *       ),
        *       description="calls per hour allowed by the recuperatorio"
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

        $q = recuperatorio::select();
        $recuperatorios = recuperatorio::search($request->toArray(), $q);
        return  new UsersCollection($recuperatorios);
    }
    /**
        * @OA\Post(
        *   path="/recuperatorios",
        *   summary="Creates a new recuperatorio",
        *   description="Creates a new recuperatorio",
        *   tags={"recuperatorios"},
        *   security={{"passport": {"*"}}},
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/recuperatorios")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *       response=200,
        *       description="The recuperatorio resource created",
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
                $recuperatorios= new recuperatorio();
                $recuperatorios->id_nota = $request->id_nota;
                $recuperatorios->fecha = $request->fecha;
                $recuperatorios->save();
                return response()->json($request, 200);      
            }
        }catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
        * @OA\Get(
        *   path="/recuperatorios/{id_nota}",
        *   summary="Gets a recuperatorio resource",
        *   description="Gets a recuperatorio resource",
        *   tags={"recuperatorios"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="id_nota",
        *   in="path",
        *   description="The recuperatorio resource id_nota",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a recuperatorio resource"
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
        * @param  int  $id_nota
        *
        * @return \Illuminate\Http\Response
        */
    public function show($id_nota)
    {
       /** esto es una consulta por la cedula */
       $recuperatorios = recuperatorio::where('id_nota', $id_nota)
            ->where('id_nota', $id_nota)
            ->first();
        if ($recuperatorios)
        {
            return response()->json($recuperatorios, 200);
        } 
        else 
        {
            return response()->json(['status' => 'error', 'message' => 'Estudiante no inscrito'], 204);
        }
    }

   /**
        * @OA\Put(
        *   path="/recuperatorios/{id_nota}",
        *   summary="Updates a recuperatorios resource",
        *   description="Updates a recuperatorios resource by the id_nota",
        *   tags={"recuperatorios"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="id_nota",
        *   in="path",
        *   description="recuperatorios resource id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a recuperatorios resource"
        *   )
        *   ),
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/recuperatorios")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *           response=200,
        *           description="The recuperatorios resource updated"
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
        * @param  int  $id_nota
        *
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $id_nota)
        {
            try {
                if ($this->validation($request, $id_nota)->fails()) {
                    $errors = $this->validation($request, $id_nota)->errors();
                    return response()->json($errors->all(), 201);
                } else {
                    $recuperatorio = recuperatorio::where('id_nota', $id_nota)
                    ->update([
                        'fecha' =>  $request->fecha,
                    ]);
                    return response()->json($recuperatorio, 201);
                }
            } catch (Exception $e) {
                return response()->json($e);
            }
        }
}
