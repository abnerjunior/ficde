<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersCollection;
use Illuminate\Http\Request;
use App\Models\aulas;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AulasController extends Controller
{
    /**4
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $nombre number nombre
     * @return [Function]  function validator
     */
    private function validation($request, $nombre)
    {
        if ($nombre !== null) {
            $unique = Rule::unique('aulas')->ignore($request->nombre, 'nombre');
        } else {
            $unique = 'unique:aulas';
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'capacidad' => 'required',
            'cod_sede' => 'required'
        ]);
        return $validator;
    }
    /**
     * @OA\Get(
     *   path="/aulas",
     *   summary="Lists available aulas",
     *   description="Gets all available aulas resources",
     *   tags={"aulas"},
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
     *           description="The unique identifier of a aulas resource"
     *       )
     *   ),
     *   @OA\Parameter(
     *       name="dataSearch",
     *       in="query",
     *       description="aulas resource name",
     *       required=false,
     *       @OA\Schema(
     *           type="string",
     *           description="The unique identifier of a aulas resource"
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
     *           description="The unique identifier of a aulas resource"
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
     *           description="The unique identifier of a aulas resource"
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
     *           description="The unique identifier of a aulas resource"
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
     *       description="A list with aulas",
     *       @OA\Header(
     *       header="X-Auth-Token",
     *       @OA\Schema(
     *           type="integer",
     *           format="int32"
     *       ),
     *       description="calls per hour allowed by the aulas"
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
        $q = aulas::select(
            'aulas.*',
            'sedes.nombre'
        )
        ->join('sedes', 'sedes.cod_sede', 'aulas.cod_sede');
        $aulas = aulas::search($request->toArray(), $q,'aulas');
        return  new UsersCollection($aulas);
    }

    /**
     * @OA\Post(
     *   path="/aulas",
     *   summary="Creates a new aulas",
     *   description="Creates a new aulas",
     *   tags={"aulas"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/aulas")
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
                return response()->json($errors->all(), 400);
            } else {
                $aulas = new aulas();
                $aulas->nombre = $request->nombre;
                $aulas->capacidad = $request->capacidad;
                $aulas->cod_sede = $request->cod_sede;
                $aulas->user_r = $request->user_r;
                $aulas->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
        //
    }
    /**
     * @OA\Get(
     *   path="/aulas/{nombre}",
     *   summary="Gets a aulas resource",
     *   description="Gets a aulas resource",
     *   tags={"aulas"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="nombre",
     *   in="path",
     *   description="The aulas resource nombre",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a aulas resource"
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
        $aulas = aulas::where('cod_sede', $nombre)
            ->where('nombre', $nombre)
            ->first();
        if ($aulas) {
            return response()->json($aulas, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'aulas no registrada'], 404);
        }
        //
    }
    /**
     * @OA\Put(
     *   path="/aulas/{nombre}",
     *   summary="Updates a aulas resource",
     *   description="Updates a aulas resource by the nombre",
     *   tags={"aulas"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="nombre",
     *   in="path",
     *   description="aulas resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a aulas resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/aulas")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The aulas resource updated"
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
                $aulas = aulas::where('cod_sede', $nombre)
                    ->update([
                        'nombre' =>  $request->nombre,
                        'capacidad' =>  $request->capacidad,
                        'cod_sede' => $request->cod_sede,
                    ]);
                return response()->json($aulas, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
        //
    }
    /**
     * @OA\Delete(
     *   path="/aulas/{dni}",
     *   summary="Removes a aulas resource",
     *   description="Removes a aulas resource",
     *   tags={"aulas"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The aulas resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a aulas resource"
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
        $aulas = aulas::where('cod_sede', $dni)
            ->where('status', 'y')
            ->first();
        if ($aulas) {
            aulas::where('cod_sede', $dni)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'aula eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'aula not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
