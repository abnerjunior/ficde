<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersCollection;
use Illuminate\Http\Request;
use App\Models\sedes;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class sedesController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $nombre number nombre
     * @return [Function]  function validator
     */
    private function validation($request, $nombre)
    {
        if ($nombre !== null) {
            $unique = Rule::unique('sedes')->ignore($request->nombre, 'nombre');
        } else {
            $unique = 'unique:sedes';
        }
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'max:20', $unique],

            'direccion' => 'required|min:5',
            'telefono' => 'required',

        ]);
        return $validator;
    }
    /**
     * @OA\Get(
     *   path="/sedes",
     *   summary="Lists available sedes",
     *   description="Gets all available sedes resources",
     *   tags={"sedes"},
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
     *           description="The unique identifier of a sede resource"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="dataSearch",
     *       in="query",
     *       description="sede resource name",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           description="The unique identifier of a sede resource"
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
     *           description="The unique identifier of a sede resource"
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
     *           description="The unique identifier of a sede resource"
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
     *           description="The unique identifier of a sede resource"
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
     *       description="A list with sedes",
     *       @OA\Header(
     *       header="X-Auth-Token",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the sedes"
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
        $q = sedes::select();
        $sedes = sedes::search($request->toArray(), $q);
        return  new UsersCollection($sedes);
    }

    /**
     * @OA\Post(
     *   path="/sedes",
     *   summary="Creates a new sede",
     *   description="Creates a new sede",
     *   tags={"sedes"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/sedes")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The sede resource created",
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
                $sedes = new sedes();
                $sedes->nombre = $request->nombre;
                $sedes->cod_institucion = $request->cod_institucion;
                $sedes->direccion = $request->direccion;
                $sedes->telefono = $request->telefono;
                $sedes->status = $request->status;

                $sedes->user = $request->user;
                $sedes->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
        //
    }
    /**
     * @OA\Get(
     *   path="/sedes/{nombre}",
     *   summary="Gets a sede resource",
     *   description="Gets a sede resource",
     *   tags={"sedes"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="nombre",
     *   in="path",
     *   description="The sede resource nombre",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a sede resource"
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
        /** esto es una consulta por la nombre */
        $sedes = sedes::where('nombre', $nombre)
            ->where('nombre', $nombre)
            ->first();
        if ($sedes) {
            return response()->json($sedes, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'La sede no esta registrada'], 404);
        }
        //
    }
    /**
     * @OA\Put(
     *   path="/sedes/{nombre}",
     *   summary="Updates a sedes resource",
     *   description="Updates a sedes resource by the nombre",
     *   tags={"sedes"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="nombre",
     *   in="path",
     *   description="sedes resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a sedes resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/sedes")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The sedes resource updated"
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
                return response()->json($errors->all(), 400);
            } else {
                $sedes = sedes::where('nombre', $nombre)
                    ->update([
                        'nombre' =>  $request->nombre,
                        'cod_institucion' =>  $request->cod_institucion,
                        'direccion' =>  $request->direccion,
                        'telefono' => $request->telefono,
                    ]);
                return response()->json($sedes, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
        //
    }
    /**
     * @OA\Delete(
     *   path="/sedes/{dni}",
     *   summary="Removes a sedes resource",
     *   description="Removes a sedes resource",
     *   tags={"users"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The sedes resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a sedes resource"
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
    public function destroy($nombre)
    {
        $sedes = sedes::where('nombre', $nombre)
            ->where('status', 'y')
            ->first();
        if ($sedes) {
            sedes::where('nombre', $nombre)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'usuario eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuario not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
