<?php

namespace App\Http\Controllers;
use App\Http\Resources\UsersCollection;
use Illuminate\Http\Request;
use App\Models\usuarios;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use Exception;

class UsuariosController extends Controller
{
  /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $dni number dni
     * @return [Function]  function validator
     */
    private function validation ($request, $dni) {
        if ($dni !== null) {
            $unique = Rule::unique('usuarios')->ignore($request->dni, 'dni');
            $pass = 'required|min:8';
        } else {
            $unique = 'unique:usuarios';
            $pass = 'min:8';
        }
        $validator = Validator::make($request->all(), [
            'user' => ['required', $unique],
            'pass' => $pass,
            'nombre' => 'required',
            'apellido' => 'required',
            'dni' => ['required', 'max:10', $unique],
            'direccion' => 'required',
            'rol' => 'required',
            'email' => ['email', 'required', $unique],
            'telefono' => 'required'
        ]);
        return $validator;
    }
   /**
        * @OA\Get(
        *   path="/usuarios",
        *   summary="Lists available Users",
        *   description="Gets all available Users resources",
        *   tags={"Users"},
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
        *           description="The unique identifier of a usuarios resource"
        *       )
        *   ),
        *   @OA\Parameter(
        *       name="dataSearch",
        *       in="query",
        *       description="usuarios resource name",
        *       required=false,
        *       @OA\Schema(
        *           type="string",
        *           description="The unique identifier of a usuarios resource"
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
        *           description="The unique identifier of a usuarios resource"
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
        *           description="The unique identifier of a usuarios resource"
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
        *           description="The unique identifier of a Users resource"
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
        *       description="A list with Users",
        *       @OA\Header(
        *       header="X-Auth-Token",
        *       @OA\Schema(
        *           type="integer",
        *           format="int32"
        *       ),
        *       description="calls per hour allowed by the usuario"
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

        $q = usuarios::select();
        $usuarios = usuarios::search($request->toArray(), $q);
        return  new UsersCollection($usuarios);
    }

    /**
        * @OA\Get(
        *   path="/usuarios/{dni}",
        *   summary="Gets a usuarios resource",
        *   description="Gets a usuarios resource",
        *   tags={"Users"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="dni",
        *   in="path",
        *   description="The usuarios resource dni",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a usuarios resource"
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
    public function show($dni)
    {
        /** esto es una consulta por la cedula */
        $usuarios = usuarios::where('dni', $dni)
            ->where('dni', $dni)
            ->first();
        if ($usuarios) {
            return response()->json($usuarios, 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'usuario not register'], 404); // no encontro el contenido
        }
    }

    /**
        * @OA\Post(
        *   path="/usuarios",
        *   summary="Creates a new usuario",
        *   description="Creates a new usuario",
        *   tags={"Users"},
        *   security={{"passport": {"*"}}},
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/usuarios")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *       response=200,
        *       description="The usuarios resource created",
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
        * @param \Illuminate\Http\Request $request
        *
        * @return \Illuminate\Http\Response
        */

    public function store(Request $request) {
        try {
            if ($this->validation($request, null)->fails()) {
                $errors = $this->validation($request, null)->errors();
                return response()->json($errors->all(), 400);
            } else {
                $usuarios = new usuarios;
                $usuarios->user = $request->user;
                $usuarios->pass = Hash::make($request->pass);
                $usuarios->nombre = $request->nombre;
                $usuarios->apellido = $request->apellido;
                $usuarios->dni = $request->dni;
                $usuarios->email = $request->email;
                $usuarios->telefono = $request->telefono;
                $usuarios->direccion = $request->direccion;
                $usuarios->rol = $request->rol;
                $usuarios->api_token = null;
                $usuarios->user_r = $request->user_r;
                $usuarios->save();
                return response()->json($usuarios, 201); // 201 es de creado
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    /**
        * @OA\Put(
        *   path="/usuarios/{dni}",
        *   summary="Updates a Users resource",
        *   description="Updates a Users resource by the dni",
        *   tags={"Users"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="dni",
        *   in="path",
        *   description="usuarios resource id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a usuarios resource"
        *   )
        *   ),
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/usuarios")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *           response=200,
        *           description="The usuarios resource updated"
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
        * @param  int  $dni
        *
        * @return \Illuminate\Http\Response
        */
    public function update(Request $request, $dni)
    {
        try {
            if ($this->validation($request, $dni)->fails()) {
                $errors = $this->validation($request, $dni)->errors();
                return response()->json($errors->all(), 400); // error en la validacion
            } else {
                // es mejor usar $request->all() 
                $usuarios = usuarios::where('dni', $dni)->update($request->all());
                return response()->json($usuarios, 200); // 200 todo salio bien
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    /**
        * @OA\Delete(
        *   path="/usuarios/{dni}",
        *   summary="Removes a usuarios resource",
        *   description="Removes a usuarios resource",
        *   tags={"users"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="dni",
        *   in="path",
        *   description="The usuarios resource dni",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a usuarios resource"
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
            $usuarios = usuarios::where('dni', $dni)
                ->where('status', 'n')
                ->first();
            if ($usuarios) {
                usuarios::where('dni', $dni)->update(['status' => 'n']);
                return response()->json(['status' => 'success', 'message' => 'estudiante eliminado'], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'estudiante not inscrito'], 404); // 404 es de que no se encontro contenido
            }
        }
}
