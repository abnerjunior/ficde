<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\aulas;

class aulasController extends Controller
{
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

       $q = aulas::select();
       $aulas = aulas::search($request->toArray(), $q);
       return  new AulasCollection($aulas);
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
