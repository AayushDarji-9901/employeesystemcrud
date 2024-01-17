<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Models\department;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
//use DataTables;
use Yajra\Datatables\Datatables;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $department=department::all();

          $depart=$request->department;
          $min_salary=$request->input('min_salary');
          $max_salary=$request->input('max_salary');

         if($request->ajax()){
            $data=employee::select('department.dept as depart','employee.*')
            ->leftJoin('department','employee.department','=','department.id');

            if ($request->get('min_salary') && $request->get('max_salary')) {
                $data = $data->whereBetween('salary', [$request->min_salary, $request->max_salary]);
            }
            return Datatables::of($data)
            ->addIndexColumn()
            ->filter(function($instance) use ($request){
                if($request->get('department')!=''){
                    $instance->where(function($w) use ($request){
                        $search=$request->get('department');
                        $w->where('department','LIKE',"$search");
                    });
                }
                if($request->get('min_salary')!='' && $request->get('max_salary')!=''){
                    $instance->where(function($w) use ($request){
                        $min_salary=$request->get('min_salary');
                        $max_salary=$request->get('max_salary');

                        $w->whereBetween('salary',[$min_salary,$max_salary]);
                    });
                }
            })
            ->make(true);
         }
         return view('employee.index',compact('department','depart','min_salary','max_salary'));
        
    }

    public function search(Request $request){
        $department=department::all();
        $employee=employee::select('department.dept as depart','employee.*')
         ->leftJoin('department','employee.department','=','department.id')->get();
         $depart=$request->department;

         $min_salary=$request->input('min_salary');
         $max_salary=$request->input('max_salary');

         if($min_salary>0 && $max_salary>0){
            $employee=employee::whereBetween('salary',[$min_salary,$max_salary]);
         }
         

         return response()->json(['employee' => $employee,'department'=>$department,'min_salary'=>$min_salary,
         'max_salary'=>$max_salary,'depart'=>$depart]);
        //  return view('employee.index',compact('department','employee','depart','min_salary','max_salary'));
        
    }
   
    public function create()
    {
        $department=department::all();

         return view('employee.create',compact('department'));
    }

    public function store(Request $request)
    {
        //$employee->columnname=$request->input(name)
        $employee=new employee;
        $employee->name=$request->input('name');
        $employee->department=$request->input('dept');
        $employee->salary=$request->input('salary');
        $employee->dob=$request->input('dob');
        $employee->gender=$request->input('gender');
        $employee->email=$request->input('email');

        $employee->save();
        return redirect()->route('employee.index')->with('Success','Employee created successfully');
    }

   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statistics(){
        $department=department::all();
        $employee=employee::select('department.dept as depart','employee.*')
         ->leftJoin('department','employee.department','=','department.id')->get();

         $max=employee::query()
         ->select('name','salary')
         ->whereRaw('salary = (select max(salary) from employee)')->first();
        // dd($max);

        $min=employee::query()
        ->select('name','salary')
        ->whereRaw('salary = (select min(salary) from employee)')->first();

        $count=employee::select('department',DB::raw("count(name) as 'no of employee'"))
                   ->leftJoin('department','employee.department','=','department.id')
                   ->groupBy('department')
                   ->get();

        $year=employee::select('name',DB::raw("sum(salary*12) as 'Yearly Salary'"))
                   ->groupBy('name')
                   ->get();
        
        $age = employee::select('name')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(dob), current_date) AS age")
                ->get();
         return view('employee.statistics',compact('department','employee','max','min','count','year','age'));

    }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
