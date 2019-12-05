<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthenticateController extends Controller
{
    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
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
        *   tags={"Users"},
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
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if(Hash::check($request->password, $user->password)){
                $apikey = $this->jwt($user);
                User::where('email', $request->email)->update(['api_token' => $apikey]);

                return response()->json(['status' => 'success','api_token' => $apikey], 200);
            } else {
              return response()->json(['status' => 'Incorrect password'], 401);
            }
        } else {
            return response()->json(['status' => 'user not register'], 401);
        }
    }
}
