@extends('employee.layout')

@section('content')

<div class="row">
    <div class="pull-right">
        <a class="btn btn-secondary" href="{{route('employee.index')}}">Back</a>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <strong></strong>
        <table class="table table-bordered">
            <tr>
                <th>Maximum Salary:</th>
                <th>Minimum Salary:</th>
                <th>No of employees per department:</th>
                <th>Employee Yearly Salary</th>
                <th>Age</th>
            </tr>
            <tr>
                <td>{{$max}}</td>
                <td>{{$min}}</td>
                <td>{{$count}}</td>
                <td>{{$year}}</td>
                <td>{{$age}}</td>
            </tr>
            
        </table>    
    </div>
</div>

@endsection