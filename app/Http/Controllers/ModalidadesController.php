<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UsersCollection;

use App\Models\modalidades;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ModalidadesController extends Controller
{

    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $modalidad number modalidad
     * @return [Function]  function validator
     */
    private function validation($request, $modalidad)
    {
        if ($modalidad !== null) {
            $unique = Rule::unique('modalidades')->ignore($request->modalidad, 'modalidad');
        } else {
            $unique = 'unique:modalidades';
        }
        $validator = Validator::make($request->all(), [
            'modalidad' => ['required', 'max:10', $unique]
        ]);
        return $validator;
    }

    /**
     * @OA\Get(
     *   path="/modalidades",
     *   summary="Lists available modalidades",
     *   description="Gets all available modalidades resources",
     *   tags={"modalidades"},
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
     *           description="The unique identifier of a modalidad resource"
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
     *       description="A list with modalidad",
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
    public function index(Request $request)
    {

        $q = modalidades::select();
        $modalidad = modalidades::search($request->toArray(), $q);
        return  new usersCollection($modalidad);
    }

    /**
     * @OA\Post(
     *   path="/modalidades",
     *   summary="Creates a new modalidad",
     *   description="Creates a new modalidad",
     *   tags={"modalidades"},
     *   security={{"passport": {"*"}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/modalidades")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *       response=200,
     *       description="The modalidad resource created",
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
                $modalidades = new modalidades();
                $modalidades->modalidad = $request->modalidad;
                $modalidades->status = $request->status;

                $modalidades->user = $request->user;
                $modalidades->save();
                return response()->json($request, 201);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * @OA\Get(
     *   path="/modalidades/{modalidad}",
     *   summary="Gets a modalidad resource",
     *   description="Gets a modalidad resource",
     *   tags={"modalidades"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="modalidad",
     *   in="path",
     *   description="The modalidad resource modalidad",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a modalidad resource"
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
     * @param  int  $modalidad
     *
     * @return \Illuminate\Http\Response
     */
    public function show($modalidad)
    {
        /** esto es una consulta por la cedula */
        $modalidades = modalidades::where('modalidad', $modalidad)
            ->where('modalidad', $modalidad)
            ->first();
        if ($modalidades) {
            return response()->json($modalidades, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No existe este modalidad'], 404);
        }
    }

    /**
     * @OA\Put(
     *   path="/modalidades/{modalidad}",
     *   summary="Updates a modalidades resource",
     *   description="Updates a modalidades resource by the modalidad",
     *   tags={"modalidades"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="modalidad",
     *   in="path",
     *   description="modalidades resource id",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a modalidades resource"
     *   )
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(ref="#/components/schemas/modalidades")
     *       )
     *   ),
     *   @OA\Response(
     *       @OA\MediaType(mediaType="application/json"),
     *           response=200,
     *           description="The modalidades resource updated"
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
     * @param  int  $modalidad
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $modalidad)
    {
        try {
            if ($this->validation($request, $modalidad)->fails()) {
                $errors = $this->validation($request, $modalidad)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $modalidad = modalidades::where('modalidad', $modalidad)
                    ->update([
                        'modalidad' =>  $request->modalidad,
                    ]);
                return response()->json($modalidad, 200);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    /**
     * @OA\Delete(
     *   path="/modalidades/{dni}",
     *   summary="Removes a modalidades resource",
     *   description="Removes a modalidades resource",
     *   tags={"users"},
     *   security={{"passport": {"*"}}},
     *   @OA\Parameter(
     *   name="dni",
     *   in="path",
     *   description="The modalidades resource dni",
     *   required=true,
     *   @OA\Schema(
     *       type="string",
     *       description="The unique identifier of a modalidades resource"
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
        $modalidades = modalidades::where('dni', $dni)
            ->where('status', 'y')
            ->first();
        if ($modalidades) {
            modalidades::where('dni', $dni)->update(['status' => 'n']);
            return response()->json(['status' => 'success', 'message' => 'usuario eliminado'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuario not inscrito'], 404); // 404 es de que no se encontro contenido
        }
    }
}
