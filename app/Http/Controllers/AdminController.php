<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                    return redirect('dashboard');
                } else {
                    return redirect('/');
                }
            }
        }
        
        return view('admin.login');


    }

    public function dashboard(){
        $employee = Employee::get();
        $job = Job::get();
        $department = department::get();


            $countemployee = $employee->count();
            // $countjob = $job->count();
            // $countdepartment = $department->count();


        return view('admin.dashboard',[
            'employee' => count($employee),
            'job' => count($job),
            'department' => count($department),
        ]);
    }

    public function employee(Request $request, $id, $action){

        $employee = Employee::get();
        $employee = Employee::paginate(10);

        if($action == 2){
            Employee::where('id', $id)->first()->delete();
        }

        return view('admin.employee', 
        [ "employees"=>$employee]);

    }

    public function employeeedit(Request $request,$id){
        $employee = Employee::where('id', $id)->first();

        if($request->edit == 1){
            $employee->first_name = $request->first_name;
            $employee->email = $request->email;
            $employee->phone_number = $request->phone_number;
            $employee->salary = $request->salary;
            $employee->department_id = $request->department_id;
            $employee->job_id = $request->job_id;
            $employee->save();

            return view('admin.edit',[
                "employee" => $employee
            ]);
        }

        return view('admin.employeeedit',[
            "employee" => $employee
        ]);
    }

    public function employeeadd(Request $request){

        if(isset($request->user_id)){
            $employee = new Employee();
            $employee->user_id = $request->user_id;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->phone_number = $request->phone_number;
            $employee->salary = $request->salary;
            $employee->department_id = $request->department_id;
            $employee->job_id = $request->job_id;
            $employee->save();
        }
        
        return view('admin.employeeadd');

    }

    public function job(Request $request, $id, $action){

        $job = Job::get();
        $job = Job::paginate(10);

        if($action == 2){
            Job::where('id', $id)->first()->delete();
        }

        return view('admin.job', 
        [ "jobs"=>$job]);

    }

    public function jobedit(Request $request,$id){
        $job = Job::where('id', $id)->first();

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
