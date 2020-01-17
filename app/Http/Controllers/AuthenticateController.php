<?php

namespace App\Http\Controllers;
use App\Models\usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthenticateController extends Controller
{
    /**
     * Create a new token.
     * 
     * @param  \App\usuarios   $user
     * @return string
     */
    protected function jwt(usuarios $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->user_id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
        * @OA\Post(
        *   path="/authenticate",
        *   summary="Authenticate",
        *   description="Authenticate Users",
        *   tags={"usuarios"},
        *   security={{"passport": {"*"}}},
        *   @OA\RequestBody(
        *       @OA\MediaType(
        *           mediaType="application/json",
        *           @OA\Schema(ref="#/components/schemas/Login")
        *       )
        *   ),
        *   @OA\Response(
        *       @OA\MediaType(mediaType="application/json"),
        *       response=200,
        *       description="The Post resource created",
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
    public function authenticate(Request $request) {
        $user = usuarios::where('dni', $request->dni)
        ->orWhere('user',$request->dni)
            ->first();
        if ($user) {
            if(Hash::check($request->pass, $user->pass)){
                $apikey = $this->jwt($user);
                usuarios::where('dni', $request->dni)->update(['api_token' => $apikey]);

                return response()->json(['status' => 'success','api_token' => $apikey], 200);
            } else {
              return response()->json(['status' => 'Incorrect password'], 401);
            }
        } else {
            return response()->json(['status' => 'user not register'], 401);
        }
    }
}
