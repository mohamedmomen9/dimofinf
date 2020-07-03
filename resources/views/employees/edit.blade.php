@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Employee</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
    <form method="post" action="{{ action('EmployeeController@update', $id) }}" >
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" name="first_name" value={{ $employee->first_name }} />
        </div>
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" name="last_name" value={{ $employee->last_name }} />
        </div>
        <div class="form-group">
            <label for="company_id">Company:</label>
            <select class="form-control" name="company_id">
                <option >select company</option>
                @foreach($companies as $company)
                    <option value="{{ $commpany->id }}" @if($commpany->id == $employee->company_id) selected @endif >{{ $company->name }}</option>
                @endForeach
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" value={{ $employee->email }} />
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" value={{ $employee->phone }} />
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection