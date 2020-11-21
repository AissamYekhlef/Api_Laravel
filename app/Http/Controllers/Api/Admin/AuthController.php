<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

// use Tymon\JWTAuth\JWTAuth;

// use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request){
        
        try{
            //Validation 
            $rules = [
                "email"=>"required",
                "password"=>"required"
            ];
            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //Login
            $credentials = $request->only(['email','password']);
            $token = Auth::guard('admin-api')->attempt($credentials);

            // Additional Options 
            // You can Claims more parameters for added to the payload  and return on the token
            // $token = Auth::guard('admin-api')->claims(['email' => $request->email])->attempt($credentials);
            // or use th auth() helper function
            // $token = auth('admin-api')->attempt($credentials);

            if(!$token){
                return $this->returnError('Email or Password incorrect', 'E111');
            }

            //Return JWT token
            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;

            return $this->returnData('admin',$admin);

        }catch(Exception $ex){
            return $this->returnError($ex->getMessage(), $ex->getCode());
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try{
            // $user = auth('admin-api')->userOrFail();
            $user = JWTAuth::parseToken()->authenticate();
            $payload = auth('admin-api')->payload();
            return response()->json([
                    'user' => [
                        'id' => auth('admin-api')->user()->id ,
                        'name' => auth('admin-api')->user()->name ,
                        'email' => auth('admin-api')->user()->email ,
                        'token_by_id' => auth('admin-api')->tokenById(1),
                    ],
                    'token' =>[
                        'payload' => $payload->toArray(),
                    ],
                    // 'special' => [
                    //     'pay_email' => $payload['email']
                    // ]
                ]);
        }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $ex){
            return response()->json(
                $this->returnError("You must be logged-in to show the Authentified User.", 400)
            , 400);
        }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $ex){
            return response()->json(
                $this->returnError('Token is Invalid !', 400)
            , 400);
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $ex){
            return response()->json(
                $this->returnError('There is a Token Exception !', 400)
            , 400);
        }catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $ex){
            return response()->json(
                $this->returnError('Token is Expireded !', 400)
            , 400);
        }
        
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        try{
            $user = auth('admin-api')->userOrFail();
            auth('admin-api')->logout();

            return response()->json([
                'message' => 'Successfully logged out, Goodbye '.$user->name
            ]);

        }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $ex){
            return $this->returnError("You must be logged-in to Logout.");
        }

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        if(!auth('admin-api')->user()){
            return $this->returnError("You must be logged-in to refreh the JWT Token.");
        }
        return $this->respondWithToken(auth('admin-api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('admin-api')->factory()->getTTL() * 60
        ]);
    }
}
