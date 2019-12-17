<?php
namespace App\Http\Controllers;
use App\Http\Resources\UsersCollection;
use Illuminate\Http\Request;
use App\Models\institucion;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class InstitucionController extends Controller
{
     /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $nombre number nombre
     * @return [Function]  function validator
     */
    private function validation ($request, $nombre) {
        if ($nombre !== null) {
            $unique = Rule::unique('institucion')->ignore($request->nombre, 'nombre');
        } else {
            $unique = 'unique:institucion';
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'registro' => 'required',
            'telefono' => 'required',
            'direccion' => 'required|min:5'
        ]);
        return $validator;
    }
      /**
        * @OA\Get(
        *   path="/institucion",
        *   summary="Lists available institucion",
        *   description="Gets all available institucion resources",
        *   tags={"institucion"},
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
        *           description="The unique identifier of a institucion resource"
        *       )
        *   ),
        *   @OA\Parameter(
        *       name="dataSearch",
        *       in="query",
        *       description="institucion resource name",
        *       required=false,
        *       @OA\Schema(
        *           type="string",
        *           description="The unique identifier of a institucion resource"
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
        *           description="The unique identifier of a institucion resource"
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
        *           description="The unique identifier of a institucion resource"
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
        *           description="The unique identifier of a institucion resource"
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
        *       description="A list with institucion",
        *       @OA\Header(
        *       header="X-Auth-Token",
        *       @OA\Schema(
        *           type="integer",
        *           format="int32"
        *       ),
        *       description="calls per hour allowed by the institucion"
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
        $q = institucion::select();
        $institucion = institucion::search($request->toArray(), $q);
        return  new UsersCollection($institucion);
    }
    
    /**
        * @OA\Post(
        *   path="/institucion",
        *   summary="Creates a new institucion",
        *   description="Creates a new institucion",
        *   tags={"institucion"},
        *   security={{"passport": {"*"}}},
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/institucion")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *       response=200,
        *       description="The  resource created",
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
     *    */
     
   
    public function store(Request $request)
    {
        try {
            if ($this->validation($request, null)->fails()) {
                $errors = $this->validation($request, null)->errors();
                return response()->json($errors->all(), 201);
            } else {
                $institucion= new institucion();
                $institucion->nombre = $request->nombre;
                $institucion->registro = $request->registro;
                $institucion->telefono = $request->telefono;
                $institucion->direccion = $request->direccion;
                $institucion->status = $request->status;

                $institucion->user = $request->user;
                $institucion->save();
                return response()->json($request, 200);      
            }
        }catch (Exception $e) {
            return response()->json($e);
        }
        //
    }
        /**
        * @OA\Get(
        *   path="/institucion/{nombre}",
        *   summary="Gets a institucion resource",
        *   description="Gets a institucion resource",
        *   tags={"institucion"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="nombre",
        *   in="path",
        *   description="The institucion resource nombre",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a institucion resource"
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
        $institucion = institucion::where('nombre', $nombre)
        ->where('nombre', $nombre)
        ->first();
    if ($institucion)
    {
        return response()->json($institucion, 200);
    } 
    else 
    {
        return response()->json(['status' => 'error', 'message' => 'institucion no registrada'], 204);
    }
        //
    }
     /**
        * @OA\Put(
        *   path="/institucion/{nombre}",
        *   summary="Updates a institucion resource",
        *   description="Updates a institucion resource by the nombre",
        *   tags={"institucion"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="nombre",
        *   in="path",
        *   description="institucion resource id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a institucion resource"
        *   )
        *   ),
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/institucion")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *           response=200,
        *           description="The institucion resource updated"
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
                $institucion = institucion::where('nombre', $nombre)
                ->update([
                    'nombre' =>  $request->nombre,
                    'registro' =>  $request->registro,
                    'direccion' =>  $request->direccion,
                    'telefono' => $request->telefono,
                ]);
                return response()->json($institucion, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
        //
    }
    
    public function destroy($nombre)
    {
  
        //
    }
}