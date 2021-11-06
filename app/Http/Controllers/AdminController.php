<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeJob;
use App\Models\User;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\JsonTrait;

class AdminController extends Controller
{
    public function index(Request $request){

        if ($request->isMethod('post')){
            $credentials = $request->validate([
                'email' => ['required','email'],
                'password' => ['required']
            ]);

            if (Auth::attempt($credentials)){
                if(Auth::user()->role==1){
                    $request->session()->regenerate();

                    $jwt_token = JWTAuth::attempt($credentials);
                    session(['jwt_token' => $jwt_token]);

                    return redirect('dashboard');
                } else {
                    return redirect('/');
                }
            }
        }
        
        return view('admin.login');


    }

    public function dashboard(){
        $employee = User::get();
        $job = EmployeeJob::get();
        $department = department::get();

        $jwt_token = session('jwt_token');


        return view('admin.dashboard',[
            'employee' => count($employee),
            'job' => count($job),
            'department' => count($department),
            'jwt_token' => $jwt_token,
        ]);
    }

    // public function employee(Request $request, $id, $action){

    //     $employee = Employee::get();
    //     $employee = Employee::paginate(10);

    //     if($action == 2){
    //         Employee::where('id', $id)->first()->delete();
    //         return view('admin.employee', 
    //     [ "employees"=>$employee]);
    //     }

    //     return view('admin.employee', 
    //     [ "employees"=>$employee]);

    // }
    

    // public function employeeedit(Request $request,$id){
    //     $employee = Employee::where('id', $id)->first();

    //     if($request->edit == 1){
    //         $employee->first_name = $request->first_name;
    //         $employee->email = $request->email;
    //         $employee->phone_number = $request->phone_number;
    //         $employee->salary = $request->salary;
    //         $employee->department_id = $request->department_id;
    //         $employee->job_id = $request->job_id;
    //         $employee->save();

    //         return view('admin.edit',[
    //             "employee" => $employee
    //         ]);
    //     }

    //     return view('admin.employeeedit',[
    //         "employee" => $employee
    //     ]);
    // }

    // public function employeeadd(Request $request){

    //     if(isset($request->user_id)){
    //         $employee = new Employee();
    //         $employee->user_id = $request->user_id;
    //         $employee->first_name = $request->first_name;
    //         $employee->last_name = $request->last_name;
    //         $employee->email = $request->email;
    //         $employee->phone_number = $request->phone_number;
    //         $employee->salary = $request->salary;
    //         $employee->department_id = $request->department_id;
    //         $employee->job_id = $request->job_id;
    //         $employee->save();
    //     }
        
    //     return view('admin.employeeadd');

    // }

    public function employee(Request $request, $id, $action){

        $employee = User::get();
        $employee = User::paginate(10);

        if($action == 2){
            User::where('id', $id)->first()->delete();
            return view('admin.employee', 
        [ "employees"=>$employee]);
        }

        return view('admin.employee', 
        [ "employees"=>$employee]);

    }
    

    public function employeeedit(Request $request,$id){
        $employee = User::where('id', $id)->first();

        if($request->edit == 1){
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->role = $request->role;
            $employee->save();

            return view('admin.employeeedit',[
                "employee" => $employee
            ]);
        }

        return view('admin.employeeedit',[
            "employee" => $employee
        ]);
    }

    public function employeeadd(Request $request){

        if(isset($request->name)){
            $employee = new User();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->password = bcrypt($request->password);
            $employee->role = $request->role;
            $employee->save();
        }
        
        return view('admin.employeeadd');

    }

    public function job(Request $request, $id, $action){

        $job = EmployeeJob::get();
        $job = EmployeeJob::paginate(10);

        if($action == 2){
            EmployeeJob::where('id', $id)->first()->delete();

            return view('admin.job', 
            [  "jobs"=>$job]);
        }

        return view('admin.job', 
        [ "jobs"=>$job]);

    }

    public function jobedit(Request $request,$id){
        $job = EmployeeJob::where('id', $id)->first();

        if($request->edit == 1){
            $job->title = $request->title;
            $job->description = $request->description;
            $job->min_salary = $request->min_salary;
            $job->max_salary = $request->max_salary;
            $job->save();

            return view('admin.jobedit',[
                "job" => $job
            ]);
        }

        return view('admin.jobedit',[
            "job" => $job
        ]);
    }

    public function jobadd(Request $request){

        if(isset($request->title)){
            $job = new job();
            $job->title = $request->title;
            $job->description = $request->description;
            $job->min_salary = $request->min_salary;
            $job->max_salary = $request->max_salary;
            $job->save();
        }
        
        return view('admin.jobadd');

    }

    public function department(Request $request, $id, $action){

        $department = Department::get();
        $department = Department::paginate(10);

        if($action == 2){
            Department::where('id', $id)->first()->delete();
            return view('admin.department', 
        [ "departments"=>$department]);
        }

        return view('admin.department', 
        [ "departments"=>$department]);

    }

    public function departmentedit(Request $request,$id){
        $department = Department::where('id', $id)->first();

        if($request->edit == 1){
            $department->name = $request->name;
            $department->save();

            return view('admin.departmentedit',[
                "department" => $department
            ]);
        }

        return view('admin.departmentedit',[
            "department" => $department
        ]);
    }

    public function departmentadd(Request $request){

        if(isset($request->name)){
            $department = new department();
            $department->name = $request->name;
            $department->save();
        }
        
        return view('admin.departmentadd');

    }

    public function logout(){
        if(Auth::Check()){
            Auth::logout();
        }
        return redirect('/admin/');
    }


}
