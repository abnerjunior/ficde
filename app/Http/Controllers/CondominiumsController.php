<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Condominium;
use App\Http\Resources\CondominiumsCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class CondominiumsController extends Controller
{
    /**
     * validate data of request
     * @param  [Request] $request data
     * @param  [String] $documents number documents
     * @return [Function]  function validator
     */
    private function validation ($request, $id) {
        if ($id !== null) {
            $unique = Rule::unique('condominiums')->ignore($request->condominium_id, 'documents');
        } else {
            $unique = 'unique:condominiums';
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => ['email', 'required', $unique],
            'type_condominium' => 'required',
            'active_indicator' => 'required|max:1'
        ]);
        return $validator;
    }
    /**
        * @OA\Get(
        *   path="/",
        *   summary="Lists available Condominiums",
        *   description="Gets all available Condominiums resources",
        *   tags={"Condominium"},
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
        *           description="The unique identifier of a Condominium resource"
        *       )
        *   ),
        *   @OA\Parameter(
        *       name="dataSearch",
        *       in="query",
        *       description="Condominium resource name",
        *       required=false,
        *       @OA\Schema(
        *           type="string",
        *           description="The unique identifier of a Condominium resource"
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
        *           description="The unique identifier of a Condominium resource"
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
        *           description="The unique identifier of a Condominium resource"
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
        *           description="The unique identifier of a Condominiums resource"
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
        *       description="A list with Condominiums",
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
        $q = Condominium::select();
        $condominium = Condominium::search($request->toArray(), $q);
        return  new CondominiumsCollection($condominium);
    }
    /**
        * @OA\Post(
        *   path="/",
        *   summary="Creates a new Condominium",
        *   description="Creates a new Condominium",
        *   tags={"Condominium"},
        *   security={{"passport": {"*"}}},
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/Condominium")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *       response=200,
        *       description="The Condominium resource created",
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
    public function store(Request $request)
    {
        try {
            if ($this->validation($request, null)->fails()) {
                $errors = $this->validation($request, null)->errors();
                return response()->json($errors->all(), 400);
            }
            $condominium = Condominium::create($request->all());
            return response()->json($condominium, 201);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
    /**
        * @OA\Get(
        *   path="/{condominium_id}",
        *   summary="Gets a Condominium resource",
        *   description="Gets a Condominium resource",
        *   tags={"Condominium"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="condominium_id",
        *   in="path",
        *   description="The Condominium resource condominium_id",
        *   required=true,
        *   @OA\Schema(
        *       type="number",
        *       description="The unique identifier of a Condominium resource"
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
        * @param  int  $documents
        *
        * @return \Illuminate\Http\Response
        */
    public function show($id)
    {
        try {
            $condominium = Condominium::where('condominium_id', $id)->firstOrFail();
            return response()->json($condominium, 200); 
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500); 
        }
    }

    /**
        * @OA\Put(
        *   path="/{condominium_id}",
        *   summary="Updates a Users resource",
        *   description="Updates a Users resource by the condominium_id",
        *   tags={"Condominium"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="condominium_id",
        *   in="path",
        *   description="User resource id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a User resource"
        *   )
        *   ),
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/Condominium")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *           response=200,
        *           description="The Condominium resource updated"
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
        * @param  int  $condominium_id
        *
        * @return \Illuminate\Http\Response
        */
    public function update(Request $request, $id)
    {
        //
    }

    /**
        * @OA\Delete(
        *   path="/{condominium_id}",
        *   summary="Removes a Condominium resource",
        *   description="Removes a Condominium resource",
        *   tags={"Condominium"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="condominium_id",
        *   in="path",
        *   description="The Condominium resource condominium_id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a Condominium resource"
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
        * @param  int  $condominium_id
        *
        * @return \Illuminate\Http\Response
        */
    public function destroy($id)
    {
        //
    }
    /**
        * @OA\patch(
        *   path="/{condominium_id}",
        *   summary="Restore a Condominium resource",
        *   description="Restore a Condominium resource",
        *   tags={"Condominium"},
        *   security={{"passport": {"*"}}},
        *   @OA\Parameter(
        *   name="condominium_id",
        *   in="path",
        *   description="The Condominium resource condominium_id",
        *   required=true,
        *   @OA\Schema(
        *       type="string",
        *       description="The unique identifier of a Condominium resource"
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
        * @param  int  $id
        *
        * @return \Illuminate\Http\Response
        */
    public function restore($id)
    {
        $user = Condominium::where('condominium_id', $documents)
            ->where('status', 'n')
            ->first();
        if ($user) {
            Condominium::where('documents', $documents)->update(['status' => 'y']);
            return response()->json(['status' => 'success', 'message' => 'Condominium restored'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Condominium not register'], 401);
        }
    }
}
