<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Http\Traits\JsonTrait;
use App\Models\Employee;
use Illuminate\Support\Facades\Gate;

// use Validator;

class ApiController extends Controller
{
    Use JsonTrait;
    /** 
     *  Login
     * 
     * Test
     * 
     * Test
     * 
     * 
     * @bodyParam user_id int Example:9
     * 
    */

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->JsonResponse($validator->errors(),
            'Invalid Input Parameter', 
            422);
        }

        if (! $token = JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

   /**
    * Dashboard
    *
    * Test text
    *
    * Test text 2
    * @authenticated
    * @header Authorization Bearer {{token}}
    * @response 401 scenario="invalid token"
    * @bodyParam page int Page number for pagination Example: 1
    */

    public function dashboard(Request $request){
        $user_total = User::count();
        $code = 0;
        $employeepage = Employee::paginate(10);
        $employee = EmployeeResource::collection($employeepage);

        return $this->jsonResponse(compact('employee','user_total', 'code'),
        '',
        200);
        //     compact('user_total', 'code')
        // );

    }

    /**
     * Users
     * 
     * ayylmao new api
     *
     * 
     * 
     * @authenticated
     * @header Authorization Bearer {{token}}
     * @bodyParam page int Page number for pagination Example: 1
     */
    public function users(Request $request){
        // $users = User::where('id', 2)->first();
        // $users = User::where('id', '<'.10);

        $response = Gate::inspect('update', auth()->user());

        if ($response->allowed()) {
            // The action is authorized...
            $users = User::paginate(10);
            return $this->JsonResponse(
                UserResource::collection($users)
                // compact('users')
            );

        } else {
            echo $response->message();
        }

        
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
        
    }
   /**
    * Get Employee
    *
    * Test text
    *
    * Test text 2
    * @authenticated
    * @header Authorization Bearer {{token}}
    * @bodyParam user_id int Example:1
    * @response 401 scenario="invalid token"
    */
    public function getEmployee(Request $request){
        $employee = Employee::where('id', $request->user_id)
        ->with(['user'])
        ->first();
        
        // $employee = new EmployeeResource(Employee::findOrFail($request->user_id));

        return $this->jsonResponse(compact('employee'),
        '',
        200);
        //     compact('user_total', 'code')
        // );

    }
}
