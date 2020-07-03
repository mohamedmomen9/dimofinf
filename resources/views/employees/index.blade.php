@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employees</h1>
    <div>
        <a style="margin: 19px;" href="{{ route('employees.create') }}" class="btn btn-primary">New Employee</a>
    </div>
    <div class="col-sm-12">
        @if(session()->get('success'))
            <div class="alert alert-success">
            {{ session()->get('success') }}  
            </div>
        @endif
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
              <td>ID</td>
              <td>First Name</td>
              <td>Last Name</td>
              <td>Company</td>
              <td>Email</td>
              <td>Phone</td>
              <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->first_name }}</td>
                <td>{{ $employee->last_name }}</td>
                <td>{{ $employee->company_id }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone }}</td>
                <td><a href="{{ action('EmployeeController@edit',$employee->id) }}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{ action('EmployeeController@destroy', $employee->id) }}" method="post">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $employees->links() }}
<div>
@endsection