<?php

namespace App\Http\Controllers;
use App\Http\Resources\UsersCollection;
use Illuminate\Http\Request;
use App\Http\Resources\estudiantesCollection;
use App\Models\turnos;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TurnosController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $turno number turno
     * @return [Function]  function validator
     */
    private function validation ($request, $turno) {
        if ($turno !== null) {
            $unique = Rule::unique('turnos')->ignore($request->turno, 'turno');
        } else {
            $unique = 'unique:turnos';
        }
        $validator = Validator::make($request->all(), [
            'turno' => ['required', 'max:10', $unique],
            'hora' => 'required|min:5'
        ]);
        return $validator;
    }
    /**
        * @OA\Get(
        *   path="/turnos",
        *   summary="Lists available turnos",
        *   description="Gets all available turnos resources",
        *   tags={"turnos"},
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
        *           description="The unique identifier of a turno resource"
        *       )
        *   ),
        *   @OA\Parameter(
        *       name="dataSearch",
        *       in="query",
        *       description="turno resource name",
        *       required=false,
        *       @OA\Schema(
        *           type="string",
        *           description="The unique identifier of a turno resource"
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
        *           description="The unique identifier of a turno resource"
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
        *           description="The unique identifier of a turno resource"
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
        *           description="The unique identifier of a turnos resource"
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
        *       description="A list with turnos",
        *       @OA\Header(
        *       header="X-Auth-Token",
        *       @OA\Schema(
        *           type="integer",
        *           format="int32"
        *       ),
        *       description="calls per hour allowed by the turno"
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

        $q = turnos::select();
        $turnos = turnos::search($request->toArray(), $q);
        return  new UsersCollection($turnos);
    }
    /**
        * @OA\Post(
        *   path="/turnos",
        *   summary="Creates a new turno",
        *   description="Creates a new turno",
        *   tags={"turnos"},
        *   security={{"passport": {"*"}}},
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/turnos")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *       response=200,
        *       description="The turno resource created",
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
                $turnos= new turnos();
                $turnos->turno = $request->turno;
                $turnos->hora = $request->hora;
                $turnos->save();
                return response()->json($request, 200);      
            }
        }catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
        * @OA\Get(
        *   path="/turnos/{turno}",
        *   summary="Gets a turno resource",
        *   description="Gets a turno resource",
        *   tags={"turnos"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="turno",
        *   in="path",
        *   description="The turno resource turno",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a turno resource"
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
        * @param  int  $turno
        *
        * @return \Illuminate\Http\Response
        */
    public function show($turno)
    {
       /** esto es una consulta por la cedula */
       $turnos = turnos::where('turno', $turno)
            ->where('turno', $turno)
            ->first();
        if ($turnos)
        {
            return response()->json($turnos, 200);
        } 
        else 
        {
            return response()->json(['status' => 'error', 'message' => 'No existe este turno'], 204);
        }
    }

        /**
        * @OA\Put(
        *   path="/turnos/{turno}",
        *   summary="Updates a turnos resource",
        *   description="Updates a turnos resource by the turno",
        *   tags={"turnos"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="turno",
        *   in="path",
        *   description="turnos resource id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a turnos resource"
        *   )
        *   ),
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/turnos")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *           response=200,
        *           description="The turnos resource updated"
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
        * @param  int  $turno
        *
        * @return \Illuminate\Http\Response
        */
        public function update(Request $request, $turno)
        {
            try {
                if ($this->validation($request, $turno)->fails()) {
                    $errors = $this->validation($request, $turno)->errors();
                    return response()->json($errors->all(), 201);
                } else {
                    $turno = turnos::where('turno', $turno)
                    ->update([
                        'turno' =>  $request->nombre,
                        'hora' => $request->hora,
                    ]);
                    return response()->json($turno, 201);
                }
            } catch (Exception $e) {
                return response()->json($e);
            }
        }

        /**
        * @OA\Delete(
        *   path="/turnos/{turno}",
        *   summary="Removes a turnos resource",
        *   description="Removes a turnos resource",
        *   tags={"turnos"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="turno",
        *   in="path",
        *   description="The turnos resource turno",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a turnos resource"
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
        * @param  int  $turno
        *
        * @return \Illuminate\Http\Response
        */
        public function destroy($turno)
        {
            $turnos = turnos::where('turno', $turno)
                ->where('status', 'n')
                ->first();
            if ($turnos) 
            {
                turnos::where('turno', $turno)->update(['status' => 'n']);
                return response()->json(['status' => 'success', 'message' => 'turno eliminado'], 200);
            } 
            else 
            {
                return response()->json(['status' => 'error', 'message' => 'turno not inscrito'], 401);
            }
        }
}
