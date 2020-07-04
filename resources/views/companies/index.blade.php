@extends('layouts.app')

@section('content')
<div class="container row justify-content-center">
<div class="card col-md-9">
    <div classs="card-header">
        <h2>{{ trans('home.companies') }}</h2>
        @auth
            <a style="margin: 19px;" href="{{ route('companies.create') }}" class="btn btn-primary float-right" >New Company</a>
        @endauth
    </div>
    <div classs="card-body">
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
              <td>Name</td>
              <td>Email</td>
              <td>Logo</td>
              <td>Website URL</td>
              @auth
              <td colspan="2">Action</td>
              @endauth
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
            <tr>
                <td>{{ $company->id }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->email }}</td>
                <td><img src="storage/{{ $company->logo }}"></td>
                <td>{{ $company->website_url }}</td>
                @auth
                <td><a href="{{action('CompanyController@edit',$company->id)}}" class="btn btn-primary">Edit</a></td>
                <td>
                    <form action="{{action('CompanyController@destroy', $company->id)}}" method="post">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
                @endauth
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $companies->links() }}
    </div>
</div>
</div>
@endsection