<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use JWTAuth;

class JwtController extends Controller
{

    public function signIn(Request $request)
    {
  		$credentials = $request->only('email', 'password');

  		if ( ! $token = JWTAuth::attempt($credentials)) {
  			return response()->json(false, Response::HTTP_UNAUTHORIZED);
  		}

  		return response()->json(compact('token'));
    }

    public function signUp(Request $request)
    {
  		$credentials = $request->only('email', 'password', 'name');

  		try {
  			$user = User::create($credentials);
  		} catch (Exception $e) {
  			return response()->json(['error' => 'User already exists.'], Response::HTTP_CONFLICT);
  		}

  		$token = JWTAuth::fromUser($user);

  		return response()->json(compact('token'));
    }

    public function restricted()
    {
       $token = JWTAuth::getToken();
       $user = JWTAuth::toUser($token);

       return response()->json([
           'data' => [
               'email' => $user->email,
               'registered_at' => $user->created_at->toDateTimeString()
           ]
       ]);
    }

    public function crossDomainRestricted()
    {
       try {
           JWTAuth::parseToken()->toUser();
       } catch (Exception $e) {
           return response()->json(['error' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
       }

       return ['data' => 'This has come from a dedicated API subdomain with restricted access.'];
    }

}
