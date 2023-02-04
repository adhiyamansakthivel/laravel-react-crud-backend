<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

use Symfony\Contracts\EventDispatcher\Event;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $post = new Employee;
        $post->name = $request->name;
        $post->email = $request->email;
        $post->empid = $request->empid;

        if ($request->file('photos')) {
            $uniqkey = random_int(100, 999);
            $name = ($uniqkey) . '.' .'jpg';
            $imageName = $request->file('photos')->move(public_path('/empImage'),$name);
        }
        $post->profilepic = $name;

        $post->save();
        
        return response()->json('successfully created');
    }


    public function index()
    {
        $employees = Employee::all();

        $response = [
            'success'=>true,
            'employees'=> $employees,
        ];
        
        return response()->json($response, 200);
    }


    public function edit($id)
    {
        return response()->json(Employee::whereId($id)->first());
    }
    

    public function update(Request $request, $id)
    {
        $employee = Employee::whereId($id)->first();

        $employee->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'empid'=>$request->empid,
        ]);
        return response()->json('success');
    }



    public function updateImage(Request $request, $id)
    {
        $employee = Employee::whereId($id)->first();

        if ($request->file('photos')) {
            $uniqkey = random_int(100, 999);
            $name = ($uniqkey) . '.' .'jpg';
            $imageName = $request->file('photos')->move(public_path('/empImage'),$name);
        }


        $employee->update([
            'profilepic'=>$name,
        ]);
        return response()->json('success');
    }




    public function destroy($id)
    {
        Employee::whereId($id)->first()->delete();

        return response()->json('success');
    }

}
